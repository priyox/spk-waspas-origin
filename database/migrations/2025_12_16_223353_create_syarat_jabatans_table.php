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
                  ->onDelete('cascade');
            // Kolom syarat dan nilai
            $table->unsignedBigInteger('minimal_golongan_id');

            $table->unsignedBigInteger('minimal_tingkat_pendidikan_id');

            // Syarat asal jabatan (OPSIONAL)
            $table->unsignedBigInteger('minimal_eselon_id')->nullable(); // jika struktural
            $table->unsignedBigInteger('minimal_jenjang_fungsional_id')->nullable(); // jika fungsional

            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);

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
