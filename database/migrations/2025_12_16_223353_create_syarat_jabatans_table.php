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
        Schema::create('syarat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eselon_id')
                  ->constrained('eselons') // Nama tabel yang direferensikan (eselons)
                  ->onDelete('restrict');
            // Kolom syarat dan nilai
            $table->string('syarat', 100); // Contoh: Pendidikan Minimal, Pengalaman Kerja, Usia Maksimal
            $table->string('nilai', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_jabatans');
    }
};
