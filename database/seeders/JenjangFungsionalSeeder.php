<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenjangFungsionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'jenjang' => 'Terampil', 'tingkat' => 1],
            ['id' => 2, 'jenjang' => 'Mahir', 'tingkat' => 2],
            ['id' => 3, 'jenjang' => 'Penyelia', 'tingkat' => 3],
            ['id' => 4, 'jenjang' => 'Ahli Pertama', 'tingkat' => 4],
            ['id' => 5, 'jenjang' => 'Ahli Muda', 'tingkat' => 5],
            ['id' => 6, 'jenjang' => 'Ahli Madya', 'tingkat' => 6],
            ['id' => 7, 'jenjang' => 'Ahli Utama', 'tingkat' => 7],
        ];

        foreach ($data as $item) {
            \App\Models\JenjangFungsional::updateOrInsert(['id' => $item['id']], $item);
        }
    }
}
