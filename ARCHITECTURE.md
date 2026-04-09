# ARCHITECTURE.md — Arsitektur Sistem BoBooks

## 📐 Overview Arsitektur

BoBooks adalah aplikasi **monolitik full-stack** yang mengikuti pola **MVC (Model-View-Controller)** bawaan Laravel. Tidak ada API terpisah — semua request menghasilkan response HTML melalui Blade template.

```
Browser ──── HTTP Request ────► Laravel Router (routes/web.php)
                                      │
                              Middleware Stack
                              ┌───────┴────────┐
                              │ auth           │  ← Laravel Breeze (session)
                              │ verified       │  ← Email verification
                              │ role:admin     │  ← CheckRole (custom)
                              └───────┬────────┘
                                      │
                               Controller
                         ┌────────────┴──────────────┐
                         │ Business Logic             │
                         │ Form Validation            │
                         │ File Upload (Storage)      │
                         └────────────┬──────────────┘
                                      │
                              Eloquent Model
                                      │
                               MySQL Database
                                      │
                              ◄─── Response ───
                           Blade View (HTML)
                           compiled + cached
```

---

## 🏛 Keputusan Arsitektur

### 1. Monolitik (bukan Microservice / SPA)

**Keputusan:** Laravel monolitik dengan server-side rendering Blade.

**Alasan:**
- Lingkup proyek sekolah — kompleksitas rendah
- Tim kecil — overhead microservice tidak sepadan
- SEO & first load performance lebih baik dengan SSR
- Tidak butuh real-time update (WebSocket cukup ditambahkan nanti)

**Trade-off:**
- ✅ Deploy mudah, satu codebase
- ❌ Skalabilitas horizontal lebih sulit jika traffic besar

---

### 2. MySQL sebagai Database

**Keputusan:** Database menggunakan MySQL, dikonfigurasi via `.env`.

**Alasan:**
- Standar industri untuk aplikasi web production
- Dukungan luas di berbagai hosting (cPanel, VPS, cloud)
- Performa lebih baik untuk data relasional dan concurrent access
- Kompatibel penuh dengan Eloquent ORM Laravel

**Konfigurasi di `.env`:**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bobooks
DB_USERNAME=root
DB_PASSWORD=
```

---

### 3. Role System Berbasis Kolom (bukan Package)

**Keputusan:** Role disimpan sebagai kolom `enum('admin', 'user')` di tabel `users`, bukan menggunakan package seperti Spatie Permission.

**Alasan:**
- Hanya 2 role — overkill jika pakai package
- Lebih mudah dipahami developer baru
- Performa lebih baik (tidak ada join table ekstra)

**Trade-off:**
- ✅ Simpel, cepat, zero-dependency
- ❌ Sulit dikembangkan jika butuh role granular (permissions per route)
- ❌ Tidak ada wildcard atau permission hierarchy

**Jika butuh berkembang:** Migrasikan ke [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)

---

### 4. File Upload via Laravel Storage

**Keputusan:** Cover buku disimpan di `storage/app/public/covers/` dan diakses via symlink.

**Alasan:**
- Tidak bergantung pada CDN eksternal
- Mudah di-manage dengan `Storage` facade
- Symlink `php artisan storage:link` membuatnya accessible dari `public/`

**Path akses di view:**
```blade
<img src="{{ asset('storage/' . $buku->cover) }}">
```

**Untuk Production:** Pertimbangkan pindah ke S3/R2 via `FILESYSTEM_DISK=s3`.

---

### 5. Autentikasi via Laravel Breeze

**Keputusan:** Scaffolding autentikasi menggunakan Laravel Breeze (Blade stack).

**Alasan:**
- Breeze menyediakan Register, Login, Logout, Email Verification, Password Reset out-of-the-box
- Blade stack konsisten dengan sisa aplikasi
- Mudah dikustomisasi

**File yang di-generate Breeze:**
- `routes/auth.php`
- `app/Http/Controllers/Auth/` (semua controller auth)
- `resources/views/auth/` (semua view auth)
- `resources/views/components/` (reusable UI components)
- `resources/views/layouts/` (app + guest layout)

---

## 🔄 Data Flow Detail

### Flow: Siswa Mengajukan Pinjam Buku

```
1. GET /dashboard
   DashboardController@index
   └── Auth::user()->role === 'user'
   └── Buku::where('stok', '>', 0)->get()
   └── return view('user.dashboard', compact('buku'))

