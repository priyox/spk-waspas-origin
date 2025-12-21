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
        Schema::create('kandidats', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 18)->unique(); 
            $table->string('nama', 255);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->foreignId('golongan_id')->constrained('golongans');
            $table->date('tmt_golongan');
            $table->foreignId('jenis_jabatan_id')->constrained('jenis_jabatans');
            $table->foreignId('eselon_id')->nullable();
            $table->string('jabatan', 255);
            $table->date('tmt_jabatan');
            $table->string('unit_kerja', 255)->nullable();
            $table->foreignId('tingkat_pendidikan_id')->constrained('tingkat_pendidikans');
            $table->string('jurusan', 255)->nullable();
            $table->foreignId('bidang_ilmu_id')->constrained('bidang_ilmus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
