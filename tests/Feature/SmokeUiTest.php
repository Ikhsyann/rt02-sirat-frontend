<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Smoke UI SIRAT frontend.
 * RefreshDatabase migrasi hanya tabel bawaan Breeze (users/cache/jobs);
 * schema domain dibuat inline per-test via sqlite :memory: (phpunit.xml),
 * sehingga MySQL rt02-db yang berbagi dengan repo Backend tidak tersentuh,
 * dan tidak ada file migrasi baru di repo frontend.
 */
class SmokeUiTest extends TestCase
{
    use RefreshDatabase;

    private function BuatTabelKegiatan(): void
    {
        Schema::dropIfExists('absensis');
        Schema::dropIfExists('kegiatans');
        Schema::dropIfExists('kartu_keluargas');

        Schema::create('kartu_keluargas', function (Blueprint $t) {
            $t->id();
            $t->timestamps();
        });
        Schema::create('kegiatans', function (Blueprint $t) {
            $t->id();
            $t->string('nama_kegiatan');
            $t->string('slug')->unique();
            $t->date('tanggal');
            $t->text('deskripsi')->nullable();
            $t->string('foto_dokumentasi')->nullable();
            $t->timestamps();
        });
        Schema::create('absensis', function (Blueprint $t) {
            $t->id();
            $t->foreignId('kegiatan_id');
            $t->unsignedBigInteger('anggota_keluarga_id')->nullable();
            $t->string('status_hadir');
            $t->timestamps();
        });
    }

