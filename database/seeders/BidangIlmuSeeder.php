<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BidangIlmu;

class BidangIlmuSeeder extends Seeder
{
    public function run(): void
    {
        BidangIlmu::query()->delete();

        $data = [
            ['id' => 1, 'bidang' => 'Teknik Informatika'],
            ['id' => 2, 'bidang' => 'Sistem Informasi'],
            ['id' => 3, 'bidang' => 'Manajemen'],
            ['id' => 4, 'bidang' => 'Hukum'],
            ['id' => 5, 'bidang' => 'Ekonomi'],
            ['id' => 6, 'bidang' => 'Administrasi Negara'],
            ['id' => 7, 'bidang' => 'Psikologi'],
        ];

        foreach ($data as $row) {
            BidangIlmu::create($row);
        }
    }
}
