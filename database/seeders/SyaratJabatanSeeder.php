<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SyaratJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        DB::table('syarat_jabatans')->insert([
            [
                'id' => 1,
                'id_eselon' => 32,
                'minimal_golongan_id' => 33,
                'minimal_pendidikan_id' => 7,
                'minimal_eselon_id' => 41,
                'minimal_jabatan_id' => 5,
                'keterangan' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'id_eselon' => 41,
                'minimal_golongan_id' => 32,
                'minimal_pendidikan_id' => 6,
                'minimal_eselon_id' => null, // Data pada gambar kosong untuk baris ini
                'minimal_jabatan_id' => 2,
                'keterangan' => null,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
