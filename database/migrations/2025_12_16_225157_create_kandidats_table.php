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
            $table->date('tanggal_lahir')->nullable();
            $table->foreignId('golongan_id')->nullable()->constrained('golongans');
            $table->date('tmt_golongan')->nullable();
            $table->foreignId('jenis_jabatan_id')->nullable()->constrained('jenis_jabatans');
            $table->foreignId('eselon_id')->nullable()->constrained('eselons');
            $table->string('jabatan', 255);
            $table->date('tmt_jabatan')->nullable();
            $table->string('unit_kerja', 255)->nullable();
            $table->foreignId('tingkat_pendidikan_id')->nullable()->constrained('tingkat_pendidikans');
            $table->string('jurusan', 255)->nullable();
            $table->foreignId('jurusan_pendidikan_id')->nullable()->constrained('jurusan_pendidikans');
            $table->foreignId('jabatan_fungsional_id')->nullable()->constrained('jabatan_fungsionals');
            $table->foreignId('jabatan_pelaksana_id')->nullable()->constrained('jabatan_pelaksanas');
            $table->foreignId('bidang_ilmu_id')->nullable()->constrained('bidang_ilmus');
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerjas');
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
