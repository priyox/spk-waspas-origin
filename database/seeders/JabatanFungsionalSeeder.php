<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JabatanFungsional;

class JabatanFungsionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JabatanFungsional::query()->delete();
        $data = [
            [
                'id' => 1,
                'jenjang_id' => 1,
                'nama_jabatan' => 'Arsiparis Terampil',
            ],
            [
                'id' => 2,
                'jenjang_id' => 2,
                'nama_jabatan' => 'Arsiparis Mahir',
            ],
             [
                'id' => 3,
                'jenjang_id' => 3,
                'nama_jabatan' => 'Arsiparis Penyelia',
            ],
             [
                'id' => 4,
                'jenjang_id' => 4,
                'nama_jabatan' => 'Arsiparis Ahli Pertama',
            ],
             [
                'id' => 5,
                'jenjang_id' => 5,
                'nama_jabatan' => 'Arsiparis Ahli Muda',
            ],
             [
                'id' => 6,
                'jenjang_id' => 6,
                'nama_jabatan' => 'Arsiparis Ahli Madya',
            ],
             [
                'id' => 7,
                'jenjang_id' => 7,
                'nama_jabatan' => 'Arsiparis Ahli Utama',
            ],
             [
                'id' => 8,
                'jenjang_id' => 1,
                'nama_jabatan' => 'Pranata Komputer Terampil',
            ],
            [
                'id' => 9,
                'jenjang_id' => 2,
                'nama_jabatan' => 'Pranata Komputer Mahir',
            ],
             [
                'id' => 10,
                'jenjang_id' => 3,
                'nama_jabatan' => 'Pranata Komputer Penyelia',
            ],
             [
                'id' => 11,
                'jenjang_id' => 4,
                'nama_jabatan' => 'Pranata Komputer Ahli Pertama',
            ],
             [
                'id' => 12,
                'jenjang_id' => 5,
                'nama_jabatan' => 'Pranata Komputer Ahli Muda',
            ],
             [
                'id' => 13,
                'jenjang_id' => 6,
                'nama_jabatan' => 'Pranata Komputer Ahli Madya',
            ],
             [
                'id' => 14,
                'jenjang_id' => 7,
                'nama_jabatan' => 'Pranata Komputer Ahli Utama',
            ],
        ];

        foreach ($data as $item) {
            JabatanFungsional::create($item);
        }
    }
}
