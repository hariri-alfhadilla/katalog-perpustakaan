<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\User;       
use App\Models\Peminjaman; 

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        if (Auth::user()->role === 'admin') {
            $totalBuku = Buku::count();
            $totalAnggota = User::where('role', 'user')->count();
            $totalPinjam = Peminjaman::where('status', 'dipinjam')->count();

            return view('admin.dashboard', compact('totalBuku', 'totalAnggota', 'totalPinjam'));
        } else {
            $query = Buku::where('stok', '>', 0);

            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('penulis', 'like', '%' . $request->search . '%');
                });
            }

            $buku = $query->latest()->get();

            return view('user.dashboard', compact('buku'));
        }
    }
}