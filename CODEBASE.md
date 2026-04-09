# CODEBASE.md — Peta Dependensi File BoBooks

---

## 🗂 Index File Utama

| File | Tipe | Tanggung Jawab |
|---|---|---|
| `routes/web.php` | Route | Definisi semua URL dan pemetaan ke controller |
| `routes/auth.php` | Route | Route autentikasi (Breeze) |
| `app/Http/Middleware/CheckRole.php` | Middleware | Guard role-based access |
| `app/Http/Controllers/DashboardController.php` | Controller | Dashboard admin & user |
| `app/Http/Controllers/BukuController.php` | Controller | CRUD buku + upload cover |
| `app/Http/Controllers/PeminjamanController.php` | Controller | Alur peminjaman lengkap |
| `app/Http/Controllers/AnggotaController.php` | Controller | Manajemen anggota |
| `app/Http/Controllers/ProfileController.php` | Controller | Profil pengguna |
| `app/Models/User.php` | Model | Tabel `users` + role |
| `app/Models/Buku.php` | Model | Tabel `buku` + stok |
| `app/Models/Peminjaman.php` | Model | Tabel `peminjaman` + relasi |
| `database/migrations/..._create_users_table.php` | Migration | Skema users, sessions, password_reset |
| `database/migrations/..._create_buku_table.php` | Migration | Skema tabel buku |
| `database/migrations/..._create_peminjaman_table.php` | Migration | Skema tabel peminjaman + FK |
| `database/seeders/DatabaseSeeder.php` | Seeder | Seed data awal (admin + siswa) |
| `database/seeders/UserSeeder.php` | Seeder | Seeder alternatif user |
| `resources/views/layouts/app.blade.php` | Layout | Layout utama (authenticated) |
| `resources/views/layouts/guest.blade.php` | Layout | Layout halaman tamu (login/register) |
| `resources/views/layouts/navigation.blade.php` | Layout | Navbar & navigasi |
| `resources/views/admin/dashboard.blade.php` | View | Dashboard admin |
| `resources/views/admin/buku/index.blade.php` | View | Daftar buku (admin) |
| `resources/views/admin/buku/create.blade.php` | View | Form tambah buku |
| `resources/views/admin/buku/edit.blade.php` | View | Form edit buku |
| `resources/views/admin/anggota/index.blade.php` | View | Daftar anggota (admin) |
| `resources/views/admin/peminjaman/index.blade.php` | View | Kelola peminjaman (admin) |
| `resources/views/user/dashboard.blade.php` | View | Katalog buku (siswa) |
| `resources/views/user/peminjaman.blade.php` | View | Riwayat peminjaman (siswa) |
| `resources/views/welcome.blade.php` | View | Halaman landing |
| `resources/css/app.css` | Asset | Entry point CSS (Tailwind) |
| `resources/js/app.js` | Asset | Entry point JS (Alpine.js + Axios) |
| `tailwind.config.js` | Config | Konfigurasi Tailwind CSS |
| `vite.config.js` | Config | Konfigurasi Vite bundler |
| `composer.json` | Config | Dependensi PHP |
| `package.json` | Config | Dependensi Node.js |
| `.env` | Config | Environment variables (jangan commit!) |
| `.env.example` | Docs | Template environment |

---

## 🔗 Peta Dependensi

### `routes/web.php`
**Bergantung pada:**
- `App\Http\Controllers\BukuController`
- `App\Http\Controllers\AnggotaController`
- `App\Http\Controllers\ProfileController`
- `App\Http\Controllers\DashboardController`
- `App\Http\Controllers\PeminjamanController`
- Middleware: `auth`, `verified`, `role:admin` → `CheckRole`

**File yang bergantung padanya:**
- Semua view (melalui `route()` helper)
- Semua form action di Blade templates

---

### `app/Http/Middleware/CheckRole.php`
**Bergantung pada:**
- `App\Models\User` → properti `role`

**Digunakan oleh:**
- `routes/web.php` → semua route dengan middleware `role:admin`
- `bootstrap/app.php` → registrasi alias `role`

> ⚠️ Jika mengubah nama kolom `role` di tabel `users`, update juga file ini.

---

### `app/Models/Buku.php`
**Bergantung pada:**
- Migration: `..._create_buku_table.php` (kolom: judul, penulis, penerbit, tahun_terbit, stok, cover)

**File yang bergantung padanya:**
- `BukuController.php` → semua method (index, store, update, destroy)
- `PeminjamanController.php` → `store()`, `terima()`, `returnBook()`
- `DashboardController.php` → `index()` (user view, admin stats)
- `Peminjaman.php` → relasi `belongsTo(Buku::class)`
- View: semua view yang menampilkan data buku

> ⚠️ Menambah kolom baru di `buku` → tambahkan ke `$fillable` di `Buku.php` + buat migration baru.

---

### `app/Models/Peminjaman.php`
**Bergantung pada:**
- Migration: `..._create_peminjaman_table.php`
- `App\Models\User` → relasi `belongsTo`
- `App\Models\Buku` → relasi `belongsTo`

**File yang bergantung padanya:**
- `PeminjamanController.php` → semua method
- `DashboardController.php` → `totalPinjam` untuk admin dashboard
- View: `admin/peminjaman/index.blade.php`, `user/peminjaman.blade.php`

> ⚠️ Mengubah enum `status` → update migration DAN semua kondisi WHERE di `PeminjamanController`.

---

### `app/Models/User.php`
**Bergantung pada:**
- Migration: `..._create_users_table.php` (kolom: name, email, password, role)

**File yang bergantung padanya:**
- `CheckRole.php` → `Auth::user()->role`
- `DashboardController.php` → `Auth::user()->role`, `User::where('role', 'user')`
- `AnggotaController.php` → `User::where('role', 'user')`
- `PeminjamanController.php` → `Auth::id()`
- Seeders

