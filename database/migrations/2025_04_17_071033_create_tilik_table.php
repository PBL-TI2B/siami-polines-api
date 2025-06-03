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
        Schema::create('tilik', function (Blueprint $table) {
            $table->id('tilik_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->text('pertanyaan');
            $table->text('indikator')->nullable();
            $table->char('sumber_data', 255)->nullable();
            $table->char('metode_perhitungan', 255)->nullable();
            $table->char('target', 255)->nullable();
            
            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tilik');
    }
};
