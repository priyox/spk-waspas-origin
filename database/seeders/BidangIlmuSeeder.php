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
            ['id' => 1, 'bidang' => 'Ilmu Hukum'],
            ['id' => 2, 'bidang' => 'Ilmu Pemerintahan'],
            ['id' => 3, 'bidang' => 'Pendidikan'],
            ['id' => 4, 'bidang' => 'Ekonomi Pembangunan'],
            ['id' => 5, 'bidang' => 'Administrasi Publik'],
            ['id' => 6, 'bidang' => 'Ilmu Komunikasi'],
            ['id' => 7, 'bidang' => 'Ilmu Politik'],
            ['id' => 8, 'bidang' => 'Teknik Lingkungan'],
            ['id' => 9, 'bidang' => 'Teknik Informatika'],
            ['id' => 10, 'bidang' => 'Desain Komunikasi Visual'],
            ['id' => 11, 'bidang' => 'Manajemen'],
            ['id' => 12, 'bidang' => 'Pendidikan IPS'],
            ['id' => 13, 'bidang' => 'Pariwisata'],
            ['id' => 14, 'bidang' => 'Pemuliaan Tanaman'],
            ['id' => 15, 'bidang' => 'Psikologi'],
            ['id' => 16, 'bidang' => 'Ekonomi'],
            ['id' => 17, 'bidang' => 'Studi Industri'],
            ['id' => 18, 'bidang' => 'Akuntansi'],
            ['id' => 19, 'bidang' => 'Ekonomi Manajemen'],
            ['id' => 20, 'bidang' => 'Ekonomi Sumber Daya'],
            ['id' => 21, 'bidang' => 'Kedokteran Hewan'],
            ['id' => 22, 'bidang' => 'Manajemen Bisnis'],
            ['id' => 23, 'bidang' => 'Psikologi Terapan'],
            ['id' => 24, 'bidang' => 'Manajemen Umum'],
            ['id' => 25, 'bidang' => 'Humaniora'],
            ['id' => 26, 'bidang' => 'Manajemen Informatika'],
            ['id' => 27, 'bidang' => 'Ilmu Komputer'],
            ['id' => 28, 'bidang' => 'Administrasi Bisnis'],
            ['id' => 29, 'bidang' => 'Agroteknologi'],
            ['id' => 30, 'bidang' => 'Manajemen Sumber Daya Manusia'],
            ['id' => 31, 'bidang' => 'Teknik Elektro'],
            ['id' => 32, 'bidang' => 'Sosial'],
            ['id' => 33, 'bidang' => 'Perencanaan Wilayah'],
            ['id' => 34, 'bidang' => 'Ilmu Informasi'],
            ['id' => 35, 'bidang' => 'Matematika'],
            ['id' => 36, 'bidang' => 'Bisnis'],
            ['id' => 37, 'bidang' => 'Logistik'],
            ['id' => 38, 'bidang' => 'Arsitektur'],
            ['id' => 39, 'bidang' => 'Perencanaan'],
            ['id' => 40, 'bidang' => 'Transportasi'],
            ['id' => 41, 'bidang' => 'Kebidanan'],
            ['id' => 42, 'bidang' => 'Keperawatan'],
            ['id' => 43, 'bidang' => 'Kedokteran'],
            ['id' => 44, 'bidang' => 'Kesehatan Masyarakat'],
            ['id' => 45, 'bidang' => 'Ilmu Gizi'],
            ['id' => 46, 'bidang' => 'Ilmu Farmasi'],
            ['id' => 47, 'bidang' => 'Kesehatan'],
            ['id' => 48, 'bidang' => 'Kedokteran Gigi'],
            ['id' => 49, 'bidang' => 'Teknik Sipil'],
            ['id' => 50, 'bidang' => 'Ilmu Veteriner'],
            ['id' => 51, 'bidang' => 'Fisika'],
            ['id' => 52, 'bidang' => 'Kimia'],
            ['id' => 53, 'bidang' => 'Biologi'],
        ];

        foreach ($data as $row) {
            BidangIlmu::create($row);
        }
    }
}
