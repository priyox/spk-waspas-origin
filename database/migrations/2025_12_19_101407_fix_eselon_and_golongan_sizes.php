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
        Schema::table('eselons', function (Blueprint $table) {
            $table->string('eselon', 20)->change();
            $table->string('jenis_jabatan', 50)->nullable()->change();
        });

        Schema::table('golongans', function (Blueprint $table) {
            $table->string('pangkat', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('eselons', function (Blueprint $table) {
            $table->string('eselon', 5)->change();
            $table->string('jenis_jabatan', 20)->nullable(false)->change();
        });

        Schema::table('golongans', function (Blueprint $table) {
            $table->string('pangkat', 20)->change();
        });
    }
};
