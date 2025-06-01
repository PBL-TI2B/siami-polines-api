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
        Schema::create('responses', function (Blueprint $table) {
            $table->id('response_id');
            $table->unsignedBigInteger('auditing_id');
            $table->unsignedBigInteger('set_instrumen_unit_kerja_id');
            $table->char('ketersediaan_standar_dan_dokumen', 100)->nullable();
            $table->enum('spt_pt', ['0','1'])->nullable();
            $table->enum('sn_dikti', ['0','1'])->nullable();
            $table->enum('lokal',['0','1'])->nullable();
            $table->enum('nasional', ['0','1'])->nullable();
            $table->enum('internasional', ['0','1'])->nullable();
            $table->char('capaian', 100)->nullable();
            $table->char('sesuai', 100)->nullable();
            $table->char('lokasi_bukti_dukung', 100)->nullable();
            $table->enum('minor', ['0','1'])->nullable();
            $table->enum('mayor', ['0','1'])->nullable();
            $table->enum('ofi', ['0','1'] )->nullable();
            $table->text('keterangan')->nullable();
            
            $table->foreign('auditing_id')->references('auditing_id')->on('auditings')->onDelete('cascade');
            $table->foreign('set_instrumen_unit_kerja_id')->references('set_instrumen_unit_kerja_id')->on('set_instrumen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
