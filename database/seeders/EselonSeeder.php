<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eselon;

class EselonSeeder extends Seeder
{
    public function run(): void
    {
        // aman untuk FK
        Eselon::query()->delete();

        $data = [
            ['id' => 21, 'eselon' => 'II.A',  'jenis_jabatan' => 'Jabatan Pimpinan Tinggi Pratama'],
            ['id' => 22, 'eselon' => 'II.B',  'jenis_jabatan' => 'Jabatan Pimpinan Tinggi Pratama'],
            ['id' => 31, 'eselon' => 'III.A', 'jenis_jabatan' => 'Jabatan Administrator'],
            ['id' => 32, 'eselon' => 'III.B', 'jenis_jabatan' => 'Jabatan Administrator'],
            ['id' => 41, 'eselon' => 'IV.A',  'jenis_jabatan' => 'Jabatan Pengawas'],
            ['id' => 42, 'eselon' => 'IV.B',  'jenis_jabatan' => 'Jabatan Pengawas'],
        ];

        foreach ($data as $row) {
            Eselon::create($row);
        }
    }
}
