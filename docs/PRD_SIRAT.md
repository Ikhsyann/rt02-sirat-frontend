# Product Requirements Document (PRD)
## Sistem Informasi Rumah Tangga (SIRAT) — Rebuild

---

## 1. Latar Belakang

SIRAT (Sistem Informasi Rumah Tangga) adalah aplikasi manajemen administrasi tingkat RT/RW yang sebelumnya sudah dikembangkan oleh tim lain. Project ini merupakan **pembuatan ulang (rebuild)** dari SIRAT versi sebelumnya, sebagai bagian dari **program pengembangan desa**.

Tujuan rebuild ini adalah untuk **memperbaiki kekurangan** dari versi sebelumnya. Aplikasi hasil rebuild ini direncanakan untuk **benar-benar digunakan** oleh RT/RW tertentu, bukan sekadar demo.

> Catatan: Nama produk final masih menggunakan "SIRAT" untuk sementara — rencana penggantian nama masih dalam pembahasan.

---

## 2. Tujuan Produk

Mempermudah pengurus RT dalam mengelola administrasi warga secara digital dan terpusat, mencakup:
- Data kependudukan (blok, rumah, kartu keluarga, anggota keluarga)
- Keuangan RT (pemasukan & pengeluaran)
- Kontak darurat
- Kegiatan warga beserta dokumentasi dan absensi

Dengan SIRAT, pengurus RT diharapkan dapat mengakses data secara efisien dan transparan, serta meningkatkan komunikasi antara pengurus dan warga.

---

## 3. Target Pengguna

| Role | Deskripsi Akses |
|---|---|
| **Admin** (Pengurus RT) | Akses penuh — kelola seluruh data (blok, rumah, kartu keluarga, anggota keluarga, keuangan, nomor darurat, kegiatan) |
| **Warga** | Akses terbatas — 1 akun Warga terhubung (linked) ke 1 data Anggota Keluarga tertentu; dapat melihat data yang relevan bagi mereka |
| **Publik** (tanpa login) | Dapat melihat halaman Beranda tanpa perlu akun |

---

## 4. Ruang Lingkup Fitur

Seluruh fitur dari versi SIRAT sebelumnya dipertahankan tanpa pengurangan:

### 4.1 Login & Logout
- Login dengan email & password, opsi "remember me"
- Role-based access (Admin / Warga)
- Logout dengan konfirmasi

### 4.2 Keuangan
- Melihat data keuangan (tanggal, jenis, kategori, nama barang, jumlah, harga satuan, total, saldo, keterangan)
- Menambah data keuangan
- Mengubah & menghapus data keuangan
- Export data keuangan ke Excel
- Kategori bersifat **input teks bebas** (bukan dropdown tetap)

### 4.3 Nomor Darurat
- Melihat daftar unit darurat (Pemadam Kebakaran, Polisi, Rumah Sakit, dll)
- Melihat nomor telepon darurat per lokasi dalam suatu unit
- Menambah, mengubah, dan menghapus nomor darurat

### 4.4 Kegiatan Warga (+ Berita/Pengumuman Publik)
- Melihat list kegiatan (nama, tanggal, deskripsi)
- Menambah kegiatan baru (dengan foto dokumentasi)
- Mengubah & menghapus data kegiatan
- **Absensi kegiatan dicatat per Anggota Keluarga** (tercatat siapa saja yang hadir, bukan sekadar foto bukti)
- **Halaman publik** — fitur Kegiatan diperluas berfungsi juga sebagai halaman **Beranda** (Berita/Pengumuman) yang dapat diakses siapa saja tanpa login, mengacu pada pola situs Kelurahan Marga Sari (margasari-balikpapan.id):
  - Halaman utama menampilkan beberapa kegiatan/berita terbaru (preview + tombol "Lihat Semua")
  - Halaman list lengkap dengan pagination
  - Setiap kegiatan/berita punya halaman detail sendiri (URL berbasis slug)

### 4.5 Data Blok & Warga
Struktur data bertingkat:
```
Blok → Rumah → Kartu Keluarga → Anggota Keluarga
```
- Blok: tambah, ubah, hapus nama blok
- Rumah: tambah, ubah, hapus nomor rumah (di dalam sebuah blok)
- Kartu Keluarga: tambah, ubah, hapus (nomor KK + foto KK) di dalam sebuah rumah
- Anggota Keluarga: tambah, ubah, hapus data anggota (nama, email, password, NIK, tempat lahir, tanggal lahir, jenis kelamin, pekerjaan, golongan darah, status perkawinan, tanggal perkawinan/perceraian, status hubungan keluarga) di dalam sebuah Kartu Keluarga

---

## 5. Batasan (Constraints)

### 5.1 Tech Stack & Repositories

Aplikasi diorganisir menggunakan arsitektur **Multi-Repo dengan Shared Database**:

