<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JabatanTarget;

class JabatanTargetSeeder extends Seeder
{
    public function run(): void
    {
        // Jangan truncate jika ada FK, gunakan delete
        JabatanTarget::query()->delete();

        $data = [
            [
                'id' => 1,
                'id_eselon' => 32,
                'nama_jabatan' => 'Kabid Informatika',
                'id_bidang' => 1,
            ],
            [
                'id' => 2,
                'id_eselon' => 41,
                'nama_jabatan' => 'Kasubag Umpeg',
                'id_bidang' => 2,
            ],
        ];

        foreach ($data as $item) {
            JabatanTarget::create($item);
        }
    }
}
