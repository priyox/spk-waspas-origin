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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')
                  ->constrained('kriterias')
                  ->onDelete('cascade'); 

            $table->string('nip', 18);
            $table->foreign('nip')->references('nip')->on('kandidats')
                  ->onDelete('cascade'); // Jika Kandidat dihapus, semua nilainya juga dihapus
                  
            $table->double('nilai', 3, 2); 

            $table->unique(['kriteria_id', 'nip']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
