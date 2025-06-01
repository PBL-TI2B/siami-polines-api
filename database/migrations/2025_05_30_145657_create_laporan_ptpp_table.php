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
        Schema::create('laporan_ptpp', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key)
            $table->string('standar'); // Kolom untuk standar 
            $table->text('uraian_temuan'); // Kolom untuk uraian temuan (teks panjang)
            $table->enum('kategori_temuan', ['NC', 'AOC', 'OFI']); // Kolom enum untuk kategori temuan
            $table->text('saran_perbaikan')->nullable(); // Kolom untuk saran perbaikan, boleh kosong
            $table->string('status'); // Kolom untuk status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_ptpp'); // Menghapus tabel jika migrasi di-rollback
    }
};
