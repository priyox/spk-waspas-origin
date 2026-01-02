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
        Schema::table('waspas_nilais', function (Blueprint $table) {
            // Ubah semua kolom menjadi double(8,4)
            // Total 8 digit, 4 digit di belakang koma
            // Nilai akan dibulatkan saat disimpan
            $table->double('pangkat', 8, 4)->nullable()->change();
            $table->double('masa_jabatan', 8, 4)->nullable()->change();
            $table->double('tingkat_pendidikan', 8, 4)->nullable()->change();
            $table->double('diklat', 8, 4)->nullable()->change();
            $table->double('skp', 8, 4)->nullable()->change();
            $table->double('penghargaan', 8, 4)->nullable()->change();
            $table->double('hukdis', 8, 4)->nullable()->change();
            $table->double('potensi', 8, 4)->nullable()->change();
            $table->double('kompetensi', 8, 4)->nullable()->change();
            $table->double('bidang_ilmu', 8, 4)->nullable()->change();
            $table->double('wsm', 8, 4)->change();
            $table->double('wpm', 8, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waspas_nilais', function (Blueprint $table) {
            // Kembalikan ke double(4,2)
            $table->double('pangkat', 4, 2)->nullable()->change();
            $table->double('masa_jabatan', 4, 2)->nullable()->change();
            $table->double('tingkat_pendidikan', 4, 2)->nullable()->change();
            $table->double('diklat', 4, 2)->nullable()->change();
            $table->double('skp', 4, 2)->nullable()->change();
            $table->double('penghargaan', 4, 2)->nullable()->change();
            $table->double('hukdis', 4, 2)->nullable()->change();
            $table->double('potensi', 4, 2)->nullable()->change();
            $table->double('kompetensi', 4, 2)->nullable()->change();
            $table->double('bidang_ilmu', 4, 2)->nullable()->change();
            $table->double('wsm', 4, 2)->change();
            $table->double('wpm', 4, 2)->change();
        });
    }
};
