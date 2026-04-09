# 🛠 Panduan Developer — BoBooks

> Panduan teknis untuk developer yang ingin berkontribusi atau mengembangkan BoBooks.

---

## Daftar Isi

- [Setup Development](#setup-development)
- [Struktur Kode](#struktur-kode)
- [Konvensi Coding](#konvensi-coding)
- [Bekerja dengan Database](#bekerja-dengan-database)
- [Bekerja dengan Views](#bekerja-dengan-views)
- [Menambah Fitur Baru](#menambah-fitur-baru)
- [Testing](#testing)
- [Code Style](#code-style)
- [Troubleshooting](#troubleshooting)
- [Useful Artisan Commands](#useful-artisan-commands)

---

## Setup Development

### Prasyarat

```bash
# Cek versi
php --version     # Harus >= 8.2
composer --version
node --version    # Harus >= 18
npm --version
```

### Clone & Install

```bash
git clone https://github.com/username/bobooks.git
cd bobooks

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed   # Includes admin & siswa demo account
```

### Jalankan Development Server

Buka **2 terminal terpisah:**

```bash
# Terminal 1 — PHP server
php artisan serve
# Output: http://127.0.0.1:8000

# Terminal 2 — Vite HMR
npm run dev
# Output: Vite dev server: http://localhost:5173
```

Buka browser di `http://127.0.0.1:8000`.

---

## Struktur Kode

### Aturan Penempatan File

| Tipe File | Lokasi |
|---|---|
| Controller baru | `app/Http/Controllers/` |
| Model baru | `app/Models/` |
| Middleware baru | `app/Http/Middleware/` |
| Form Request | `app/Http/Requests/` |
| Migration | `database/migrations/` (via artisan) |
| Seeder | `database/seeders/` |
| View Admin | `resources/views/admin/{module}/` |
| View User | `resources/views/user/` |
| View Komponen | `resources/views/components/` |
| Layout | `resources/views/layouts/` |

---

## Konvensi Coding

### PHP / Laravel

```php
// ✅ Gunakan type hints
public function store(Request $request): RedirectResponse

// ✅ Named routes selalu digunakan
return redirect()->route('buku.index');

// ✅ Flash message konsisten
->with('success', 'Pesan sukses.')
->with('error', 'Pesan error.')

// ❌ Hindari raw query
DB::select('SELECT * FROM buku');
// ✅ Gunakan Eloquent
Buku::all();

// ✅ Validasi selalu di Controller atau Form Request
$request->validate([...]);

// ✅ findOrFail, bukan find (untuk 404 otomatis)
$buku = Buku::findOrFail($id);
```

### Blade Templates

```blade
{{-- ✅ Selalu escape output --}}
{{ $buku->judul }}

{{-- ✅ Raw HTML hanya jika diperlukan --}}
{!! $htmlContent !!}

{{-- ✅ CSRF di semua form --}}
<form method="POST">
    @csrf
    ...
</form>

{{-- ✅ Method spoofing untuk PUT/DELETE --}}
<form method="POST">
    @csrf
    @method('PUT')
    ...
</form>

{{-- ✅ Gunakan named routes --}}
<a href="{{ route('buku.index') }}">Daftar Buku</a>
<form action="{{ route('buku.update', $buku->id) }}">
```

### Penamaan

| Elemen | Konvensi | Contoh |
|---|---|---|
| Controller | PascalCase + `Controller` | `BukuController` |
| Model | PascalCase, singular | `Buku`, `Peminjaman` |
| Migration | snake_case, deskriptif | `create_buku_table` |
| Route name | dot.notation | `buku.index`, `peminjaman.store` |
| Blade view | snake_case | `admin/buku/index.blade.php` |
| Variable | camelCase | `$totalBuku`, `$jumlahPinjam` |

---

## Bekerja dengan Database

### Membuat Migration Baru

```bash
# Buat tabel baru
php artisan make:migration create_kategori_table

# Tambah kolom ke tabel existing
php artisan make:migration add_isbn_to_buku_table --table=buku
```

### Contoh Migration Tambah Kolom

```php
// database/migrations/xxxx_add_isbn_to_buku_table.php
public function up(): void
{
    Schema::table('buku', function (Blueprint $table) {
        $table->string('isbn')->nullable()->after('judul');
    });
}

public function down(): void
{
    Schema::table('buku', function (Blueprint $table) {
        $table->dropColumn('isbn');
    });
}
```

Setelah itu, tambahkan `'isbn'` ke `$fillable` di `app/Models/Buku.php`.

### Perintah Database Umum

```bash
# Jalankan semua migration yang pending
php artisan migrate

# Reset & jalankan ulang semua migration
php artisan migrate:fresh

# Reset & jalankan ulang + seed
php artisan migrate:fresh --seed

# Lihat status migration
php artisan migrate:status

# Rollback migration terakhir
php artisan migrate:rollback
```

### Membuat Seeder

```bash
php artisan make:seeder BukuSeeder
```

```php
// database/seeders/BukuSeeder.php
public function run(): void
{
    Buku::create([
        'judul'       => 'Laskar Pelangi',
        'penulis'     => 'Andrea Hirata',
        'penerbit'    => 'Bentang Pustaka',
        'tahun_terbit'=> 2005,
        'stok'        => 5,
    ]);
}
```

Daftarkan di `DatabaseSeeder.php`:
```php
$this->call([
    BukuSeeder::class,
]);
```

---

## Bekerja dengan Views

### Struktur Layout

Semua halaman authenticated menggunakan `<x-app-layout>`:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Judul Halaman
        </h2>
    </x-slot>

    {{-- Konten halaman di sini --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ... --}}
        </div>
    </div>
</x-app-layout>
```

### Flash Messages

Tampilkan flash message di view (biasanya setelah form):

```blade
@if (session('success'))
    <div class="alert alert-success bg-green-100 ...">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error bg-red-100 ...">
        {{ session('error') }}
    </div>
@endif
```

### Menampilkan Cover Buku

```blade
@if ($buku->cover)
    <img src="{{ asset('storage/' . $buku->cover) }}"
         alt="Cover {{ $buku->judul }}"
         class="w-32 h-48 object-cover">
@else
    <div class="w-32 h-48 bg-gray-200 flex items-center justify-center">
        <span class="text-gray-400 text-sm">No Cover</span>
    </div>
@endif
```

---

## Menambah Fitur Baru

### Checklist Fitur Baru

```
[ ] 1. Buat migration (jika perlu perubahan DB)
[ ] 2. Update Model (jika ada kolom/relasi baru)
[ ] 3. Buat/update Controller
[ ] 4. Daftarkan Route di web.php
[ ] 5. Buat View Blade
[ ] 6. Update Navigation (jika perlu menu baru)
[ ] 7. Update CODEBASE.md (dependency baru)
[ ] 8. Tulis test
```

### Contoh: Menambah Fitur Kategori Buku

```bash
# 1. Migration
php artisan make:migration create_kategori_table
php artisan make:migration add_kategori_id_to_buku_table --table=buku

# 2. Model
php artisan make:model Kategori

# 3. Controller
php artisan make:controller KategoriController --resource

# 4. Tambah relasi di Buku.php
public function kategori() {
    return $this->belongsTo(Kategori::class);
}

# 5. Tambah route di web.php
Route::resource('kategori', KategoriController::class);

# 6. Buat views
resources/views/admin/kategori/index.blade.php
resources/views/admin/kategori/create.blade.php
resources/views/admin/kategori/edit.blade.php
```

---

## Testing

### Menjalankan Test

```bash
# Semua test
php artisan test

# Test spesifik file
php artisan test tests/Feature/BukuTest.php

# Dengan verbose output
php artisan test --verbose

# Dengan code coverage (butuh Xdebug)
php artisan test --coverage
```

### Menulis Feature Test

```php
// tests/Feature/PeminjamanTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PeminjamanTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_bisa_pinjam_buku_tersedia(): void
    {
        // Arrange
        $user = User::factory()->create(['role' => 'user']);
        $buku = Buku::factory()->create(['stok' => 3]);

        // Act
        $response = $this->actingAs($user)
                         ->post(route('peminjaman.store', $buku->id));

        // Assert
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('peminjaman', [
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'status'  => 'menunggu',
        ]);
    }

    public function test_siswa_tidak_bisa_pinjam_lebih_dari_3(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $buku = Buku::factory()->create(['stok' => 5]);

        // Buat 3 pinjaman aktif
        Peminjaman::factory()->count(3)->create([
            'user_id' => $user->id,
            'status'  => 'dipinjam',
        ]);

        $response = $this->actingAs($user)
                         ->post(route('peminjaman.store', $buku->id));

        $response->assertSessionHas('error');
    }
}
```

### Membuat Model Factory

```bash
php artisan make:factory BukuFactory --model=Buku
```

```php
// database/factories/BukuFactory.php
public function definition(): array
{
    return [
        'judul'        => fake()->sentence(3),
        'penulis'      => fake()->name(),
        'penerbit'     => fake()->company(),
        'tahun_terbit' => fake()->year(),
        'stok'         => fake()->numberBetween(1, 20),
        'cover'        => null,
    ];
}
```

---

## Code Style

BoBooks menggunakan **Laravel Pint** untuk formatting otomatis.

```bash
# Check style (tanpa ubah file)
./vendor/bin/pint --test

# Fix otomatis semua file
./vendor/bin/pint

# Fix file tertentu
./vendor/bin/pint app/Http/Controllers/BukuController.php
```

**Konfigurasi:** Pint menggunakan preset Laravel secara default. Jika ingin kustomisasi, buat `pint.json` di root.

---

## Troubleshooting

### "Class not found" setelah membuat file baru

```bash
composer dump-autoload
```

### View tidak ter-update

```bash
php artisan view:clear
php artisan cache:clear
```

### Route tidak ditemukan

```bash
php artisan route:clear
php artisan route:cache   # hanya di production
```

### Gambar cover tidak muncul

```bash
# Pastikan symlink ada
php artisan storage:link

# Cek apakah folder exists
ls public/storage  # Windows: dir public\storage
```

### Migration error "table already exists"

```bash
# Lihat status
php artisan migrate:status

# Reset bersih (hati-hati: hapus semua data!)
php artisan migrate:fresh --seed
```

### Error 403 Forbidden di halaman admin

- Pastikan akun memiliki `role = 'admin'` di database
- Cek via Tinker: `App\Models\User::find(1)->role`
- Update: `App\Models\User::find(1)->update(['role' => 'admin'])`

### Port 8000 sudah terpakai

```bash
php artisan serve --port=8080
```

---

## Useful Artisan Commands

```bash
# ─── Development ───────────────────────────────
php artisan serve               # Jalankan server
php artisan tinker              # Interactive REPL
php artisan route:list          # Lihat semua route
php artisan route:list --name=buku  # Filter route by name

# ─── Database ──────────────────────────────────
php artisan migrate             # Jalankan migration pending
php artisan migrate:fresh --seed  # Reset + seed ulang
php artisan migrate:status      # Status migration
php artisan db:seed --class=UserSeeder  # Seed kelas tertentu

# ─── Code Generation ───────────────────────────
php artisan make:model Kategori -m -c -r  # Model + migration + controller resource
php artisan make:controller KategoriController --resource
php artisan make:migration create_table_name
php artisan make:seeder NamaSeeder
php artisan make:request StoreBukuRequest
php artisan make:middleware CheckRole
php artisan make:factory BukuFactory --model=Buku
php artisan make:test BukuControllerTest --feature

# ─── Cache & Optimization ──────────────────────
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize           # Cache semua (production)
php artisan optimize:clear     # Clear semua cache

# ─── Storage ───────────────────────────────────
php artisan storage:link       # Buat symlink public/storage
```
