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
        Schema::table('jabatan_fungsionals', function (Blueprint $table) {
            $table->dropColumn('jenjang');
            $table->unsignedBigInteger('jenjang_id')->nullable()->after('id');
            $table->foreign('jenjang_id')
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
        Schema::table('jabatan_fungsionals', function (Blueprint $table) {
            $table->dropForeign(['jenjang_id']);
            $table->dropColumn('jenjang_id');
            $table->string('jenjang')->after('id');
        });
    }
};
