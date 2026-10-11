# Panduan Migration SIRAT

> **PENTING (Arsitektur Multi-Repo):**
> Seluruh migrasi database **HANYA dikelola dan dijalankan di dalam repository Backend (`rt02-sirat-backend`)**.
> Repository Frontend (`rt02-sirat-frontend`) dilarang menjalankan `php artisan migrate:fresh` karena skema database `rt02-db` dikelola terpusat dari Backend.

Jalankan command ini **satu per satu** di terminal, di dalam folder project backend (`rt02-sirat` / `rt02-sirat-backend`). Urutannya penting karena ada foreign key yang saling bergantung.

---

## 0. Modifikasi tabel `users` bawaan (tambah kolom role)

Laravel udah otomatis bikin migration `users` — kita tinggal **edit file yang udah ada**, bukan bikin baru. Cari file:
```
database/migrations/0001_01_01_000000_create_users_table.php
```
Tambahkan baris ini di dalam `Schema::create('users', ...)`, setelah `$table->string('password')`:
```php
$table->enum('role', ['admin', 'warga'])->default('warga');
```

---

## 1. Bloks

```bash
php artisan make:migration create_bloks_table
```
Isi file-nya:
```php
Schema::create('bloks', function (Blueprint $table) {
    $table->id();
    $table->string('nama_blok');
    $table->timestamps();
});
```

## 2. Rumahs

```bash
php artisan make:migration create_rumahs_table
```
```php
Schema::create('rumahs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('blok_id')->constrained('bloks')->cascadeOnDelete();
    $table->string('nomor_rumah');
    $table->timestamps();
});
```

## 3. Kartu Keluargas

```bash
php artisan make:migration create_kartu_keluargas_table
```
```php
Schema::create('kartu_keluargas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rumah_id')->constrained('rumahs')->cascadeOnDelete();
    $table->string('nomor_kk')->unique();
    $table->string('foto_kk')->nullable();
    $table->timestamps();
});
```

## 4. Anggota Keluargas

```bash
php artisan make:migration create_anggota_keluargas_table
```
```php
Schema::create('anggota_keluargas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->cascadeOnDelete();
    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
    $table->string('nama');
    $table->string('nik')->unique();
    $table->string('tempat_lahir')->nullable();
    $table->date('tanggal_lahir')->nullable();
    $table->string('jenis_kelamin')->nullable();
    $table->string('pekerjaan')->nullable();
    $table->string('golongan_darah')->nullable();
    $table->string('status_perkawinan')->nullable();
    $table->date('tanggal_perkawinan_perceraian')->nullable();
    $table->string('status_hubungan_keluarga')->nullable();
    $table->timestamps();
});
```

## 5. Keuangans

```bash
php artisan make:migration create_keuangans_table
```
```php
Schema::create('keuangans', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal');
    $table->enum('jenis', ['income', 'expense']);
    $table->string('kategori');
    $table->string('nama_barang');
    $table->integer('jumlah');
    $table->decimal('harga_satuan', 15, 2);
    $table->decimal('total', 15, 2);
    $table->decimal('saldo', 15, 2);
    $table->text('keterangan')->nullable();
    $table->timestamps();
});
```

## 6. Unit Darurats

```bash
php artisan make:migration create_unit_darurats_table
```
```php
Schema::create('unit_darurats', function (Blueprint $table) {
    $table->id();
    $table->string('nama_unit');
    $table->timestamps();
});
```

## 7. Nomor Darurats

```bash
php artisan make:migration create_nomor_darurats_table
```
```php
Schema::create('nomor_darurats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('unit_darurat_id')->constrained('unit_darurats')->cascadeOnDelete();
    $table->string('lokasi');
    $table->string('nomor_telepon');
    $table->timestamps();
});
```

## 8. Kegiatans

```bash
php artisan make:migration create_kegiatans_table
```
```php
Schema::create('kegiatans', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kegiatan');
    $table->string('slug')->unique();
    $table->date('tanggal');
    $table->text('deskripsi')->nullable();
    $table->string('foto_dokumentasi')->nullable();
    $table->timestamps();
});
```

## 9. Absensis

```bash
php artisan make:migration create_absensis_table
```
```php
Schema::create('absensis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kegiatan_id')->constrained('kegiatans')->cascadeOnDelete();
    $table->foreignId('anggota_keluarga_id')->constrained('anggota_keluargas')->cascadeOnDelete();
    $table->string('status_hadir')->default('hadir');
    $table->timestamps();
});
```

---

## Terakhir: jalankan semua migration

```bash
php artisan migrate
```

Kalau ada kesalahan di tengah jalan dan mau ulang dari nol (hati-hati, ini hapus semua data):
```bash
php artisan migrate:fresh
```
