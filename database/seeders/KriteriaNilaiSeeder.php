<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaNilaiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // kriteria_id 1
            ['id' => 1, 'kriteria_id' => 1, 'kategori' => 'Dalam Jenjang Pangkat Lebih Tinggi Yang Dipersyaratkan', 'nilai' => 5],
            ['id' => 2, 'kriteria_id' => 1, 'kategori' => 'Dalam Jenjang Pangkat Sama Dengan Yang Dipersyaratkan Lebih Dari 4 tahun', 'nilai' => 4],
            ['id' => 3, 'kriteria_id' => 1, 'kategori' => 'Dalam Jenjang Pangkat Sama Dengan Yang Dipersyaratkan Kurang Dari atau Sama Dengan 4 Tahun', 'nilai' => 3],
            ['id' => 4, 'kriteria_id' => 1, 'kategori' => 'Satu Tingkat Dibawah Jenjang Pangkat Yang Dipersyaratkan', 'nilai' => 1],

            // kriteria_id 2
            ['id' => 5, 'kriteria_id' => 2, 'kategori' => '>= 4 tahun', 'nilai' => 5],
            ['id' => 6, 'kriteria_id' => 2, 'kategori' => '3 tahun', 'nilai' => 4],
            ['id' => 7, 'kriteria_id' => 2, 'kategori' => '2 tahun', 'nilai' => 3],
            ['id' => 8, 'kriteria_id' => 2, 'kategori' => '< 2 tahun', 'nilai' => 1],

            // kriteria_id 3
            ['id' => 9, 'kriteria_id' => 3, 'kategori' => 'S2', 'nilai' => 5],
            ['id' => 10, 'kriteria_id' => 3, 'kategori' => 'S1', 'nilai' => 4],
            ['id' => 11, 'kriteria_id' => 3, 'kategori' => 'DIII', 'nilai' => 3],
            ['id' => 12, 'kriteria_id' => 3, 'kategori' => 'Dibawah DIII', 'nilai' => 1],

            // kriteria_id 8 (Diklat) - Static
            ['id' => 13, 'kriteria_id' => 8, 'kategori' => '> 24 JP', 'nilai' => 5],
            ['id' => 14, 'kriteria_id' => 8, 'kategori' => '19 - 24 JP', 'nilai' => 4],
            ['id' => 15, 'kriteria_id' => 8, 'kategori' => '13 - 18 JP', 'nilai' => 3],
            ['id' => 16, 'kriteria_id' => 8, 'kategori' => '6 - 12 JP', 'nilai' => 2],
            ['id' => 17, 'kriteria_id' => 8, 'kategori' => '< 6 JP', 'nilai' => 1],

            // kriteria_id 5
            ['id' => 18, 'kriteria_id' => 5, 'kategori' => 'Sangat Baik', 'nilai' => 5],
            ['id' => 19, 'kriteria_id' => 5, 'kategori' => 'Baik', 'nilai' => 4],
            ['id' => 20, 'kriteria_id' => 5, 'kategori' => 'Cukup', 'nilai' => 3],
            ['id' => 21, 'kriteria_id' => 5, 'kategori' => 'Kurang', 'nilai' => 2],
            ['id' => 22, 'kriteria_id' => 5, 'kategori' => 'Sangat Kurang', 'nilai' => 1],

            // kriteria_id 6
            ['id' => 23, 'kriteria_id' => 6, 'kategori' => 'Prestasi / penghargaan tingkat nasional atau internasional', 'nilai' => 5],
            ['id' => 24, 'kriteria_id' => 6, 'kategori' => 'Prestasi / penghargaan tingkat provinsi', 'nilai' => 4],
            ['id' => 25, 'kriteria_id' => 6, 'kategori' => 'Prestasi / penghargaan tingkat kabupaten/kota', 'nilai' => 3],
            ['id' => 26, 'kriteria_id' => 6, 'kategori' => 'Tidak memiliki prestasi', 'nilai' => 1],

            // kriteria_id 7
            ['id' => 27, 'kriteria_id' => 7, 'kategori' => 'Tidak pernah dijatuhi Hukuman Disiplin', 'nilai' => 5],
            ['id' => 28, 'kriteria_id' => 7, 'kategori' => 'Pernah Dijatuhi Hukuman Disiplin Ringan', 'nilai' => 2],
            ['id' => 29, 'kriteria_id' => 7, 'kategori' => 'Pernah Dijatuhi Hukuman Disiplin Sedang', 'nilai' => 1],
            ['id' => 30, 'kriteria_id' => 7, 'kategori' => 'Pernah Dijatuhi Hukuman Disiplin Berat', 'nilai' => 0],

            // kriteria_id 4 (Bidang Ilmu) - Dynamic
            ['id' => 31, 'kriteria_id' => 4, 'kategori' => 'Sesuai', 'nilai' => 5],
            ['id' => 32, 'kriteria_id' => 4, 'kategori' => 'Tidak Sesuai', 'nilai' => 2],
       
            // kriteria_id 9
            ['id' => 33, 'kriteria_id' => 9, 'kategori' => 'Potensi Tinggi', 'nilai' => 3],
            ['id' => 34, 'kriteria_id' => 9, 'kategori' => 'Potensi Sedang', 'nilai' => 2],
            ['id' => 35, 'kriteria_id' => 9, 'kategori' => 'Potensi Rendah', 'nilai' => 1],

            // kriteria_id 10
            ['id' => 36, 'kriteria_id' => 10, 'kategori' => 'Memenuhi Syarat', 'nilai' => 3],
            ['id' => 37, 'kriteria_id' => 10, 'kategori' => 'Masih Memenuhi Syarat', 'nilai' => 2],
            ['id' => 38, 'kriteria_id' => 10, 'kategori' => 'Kurang Memenuhi Syarat', 'nilai' => 1],
        
        ];

        foreach ($data as $item) {
            DB::table('kriteria_nilais')->updateOrInsert(['id' => $item['id']], $item);
        }
    }
}