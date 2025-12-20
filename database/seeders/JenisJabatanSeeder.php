<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisJabatan;

class JenisJabatanSeeder extends Seeder
{
    public function run(): void
    {
        // aman terhadap foreign key
        JenisJabatan::query()->delete();

        $data = [
            ['id' => 20, 'jenis_jabatan' => 'Jabatan Pimpinan Tinggi Pratama'],
            ['id' => 30, 'jenis_jabatan' => 'Administrator'],
            ['id' => 40, 'jenis_jabatan' => 'Pengawas'],
            ['id' => 2,  'jenis_jabatan' => 'Fungsional'],
            ['id' => 3,  'jenis_jabatan' => 'Pelaksana'],
        ];

        foreach ($data as $row) {
            JenisJabatan::create($row);
        }
    }
}
