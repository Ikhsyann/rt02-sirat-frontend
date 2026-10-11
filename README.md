# SIRAT Frontend (Portal Warga & Beranda Publik)

Sistem Informasi Rumah Tangga (SIRAT) — RT 02.
Repository ini berfungsi sebagai **Frontend (Portal Warga & Beranda Publik)** yang membaca data dari database bersama `rt02-db`.

## Spesifikasi & Tech Stack
- **Framework**: Laravel 12
- **Auth Warga**: Laravel Breeze (`/login`)
- **UI & Templating**: Blade + Tailwind CSS + Vite
- **Database**: MySQL 8.0 (`rt02-db` di DBngin) — *Shared Database dengan Backend*
- **Port Default**: `8001` (`http://127.0.0.1:8001`)

## Peran & Tanggung Jawab
1. **Halaman Publik (`/`)**:
   - Beranda Berita & Dokumentasi Kegiatan RT (Carousel, list pagination, detail artikel dengan slug).
2. **Portal Warga (`/login` & `/dashboard`)**:
   - Login warga (terhubung 1-to-1 dengan data `AnggotaKeluarga`).
   - Layanan Warga: Data Keluarga, Laporan Keuangan RT (read-only), Nomor Darurat RT.

## Catatan Penting
> **JANGAN JALANKAN `php artisan migrate:fresh` DI REPO INI!**
> Seluruh migrasi database dikelola oleh repository Backend (`rt02-sirat`).

## Cara Menjalankan
```bash
composer install
npm install
npm run dev
php artisan serve --port=8001
```
Login Warga: `warga@rt02.test` / `password`.
