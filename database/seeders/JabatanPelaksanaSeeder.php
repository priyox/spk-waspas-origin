<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JabatanPelaksana;

class JabatanPelaksanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JabatanPelaksana::query()->delete();
          $data = [
            [
                'id' => 1,
                'nama_jabatan' => 'Operator Layanan Operasional',
            ],
            [
                'id' => 2,
                'nama_jabatan' => 'Pengelola Umum Operasional',
            ],
             [
                'id' => 3,
                'nama_jabatan' => 'Penata Layanan Opeasional',
            ],
             [
                'id' => 4,
                'nama_jabatan' => 'Penelaah Teknis Kebijakan',
            ],
             [
                'id' => 5,
                'nama_jabatan' => 'Penata Kelola Pemerintahan',
            ],
             [
                'id' => 6,
                'nama_jabatan' => 'Pengawas Keuangan Negara',
            ],
        ];

        foreach ($data as $item) {
            JabatanPelaksana::create($item);
        }
    }
}
