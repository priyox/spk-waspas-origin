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
            // Ubah semua kolom double menjadi float tanpa batasan
            // Ini memberikan presisi penuh untuk penyimpanan
            $table->float('pangkat')->nullable()->change();
            $table->float('masa_jabatan')->nullable()->change();
            $table->float('tingkat_pendidikan')->nullable()->change();
            $table->float('diklat')->nullable()->change();
            $table->float('skp')->nullable()->change();
            $table->float('penghargaan')->nullable()->change();
            $table->float('hukdis')->nullable()->change();
            $table->float('potensi')->nullable()->change();
            $table->float('kompetensi')->nullable()->change();
            $table->float('bidang_ilmu')->nullable()->change();
            $table->float('wsm')->change();
            $table->float('wpm')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waspas_nilais', function (Blueprint $table) {
            // Kembalikan ke double dengan presisi semula
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