    private function BuatTabelKeluarga(): void
    {
        Schema::dropIfExists('anggota_keluargas');
        Schema::dropIfExists('kartu_keluargas');
        Schema::dropIfExists('rumahs');
        Schema::dropIfExists('bloks');

        Schema::create('bloks', function (Blueprint $t) {
            $t->id();
            $t->string('nama_blok');
            $t->timestamps();
        });
        Schema::create('rumahs', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('blok_id');
            $t->string('nomor_rumah');
            $t->timestamps();
        });
        Schema::create('kartu_keluargas', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('rumah_id');
            $t->string('nomor_kk');
            $t->string('foto_kk')->nullable();
            $t->timestamps();
        });
        Schema::create('anggota_keluargas', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('kartu_keluarga_id');
            $t->unsignedBigInteger('user_id')->nullable();
            $t->string('nama');
            $t->string('nik')->nullable();
            $t->string('tempat_lahir')->nullable();
            $t->date('tanggal_lahir')->nullable();
            $t->string('jenis_kelamin')->nullable();
            $t->string('pekerjaan')->nullable();
            $t->string('golongan_darah')->nullable();
            $t->string('status_perkawinan')->nullable();
            $t->string('tanggal_perkawinan_perceraian')->nullable();
            $t->string('status_hubungan_keluarga')->nullable();
            $t->timestamps();
        });
    }

    private function Baris(string $tabel, array $data): void
    {
        DB::table($tabel)->insert($data + ['created_at' => now(), 'updated_at' => now()]);
    }

    public function test_halaman_publik_dapat_diakses(): void
    {
        $this->BuatTabelKegiatan();

        Kegiatan::create([
            'nama_kegiatan' => 'Kerja Bakti Lingkungan',
            'slug' => 'kerja-bakti',
            'tanggal' => now()->toDateString(),
            'deskripsi' => "Paragraf pertama.\nParagraf kedua.",
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Selamat datang')
            ->assertSee('Kerja Bakti Lingkungan');

        $this->get('/kegiatan')->assertOk()->assertSee('Kerja Bakti Lingkungan');
        $this->get('/kegiatan/kerja-bakti')->assertOk()
            ->assertSee('Kerja Bakti Lingkungan')
            ->assertSee('Paragraf pertama.');
    }

    public function test_pencarian_kegiatan_bertahan_saat_pindah_halaman(): void
    {
        $this->BuatTabelKegiatan();

        foreach (range(1, 7) as $i) {
            Kegiatan::create([
                'nama_kegiatan' => 'Kerja Bakti '.$i,
                'slug' => 'kerja-bakti-'.$i,
                'tanggal' => now()->subDays($i)->toDateString(),
            ]);
        }

        $this->get('/kegiatan?q=Kerja Bakti')
            ->assertOk()
            ->assertSee('q=Kerja', false)
            ->assertSee('page=2', false);
    }

    public function test_pencarian_kegiatan_menganggap_persen_sebagai_teks_biasa(): void
    {
        $this->BuatTabelKegiatan();

        Kegiatan::create([
            'nama_kegiatan' => 'Diskon 100%',
            'slug' => 'diskon-100',
            'tanggal' => now()->toDateString(),
        ]);
        Kegiatan::create([
            'nama_kegiatan' => 'Kerja Bakti',
            'slug' => 'kerja-bakti',
            'tanggal' => now()->subDay()->toDateString(),
        ]);

        $this->get('/kegiatan?q='.urlencode('100%'))
            ->assertOk()
            ->assertSee('Diskon 100%')
            ->assertDontSee('Kerja Bakti');
    }

    public function test_parameter_array_tidak_menyebabkan_error(): void
    {
        $this->BuatTabelKegiatan();

        $this->get('/kegiatan?q[]=x')->assertOk();
    }

    public function test_halaman_warga_wajib_login(): void
    {
        foreach (['/dashboard', '/layanan/keuangan', '/layanan/nomor-darurat', '/layanan/data-keluarga', '/profile'] as $halaman) {
            $this->get($halaman)->assertRedirect(route('login'));
        }
    }

    public function test_warga_hanya_melihat_keluarga_miliknya(): void
    {
        $this->BuatTabelKeluarga();

        $this->Baris('bloks', ['nama_blok' => 'F1']);
        $this->Baris('rumahs', ['blok_id' => 1, 'nomor_rumah' => 'B 04']);
        $this->Baris('kartu_keluargas', ['rumah_id' => 1, 'nomor_kk' => '64710001', 'foto_kk' => null]);
        $this->Baris('kartu_keluargas', ['rumah_id' => 1, 'nomor_kk' => '64710002', 'foto_kk' => null]);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->Baris('anggota_keluargas', ['kartu_keluarga_id' => 1, 'user_id' => $user1->id, 'nama' => 'Bpk. Hendra', 'status_hubungan_keluarga' => 'Kepala Keluarga']);
        $this->Baris('anggota_keluargas', ['kartu_keluarga_id' => 2, 'user_id' => $user2->id, 'nama' => 'Ibu Sri', 'status_hubungan_keluarga' => 'Kepala Keluarga']);

        $this->actingAs($user1)
            ->get('/layanan/data-keluarga')
            ->assertOk()
            ->assertSee('64710001')
            ->assertSee('Bpk. Hendra')
            ->assertDontSee('64710002')
            ->assertDontSee('Ibu Sri');
    }

    public function test_foto_kk_hanya_dapat_diakses_pemiliknya(): void
    {
        $this->BuatTabelKeluarga();
        Storage::fake('kk');
        Storage::disk('kk')->put('kartu-keluarga/satu.jpg', 'foto-kk-satu');
        Storage::disk('kk')->put('kartu-keluarga/dua.jpg', 'foto-kk-dua');

        $this->Baris('bloks', ['nama_blok' => 'F1']);
        $this->Baris('rumahs', ['blok_id' => 1, 'nomor_rumah' => 'B 04']);
        $this->Baris('kartu_keluargas', ['rumah_id' => 1, 'nomor_kk' => '64710001', 'foto_kk' => 'kartu-keluarga/satu.jpg']);
        $this->Baris('kartu_keluargas', ['rumah_id' => 1, 'nomor_kk' => '64710002', 'foto_kk' => 'kartu-keluarga/dua.jpg']);
        $this->Baris('kartu_keluargas', ['rumah_id' => 1, 'nomor_kk' => '64710003', 'foto_kk' => null]);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->Baris('anggota_keluargas', ['kartu_keluarga_id' => 1, 'user_id' => $user1->id, 'nama' => 'Bpk. Hendra']);
        $this->Baris('anggota_keluargas', ['kartu_keluarga_id' => 2, 'user_id' => $user2->id, 'nama' => 'Ibu Sri']);
        $this->Baris('anggota_keluargas', ['kartu_keluarga_id' => 3, 'user_id' => $user3->id, 'nama' => 'Bpk. Tanpa Foto']);

        $this->get(route('layanan.data-keluarga.foto'))->assertRedirect(route('login'));

        $this->actingAs($user1)->get(route('layanan.data-keluarga.foto'))
            ->assertOk()
            ->assertStreamedContent('foto-kk-satu');

        $this->actingAs($user2)->get(route('layanan.data-keluarga.foto'))
            ->assertOk()
            ->assertStreamedContent('foto-kk-dua');

        $this->actingAs($user3)->get(route('layanan.data-keluarga.foto'))->assertNotFound();
    }
}
