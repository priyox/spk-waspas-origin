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
        Schema::create('waspas_nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jabatan_target_id')
                  ->constrained('jabatan_targets') // Merujuk ke tabel jabatan_targets
                  ->onDelete('cascade'); 
                  
            // Kolom Foreign Key ke tabel 'kandidats' (id)
            $table->foreignId('kandidats_id')
                  ->constrained('kandidats') // Merujuk ke tabel kandidats
                  ->onDelete('cascade'); 
                  
            $table->double('pangkat', 4, 2)->nullable(); 
            $table->double('masa_jabatan', 4, 2)->nullable();
            $table->double('tingkat_pendidikan', 4, 2)->nullable(); // Mengganti nama kolom untuk kejelasan
            $table->double('diklat', 4, 2)->nullable();
            $table->double('skp', 4, 2)->nullable();
            $table->double('penghargaan', 4, 2)->nullable();
            $table->double('hukdis', 4, 2)->nullable(); // Hukuman Disiplin
            $table->double('potensi', 4, 2)->nullable();
            $table->double('kompetensi', 4, 2)->nullable();
            $table->double('bidang_ilmu', 4, 2)->nullable();

            // Kolom Hasil WASPAS
            $table->double('wsm', 4, 2); // Weighted Sum Model Score
            $table->double('wpm', 4, 2); // Weighted Product Model Score

            // Constraint unik: Satu kandidat hanya boleh memiliki satu hasil per jabatan target
            $table->unique(['jabatan_target_id', 'kandidats_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waspas_nilais');
    }
};
