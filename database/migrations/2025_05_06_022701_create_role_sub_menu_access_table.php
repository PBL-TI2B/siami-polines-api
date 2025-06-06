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
        Schema::create('role_sub_menu_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('sub_menu_id');
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->foreign('sub_menu_id')->references('sub_menu_id')->on('sub_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_sub_menu_access');
    }
};
