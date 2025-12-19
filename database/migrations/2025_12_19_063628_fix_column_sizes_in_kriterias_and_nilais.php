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
        Schema::table('kriterias', function (Blueprint $table) {
            $table->double('bobot')->change(); // Remove (3,2) constraint
        });

        Schema::table('nilais', function (Blueprint $table) {
            $table->double('nilai')->change(); // Remove (3,2) constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            $table->double('bobot', 3, 2)->change();
        });

        Schema::table('nilais', function (Blueprint $table) {
            $table->double('nilai', 3, 2)->change();
        });
    }
};