| Komponen | Teknologi | Repository | Keterangan |
|---|---|---|---|
| **Backend & Admin** | Laravel 12 + Filament v5 | [`rt02-sirat-backend`](https://github.com/Ikhsyann/rt02-sirat-backend) | Admin Panel pengurus RT, single source of truth skema & migrasi DB |
| **Frontend & Publik** | Laravel 12 + Blade + Breeze | [`rt02-sirat-frontend`](https://github.com/Ikhsyann/rt02-sirat-frontend) | Portal Warga, Beranda publik, dokumentasi kegiatan, detail artikel |
| **Admin Panel** | Filament v5 | Di Backend (`/admin`) | CRUD otomatis untuk pengurus RT |
| **Auth Warga** | Laravel Breeze | Di Frontend (`/login`) | Login warga terhubung 1-to-1 ke data Anggota Keluarga |
| **Database** | MySQL 8.0 (`rt02-db`) | Bersama (Shared) | Kedua repo membaca & menulis ke basis data yang sama |
| **CSS / Styling** | Tailwind CSS + Vite | Di Frontend & Backend | Desain responsif (mobile-first) |
| **Export Excel** | Maatwebsite/Laravel-Excel | Di Backend | Export laporan keuangan RT |
| **Upload File** | Laravel Storage | Di Backend & Frontend | Foto KK & dokumentasi kegiatan warga |

### 5.2 Deployment
- Wajib deploy publik (ketentuan program pengembangan desa)
- Hosting: **Jagoan Hosting**

### 5.3 Aturan Bisnis Utama
- 1 akun login Warga terhubung ke tepat 1 data Anggota Keluarga
- Kategori pada modul Keuangan bersifat teks bebas, bukan daftar tetap
- Halaman Beranda dapat diakses publik tanpa login

---

## 6. Use Case Diagram

### Aktor
- **Admin** (Pengurus RT) — akses penuh untuk kelola seluruh data
- **Warga** — akses login terbatas, terhubung ke data Anggota Keluarga miliknya sendiri
- **Publik** — tanpa login, hanya dapat mengakses halaman Beranda (Kegiatan/Berita)

### Use Case per Aktor

| Aktor | Use Case |
|---|---|
| Admin | Login & Logout |
| Admin | Kelola data warga (Blok, Rumah, Kartu Keluarga, Anggota Keluarga) |
| Admin | Kelola keuangan |
| Admin | Kelola nomor darurat |
| Admin | Kelola kegiatan |
| Warga | Login & Logout |
| Warga | Lihat keuangan |
| Warga | Lihat nomor darurat |
| Warga | Lihat data keluarga sendiri |
| Publik | Lihat Beranda (kegiatan/berita) |

---

## 7. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
  BLOKS ||--o{ RUMAHS : memiliki
  RUMAHS ||--o{ KARTU_KELUARGAS : memiliki
  KARTU_KELUARGAS ||--o{ ANGGOTA_KELUARGAS : memiliki
  USERS ||--o| ANGGOTA_KELUARGAS : terhubung
  UNIT_DARURATS ||--o{ NOMOR_DARURATS : memiliki
  KEGIATANS ||--o{ ABSENSIS : memiliki
  ANGGOTA_KELUARGAS ||--o{ ABSENSIS : menghadiri

  BLOKS {
    bigint id PK
    string nama_blok
  }
  RUMAHS {
    bigint id PK
    bigint blok_id FK
    string nomor_rumah
  }
  KARTU_KELUARGAS {
    bigint id PK
    bigint rumah_id FK
    string nomor_kk
    string foto_kk
  }
  ANGGOTA_KELUARGAS {
    bigint id PK
    bigint kartu_keluarga_id FK
    bigint user_id FK
    string nama
    string nik
    string tempat_lahir
    date tanggal_lahir
    string jenis_kelamin
    string pekerjaan
    string golongan_darah
    string status_perkawinan
    date tanggal_perkawinan_perceraian
    string status_hubungan_keluarga
  }
  USERS {
    bigint id PK
    string name
    string email
    string password
    string role
  }
  KEUANGANS {
    bigint id PK
    date tanggal
    string jenis
    string kategori
    string nama_barang
    int jumlah
    decimal harga_satuan
    decimal total
    decimal saldo
    string keterangan
  }
  UNIT_DARURATS {
    bigint id PK
    string nama_unit
  }
  NOMOR_DARURATS {
    bigint id PK
    bigint unit_darurat_id FK
    string lokasi
    string nomor_telepon
  }
  KEGIATANS {
    bigint id PK
    string nama_kegiatan
    string slug
    date tanggal
    string deskripsi
    string foto_dokumentasi
  }
  ABSENSIS {
    bigint id PK
    bigint kegiatan_id FK
    bigint anggota_keluarga_id FK
    string status_hadir
  }
```

**Catatan relasi:**
- Hierarki utama: Blok → Rumah → Kartu Keluarga → Anggota Keluarga
- 1 akun `Users` (role Warga) terhubung ke tepat 1 `Anggota Keluarga`
- `Absensi` adalah tabel pivot antara `Kegiatan` dan `Anggota Keluarga`, mencatat siapa saja yang hadir per kegiatan
- `Keuangan` berdiri sendiri, tidak punya relasi foreign key ke tabel lain

---

## 8. Wireframe

![Wireframe Beranda, Beranda Warga, dan Isi Berita/Kegiatan](wireframes/wireframe_beranda.png)

**Beranda (Publik)** — dapat diakses tanpa login:
- Header: Logo + tombol Login
- Hero section: judul sambutan, tagline, tombol Layanan
- Section Berita/Kegiatan: carousel dengan navigasi kiri-kanan + dots pagination
- Section Tentang + peta lokasi
- Footer: info RT, kontak, sosial media, copyright

**Beranda Warga** — setelah login sebagai Warga:
- Header: Logo + Nama Warga (menggantikan tombol Login)
- Tombol "Kembali ke beranda"
- Hero section: judul sambutan khusus warga
- Section "Layanan": 3 card (Lihat Keuangan, Lihat Nomor Darurat, Lihat Data Keluarga)
- Footer sama seperti Beranda Publik

**Isi Berita/Kegiatan** — halaman detail:
- Header sama seperti Beranda Warga
- Tombol "Kembali ke beranda"
- Judul kegiatan/berita, gambar, isi konten, tombol "Bagikan artikel ini"
- Digunakan khusus untuk detail Berita/Kegiatan

> Catatan: Halaman detail untuk Keuangan, Nomor Darurat, dan Data Keluarga masing-masing akan memiliki layout tersendiri (sesuai jenis kontennya — tabular, daftar kontak, struktur keluarga), namun tetap konsisten secara visual dengan wireframe di atas.

---

## 9. Arsitektur Sistem

SIRAT menggunakan arsitektur **Multi-Repo dengan Shared Database** (mengadopsi pola pemisahan *back-door* dan *front-door* seperti pada repo referensi kepanitiaan):

```
                        ┌──────────────────────────────┐
                        │   MySQL Database (rt02-db)   │
                        │   (Single Source of Truth)   │
                        └──────────────┬───────────────┘
                                       │
                    ┌──────────────────┴──────────────────┐
                    ▼                                     ▼
        ┌─────────────────────────┐           ┌─────────────────────────┐
        │  Repo 1: BACKEND        │           │  Repo 2: FRONTEND       │
        │  (rt02-sirat-backend)   │           │  (rt02-sirat-frontend)  │
        ├─────────────────────────┤           ├─────────────────────────┤
        │ • Laravel 12 + Filament │           │ • Laravel 12 + Blade    │
        │ • Admin Panel (/admin)  │           │ • Auth Warga (Breeze)   │
        │ • Pemilik Migrasi & DB  │           │ • Beranda Publik (/)    │
        │ • Port: 8000            │           │ • Port: 8001            │
        └─────────────────────────┘           └─────────────────────────┘
```

**Alur & Pembagian Tanggung Jawab:**
1. **Browser (Klien)**:
   - Pengurus RT mengakses: `http://domain-admin/admin` (Repo Backend).
   - Warga & Masyarakat Umum mengakses: `http://domain-utama/` dan `/login` (Repo Frontend).
2. **Repository Backend (`rt02-sirat-backend`)**:
   - Menjalankan Filament v5 Admin Panel dengan CRUD lengkap.
   - Mengelola **seluruh migrasi tabel dan data seeder** (Database Single Source of Truth).
   - Menjalankan export laporan keuangan ke Excel.
3. **Repository Frontend (`rt02-sirat-frontend`)**:
   - Menjalankan Blade Views untuk halaman publik (Beranda carousel kegiatan & berita) dan halaman portal warga (Dashboard, Layanan Data Keluarga, Keuangan, Kontak Darurat).
   - Menjalankan sistem autentikasi warga via Laravel Breeze yang membaca tabel `users` pada database bersama.
   - Menggunakan model-model Eloquent yang diselaraskan dengan skema database backend.
4. **MySQL Database (`rt02-db`)**:
   - Basis data bersama di server/hosting yang sama, diakses oleh kedua aplikasi Laravel.
5. **Vite**:
   - Digunakan di masing-masing repo untuk meng-compile asset CSS (Tailwind) & JavaScript ke folder `public/build/`.

---

## 10. Belum Ditentukan / Next Steps

- [ ] Wireframe halaman lain (Keuangan, Nomor Darurat, Data Keluarga, Login)
- [ ] Nama final produk (masih "SIRAT" sementara)

---

*Dokumen ini adalah draft awal dan dapat berkembang seiring proses development.*
