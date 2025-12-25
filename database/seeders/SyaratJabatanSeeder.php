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
                'eselon_id' => 21, // Eselon III.B
                'minimal_golongan_id' => 42, // Minimal III/c
                'syarat_golongan_id' => 43, // Minimal III/c
                'minimal_tingkat_pendidikan_id' => 7, // Minimal D-IV/S-1
                'minimal_eselon_id' => 22, // Minimal Eselon IV.A
                'minimal_jenjang_fungsional_id' => 7,
                'keterangan' => null,
            ],
            [
                'id' => 2,
                'eselon_id' => 22, // Eselon IV.A
                'minimal_golongan_id' => 41, // Minimal III/b
                'syarat_golongan_id' => 42, // Minimal III/b
                'minimal_tingkat_pendidikan_id' => 7, // Minimal D-III
                'minimal_eselon_id' => 32,
                'minimal_jenjang_fungsional_id' => 7,
                'keterangan' => null,
            ],
            [
                'id' => 3,
                'eselon_id' => 31, // Eselon IV.A
                'minimal_golongan_id' => 34, // Minimal III/b
                'syarat_golongan_id' => 41, // Minimal III/b
                'minimal_tingkat_pendidikan_id' => 7, // Minimal D-III
                'minimal_eselon_id' => 41,
                'minimal_jenjang_fungsional_id' => 6,
                'keterangan' => null,
            ],
            [
                'id' => 4,
                'eselon_id' => 32, // Eselon IV.A
                'minimal_golongan_id' => 33, // Minimal III/b
                'syarat_golongan_id' => 34, // Minimal III/b
                'minimal_tingkat_pendidikan_id' => 7, // Minimal D-III
                'minimal_eselon_id' => 41,
                'minimal_jenjang_fungsional_id' => 6,
                'keterangan' => null,
            ],
            [
                'id' => 5,
                'eselon_id' => 41, // Eselon IV.A
                'minimal_golongan_id' => 32, // Minimal III/b
                'syarat_golongan_id' => 33, // Minimal III/b
                'minimal_tingkat_pendidikan_id' => 6, // Minimal D-III
                'minimal_eselon_id' => null,
                'minimal_jenjang_fungsional_id' => 3,
                'keterangan' => null,
            ],
               [
                'id' => 6,
                'eselon_id' => 42, // Eselon IV.A
                'minimal_golongan_id' => 31, // Minimal III/b
                'syarat_golongan_id' => 32, // Minimal III/b
                'minimal_tingkat_pendidikan_id' => 6, // Minimal D-III
                'minimal_eselon_id' => null,
                'minimal_jenjang_fungsional_id' => 3,
                'keterangan' => null,
            ],
        ];

        SyaratJabatan::insert($data);
    }
}
