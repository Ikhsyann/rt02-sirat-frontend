<?php

namespace Tests\Feature;

use App\Models\Keuangan;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Logika laporan kas: filter kategori, batas periode, dan saldo kumulatif.
 * Schema domain dibuat inline (sqlite :memory:) agar MySQL bersama tidak tersentuh.
 */
class KeuanganTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('keuangans', function (Blueprint $t) {
            $t->id();
            $t->date('tanggal');
            $t->enum('jenis', ['income', 'expense']);
            $t->string('kategori')->nullable();
            $t->string('nama_barang')->nullable();
            $t->unsignedInteger('jumlah')->default(1);
            $t->decimal('harga_satuan', 15, 2)->default(0);
            $t->decimal('total', 15, 2)->default(0);
            $t->decimal('saldo', 15, 2)->default(0);
            $t->text('keterangan')->nullable();
            $t->timestamps();
        });
    }

    private function kas(string $tanggal, string $jenis, int $total, int $saldo, string $kategori = 'Umum', string $nama = 'Transaksi'): Keuangan
    {
        return Keuangan::create([
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'kategori' => $kategori,
            'nama_barang' => $nama,
            'jumlah' => 1,
            'harga_satuan' => $total,
            'total' => $total,
            'saldo' => $saldo,
        ]);
    }

    private function lihat(array $query = [])
    {
        return $this->actingAs(User::factory()->create())
            ->get('/layanan/keuangan'.($query ? '?'.http_build_query($query) : ''));
    }

    public function test_pemasukan_dan_pengeluaran_hanya_menghitung_periode_terpilih(): void
    {
        $this->kas('2026-01-05', 'income', 100000, 100000);
        $this->kas('2026-01-20', 'expense', 30000, 70000);
        $this->kas('2026-02-03', 'income', 50000, 120000);
        $this->kas('2026-02-10', 'expense', 10000, 110000);

        $response = $this->lihat(['periode' => '2026-02'])->assertOk();

        $this->assertEquals(50000, $response->viewData('pemasukan'));
        $this->assertEquals(10000, $response->viewData('pengeluaran'));
        // Saldo tetap kumulatif sampai akhir periode, bukan hanya periode itu.
        $this->assertEquals(110000, $response->viewData('saldoAkhir'));
        $this->assertCount(2, $response->viewData('rows'));
    }

    public function test_filter_kategori_memakai_parameter_kategori(): void
    {
        $this->kas('2026-02-01', 'expense', 10000, 90000, 'Konsumsi', 'Air minum rapat');
        $this->kas('2026-02-02', 'expense', 20000, 70000, 'Listrik', 'Token listrik pos');

        $response = $this->lihat(['periode' => 'semua', 'kategori' => 'Konsumsi'])->assertOk();

        $baris = $response->viewData('rows');
        $this->assertCount(1, $baris);
        $this->assertSame('Air minum rapat', $baris->first()->nama_barang);
    }

    public function test_parameter_array_tidak_menyebabkan_error(): void
    {
        $this->lihat([
            'q' => ['x'],
            'kategori' => ['x'],
            'jenis' => ['x'],
            'periode' => ['2026-02'],
        ])->assertOk();
    }

    public function test_filter_kategori_menganggap_persen_sebagai_teks_biasa(): void
    {
        $this->kas('2026-02-01', 'expense', 10000, 90000, 'Diskon 100%', 'Barang diskon');
        $this->kas('2026-02-02', 'expense', 20000, 70000, 'Listrik', 'Token listrik');

        $response = $this->lihat(['periode' => 'semua', 'kategori' => '100%'])->assertOk();

        $this->assertCount(1, $response->viewData('rows'));
        $this->assertSame('Barang diskon', $response->viewData('rows')->first()->nama_barang);
    }

    public function test_periode_tidak_valid_jatuh_ke_bulan_berjalan(): void
    {
        $this->kas('2026-02-01', 'income', 10000, 10000);

        $bulanIni = now()->format('Y-m');

        $this->lihat(['periode' => 'abc'])->assertOk()->assertViewHas('periode', $bulanIni);
        $this->lihat(['periode' => '2026-13'])->assertOk()->assertViewHas('periode', $bulanIni);
        $this->lihat(['periode' => ['2026-02']])->assertOk()->assertViewHas('periode', $bulanIni);
    }
}
