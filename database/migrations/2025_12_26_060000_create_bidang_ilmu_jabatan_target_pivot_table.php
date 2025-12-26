<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bidang_ilmu_jabatan_target', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jabatan_target_id')->constrained('jabatan_targets')->onDelete('cascade');
            $table->foreignId('bidang_ilmu_id')->constrained('bidang_ilmus')->onDelete('cascade');
            $table->timestamps();
        });

        // Migrate existing data
        $results = DB::table('jabatan_targets')->whereNotNull('id_bidang')->get();
        foreach ($results as $row) {
            DB::table('bidang_ilmu_jabatan_target')->insert([
                'jabatan_target_id' => $row->id,
                'bidang_ilmu_id' => $row->id_bidang,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Drop old column
        Schema::table('jabatan_targets', function (Blueprint $table) {
            // No foreign key to drop based on original migration
            $table->dropColumn('id_bidang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jabatan_targets', function (Blueprint $table) {
            $table->integer('id_bidang')->nullable();
        });

        // Restore data (take first one if multiple)
        $results = DB::table('bidang_ilmu_jabatan_target')->get();
        foreach ($results as $row) {
            // Only update if null to avoid overwriting with secondary values (imperfect reverse)
            $exists = DB::table('jabatan_targets')->where('id', $row->jabatan_target_id)->whereNotNull('id_bidang')->exists();
            if (!$exists) {
                DB::table('jabatan_targets')
                    ->where('id', $row->jabatan_target_id)
                    ->update(['id_bidang' => $row->bidang_ilmu_id]);
            }
        }

        Schema::dropIfExists('bidang_ilmu_jabatan_target');
    }
};