2. POST /pinjam/{id}
   PeminjamanController@store
   ├── Buku::findOrFail($id)
   ├── Auth::id() → $userId
   ├── [VALIDASI 1] Peminjaman::where(user_id, whereIn[menunggu,dipinjam]).count() >= 3 → TOLAK
   ├── [VALIDASI 2] Peminjaman::where(user_id, buku_id, whereIn[menunggu,dipinjam]).exists() → TOLAK
   ├── [VALIDASI 3] $buku->stok > 0 → LANJUT / else TOLAK
   └── Peminjaman::create([user_id, buku_id, status:'menunggu'])
       └── redirect()->back()->with('success', '...')
```

### Flow: Admin Menyetujui Peminjaman

```
PUT /admin/peminjaman/{id}/terima
PeminjamanController@terima
├── Peminjaman::findOrFail($id)
├── Buku::findOrFail($pinjam->buku_id)
├── [CHECK] $buku->stok > 0
│   ├── YES:
│   │   ├── $pinjam->update([status:'dipinjam', tanggal_peminjaman: now()])
│   │   └── $buku->decrement('stok')   ← stok berkurang 1
│   └── NO:
│       └── redirect()->back()->with('error', '...')
```

### Flow: Siswa Mengembalikan Buku

```
POST /kembalikan/{id}
PeminjamanController@returnBook
├── Peminjaman::findOrFail($id)
├── $pinjam->update([status:'dikembalikan', tanggal_pengembalian: now()])
└── $pinjam->buku->increment('stok')   ← stok bertambah 1
```

---

## 🧩 Layer Breakdown

### Presentation Layer (Views)

```
resources/views/
├── layouts/          ← Shell HTML (header, nav, footer)
│   ├── app.blade.php       Layout authenticated
│   ├── guest.blade.php     Layout tamu (login/register)
│   └── navigation.blade.php Nav bar + menu role-based
├── components/       ← Reusable UI atoms (Breeze-generated)
├── admin/            ← Semua halaman Admin
│   ├── dashboard.blade.php  Statistik global
│   ├── buku/               CRUD buku
│   ├── anggota/            Manajemen anggota
│   └── peminjaman/         Approve/reject peminjaman
├── user/             ← Semua halaman Siswa
│   ├── dashboard.blade.php  Katalog + search buku
│   └── peminjaman.blade.php Riwayat & kembalikan buku
└── auth/             ← Login, register, dll (Breeze)
```

**Pola:** Semua view menggunakan `<x-app-layout>` atau `<x-guest-layout>`.
Konten diinjeksikan via Blade `$slot`.

---

### Application Layer (Controllers)

```
app/Http/Controllers/
├── Controller.php            Base class (kosong)
├── DashboardController       Role-based routing → 2 view
├── BukuController            CRUD + file storage
├── PeminjamanController      Business logic peminjaman
├── AnggotaController         Read + delete users
├── ProfileController         Edit profil (Breeze)
└── Auth/                     Register, Login, dll (Breeze)
```

**Pola:** Fat Controller dihindari. Business logic yang kompleks ada di controller method dengan validasi inline. Tidak ada Service Layer karena scope MVP masih kecil.

> **Saran pengembangan:** Jika logika bisnis `PeminjamanController::store()` makin kompleks, ekstrak ke `app/Services/PeminjamanService.php`.

---

### Domain Layer (Models)

```
app/Models/
├── User.php        Autentikasi + peran
├── Buku.php        Data buku + stok
└── Peminjaman.php  Transaksi + relasi + state
```

**Relasi Eloquent:**
```
User    hasMany    Peminjaman    (implisit, via Auth::id())
Buku    hasMany    Peminjaman    (implisit, via buku_id)
Peminjaman belongsTo User       (explicit)
Peminjaman belongsTo Buku       (explicit)
```

---

### Infrastructure Layer

| Komponen | Implementasi |
|---|---|
| **Database** | MySQL via Eloquent ORM |
| **Session** | File-based (default Laravel) |
| **Cache** | File-based (default Laravel) |
| **File Storage** | `Storage::disk('public')` → `storage/app/public/` |
| **Queue** | Sync (tidak ada background job saat ini) |
| **Auth** | Session-based (cookie + server session) |
| **Asset Build** | Vite 5 (HMR dev, optimized prod) |

---

## 🔐 Security Architecture

### Authentication
- **Mekanisme:** Session-based (stateful). Cookie `laravel_session` dikirim setiap request.
- **Password:** Di-hash dengan `bcrypt` via Laravel Hash facade.
- **CSRF Protection:** Token CSRF otomatis pada semua form POST/PUT/DELETE via `@csrf` directive.

### Authorization
```
Level 1: Route Middleware
  └── auth       → harus login
  └── verified   → email harus terverifikasi
  └── role:admin → harus role admin (CheckRole)

