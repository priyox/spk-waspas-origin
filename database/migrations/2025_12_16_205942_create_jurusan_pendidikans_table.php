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
        Schema::create('jurusan_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('jurusan');
            $table->foreignId('tingkat_pendidikan_id')
                  ->constrained('tingkat_pendidikans') // Merujuk ke tabel tingkat_pendidikans
                  ->onDelete('cascade'); 
            $table->foreignId('bidang_ilmu_id')
                  ->constrained('bidang_ilmus') // Merujuk ke tabel bidang_ilmus
                  ->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_pendidikans');
    }
};
