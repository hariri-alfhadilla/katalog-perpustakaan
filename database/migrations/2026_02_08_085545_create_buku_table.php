<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('cover')->nullable();
            $table->string('judul');      // <--- Pastikan baris ini ada
            $table->string('penulis');    // <--- Pastikan baris ini ada
            $table->string('penerbit');   // <--- Pastikan baris ini ada
            $table->integer('tahun_terbit');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
