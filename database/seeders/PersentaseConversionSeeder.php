<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersentaseConversion;

class PersentaseConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversions = [
            // Kriteria 9 - Potensi
            [
                'kriteria_id' => 9,
                'min_persentase' => 0,
                'max_persentase' => 20,
                'nilai' => 1,
                'keterangan' => '0-20: Sangat Kurang',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'kriteria_id' => 9,
                'min_persentase' => 21,
                'max_persentase' => 40,
                'nilai' => 2,
                'keterangan' => '21-40: Kurang',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'kriteria_id' => 9,
                'min_persentase' => 41,
                'max_persentase' => 60,
                'nilai' => 3,
                'keterangan' => '41-60: Cukup',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'kriteria_id' => 9,
                'min_persentase' => 61,
                'max_persentase' => 80,
                'nilai' => 4,
                'keterangan' => '61-80: Baik',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'kriteria_id' => 9,
                'min_persentase' => 81,
                'max_persentase' => 100,
                'nilai' => 5,
                'keterangan' => '81-100: Sangat Baik',
                'is_active' => true,
                'order' => 5,
            ],

            // Kriteria 10 - Kompetensi
            [
                'kriteria_id' => 10,
                'min_persentase' => 0,
                'max_persentase' => 20,
                'nilai' => 1,
                'keterangan' => '0-20: Sangat Kurang',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'kriteria_id' => 10,
                'min_persentase' => 21,
                'max_persentase' => 40,
                'nilai' => 2,
                'keterangan' => '21-40: Kurang',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'kriteria_id' => 10,
                'min_persentase' => 41,
                'max_persentase' => 60,
                'nilai' => 3,
                'keterangan' => '41-60: Cukup',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'kriteria_id' => 10,
                'min_persentase' => 61,
                'max_persentase' => 80,
                'nilai' => 4,
                'keterangan' => '61-80: Baik',
                'is_active' => true,
                'order' => 9,
            ],
            [
                'kriteria_id' => 10,
                'min_persentase' => 81,
                'max_persentase' => 100,
                'nilai' => 5,
                'keterangan' => '81-100: Sangat Baik',
                'is_active' => true,
                'order' => 10,
            ],
        ];

        foreach ($conversions as $conversion) {
            PersentaseConversion::create($conversion);
        }
    }
}
