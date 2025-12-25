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
        Schema::table('kandidats', function (Blueprint $table) {
            // Static criteria columns (Foreign Keys to kriteria_nilais)
            $table->unsignedBigInteger('kn_id_diklat')->nullable()->after('bidang_ilmu_id'); // K4
            $table->unsignedBigInteger('kn_id_skp')->nullable()->after('kn_id_diklat'); // K5
            $table->unsignedBigInteger('kn_id_penghargaan')->nullable()->after('kn_id_skp'); // K6
            $table->unsignedBigInteger('kn_id_integritas')->nullable()->after('kn_id_penghargaan'); // K7
            $table->unsignedBigInteger('kn_id_potensi')->nullable()->after('kn_id_integritas'); // K9
            $table->unsignedBigInteger('kn_id_kompetensi')->nullable()->after('kn_id_potensi'); // K10

            // Foreign key constraints
            $table->foreign('kn_id_diklat')->references('id')->on('kriteria_nilais')->onDelete('set null');
            $table->foreign('kn_id_skp')->references('id')->on('kriteria_nilais')->onDelete('set null');
            $table->foreign('kn_id_penghargaan')->references('id')->on('kriteria_nilais')->onDelete('set null');
            $table->foreign('kn_id_integritas')->references('id')->on('kriteria_nilais')->onDelete('set null');
            $table->foreign('kn_id_potensi')->references('id')->on('kriteria_nilais')->onDelete('set null');
            $table->foreign('kn_id_kompetensi')->references('id')->on('kriteria_nilais')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropForeign(['kn_id_diklat']);
            $table->dropForeign(['kn_id_skp']);
            $table->dropForeign(['kn_id_penghargaan']);
            $table->dropForeign(['kn_id_integritas']);
            $table->dropForeign(['kn_id_potensi']);
            $table->dropForeign(['kn_id_kompetensi']);

            $table->dropColumn([
                'kn_id_diklat',
                'kn_id_skp',
                'kn_id_penghargaan',
                'kn_id_integritas',
                'kn_id_potensi',
                'kn_id_kompetensi'
            ]);
        });
    }
};
