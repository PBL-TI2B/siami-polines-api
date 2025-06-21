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
        Schema::create('laporan_temuan', function (Blueprint $table) {
            $table->id('laporan_temuan_id');
            $table->unsignedBigInteger('auditing_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->text('uraian_temuan')->nullable();
            $table->enum('kategori_temuan', ['NC', 'AOC', 'OFI']);
            $table->text('saran_perbaikan')->nullable();

            $table->foreign('auditing_id')->references('auditing_id')->on('auditings')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
        });

        // Schema::create('laporan_temuan_kriteria', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('laporan_temuan_id')->references('laporan_temuan_id')->on('laporan_temuan')->onDelete('cascade');
        //     $table->foreignId('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_temuan_kriteria');
        Schema::dropIfExists('laporan_temuan');
    }
};
