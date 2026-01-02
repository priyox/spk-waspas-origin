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
            // Ubah presisi kolom wsm dan wpm dari double(4,2) ke double(8,4)
            // Ini memungkinkan penyimpanan hingga 4 digit desimal
            $table->double('wsm', 8, 4)->change();
            $table->double('wpm', 8, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waspas_nilais', function (Blueprint $table) {
            // Kembalikan ke presisi semula
            $table->double('wsm', 4, 2)->change();
            $table->double('wpm', 4, 2)->change();
        });
    }
};
