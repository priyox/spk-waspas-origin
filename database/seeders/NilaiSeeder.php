<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nilai;
use App\Models\Kandidat;
use App\Models\Kriteria;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        Nilai::query()->delete();

        $kandidats = Kandidat::all();
        $kriterias = Kriteria::all();

        // Kriteria yang auto-filled, JANGAN diisi di seeder
        $autoFilledKriterias = [1, 2, 3, 8];

        foreach ($kandidats as $kandidat) {
            foreach ($kriterias as $kriteria) {
                // Skip kriteria auto-fill, biarkan kosong untuk di-auto-fill
                if (in_array($kriteria->id, $autoFilledKriterias)) {
                    continue;
                }

                $nilai = 0;
                // Generate values untuk kriteria manual (4,5,6,7,9,10)
                switch ($kriteria->id) {
                    case 4: $nilai = rand(1, 5); break;   // Diklat (1-5)
                    case 5: $nilai = rand(3, 5); break;   // SKP (3-5, biasanya bagus)
                    case 6: $nilai = rand(1, 5); break;   // Penghargaan (1-5)
                    case 7: $nilai = rand(2, 5); break;   // Integritas (2-5, biasanya baik)
                    case 9: $nilai = rand(60, 95); break; // Potensi (0-100, nilai asli disimpan)
                    case 10: $nilai = rand(60, 95); break; // Kompetensi (0-100, nilai asli disimpan)
                    default: $nilai = rand(1, 5);
                }

                Nilai::create([
                    'kandidats_id' => $kandidat->id,
                    'kriteria_id' => $kriteria->id,
                    'nilai' => $nilai
                ]);
            }
        }
    }
}