Level 2: Controller Logic
  └── Auth::id() → memastikan data milik user yang login
  └── Peminjaman::where('user_id', Auth::id()) → data isolation
```

### File Upload Security
```
'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
```
- Hanya JPEG/PNG yang diterima
- Maksimal 2MB
- Disimpan di `storage/public/` (tidak di-execute web server)

---

## 📈 Skalabilitas & Pengembangan Masa Depan

### Jangka Pendek (Mudah)
- [ ] Tambah field `isbn`, `kategori`, `sinopsis` di tabel buku → migration baru + update `$fillable`
- [ ] Tambah fitur pencarian di halaman admin buku → update `BukuController@index`
- [ ] Tambah notifikasi email saat peminjaman disetujui → `Mail` + `Queue`
- [ ] Export data peminjaman ke Excel → package `maatwebsite/excel`

### Jangka Menengah (Butuh Refactor)
- [ ] Service Layer untuk business logic peminjaman
- [ ] Form Request classes untuk validasi terpisah
- [ ] Repository pattern untuk database queries
- [ ] Feature tests lengkap dengan PHPUnit

### Jangka Panjang (Breaking Change)
- [ ] Multi-role granular → Spatie Permission
- [ ] API endpoint → Laravel Sanctum + JSON API
- [ ] Real-time notifikasi → Laravel Echo + Pusher/Soketi
- [ ] Cloud file storage → S3/R2 untuk covers

---

## 🧪 Testing Architecture

```
tests/
├── Feature/        ← Integration tests (HTTP request → response)
│   └── Auth/       (Breeze default tests)
└── Unit/           ← Unit tests (isolated logic)
```

**Command:**
```bash
php artisan test
# atau
./vendor/bin/phpunit
```

**Coverage yang direkomendasikan:**
| Area | Priority | Test Type |
|---|---|---|
| Peminjaman business rules | 🔴 Tinggi | Feature Test |
| Role middleware | 🔴 Tinggi | Feature Test |
| BukuController CRUD | 🟡 Sedang | Feature Test |
| Model relationships | 🟡 Sedang | Unit Test |
| File upload | 🟢 Rendah | Feature Test |

---

## 📦 Dependency Graph

```
Laravel 11
├── laravel/breeze          ← Auth scaffolding
├── laravel/tinker          ← REPL interaktif
│
├── [dev] fakerphp/faker    ← Data faker untuk seeder/test
├── [dev] laravel/pint      ← PHP code style fixer
├── [dev] laravel/sail      ← Docker environment (opsional)
├── [dev] phpunit/phpunit   ← Testing framework
└── [dev] spatie/ignition   ← Error page yang informatif

Frontend
├── tailwindcss ^3.1        ← Utility CSS framework
├── @tailwindcss/forms      ← Plugin form styling
├── alpinejs ^3.4           ← Lightweight JS reactivity
├── axios ^1.6              ← HTTP client (untuk AJAX future)
└── vite ^5.0               ← Asset bundler + HMR
```

---
