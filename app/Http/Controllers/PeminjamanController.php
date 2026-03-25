<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // 1. SISWA: Mengajukan Peminjaman
    public function store(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // CEK VALIDASI: Apakah siswa sudah meminjam atau sedang menunggu persetujuan buku ini?
        $sudahAda = Peminjaman::where('user_id', Auth::id())
                            ->where('buku_id', $id)
                            ->whereIn('status', ['menunggu', 'dipinjam'])
                            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Gagal! Kamu sedang meminjam atau menunggu konfirmasi untuk buku ini.');
        }

        // CEK STOK: Kalau belum pinjam, pastikan stok masih ada
        if ($buku->stok > 0) {
            
            Peminjaman::create([
                'user_id' => Auth::id(),
                'buku_id' => $id,
                'status' => 'menunggu' // Status awalnya 'menunggu', bukan langsung 'dipinjam'
            ]);

            // STOK JANGAN DIKURANGI DULU DI SINI

            return redirect()->back()->with('success', 'Permintaan terkirim! Silakan tunggu admin menyetujui peminjamanmu.');
        }

        return redirect()->back()->with('error', 'Maaf, stok buku habis.');
    }

    // 2. SISWA: Tampilkan Halaman Peminjaman Saya
    public function index()
    {
        // Tampilkan yang statusnya 'menunggu' ATAU 'dipinjam' biar siswa tahu progresnya
        $peminjaman = Peminjaman::with('buku')
                        ->where('user_id', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();

        return view('user.peminjaman', compact('peminjaman'));
    }

    // 3. SISWA: Proses Pengembalian Buku
    public function returnBook($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // Ubah status dan tanggal kembali
        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_pengembalian' => now(),
        ]);

        // Kembalikan stok buku
        $pinjam->buku->increment('stok');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }

    // 4. ADMIN: Tampilkan Semua Riwayat Peminjaman
    public function adminIndex()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->orderBy('id', 'desc')->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    // 5. ADMIN: Terima Peminjaman (FUNGSI BARU)
    public function terima($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $buku = Buku::findOrFail($pinjam->buku_id);

        // Cek lagi stoknya, jaga-jaga kalau stok keburu habis dipinjam orang lain
        if ($buku->stok > 0) {
            $pinjam->update([
                'status' => 'dipinjam',
                'tanggal_peminjaman' => now(), // Tanggal peminjaman baru dicatat saat disetujui
            ]);

            // Kurangi stok buku
            $buku->decrement('stok');

            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
        }

        return redirect()->back()->with('error', 'Gagal disetujui! Stok buku ternyata sudah habis.');
    }

    // 6. ADMIN: Tolak Peminjaman (FUNGSI BARU)
    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'ditolak',
            // Tanggal peminjaman biarkan kosong karena tidak jadi dipinjam
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman telah ditolak.');
    }
}