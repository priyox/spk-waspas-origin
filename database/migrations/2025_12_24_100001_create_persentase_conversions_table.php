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
        Schema::create('persentase_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->decimal('min_persentase', 5, 2)->comment('Minimal persentase (0-100)');
            $table->decimal('max_persentase', 5, 2)->comment('Maksimal persentase (0-100)');
            $table->integer('nilai')->comment('Nilai yang didapat (1-5)');
            $table->string('keterangan')->comment('Deskripsi range, misal: "81-100: Sangat Baik"');
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
        Schema::dropIfExists('persentase_conversions');
    }
};
