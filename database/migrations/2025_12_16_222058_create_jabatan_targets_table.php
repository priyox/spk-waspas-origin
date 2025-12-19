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
        Schema::create('jabatan_targets', function (Blueprint $table) {
            $table->id();
            $table->integer('id_eselon');
            $table->string('nama_jabatan', 255); // String dengan batas default 255 karakter
            $table->integer('id_bidang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan_targets');
    }
};
