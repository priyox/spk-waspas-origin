<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasaJabatanRange;

class MasaJabatanRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranges = [
            [
                'min_tahun' => null,
                'max_tahun' => 2,
                'nilai' => 1,
                'keterangan' => '< 2 tahun',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'min_tahun' => 2,
                'max_tahun' => 3,
                'nilai' => 3,
                'keterangan' => '2 - 3 tahun',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'min_tahun' => 3,
                'max_tahun' => 4,
                'nilai' => 4,
                'keterangan' => '3 - 4 tahun',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'min_tahun' => 4,
                'max_tahun' => null,
                'nilai' => 5,
                'keterangan' => '> 4 tahun',
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($ranges as $range) {
            MasaJabatanRange::create($range);
        }
    }
}