---

### `app/Http/Controllers/BukuController.php`
**Bergantung pada:**
- `App\Models\Buku`
- `Illuminate\Support\Facades\Storage` → upload/delete cover
- Views: `admin.buku.index`, `admin.buku.create`, `admin.buku.edit`

**Dipanggil oleh:**
- `routes/web.php` → `Route::resource('buku', BukuController::class)`

> ⚠️ File cover disimpan di `storage/app/public/covers/`. Pastikan `php artisan storage:link` sudah dijalankan.

---

### `app/Http/Controllers/PeminjamanController.php`
**Bergantung pada:**
- `App\Models\Buku`
- `App\Models\Peminjaman`
- `Illuminate\Support\Facades\Auth`
- Views: `user.peminjaman`, `admin.peminjaman.index`

**Aturan bisnis kritis (jangan diubah tanpa pertimbangan):**
- Batas maksimal 3 peminjaman aktif per user
- Tidak bisa meminjam buku yang sama 2x bersamaan
- Stok hanya berkurang saat Admin `terima`, bukan saat siswa request

---

### `app/Http/Controllers/DashboardController.php`
**Bergantung pada:**
- `App\Models\Buku`, `App\Models\User`, `App\Models\Peminjaman`
- `Auth::user()->role` → routing conditional ke view yang berbeda
- Views: `admin.dashboard`, `user.dashboard`

> ⚠️ Satu controller, dua view berbeda berdasarkan role. Jangan pisahkan kecuali ada alasan kuat.

---

### `resources/views/layouts/app.blade.php`
**Bergantung pada:**
- `resources/views/layouts/navigation.blade.php` → `@include`
- `resources/css/app.css` + `resources/js/app.js` → `@vite`

**Digunakan oleh:**
- Semua view yang menggunakan `<x-app-layout>`

---

### `resources/views/layouts/navigation.blade.php`
**Bergantung pada:**
- Named routes: `dashboard`, `profile.edit`, dll
- `Auth::user()->role` → tampilkan menu berbeda per role
- Blade components: `x-nav-link`, `x-responsive-nav-link`, `x-dropdown`

> ⚠️ Menambah menu baru → edit file ini dan tambahkan kondisi role jika perlu.

---

### `resources/css/app.css` + `resources/js/app.js`
**Bergantung pada:**
- `tailwind.config.js` (CSS)
- `alpinejs` (JS)
- `axios` (JS)

**Digunakan oleh:**
- `layouts/app.blade.php` → dimuat via `@vite()`
- `layouts/guest.blade.php` → dimuat via `@vite()`

---

### `database/migrations/..._create_peminjaman_table.php`
**Bergantung pada:**
- Migration `users` (karena FK `user_id`)
- Migration `buku` (karena FK `buku_id`)

> ⚠️ **Urutan migrasi penting!** Peminjaman harus dimigrasi SETELAH users dan buku.

---

### `database/seeders/DatabaseSeeder.php`
**Membuat:**
- Akun admin: `admin@test.com` / `password1`
- Akun siswa: `siswa@test.com` / `password1`

**Dijalankan dengan:**
```bash
php artisan db:seed
# atau fresh:
php artisan migrate:fresh --seed
```

---

## ⚡ Dampak Perubahan (Change Impact Matrix)

| Jika mengubah... | Maka update juga... |
|---|---|
| Kolom tabel `buku` | `Buku.php` ($fillable), migration baru, semua view buku |
| Kolom tabel `peminjaman` | `Peminjaman.php` ($fillable), migration baru, semua view peminjaman |
| Enum `status` peminjaman | `PeminjamanController.php` (semua whereIn/where status), view badge |
| Kolom `role` di users | `CheckRole.php`, `DashboardController`, `AnggotaController` |
| Named route di `web.php` | Semua `route()` helper di views dan controllers |
| Layout `app.blade.php` | Semua view yang extends `<x-app-layout>` |
| Komponen Blade di `components/` | Semua view yang menggunakan komponen tersebut |
| Storage disk config | `BukuController.php` (Storage::disk name) |

---

## 🧩 Komponen Blade (`resources/views/components/`)

| Komponen | Penggunaan |
|---|---|
| `<x-app-layout>` | Layout authenticated utama |
| `<x-guest-layout>` | Layout halaman tamu |
| `<x-primary-button>` | Tombol aksi utama (biru) |
| `<x-secondary-button>` | Tombol aksi sekunder |
| `<x-danger-button>` | Tombol aksi berbahaya (merah/hapus) |
| `<x-text-input>` | Input teks standar |
| `<x-input-label>` | Label untuk input form |
| `<x-input-error>` | Tampilan pesan error validasi |
| `<x-modal>` | Dialog konfirmasi modal |
| `<x-nav-link>` | Link navigasi desktop |
| `<x-responsive-nav-link>` | Link navigasi mobile |
| `<x-dropdown>` | Dropdown menu |
| `<x-dropdown-link>` | Item dalam dropdown |
| `<x-auth-session-status>` | Pesan status sesi auth |
| `<x-application-logo>` | Logo aplikasi |

---

## 🚫 File yang Tidak Boleh Diedit Sembarangan

| File | Alasan |
|---|---|
| `.env` | Kredensial rahasia — JANGAN commit ke Git |
| `composer.lock` | Digenerate otomatis oleh Composer |
| `package-lock.json` | Digenerate otomatis oleh npm |
| `vendor/` | Dependencies — digenerate oleh `composer install` |
| `node_modules/` | Dependencies — digenerate oleh `npm install` |
| `storage/app/public/` | File upload pengguna |
