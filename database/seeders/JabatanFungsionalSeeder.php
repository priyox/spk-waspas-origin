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
                'jenjang' => 'Terampil',
                'nama_jabatan' => 'Arsiparis Terampil',
            ],
            [
                'id' => 2,
                'jenjang' => 'Mahir',
                'nama_jabatan' => 'Arsiparis Mahir',
            ],
             [
                'id' => 3,
                'jenjang' => 'Penyelia',
                'nama_jabatan' => 'Arsiparis Penyelia',
            ],
             [
                'id' => 4,
                'jenjang' => 'Ahli Pertama',
                'nama_jabatan' => 'Arsiparis Ahli Pertama',
            ],
             [
                'id' => 5,
                'jenjang' => 'Ahli Muda',
                'nama_jabatan' => 'Arsiparis Ahli Muda',
            ],
             [
                'id' => 6,
                'jenjang' => 'Ahli Madya',
                'nama_jabatan' => 'Arsiparis Ahli Madya',
            ],
             [
                'id' => 7,
                'jenjang' => 'Ahli Utama',
                'nama_jabatan' => 'Arsiparis Ahli Utama',
            ],
             [
                'id' => 8,
                'jenjang' => 'Terampil',
                'nama_jabatan' => 'Pranata Komputer Terampil',
            ],
            [
                'id' => 9,
                'jenjang' => 'Mahir',
                'nama_jabatan' => 'Pranata Komputer Mahir',
            ],
             [
                'id' => 10,
                'jenjang' => 'Penyelia',
                'nama_jabatan' => 'Pranata Komputer Penyelia',
            ],
             [
                'id' => 11,
                'jenjang' => 'Ahli Pertama',
                'nama_jabatan' => 'Pranata Komputer Ahli Pertama',
            ],
             [
                'id' => 12,
                'jenjang' => 'Ahli Muda',
                'nama_jabatan' => 'Pranata Komputer Ahli Muda',
            ],
             [
                'id' => 13,
                'jenjang' => 'Ahli Madya',
                'nama_jabatan' => 'Pranata Komputer Ahli Madya',
            ],
             [
                'id' => 14,
                'jenjang' => 'Ahli Utama',
                'nama_jabatan' => 'Pranata Komputer Ahli Utama',
            ],
        ];

        foreach ($data as $item) {
            JabatanFungsional::create($item);
        }
    }
}
