<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SyaratJabatan;

class SyaratJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SyaratJabatan::query()->delete();
        $data = [
            [
                'id' => 1,
                'eselon_id' => 32, // Eselon III.B
                'minimal_golongan_id' => 33, // Minimal III/c
                'minimal_tingkat_pendidikan_id' => 7, // Minimal D-IV/S-1
                'minimal_eselon_id' => 41, // Minimal Eselon IV.A
                'minimal_jenjang_fungsional_id' => null,
                'keterangan' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'eselon_id' => 41, // Eselon IV.A
                'minimal_golongan_id' => 32, // Minimal III/b
                'minimal_tingkat_pendidikan_id' => 6, // Minimal D-III
                'minimal_eselon_id' => null,
                'minimal_jenjang_fungsional_id' => null,
                'keterangan' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        SyaratJabatan::insert($data);
    }
}
