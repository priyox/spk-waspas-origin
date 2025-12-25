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
        Schema::table('syarat_jabatans', function (Blueprint $table) {
            $table->unsignedBigInteger('syarat_golongan_id')->nullable()->after('minimal_golongan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syarat_jabatans', function (Blueprint $table) {
            $table->dropColumn('syarat_golongan_id');
        });
    }
};
