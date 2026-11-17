<?php

namespace Tests\Feature;

use App\Models\Prestasi;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Halaman publik prestasi: dibaca tanpa login, filter jenis tahan
 * parameter jahat. Schema domain dibuat inline (sqlite :memory:)
 * mengikuti pola KeuanganTest agar MySQL bersama tidak tersentuh.
 */
class PrestasiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('prestasis', function (Blueprint $t) {
            $t->id();
            $t->string('judul', 255);
            $t->string('jenis', 20);
            $t->date('tanggal');
            $t->text('deskripsi')->nullable();
            $t->string('foto')->nullable();
            $t->timestamps();
        });
    }

    private function prestasi(string $judul, string $jenis): Prestasi
    {
        return Prestasi::create([
            'judul' => $judul,
            'jenis' => $jenis,
            'tanggal' => '2026-11-10',
            'foto' => "prestasi/{$judul}.jpg",
        ]);
    }

    public function test_tamu_dapat_membuka_halaman_prestasi(): void
    {
        $this->prestasi('Juara 1 Kebersihan', 'piala');

        $this->get('/prestasi')
            ->assertOk()
            ->assertSee('Juara 1 Kebersihan')
            // Foto disajikan dari storage backend melalui symlink public/storage.
            ->assertSee('storage/prestasi/Juara 1 Kebersihan.jpg');
    }

    public function test_filter_jenis_menyaring_daftar(): void
    {
        $this->prestasi('Sertifikat K3', 'sertifikat');
        $this->prestasi('Piala Lomba Futsal', 'piala');

        $this->get('/prestasi?jenis=sertifikat')
            ->assertOk()
            ->assertSee('Sertifikat K3')
            ->assertDontSee('Piala Lomba Futsal');

        $this->get('/prestasi?jenis=piala')
            ->assertOk()
            ->assertSee('Piala Lomba Futsal')
            ->assertDontSee('Sertifikat K3');
    }

    public function test_parameter_jenis_jahat_jatuh_ke_semua(): void
    {
        $this->prestasi('Sertifikat K3', 'sertifikat');

        // Nilai di luar daftar dan parameter berupa array tidak boleh 500.
        $this->get('/prestasi?jenis=medali')
            ->assertOk()
            ->assertSee('Sertifikat K3');

        $this->get('/prestasi?jenis%5B0%5D=sertifikat')
            ->assertOk()
            ->assertSee('Sertifikat K3');
    }

    public function test_halaman_prestasi_kosong_tetap_tampil(): void
    {
        $this->get('/prestasi')
            ->assertOk()
            ->assertSee('Belum ada prestasi');
    }
}
