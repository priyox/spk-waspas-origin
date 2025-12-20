<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenjangJabfung;

class JenjangJabfungSeeder extends Seeder
{
    public function run(): void
    {
        JenjangJabfung::query()->delete();

        $data = [
            ['id' => 1, 'nama_jenjang' => 'Pemula'],
            ['id' => 2, 'nama_jenjang' => 'Terampil'],
            ['id' => 3, 'nama_jenjang' => 'Penyelia'],
            ['id' => 4, 'nama_jenjang' => 'Ahli Pertama'],
            ['id' => 5, 'nama_jenjang' => 'Ahli Muda'],
            ['id' => 6, 'nama_jenjang' => 'Ahli Madya'],
            ['id' => 7, 'nama_jenjang' => 'Ahli Utama'],
        ];

        foreach ($data as $item) {
            JenjangJabfung::create($item);
        }
    }
}
