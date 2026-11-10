<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Keuangan;
use App\Models\UnitDarurat;
use App\Support\LikePattern;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    /**
     * Beranda warga: 3 pilar layanan + ringkasan akun terhubung KK.
     */
    public function dashboard(Request $request)
    {
        $anggota = $request->user()->anggotaKeluarga()
            ->with('kartuKeluarga.rumah.blok', 'kartuKeluarga.anggotaKeluargas')
            ->first();

        $agenda = Kegiatan::whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->take(3)
            ->get();

        return view('dashboard', compact('anggota', 'agenda'));
    }

    /**
     * Laporan kas: read-only; pengelolaan transaksi dilakukan pengurus di repo Backend.
     */
    public function keuangan(Request $request)
    {
        // Periode tak dikenal (mis. ?periode=abc) jatuh ke bulan berjalan, bukan error 500.
        $periode = $request->query('periode');
        if (! is_string($periode) || ($periode !== 'semua' && ! preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $periode))) {
            $periode = now()->format('Y-m');
        }

        $awalPeriode = $periode === 'semua' ? null : Carbon::createFromFormat('Y-m-d', $periode.'-01')->startOfMonth();
        $akhirPeriode = $awalPeriode?->copy()->endOfMonth();

        // Nilai array dari query string diperlakukan kosong, bukan dipaksa jadi string.
        $cari = $request->input('q');
        $cari = is_string($cari) ? trim($cari) : '';
        $kategori = $request->input('kategori');
        $kategori = is_string($kategori) ? trim($kategori) : '';
        $jenis = $request->input('jenis');
        $jenis = is_string($jenis) && in_array($jenis, ['income', 'expense'], true) ? $jenis : null;

        // jenis di DB: enum 'income'|'expense' (tampil sebagai Pemasukan/Pengeluaran)
        $jenisMap = ['income' => 'Pemasukan', 'expense' => 'Pengeluaran'];

        $rows = Keuangan::query()
            ->when($cari !== '', fn ($q) => $q->where(fn ($w) => $w
                ->whereRaw("nama_barang LIKE ? ESCAPE '!'", [LikePattern::contains($cari)])
                ->orWhereRaw("keterangan LIKE ? ESCAPE '!'", [LikePattern::contains($cari)])))
            ->when($kategori !== '', fn ($q) => $q->whereRaw("kategori LIKE ? ESCAPE '!'", [LikePattern::contains($kategori)]))
            ->when($jenis, fn ($q) => $q->where('jenis', $jenis))
            ->when($awalPeriode, fn ($q) => $q->whereBetween('tanggal', [$awalPeriode->toDateString(), $akhirPeriode->toDateString()]))
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Saldo kumulatif sampai akhir periode; pemasukan/pengeluaran hanya dalam periode terpilih.
        $saldoAkhir = Keuangan::whereDate('tanggal', '<=', $akhirPeriode ?? now())
            ->orderByDesc('tanggal')->orderByDesc('id')
            ->value('saldo') ?? 0;
        $pemasukan = Keuangan::where('jenis', 'income')
            ->when($awalPeriode, fn ($q) => $q->whereBetween('tanggal', [$awalPeriode->toDateString(), $akhirPeriode->toDateString()]))
            ->sum('total');
        $pengeluaran = Keuangan::where('jenis', 'expense')
            ->when($awalPeriode, fn ($q) => $q->whereBetween('tanggal', [$awalPeriode->toDateString(), $akhirPeriode->toDateString()]))
            ->sum('total');

        return view('layanan.keuangan', compact('rows', 'jenisMap', 'periode', 'saldoAkhir', 'pemasukan', 'pengeluaran', 'cari', 'kategori', 'jenis'));
    }

    /**
     * Nomor darurat dikelompokkan per unit.
     */
    public function nomorDarurat()
    {
        $unit = UnitDarurat::with('nomorDarurats')
            ->orderBy('nama_unit')
            ->get();

        return view('layanan.nomor-darurat', compact('unit'));
    }

    /**
     * Data keluarga milik akun sendiri: 1 akun warga -> 1 AnggotaKeluarga -> 1 KK.
     */
    public function dataKeluarga(Request $request)
    {
        $anggota = $request->user()->anggotaKeluarga()
            ->with('kartuKeluarga.anggotaKeluargas', 'kartuKeluarga.rumah.blok')
            ->first();

        return view('layanan.data-keluarga', ['anggota' => $anggota]);
    }

    /**
     * Foto KK hanya untuk pemiliknya. URL sengaja tanpa ID agar dokumen
     * keluarga lain tidak bisa ditebak; path diambil dari KK akun sendiri.
     */
    public function fotoKartuKeluarga(Request $request)
    {
        $foto = $request->user()->anggotaKeluarga()
            ->with('kartuKeluarga:id,foto_kk')
            ->first()?->kartuKeluarga?->foto_kk;

        abort_unless($foto && Storage::disk('kk')->exists($foto), 404);

        return Storage::disk('kk')->response($foto, null, [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
