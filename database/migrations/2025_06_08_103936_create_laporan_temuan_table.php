<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_temuan', function (Blueprint $table) {
            $table->id('laporan_temuan_id'); // Primary key
            $table->unsignedBigInteger('auditing_id'); // Foreign key untuk tabel auditings
            $table->unsignedBigInteger('standar'); // Foreign key untuk tabel kriteria
            $table->text('uraian_temuan'); // Deskripsi temuan
            $table->enum('kategori_temuan', ['NC', 'AOC', 'OFI']); // Kategori temuan
            $table->text('saran_perbaikan')->nullable(); // Saran perbaikan, boleh kosong

            $table->foreign('auditing_id')->references('auditing_id')->on('auditings')->onDelete('cascade');
            $table->foreign('standar')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_temuan');
    }
};
