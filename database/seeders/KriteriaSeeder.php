<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // aman terhadap foreign key
        Kriteria::query()->delete();

        $data = [
            [
                'id' => 1,
                'kriteria' => 'Pangkat/Golongan',
                'bobot' => 5,
                'jenis' => 'benefit',
                'keterangan' => 'Kesesuaian pangkat dengan syarat jabatan',
            ],
            [
                'id' => 2,
                'kriteria' => 'Masa Jabatan',
                'bobot' => 10,
                'jenis' => 'benefit',
                'keterangan' => 'Masa kerja sejak diangkat dalam jabatan terakhir',
            ],
            [
                'id' => 3,
                'kriteria' => 'Tingkat Pendidikan',
                'bobot' => 5,
                'jenis' => 'benefit',
                'keterangan' => 'Tingkat Pendidikan Terakhir',
            ],
            [
                'id' => 4,
                'kriteria' => 'Bidang Ilmu',
                'bobot' => 10,
                'jenis' => 'benefit',
                'keterangan' => 'Kesesuaian bidang ilmu dengan syarat jabatan',
            ],
            [
                'id' => 5,
                'kriteria' => 'Predikat Kinerja (SKP)',
                'bobot' => 15,
                'jenis' => 'benefit',
                'keterangan' => 'Predikat penilaian kinerja (SKP)',
            ],
            [
                'id' => 6,
                'kriteria' => 'Penghargaan',
                'bobot' => 5,
                'jenis' => 'benefit',
                'keterangan' => 'Penghargaan yang diperoleh dalam 5 tahun terakhir',
            ],
            [
                'id' => 7,
                'kriteria' => 'Integritas',
                'bobot' => 5,
                'jenis' => 'benefit',
                'keterangan' => 'Riwayat Hukuman Disiplin',
            ],
            [
                'id' => 8,
                'kriteria' => 'Diklat',
                'bobot' => 5,
                'jenis' => 'benefit',
                'keterangan' => 'Diklat yang diikuti dalam 3 tahun terakhir',
            ],
            [
                'id' => 9,
                'kriteria' => 'Potensi',
                'bobot' => 20,
                'jenis' => 'benefit',
                'keterangan' => 'Nilai potensi hasil assessment',
            ],
            [
                'id' => 10,
                'kriteria' => 'Kompetensi',
                'bobot' => 20,
                'jenis' => 'benefit',
                'keterangan' => 'Nilai kompetensi hasil assessment',
            ],
        ];

        foreach ($data as $row) {
            Kriteria::create($row);
        }
    }
}
