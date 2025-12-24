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
        Schema::create('masa_jabatan_ranges', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_tahun', 5, 2)->nullable()->comment('Minimal tahun, null untuk tidak terbatas');
            $table->decimal('max_tahun', 5, 2)->nullable()->comment('Maksimal tahun, null untuk tidak terbatas');
            $table->integer('nilai')->comment('Nilai yang didapat (1-5)');
            $table->string('keterangan')->comment('Deskripsi range, misal: "> 4 tahun"');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0)->comment('Urutan tampilan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masa_jabatan_ranges');
    }
};
