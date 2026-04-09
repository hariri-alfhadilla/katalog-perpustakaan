<h1 align="center">📚 BoBooks — Sistem Manajemen Perpustakaan</h1>

<p align="center">
  Aplikasi web manajemen perpustakaan berbasis <strong>Laravel 11</strong> yang memungkinkan siswa meminjam buku secara digital dan admin mengelola seluruh data perpustakaan.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel" alt="Laravel 11"/>
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php" alt="PHP 8.2+"/>
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38bdf8?style=flat-square&logo=tailwindcss" alt="Tailwind CSS"/>
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8bc0d0?style=flat-square&logo=alpine.js" alt="Alpine.js"/>
  <img src="https://img.shields.io/badge/Vite-5.x-646CFF?style=flat-square&logo=vite" alt="Vite"/>
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License"/>
</p>

---

## 📚 Dokumentasi Lengkap

| Dokumen | Deskripsi |
|---|---|
| 📖 [README.md](./README.md) | Gambaran umum proyek (file ini) |
| 🏛 [ARCHITECTURE.md](./ARCHITECTURE.md) | Keputusan arsitektur & alur data |
| 🗂 [CODEBASE.md](./CODEBASE.md) | Peta dependensi antar file |
| 👤 [docs/USER_GUIDE.md](./docs/USER_GUIDE.md) | Panduan penggunaan untuk siswa & admin |
| 🛠 [docs/DEVELOPER_GUIDE.md](./docs/DEVELOPER_GUIDE.md) | Panduan setup & pengembangan |

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Arsitektur Aplikasi](#-arsitektur-aplikasi)
- [Struktur Database](#-struktur-database)
- [Struktur Direktori](#-struktur-direktori)
- [Alur Aplikasi (Flow)](#-alur-aplikasi-flow)
- [Routes & Endpoint](#-routes--endpoint)
- [Controllers](#-controllers)
- [Models & Relasi](#-models--relasi)
- [Middleware](#-middleware)
- [Peran Pengguna (Role System)](#-peran-pengguna-role-system)
- [Instalasi & Setup](#-instalasi--setup)
- [Konfigurasi Environment](#-konfigurasi-environment)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Deployment](#-deployment)

---

## 🎯 Tentang Proyek

**BoBooks** adalah sistem manajemen perpustakaan sekolah berbasis web yang dibangun menggunakan framework **Laravel 11**. Aplikasi ini dirancang untuk menggantikan catatan peminjaman manual dengan sistem digital yang terorganisir.

Terdapat dua jenis pengguna utama:
- **Admin** — mengelola data buku, anggota, dan menyetujui/menolak permintaan peminjaman.
- **Siswa (User)** — mencari dan meminjam buku, serta melacak status peminjaman mereka.

---

## ✨ Fitur Utama

### 👨‍💼 Fitur Admin
| Fitur | Deskripsi |
|---|---|
| Dashboard Statistik | Melihat total buku, total anggota, dan total buku yang sedang dipinjam |
| Manajemen Buku | Tambah, edit, hapus buku beserta upload cover gambar |
| Manajemen Anggota | Melihat daftar siswa terdaftar dan menghapus akun siswa |
| Kelola Peminjaman | Menyetujui (`terima`) atau menolak (`tolak`) permintaan peminjaman |
| Manajemen Stok | Stok buku berkurang otomatis saat dipinjam dan bertambah saat dikembalikan |

### 👨‍🎓 Fitur Siswa (User)
| Fitur | Deskripsi |
|---|---|
| Katalog Buku | Melihat daftar semua buku yang tersedia (stok > 0) |
| Pencarian Buku | Mencari buku berdasarkan judul atau nama penulis |
| Pinjam Buku | Mengajukan permintaan peminjaman buku |
| Riwayat Peminjaman | Melihat semua histori peminjaman dan status terkini |
| Kembalikan Buku | Melaporkan pengembalian buku secara mandiri |

### 🔒 Fitur Sistem
| Fitur | Deskripsi |
|---|---|
| Autentikasi Lengkap | Register, Login, Logout via Laravel Breeze |
| Role-Based Access Control | Middleware `CheckRole` memproteksi route Admin |
| Validasi Form | Validasi input sisi server untuk semua form |
| Flash Messages | Notifikasi sukses/error setelah setiap aksi |
| Batas Peminjaman | Maksimal 3 buku aktif per siswa pada satu waktu |
| Cegah Duplikasi | Tidak bisa meminjam buku yang sama jika masih aktif |

---

## 🛠 Tech Stack

| Kategori | Teknologi | Versi |
|---|---|---|
| **Backend Framework** | Laravel | ^11.0 |
| **Bahasa** | PHP | ^8.2 |
| **Autentikasi** | Laravel Breeze | ^2.3 |
| **Frontend CSS** | Tailwind CSS | ^3.1.0 |
| **Frontend JS** | Alpine.js | ^3.4.2 |
| **Build Tool** | Vite | ^5.0 |
| **HTTP Client** | Axios | ^1.6.4 |
| **Database** | MySQL | >= 5.7 / 8.x |
| **ORM** | Eloquent | (bawaan Laravel) |
| **Testing** | PHPUnit | ^10.5 |
| **Code Style** | Laravel Pint | ^1.13 |
| **Debug** | Spatie Ignition | ^2.4 |

---

## 🏗 Arsitektur Aplikasi

Aplikasi ini menggunakan pola **MVC (Model-View-Controller)** standar Laravel, dengan tambahan **Custom Middleware** untuk proteksi role.

```
Request → Route → Middleware → Controller → Model → Database
                                    ↓
                               View (Blade)
                                    ↓
                              Response (HTML)
```

### Layer Architecture

```
┌─────────────────────────────────────────────────┐
│                   PRESENTATION                  │
│        Blade Templates + Tailwind CSS           │
│        (resources/views/admin & user)           │
├─────────────────────────────────────────────────┤
│                   APPLICATION                   │
│   Controllers → Form Validation → Business Logic│
│   (app/Http/Controllers)                        │
├─────────────────────────────────────────────────┤
│                     DOMAIN                      │
│     Eloquent Models + Relationships             │
│     (app/Models: User, Buku, Peminjaman)        │
├─────────────────────────────────────────────────┤
│                  INFRASTRUCTURE                 │
│     MySQL Database | Storage (File Upload)      │
│     Laravel Cache | Sessions                    │
└─────────────────────────────────────────────────┘
```

---

## 🗄 Struktur Database

### Entity Relationship Diagram

```
┌──────────────┐        ┌─────────────────────┐        ┌──────────────────┐
│    users     │        │     peminjaman       │        │      buku        │
├──────────────┤        ├─────────────────────┤        ├──────────────────┤
│ id (PK)      │◄──┐    │ id (PK)             │    ┌──►│ id (PK)          │
│ name         │   └────│ user_id (FK)        │    │   │ judul            │
│ email        │        │ buku_id (FK)        │────┘   │ penulis          │
│ password     │        │ tanggal_peminjaman  │        │ penerbit         │
│ role         │        │ tanggal_pengembalian│        │ tahun_terbit     │
│ email_verified│       │ status (enum)       │        │ stok             │
│ created_at   │        │ created_at          │        │ cover            │
│ updated_at   │        │ updated_at          │        │ created_at       │
└──────────────┘        └─────────────────────┘        │ updated_at       │
                                                        └──────────────────┘
```

### Tabel: `users`

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Primary key |
| `name` | VARCHAR | NOT NULL | Nama lengkap pengguna |
| `email` | VARCHAR | UNIQUE, NOT NULL | Email (untuk login) |
| `email_verified_at` | TIMESTAMP | NULLABLE | Verifikasi email |
| `password` | VARCHAR | NOT NULL | Password ter-hash (bcrypt) |
| `role` | ENUM | NOT NULL, Default: `user` | `admin` atau `user` |
| `remember_token` | VARCHAR | NULLABLE | Token "ingat saya" |
| `created_at` | TIMESTAMP | - | Waktu dibuat |
| `updated_at` | TIMESTAMP | - | Waktu diperbarui |

### Tabel: `buku`

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Primary key |
| `cover` | VARCHAR | NULLABLE | Path file gambar cover |
| `judul` | VARCHAR | NOT NULL | Judul buku |
| `penulis` | VARCHAR | NOT NULL | Nama penulis |
| `penerbit` | VARCHAR | NOT NULL | Nama penerbit |
| `tahun_terbit` | INTEGER | NOT NULL | Tahun terbit buku |
| `stok` | INTEGER | NOT NULL | Jumlah stok tersedia |
| `created_at` | TIMESTAMP | - | Waktu dibuat |
| `updated_at` | TIMESTAMP | - | Waktu diperbarui |

### Tabel: `peminjaman`

| Kolom | Tipe | Constraint | Keterangan |
|---|---|---|---|
| `id` | BIGINT | PK, Auto Increment | Primary key |
| `user_id` | BIGINT | FK → users.id, CASCADE | ID siswa peminjam |
| `buku_id` | BIGINT | FK → buku.id, CASCADE | ID buku yang dipinjam |
| `tanggal_peminjaman` | DATE | NULLABLE | Tanggal resmi dipinjam (diset admin) |
| `tanggal_pengembalian` | DATE | NULLABLE | Tanggal buku dikembalikan |
| `status` | ENUM | Default: `menunggu` | `menunggu` / `dipinjam` / `dikembalikan` / `ditolak` |
| `created_at` | TIMESTAMP | - | Waktu dibuat |
| `updated_at` | TIMESTAMP | - | Waktu diperbarui |

#### Status Peminjaman (State Machine)

```
[Siswa Mengajukan]
       │
       ▼
  ┌─────────┐
  │ menunggu │
  └────┬────┘
       │
   ┌───┴───┐
   ▼       ▼
┌──────┐ ┌────────┐
│dipinjam│ │ ditolak│
└───┬───┘ └────────┘
    │
    ▼
┌─────────────┐
│ dikembalikan │
└─────────────┘
```

---

## 📁 Struktur Direktori

```
bobooks/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/               # Controller autentikasi (Breeze)
│   │   │   ├── AnggotaController.php
│   │   │   ├── BukuController.php
│   │   │   ├── Controller.php      # Base controller
│   │   │   ├── DashboardController.php
│   │   │   ├── PeminjamanController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php       # Custom role guard
│   │   └── Requests/               # Form Request (validasi)
│   ├── Models/
│   │   ├── Buku.php
│   │   ├── Peminjaman.php
│   │   └── User.php
│   ├── Providers/
│   └── View/
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_cache_table.php
│   │   ├── ..._create_jobs_table.php
│   │   ├── 2026_02_08_..._create_buku_table.php
│   │   └── 2026_02_08_..._create_peminjaman_table.php
│   ├── seeders/
│   └── (MySQL — konfigurasi via .env)
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── buku/               # Index, Create, Edit buku
│       │   ├── anggota/            # Index daftar anggota
│       │   └── peminjaman/         # Index kelola peminjaman
│       ├── auth/                   # Login, Register, dll (Breeze)
│       ├── components/             # Komponen Blade reusable
│       ├── layouts/                # Layout utama aplikasi
│       ├── profile/                # Halaman profil
│       ├── user/
│       │   ├── dashboard.blade.php # Katalog buku siswa
│       │   └── peminjaman.blade.php # Riwayat peminjaman siswa
│       └── welcome.blade.php       # Halaman landing
├── routes/
│   ├── auth.php                    # Route autentikasi Breeze
│   ├── console.php
│   └── web.php                     # Route utama aplikasi
├── storage/
│   └── app/public/covers/          # Penyimpanan gambar cover
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## 🔄 Alur Aplikasi (Flow)

### Alur Siswa Meminjam Buku

```
1. Siswa Login
        │
        ▼
2. Buka Dashboard (Katalog Buku)
        │
        ▼
3. Cari / Pilih Buku  ──── Tombol "Pinjam"
        │
        ▼
4. Sistem Validasi:
   ✅ Stok tersedia?
   ✅ Batas pinjam < 3?
   ✅ Buku belum dipinjam siswa ini?
        │
        ▼
5. Status → "menunggu" (notifikasi sukses)
        │
        ▼
6. Admin Melihat Permintaan
        │
   ┌────┴────┐
   │ TERIMA  │  → Status → "dipinjam", stok berkurang, tanggal_peminjaman diset
   └─────────┘
   ┌─────────┐
   │  TOLAK  │  → Status → "ditolak"
   └─────────┘
        │
        ▼
7. Siswa Mengembalikan Buku
        │
        ▼
   Status → "dikembalikan", tanggal_pengembalian diset, stok bertambah
```

---

## 🗺 Routes & Endpoint

### Public Routes

| Method | URL | Action | Keterangan |
|---|---|---|---|
| `GET` | `/` | Closure | Halaman welcome / landing |

### Auth Routes (Laravel Breeze — `routes/auth.php`)

| Method | URL | Keterangan |
|---|---|---|
| `GET` | `/login` | Form login |
| `POST` | `/login` | Proses login |
| `POST` | `/logout` | Logout |
| `GET` | `/register` | Form registrasi |
| `POST` | `/register` | Proses registrasi |

### Middleware: `auth` + `verified`

| Method | URL | Controller | Name |
|---|---|---|---|
| `GET` | `/dashboard` | `DashboardController@index` | `dashboard` |

### Middleware: `auth`

| Method | URL | Controller | Name |
|---|---|---|---|
| `GET` | `/profile` | `ProfileController@edit` | `profile.edit` |
| `PATCH` | `/profile` | `ProfileController@update` | `profile.update` |
| `DELETE` | `/profile` | `ProfileController@destroy` | `profile.destroy` |
| `GET` | `/peminjaman` | `PeminjamanController@index` | `peminjaman.index` |
| `POST` | `/pinjam/{id}` | `PeminjamanController@store` | `peminjaman.store` |
| `POST` | `/kembalikan/{id}` | `PeminjamanController@returnBook` | `peminjaman.return` |

### Middleware: `auth` + `role:admin`

| Method | URL | Controller | Name |
|---|---|---|---|
| `GET` | `/buku` | `BukuController@index` | `buku.index` |
| `GET` | `/buku/create` | `BukuController@create` | `buku.create` |
| `POST` | `/buku` | `BukuController@store` | `buku.store` |
| `GET` | `/buku/{id}/edit` | `BukuController@edit` | `buku.edit` |
| `PUT/PATCH` | `/buku/{id}` | `BukuController@update` | `buku.update` |
| `DELETE` | `/buku/{id}` | `BukuController@destroy` | `buku.destroy` |
| `GET` | `/anggota` | `AnggotaController@index` | `anggota.index` |
| `DELETE` | `/anggota/{id}` | `AnggotaController@destroy` | `anggota.destroy` |
| `GET` | `/admin/peminjaman` | `PeminjamanController@adminIndex` | `admin.peminjaman` |
| `PUT` | `/admin/peminjaman/{id}/terima` | `PeminjamanController@terima` | `peminjaman.terima` |
| `PUT` | `/admin/peminjaman/{id}/tolak` | `PeminjamanController@tolak` | `peminjaman.tolak` |

---

## 🎮 Controllers

### `DashboardController`
**File:** `app/Http/Controllers/DashboardController.php`

Menangani routing dashboard berdasarkan role pengguna. Satu controller, dua tampilan berbeda.

| Method | Role | View | Data |
|---|---|---|---|
| `index()` | `admin` | `admin.dashboard` | `totalBuku`, `totalAnggota`, `totalPinjam` |
| `index()` | `user` | `user.dashboard` | `buku` (dengan filter pencarian) |

---

### `BukuController`
**File:** `app/Http/Controllers/BukuController.php`

Mengelola CRUD buku. Hanya dapat diakses oleh Admin.

| Method | HTTP | Fungsi |
|---|---|---|
| `index()` | GET | Menampilkan semua buku (terbaru di atas) |
| `create()` | GET | Menampilkan form tambah buku |
| `store(Request)` | POST | Validasi & simpan buku baru + upload cover |
| `edit($id)` | GET | Menampilkan form edit buku |
| `update(Request, $id)` | PUT | Validasi & update data buku + ganti cover |
| `destroy($id)` | DELETE | Hapus buku + hapus file cover dari storage |

**Validasi `store` dan `update`:**
```php
'judul'        => 'required'
'penulis'      => 'required'
'penerbit'     => 'required'
'tahun_terbit' => 'required|integer'
'stok'         => 'required|integer'
'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
```

---

### `PeminjamanController`
**File:** `app/Http/Controllers/PeminjamanController.php`

Mengelola seluruh alur peminjaman dari pengajuan hingga pengembalian.

| Method | HTTP | Akses | Fungsi |
|---|---|---|---|
| `store(Request, $id)` | POST | User | Ajukan pinjam buku (dengan 3 validasi bisnis) |
| `index()` | GET | User | Tampilkan riwayat peminjaman milik user |
| `returnBook($id)` | POST | User | Kembalikan buku, update stok |
| `adminIndex()` | GET | Admin | Tampilkan semua data peminjaman |
| `terima($id)` | PUT | Admin | Setujui peminjaman, kurangi stok |
| `tolak($id)` | PUT | Admin | Tolak peminjaman |

**Aturan Bisnis pada `store()`:**
1. ❌ Ditolak jika user sudah punya **≥ 3 peminjaman aktif** (status `menunggu` atau `dipinjam`)
2. ❌ Ditolak jika user **sudah meminjam buku yang sama** dan masih aktif
3. ❌ Ditolak jika **stok buku = 0**
4. ✅ Berhasil → Buat record dengan status `menunggu`

---

### `AnggotaController`
**File:** `app/Http/Controllers/AnggotaController.php`

Hanya Admin. Menampilkan dan menghapus akun siswa.

| Method | HTTP | Fungsi |
|---|---|---|
| `index()` | GET | Tampilkan semua user berole `user` |
| `destroy($id)` | DELETE | Hapus akun siswa dari sistem |

---

### `ProfileController`
**File:** `app/Http/Controllers/ProfileController.php`

Menggunakan bawaan Laravel Breeze. Mengelola profil pengguna (nama, email, password).

---

## 📦 Models & Relasi

### `User`
**File:** `app/Models/User.php`

```php
// Fillable: name, email, password, role
// Relasi: -
// Role: 'admin' | 'user'
```

### `Buku`
**File:** `app/Models/Buku.php`

```php
protected $table    = 'buku';
protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'cover'];

// Relasi: -
// Cover disimpan di: storage/app/public/covers/
```

### `Peminjaman`
**File:** `app/Models/Peminjaman.php`

```php
protected $table    = 'peminjaman';
protected $fillable = ['user_id', 'buku_id', 'tanggal_peminjaman', 'tanggal_pengembalian', 'status'];

// Relasi:
public function user() → belongsTo(User::class)
public function buku() → belongsTo(Buku::class)
```

### Diagram Relasi

```
User ──────────────────────── Peminjaman ──────────── Buku
  id   ◄── (user_id) FK          status              id ◄── (buku_id) FK
  name                        [menunggu,              judul
  role                         dipinjam,              stok
                               dikembalikan,
                               ditolak]
```

---

## 🔐 Middleware

### `CheckRole`
**File:** `app/Http/Middleware/CheckRole.php`

Middleware custom untuk proteksi route berdasarkan role. Diregistrasi dengan alias `role`.

```php
// Cara penggunaan di route:
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route khusus admin
});
```

**Logika:**
- Jika user **belum login** → abort 403
- Jika user login tapi **role tidak sesuai** → abort 403
- Jika role sesuai → lanjut ke route

---

## 👥 Peran Pengguna (Role System)

### Admin
- Didaftarkan manual (atau diubah role-nya langsung di database/seeder)
- Memiliki akses penuh ke semua route admin
- Melihat dashboard statistik global
- Mengelola seluruh data (buku, anggota, peminjaman)

### User (Siswa)
- Mendaftar sendiri via halaman register
- Role default saat registrasi: `user`
- Melihat katalog & mencari buku
- Mengajukan, memantau, dan mengembalikan peminjaman

---

## ⚙️ Instalasi & Setup

### Prasyarat

Pastikan sistem Anda memiliki:
- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm**
- **Laravel** 11 compatible environment (Laragon, XAMPP, dll)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/bobooks.git
cd bobooks

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Buat symlink storage (untuk akses gambar cover)
php artisan storage:link

# 7. Jalankan migrasi database
php artisan migrate

# 8. (Opsional) Jalankan seeder jika tersedia
php artisan db:seed
```

---

## 🔧 Konfigurasi Environment

Buka file `.env` dan sesuaikan konfigurasi berikut:

```dotenv
# Nama Aplikasi
APP_NAME="BoBooks"
APP_URL=http://localhost

# Environment
APP_ENV=local
APP_DEBUG=true

# Database — MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bobooks
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi Mail (untuk verifikasi email)
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@bobooks.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## ▶️ Menjalankan Aplikasi

### Mode Development

Jalankan dua terminal secara bersamaan:

```bash
# Terminal 1: Laravel development server
php artisan serve
# → http://127.0.0.1:8000

# Terminal 2: Vite asset bundler (Hot Module Replacement)
npm run dev
```

### Buat Akun Admin

Setelah migrasi, buat akun biasa lalu ubah role-nya:

```bash
# Via Artisan Tinker
php artisan tinker

# Dalam tinker:
App\Models\User::where('email', 'admin@email.com')->update(['role' => 'admin']);
```

Atau buat user admin langsung:

```php
// Dalam tinker:
App\Models\User::create([
    'name'     => 'Administrator',
    'email'    => 'admin@bobooks.com',
    'password' => bcrypt('password123'),
    'role'     => 'admin',
]);
```

---

## 🚀 Deployment

### Persiapan Production

```bash
# 1. Set environment ke production
APP_ENV=production
APP_DEBUG=false

# 2. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 3. Cache konfigurasi, route, dan view
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Build asset frontend untuk production
npm run build

# 5. Jalankan migrasi production
php artisan migrate --force
```

### Konfigurasi Web Server (Apache / Nginx)

Pastikan **document root** diarahkan ke folder `public/`:

```
# Apache: VirtualHost
DocumentRoot /var/www/bobooks/public

# Nginx: server block
root /var/www/bobooks/public;
index index.php;
```

---

## 📄 Lisensi

Project ini dibuat untuk keperluan edukasi dan manajemen perpustakaan sekolah.
Dikembangkan dengan ❤️ menggunakan [Laravel](https://laravel.com).

---

<p align="center">
  <strong>BoBooks</strong> — Solusi Digital untuk Perpustakaan Modern
</p>
