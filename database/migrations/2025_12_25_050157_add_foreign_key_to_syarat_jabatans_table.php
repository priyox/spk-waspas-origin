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
            $table->foreign('minimal_jenjang_fungsional_id')
                  ->references('id')
                  ->on('jenjang_fungsionals')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syarat_jabatans', function (Blueprint $table) {
            $table->dropForeign(['minimal_jenjang_fungsional_id']);
        });
    }
};
