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

        foreach ($kandidats as $kandidat) {
            foreach ($kriterias as $kriteria) {
                $nilai = 0;
                // Generate values between 1-100 for simplicity and testing
                switch ($kriteria->id) {
                    case 1: $nilai = rand(70, 95); break; // Pangkat
                    case 2: $nilai = rand(5, 20); break;  // Masa Jabatan
                    case 3: $nilai = rand(70, 98); break; // Pendidikan
                    case 4: $nilai = rand(1, 10); break;  // Diklat
                    case 5: $nilai = rand(80, 100); break; // SKP
                    case 6: $nilai = rand(0, 5); break;   // Penghargaan
                    case 7: $nilai = rand(90, 100); break; // Integritas
                    case 8: $nilai = rand(70, 95); break;  // Bidang Ilmu
                    case 9: $nilai = rand(75, 95); break;  // Potensi
                    case 10: $nilai = rand(75, 95); break; // Kompetensi
                    default: $nilai = rand(60, 90);
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
