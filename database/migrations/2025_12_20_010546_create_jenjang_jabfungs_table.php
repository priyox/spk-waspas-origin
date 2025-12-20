<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenjang_jabfung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenjang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenjang_jabfung');
    }
};
