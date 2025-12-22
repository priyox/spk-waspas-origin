<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan_fungsionals', function (Blueprint $table) {
            $table->id();
            $table->string('jenjang');
            $table->string('nama_jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan_fungsionals');
    }
};
