<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kegiatan;
use App\Support\LikePattern;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function beranda()
    {
        return view('welcome', [
            'kegiatanTerbaru' => Kegiatan::orderByDesc('tanggal')->orderByDesc('id')->take(4)->get(),
            // Statistik hero harus data nyata: jumlah KK terdaftar (DESIGN.md bagian 3)
            'jumlahKk' => KartuKeluarga::count(),
        ]);
    }

    public function kegiatanIndex(Request $request)
    {
        $q = $request->input('q');
        $q = is_string($q) ? trim($q) : '';

        $kegiatan = Kegiatan::query()
            ->when($q !== '', fn ($query) => $query->whereRaw("nama_kegiatan LIKE ? ESCAPE '!'", [LikePattern::contains($q)]))
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(6)
            ->withQueryString();

        return view('kegiatan.index', compact('kegiatan', 'q'));
    }

    public function kegiatanShow(Kegiatan $kegiatan)
    {
        $terkait = Kegiatan::where('id', '!=', $kegiatan->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        return view('kegiatan.show', compact('kegiatan', 'terkait'));
    }
}
