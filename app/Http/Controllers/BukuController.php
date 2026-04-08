<?php

namespace App\Http\Controllers;

use App\Models\Buku; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::latest()->get();
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $validatedData['cover'] = $path;
        }

        Buku::create($validatedData);
        return redirect()->route('buku.index')->with('success', 'Buku beserta cover berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $path = $request->file('cover')->store('covers', 'public');
            $validatedData['cover'] = $path;
        }

        $buku->update($validatedData);
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku beserta gambar cover berhasil dihapus permanen!');
    }
}