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
        Schema::create('kriteria_nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')
                  ->constrained('kriterias') // Merujuk ke tabel 'kriterias'
                  ->onDelete('cascade'); // Jika kriteria dihapus, nilai-nilainya juga dihapus
            $table->string('kategori', 100); 
            $table->integer('nilai');        
            $table->text('ket')->nullable(); // Keterangan atau deskripsi tambahan
            $table->unique(['kriteria_id', 'kategori']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_nilais');
    }
};
