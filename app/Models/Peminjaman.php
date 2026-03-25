<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = ['user_id', 'buku_id', 'tanggal_peminjaman', 'tanggal_pengembalian', 'status'];

    // Relasi: Peminjaman ini milik siapa (User)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman ini untuk buku apa
    public function buku() {
        return $this->belongsTo(Buku::class);
    }
}
