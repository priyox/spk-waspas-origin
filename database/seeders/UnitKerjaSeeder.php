<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitKerja;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       UnitKerja::query()->delete();

        $data = [
            ['id' => 1, 'unit_kerja' => 'Sekretariat Daerah'],
            ['id' => 2, 'unit_kerja' => 'Sekretariat Dewan Perwakilan Rakyat Daerah'],
            ['id' => 3, 'unit_kerja' => 'Badan Kepegawaian Daerah'],
            ['id' => 4, 'unit_kerja' => 'Badan Pengelolaan Pendapatan Keuangan dan Aset Daerah'],
            ['id' => 5, 'unit_kerja' => 'Badan Penanggulangan Bencana Daerah'],
            ['id' => 6, 'unit_kerja' => 'Dinas Pendidikan'],
            ['id' => 7, 'unit_kerja' => 'Dinas Kesehatan'],
            ['id' => 8, 'unit_kerja' => 'Dinas Lingkungan Hidup'],
            ['id' => 9, 'unit_kerja' => 'Dinas Pekerjaan Umum'],
        ];

        foreach ($data as $row) {
            UnitKerja::create($row);
        }
    }
}
