<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\User;       
use App\Models\Peminjaman; 

class DashboardController extends Controller
{
    // Tambahin Request $request di parameter biar gampang nangkep inputan
    public function index(Request $request) 
    {
        if (Auth::user()->role === 'admin') {
            // LOGIKA BARU UNTUK ADMIN
            $totalBuku = Buku::count();
            $totalAnggota = User::where('role', 'user')->count();
            $totalPinjam = Peminjaman::where('status', 'dipinjam')->count();

            return view('admin.dashboard', compact('totalBuku', 'totalAnggota', 'totalPinjam'));
        } else {
            // LOGIKA UNTUK USER (Siswa)
            
            // 1. Siapin query dasar: cuma nampilin stok > 0 (tanpa relasi kategori)
            $query = Buku::where('stok', '>', 0);

            // 2. Kalau ada pencarian judul/penulis
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('penulis', 'like', '%' . $request->search . '%');
                });
            }

            // 3. Eksekusi query-nya (latest() biar buku terbaru ada di atas)
            $buku = $query->latest()->get();

            // 4. Kirim data buku ke view (tanpa variabel categories)
            return view('user.dashboard', compact('buku'));
        }
    }
}