<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * 
     * 
     */
    public function index()
    {
        $anggota = User::where('role', 'user')->latest()->get();
        return view('admin.anggota.index', compact('anggota'));
    }

    /**
     * 
     * 
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('anggota.index')->with('success', 'Akun siswa berhasil dihapus dari sistem.');
    }
}