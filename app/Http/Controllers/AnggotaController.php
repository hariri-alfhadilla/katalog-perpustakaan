<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Tampilkan Daftar Anggota (Hanya Siswa)
     * Admin hanya memantau siswa yang sudah mendaftar sendiri.
     */
    public function index()
    {
        // Mengambil semua user dengan role 'user' dan diurutkan dari yang terbaru daftar
        $anggota = User::where('role', 'user')->latest()->get();
        
        return view('admin.anggota.index', compact('anggota'));
    }

    /**
     * Hapus Anggota
     * Digunakan Admin jika ada akun siswa yang tidak valid atau melanggar aturan.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('anggota.index')->with('success', 'Akun siswa berhasil dihapus dari sistem.');
    }
}