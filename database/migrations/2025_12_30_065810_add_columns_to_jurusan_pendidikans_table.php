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
        Schema::table('jurusan_pendidikans', function (Blueprint $table) {
            // Add foreign keys if they don't exist
            if (!Schema::hasColumn('jurusan_pendidikans', 'tingkat_pendidikan_id')) {
                $table->foreignId('tingkat_pendidikan_id')->nullable()->after('id')
                      ->constrained('tingkat_pendidikans')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('jurusan_pendidikans', 'bidang_ilmu_id')) {
                $table->foreignId('bidang_ilmu_id')->nullable()->after('tingkat_pendidikan_id')
                      ->constrained('bidang_ilmus')->onDelete('cascade');
            }

            // Fix column name if needed
            if (Schema::hasColumn('jurusan_pendidikans', 'jurusan') && !Schema::hasColumn('jurusan_pendidikans', 'nama_jurusan')) {
                $table->renameColumn('jurusan', 'nama_jurusan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurusan_pendidikans', function (Blueprint $table) {
             if (Schema::hasColumn('jurusan_pendidikans', 'tingkat_pendidikan_id')) {
                $table->dropForeign(['tingkat_pendidikan_id']);
                $table->dropColumn('tingkat_pendidikan_id');
            }
            if (Schema::hasColumn('jurusan_pendidikans', 'bidang_ilmu_id')) {
                $table->dropForeign(['bidang_ilmu_id']);
                $table->dropColumn('bidang_ilmu_id');
            }
        });
    }
};
