# 📖 Panduan Pengguna — BoBooks

> Panduan lengkap penggunaan aplikasi BoBooks untuk **Siswa** dan **Admin**.

---

## Daftar Isi

- [Akses Aplikasi](#akses-aplikasi)
- [Panduan Siswa](#-panduan-siswa)
- [Panduan Admin](#-panduan-admin)
- [Status Peminjaman](#status-peminjaman)
- [FAQ](#-faq)

---

## Akses Aplikasi

| URL Default | Keterangan |
|---|---|
| `http://localhost:8000` | Halaman utama (landing) |
| `http://localhost:8000/login` | Halaman login |
| `http://localhost:8000/register` | Halaman daftar akun baru |
| `http://localhost:8000/dashboard` | Dashboard (redirect setelah login) |

### Akun Demo (Seeder)

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@test.com` | `password1` |
| **Siswa** | `siswa@test.com` | `password1` |

---

## 👨‍🎓 Panduan Siswa

### 1. Membuat Akun

1. Buka halaman **Register** (`/register`)
2. Isi formulir:
   - **Nama Lengkap** — nama asli kamu
   - **Email** — email aktif (digunakan untuk login)
   - **Password** — minimal 8 karakter
   - **Konfirmasi Password** — ulangi password
3. Klik tombol **Daftar**
4. Akun otomatis dibuat dengan role **Siswa**

---

### 2. Login

1. Buka halaman **Login** (`/login`)
2. Masukkan **Email** dan **Password**
3. (Opsional) Centang **Remember me** agar tidak perlu login ulang
4. Klik **Log in**
5. Diarahkan ke **Dashboard Katalog Buku**

---

### 3. Mencari Buku

Di halaman **Dashboard**, kamu bisa melihat semua buku yang tersedia (stok > 0).

**Cara mencari:**
1. Ketik judul atau nama penulis di kolom **Cari buku...**
2. Tekan Enter atau klik tombol Search
3. Hasil pencarian akan muncul otomatis

> ℹ️ Buku yang stoknya **habis (0)** tidak akan muncul di katalog.

---

### 4. Meminjam Buku

1. Temukan buku yang ingin dipinjam di katalog
2. Klik tombol **Pinjam** pada kartu buku
3. Sistem akan memvalidasi:
   - Apakah kamu sudah punya 3 pinjaman aktif? → Ditolak
   - Apakah buku ini sudah kamu pinjam? → Ditolak
   - Apakah stok masih ada? → Lanjut
4. Jika berhasil, status peminjaman menjadi **Menunggu Konfirmasi Admin**
5. Tunggu Admin menyetujui permintaanmu

---

### 5. Melihat Status Peminjaman

1. Klik menu **Peminjaman Saya** di navbar
2. Lihat daftar semua peminjaman beserta statusnya:

| Status | Artinya |
|---|---|
| 🟡 Menunggu | Permintaan terkirim, menunggu admin |
| 🟢 Dipinjam | Admin sudah setuju, buku sedang dipinjam |
| ✅ Dikembalikan | Buku sudah dikembalikan |
| 🔴 Ditolak | Permintaan ditolak oleh admin |

---

### 6. Mengembalikan Buku

1. Buka halaman **Peminjaman Saya**
2. Temukan buku dengan status **Dipinjam**
3. Klik tombol **Kembalikan**
4. Status berubah menjadi **Dikembalikan** dan stok buku bertambah

> ⚠️ Pastikan kamu sudah mengembalikan buku fisiknya ke perpustakaan sebelum mengklik tombol ini!

---

### 7. Mengedit Profil

1. Klik nama kamu di pojok kanan atas navbar
2. Pilih **Profile**
3. Edit nama atau email
4. Klik **Save** untuk menyimpan
5. Untuk ganti password, scroll ke bagian **Update Password**

---

## 👨‍💼 Panduan Admin

### 1. Login sebagai Admin

Gunakan akun yang sudah diberi role `admin` di database.

Setelah login, dashboard Admin menampilkan **statistik global:**
- 📚 **Total Buku** — jumlah semua buku di katalog
- 👥 **Total Anggota** — jumlah siswa terdaftar
- 📖 **Sedang Dipinjam** — jumlah peminjaman aktif

---

### 2. Manajemen Buku

Menu: **Kelola Buku** di navbar admin.

#### Tambah Buku Baru
1. Klik tombol **Tambah Buku**
2. Isi formulir:
   - **Judul** — judul lengkap buku
   - **Penulis** — nama penulis
   - **Penerbit** — nama penerbit
   - **Tahun Terbit** — angka tahun (contoh: 2023)
   - **Stok** — jumlah eksemplar yang tersedia
   - **Cover** (opsional) — upload gambar JPEG/PNG, maks 2MB
3. Klik **Simpan**

#### Edit Buku
1. Klik ikon ✏️ **Edit** pada baris buku
2. Ubah data yang perlu diperbarui
3. Upload cover baru jika ingin mengganti (cover lama otomatis terhapus)
4. Klik **Perbarui**

#### Hapus Buku
1. Klik ikon 🗑️ **Hapus** pada baris buku
2. Konfirmasi penghapusan
3. Buku dan file cover-nya dihapus permanen dari sistem

> ⚠️ Buku yang sedang dipinjam **tidak aman untuk dihapus** — relasi cascade akan menghapus data peminjaman juga.

---

### 3. Manajemen Anggota

Menu: **Kelola Anggota** di navbar admin.

- Melihat semua siswa yang terdaftar (role = user)
- Klik **Hapus** untuk menghapus akun siswa dari sistem

> ⚠️ Menghapus akun siswa akan menghapus semua data peminjamanannya juga (cascade delete).

---

### 4. Mengelola Peminjaman

Menu: **Kelola Peminjaman** di navbar admin.

Halaman ini menampilkan semua permintaan peminjaman dari seluruh siswa, diurutkan dari yang terbaru.

#### Menyetujui Peminjaman
1. Temukan permintaan dengan status **Menunggu**
2. Klik tombol ✅ **Terima**
3. Sistem akan:
   - Mengubah status menjadi **Dipinjam**
   - Mencatat tanggal peminjaman (hari ini)
   - Mengurangi stok buku sebesar 1
4. Siswa akan bisa melihat status berubah di halaman mereka

#### Menolak Peminjaman
1. Temukan permintaan dengan status **Menunggu**
2. Klik tombol ❌ **Tolak**
3. Status berubah menjadi **Ditolak**
4. Stok buku tidak berubah

---

## Status Peminjaman

```
Siswa klik "Pinjam"
        ↓
   [menunggu] ──── Admin klik "Terima" ────► [dipinjam]
        │                                        │
        └──── Admin klik "Tolak" ────► [ditolak] │
                                                  │
                                   Siswa klik "Kembalikan"
                                                  │
                                          [dikembalikan]
```

| Status | Badge | Deskripsi |
|---|---|---|
| `menunggu` | 🟡 Kuning | Menunggu persetujuan admin |
| `dipinjam` | 🟢 Hijau | Buku aktif dipinjam |
| `dikembalikan` | 🔵 Biru | Sudah dikembalikan |
| `ditolak` | 🔴 Merah | Ditolak oleh admin |

---

## ❓ FAQ

**Q: Saya tidak bisa meminjam buku, ada pesan error "mencapai batas maksimal"?**
> A: Kamu sudah meminjam 3 buku sekaligus (menunggu atau sedang dipinjam). Kembalikan salah satu dulu sebelum meminjam buku baru.

**Q: Saya tidak bisa meminjam buku yang sama dua kali?**
> A: Sistem mencegah duplikasi. Jika kamu sudah meminjam atau menunggu konfirmasi untuk buku yang sama, kamu tidak bisa mengajukan lagi.

**Q: Tombol "Kembalikan" tidak muncul?**
> A: Tombol hanya muncul untuk peminjaman dengan status **Dipinjam**. Jika status masih **Menunggu**, tunggu admin menyetujui dulu.

**Q: Cover buku tidak muncul?**
> A: Kemungkinan `php artisan storage:link` belum dijalankan. Minta developer untuk menjalankannya.

**Q: Saya lupa password?**
> A: Gunakan fitur **Forgot Password** di halaman login. Email reset password akan dikirim ke email terdaftar.

**Q: Sebagai admin, bagaimana cara mengubah stok buku tanpa menghapus?**
> A: Gunakan fitur **Edit Buku** dan ubah nilai di kolom Stok.
