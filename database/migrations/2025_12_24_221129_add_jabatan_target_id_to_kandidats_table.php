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
            $table->foreignId('jabatan_target_id')->nullable()->constrained('jabatan_targets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropForeign(['jabatan_target_id']);
            $table->dropColumn('jabatan_target_id');
        });
    }
};
