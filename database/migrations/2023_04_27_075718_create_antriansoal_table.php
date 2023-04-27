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
        Schema::create('antriansoal', function (Blueprint $table) {
            $table->string('nomorkartu', 9)->primary();
            $table->string('nomorantrean');
            $table->integer('angkaantrean');
            $table->string('norm');
            $table->string('namapoli');
            $table->string('kodepoli');
            $table->date('tglpriksa');
            $table->string('nik');
            $table->string('keluhan');
            $table->integer('statusdipanggil');
            $table->integer('int')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antriansoal');
    }
};
