<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JurusanPendidikan;

class JurusanPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         JurusanPendidikan::query()->delete();

        $data = [
            ['id' => 1, 'jurusan' => 'Sekolah Dasar', 'tingkat_pendidikan_id' => 1, 'bidang_ilmu_id' => 1],
            ['id' => 2, 'jurusan' => 'Sekolah Lanjutan Tingkat Pertama', 'tingkat_pendidikan_id' => 2, 'bidang_ilmu_id' => 2],
            ['id' => 3, 'jurusan' => 'Sekolah Lanjutan Tingkat Atas', 'tingkat_pendidikan_id' => 3, 'bidang_ilmu_id' => 3],
            ['id' => 4, 'jurusan' => 'D-III Teknik Informatika', 'tingkat_pendidikan_id' => 6, 'bidang_ilmu_id' => 1],
            ['id' => 5, 'jurusan' => 'D-III Ekonomi', 'tingkat_pendidikan_id' => 6, 'bidang_ilmu_id' => 5],
            ['id' => 6, 'jurusan' => 'D-III Administrasi Negara', 'tingkat_pendidikan_id' => 6, 'bidang_ilmu_id' => 6],
            ['id' => 7, 'jurusan' => 'S-1 Psikologi', 'tingkat_pendidikan_id' => 7, 'bidang_ilmu_id' => 7],
            ['id' => 8, 'jurusan' => 'S-1 Teknik Informatika', 'tingkat_pendidikan_id' => 7, 'bidang_ilmu_id' => 1],
            ['id' => 9, 'jurusan' => 'S-1 Sistem Informasi', 'tingkat_pendidikan_id' => 7, 'bidang_ilmu_id' => 1],
            ['id' => 10, 'jurusan' => 'S-1 Manajemen', 'tingkat_pendidikan_id' => 7, 'bidang_ilmu_id' => 3],
            ['id' => 11, 'jurusan' => 'S-1 Hukum', 'tingkat_pendidikan_id' => 7, 'bidang_ilmu_id' => 4],
            ['id' => 12, 'jurusan' => 'S-2 Ekonomi', 'tingkat_pendidikan_id' => 8, 'bidang_ilmu_id' => 5],
            ['id' => 13, 'jurusan' => 'S-2 Administrasi Negara', 'tingkat_pendidikan_id' => 8, 'bidang_ilmu_id' => 6],
            ['id' => 14, 'jurusan' => 'S-2 Psikologi', 'tingkat_pendidikan_id' => 8, 'bidang_ilmu_id' => 7],
            ['id' => 13, 'jurusan' => 'S-3 Administrasi Publik', 'tingkat_pendidikan_id' => 9, 'bidang_ilmu_id' => 6],
            ['id' => 14, 'jurusan' => 'S-3 Teknik Informatika', 'tingkat_pendidikan_id' => 9, 'bidang_ilmu_id' => 1],

        ];

        foreach ($data as $row) {
            JurusanPendidikan::create($row);
        }
    }
}
