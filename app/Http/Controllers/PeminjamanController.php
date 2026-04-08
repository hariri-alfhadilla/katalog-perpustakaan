<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $userId = Auth::id();

        $jumlahPinjamanAktif = Peminjaman::where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($jumlahPinjamanAktif >= 3) {
            return redirect()->back()->with('error', 'Gagal meminjam! Kamu sudah mencapai batas maksimal peminjaman (3 buku).');
        }

        $sudahAda = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Gagal! Kamu sedang meminjam atau menunggu konfirmasi untuk buku ini.');
        }

        if ($buku->stok > 0) {
            Peminjaman::create([
                'user_id' => $userId,
                'buku_id' => $id,
                'status' => 'menunggu'
            ]);

            return redirect()->back()->with('success', 'Permintaan terkirim! Silakan tunggu admin menyetujui peminjamanmu.');
        }

        return redirect()->back()->with('error', 'Maaf, stok buku habis.');
    }

    public function index()
    {
        $peminjaman = Peminjaman::with('buku')
                        ->where('user_id', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();

        return view('user.peminjaman', compact('peminjaman'));
    }

    public function returnBook($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_pengembalian' => now(),
        ]);

        $pinjam->buku->increment('stok');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }

    public function adminIndex()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->orderBy('id', 'desc')->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function terima($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $buku = Buku::findOrFail($pinjam->buku_id);

        if ($buku->stok > 0) {
            $pinjam->update([
                'status' => 'dipinjam',
                'tanggal_peminjaman' => now(),
            ]);

            $buku->decrement('stok');

            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
        }

        return redirect()->back()->with('error', 'Gagal disetujui! Stok buku ternyata sudah habis.');
    }

    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'ditolak',
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman telah ditolak.');
    }
}