# Panduan Model & Seeder SIRAT

> **PENTING (Arsitektur Multi-Repo):**
> - **Model (Bagian 1)**: Wajib disinkronkan dan berada di folder `app/Models/` pada **KEDUA repository** (`rt02-sirat-backend` dan `rt02-sirat-frontend`) agar kedua aplikasi dapat melakukan query ke tabel-tabel yang sama.
> - **Seeder (Bagian 2)**: **HANYA dijalankan di repository Backend (`rt02-sirat-backend`)**.

## Bagian 1: Model + Relasi

Generate semua model dulu (tanpa `-m` karena migration udah ada):

```bash
php artisan make:model Blok
php artisan make:model Rumah
php artisan make:model KartuKeluarga
php artisan make:model AnggotaKeluarga
php artisan make:model Keuangan
php artisan make:model UnitDarurat
php artisan make:model NomorDarurat
php artisan make:model Kegiatan
php artisan make:model Absensi
```

Lalu isi tiap file di `app/Models/` dengan kode berikut.

### User (edit file yang sudah ada: `app/Models/User.php`)
Tambahkan relasi ini di dalam class, dan tambahkan `'role'` ke `$fillable`:
```php
public function anggotaKeluarga()
{
    return $this->hasOne(AnggotaKeluarga::class);
}
```

### Blok.php
```php
class Blok extends Model
{
    protected $fillable = ['nama_blok'];

    public function rumahs()
    {
        return $this->hasMany(Rumah::class);
    }
}
```

### Rumah.php
```php
class Rumah extends Model
{
    protected $fillable = ['blok_id', 'nomor_rumah'];

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }
}
```

### KartuKeluarga.php
```php
class KartuKeluarga extends Model
{
    protected $fillable = ['rumah_id', 'nomor_kk', 'foto_kk'];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class);
    }

    public function anggotaKeluargas()
    {
        return $this->hasMany(AnggotaKeluarga::class);
    }
}
```

### AnggotaKeluarga.php
```php
class AnggotaKeluarga extends Model
{
    protected $fillable = [
        'kartu_keluarga_id', 'user_id', 'nama', 'nik', 'tempat_lahir',
        'tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'golongan_darah',
        'status_perkawinan', 'tanggal_perkawinan_perceraian', 'status_hubungan_keluarga',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_perkawinan_perceraian' => 'date',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
```

### Keuangan.php
```php
class Keuangan extends Model
{
    protected $fillable = [
        'tanggal', 'jenis', 'kategori', 'nama_barang', 'jumlah',
        'harga_satuan', 'total', 'saldo', 'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
```

### UnitDarurat.php
```php
class UnitDarurat extends Model
{
    protected $fillable = ['nama_unit'];

    public function nomorDarurats()
    {
        return $this->hasMany(NomorDarurat::class);
    }
}
```

### NomorDarurat.php
```php
class NomorDarurat extends Model
{
    protected $fillable = ['unit_darurat_id', 'lokasi', 'nomor_telepon'];

    public function unitDarurat()
    {
        return $this->belongsTo(UnitDarurat::class);
    }
}
```

### Kegiatan.php
```php
class Kegiatan extends Model
{
    protected $fillable = ['nama_kegiatan', 'slug', 'tanggal', 'deskripsi', 'foto_dokumentasi'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function anggotaHadir()
    {
        return $this->belongsToMany(AnggotaKeluarga::class, 'absensis');
    }
}
```

### Absensi.php
```php
class Absensi extends Model
{
    protected $fillable = ['kegiatan_id', 'anggota_keluarga_id', 'status_hadir'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class);
    }
}
```

---

## Bagian 2: Seeder Data Dummy

```bash
php artisan make:seeder BlokSeeder
```

Isi `database/seeders/DatabaseSeeder.php` — ini seeder utama yang jalanin semuanya sekaligus dan sudah berisi data dummy langsung (tidak perlu bikin seeder terpisah per tabel):

```php
<?php

namespace Database\Seeders;

use App\Models\{Blok, Rumah, KartuKeluarga, AnggotaKeluarga, User, Keuangan, UnitDarurat, NomorDarurat, Kegiatan, Absensi};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin RT 02',
            'email' => 'admin@rt02.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Blok, Rumah, Kartu Keluarga, Anggota Keluarga
        $blok = Blok::create(['nama_blok' => 'F1']);
        $rumah = Rumah::create(['blok_id' => $blok->id, 'nomor_rumah' => 'F1-1']);
        $kk = KartuKeluarga::create(['rumah_id' => $rumah->id, 'nomor_kk' => '3271010101010001']);

        $userWarga = User::create([
            'name' => 'Budi Santoso',
            'email' => 'warga@rt02.test',
            'password' => bcrypt('password'),
            'role' => 'warga',
        ]);

        $anggota = AnggotaKeluarga::create([
            'kartu_keluarga_id' => $kk->id,
            'user_id' => $userWarga->id,
            'nama' => 'Budi Santoso',
            'nik' => '6471010101010001',
            'tempat_lahir' => 'Balikpapan',
            'tanggal_lahir' => '1990-05-10',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'Wiraswasta',
            'golongan_darah' => 'O',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
        ]);

        // Keuangan
        Keuangan::create([
            'tanggal' => now(),
            'jenis' => 'income',
            'kategori' => 'Iuran',
            'nama_barang' => 'Iuran Warga Bulan Ini',
            'jumlah' => 1,
            'harga_satuan' => 50000,
            'total' => 50000,
            'saldo' => 50000,
        ]);

        // Nomor Darurat
        $unit = UnitDarurat::create(['nama_unit' => 'Pemadam Kebakaran']);
        NomorDarurat::create([
            'unit_darurat_id' => $unit->id,
            'lokasi' => 'Balikpapan Timur',
            'nomor_telepon' => '0800000',
        ]);

        // Kegiatan + Absensi
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Kerja Bakti',
            'slug' => Str::slug('Kerja Bakti ' . now()->timestamp),
            'tanggal' => now(),
            'deskripsi' => 'Kerja bakti membersihkan lingkungan RT',
        ]);

        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'anggota_keluarga_id' => $anggota->id,
            'status_hadir' => 'hadir',
        ]);
    }
}
```

Jalankan:
```bash
php artisan db:seed
```

Kalau mau reset database + isi ulang data dummy dari nol:
```bash
php artisan migrate:fresh --seed
```
