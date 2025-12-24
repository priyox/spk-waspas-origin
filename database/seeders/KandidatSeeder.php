<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kandidat;
use Carbon\Carbon;

class KandidatSeeder extends Seeder
{
    public function run(): void
    {
        Kandidat::query()->delete();

        $data = [
            [
                'nip' => '198501012010011001',
                'nama' => 'DR. BUDI SANTOSO, M.KOM',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-01-01',
                'golongan_id' => 42, // IV/b
                'jenis_jabatan_id' => 20, // JPT Pratama
                'eselon_id' => 22, // II.B
                'jabatan' => 'Kepala Dinas Komunikasi dan Informatika',
                'unit_kerja' => 'Dinas Kominfo',
                'tingkat_pendidikan_id' => 9, // S-3
                'jurusan' => 'Doktor Ilmu Komputer',
                'bidang_ilmu_id' => 1, // Teknik Informatika
                'tmt_golongan' => Carbon::now()->subYears(3)->subMonths(2),
                'tmt_jabatan' => Carbon::now()->subYears(5)->subMonths(3), // > 4 tahun
            ],
            [
                'nip' => '198802022012022002',
                'nama' => 'IR. SITI AMINAH, M.T',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1988-02-02',
                'golongan_id' => 34, // III/d
                'jenis_jabatan_id' => 30, // Administrator
                'eselon_id' => 31, // III.A
                'jabatan' => 'Kabid Penyelenggaraan E-Government',
                'unit_kerja' => 'Dinas Kominfo',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Teknik Perangkat Lunak',
                'bidang_ilmu_id' => 2, // Sistem Informasi
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(1),
                'tmt_jabatan' => Carbon::now()->subYears(3)->subMonths(6), // 3-4 tahun
            ],
            [
                'nip' => '199003032015031003',
                'nama' => 'ANDI WIJAYA, S.H, M.H',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1990-03-03',
                'golongan_id' => 32, // III/b
                'jenis_jabatan_id' => 40, // Pengawas
                'eselon_id' => 41, // IV.A
                'jabatan' => 'Kasubag Hukum dan Organisasi',
                'unit_kerja' => 'Sekretariat Daerah',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Hukum Tata Negara',
                'bidang_ilmu_id' => 4, // Hukum
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(8),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(8), // 2-3 tahun
            ],
            [
                'nip' => '199204042018042004',
                'nama' => 'DEWI LESTARI, S.E, M.AK',
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '1992-04-04',
                'golongan_id' => 31, // III/a
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Auditor Ahli Pertama',
                'unit_kerja' => 'Inspektorat',
                'tingkat_pendidikan_id' => 8, // S-Magister Akuntansi
                'jurusan' => 'Akuntansi Sektor Publik',
                'bidang_ilmu_id' => 5, // Ekonomi
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(3),
                'tmt_jabatan' => Carbon::now()->subYears(1)->subMonths(6), // < 2 tahun
            ],
            [
                'nip' => '198705052011051005',
                'nama' => 'EKO PRASETYO, S.T',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1987-05-05',
                'golongan_id' => 33, // III/c
                'jenis_jabatan_id' => 3, // Pelaksana
                'eselon_id' => null,
                'jabatan' => 'Analis Sistem Informasi',
                'unit_kerja' => 'Badan Kepegawaian Daerah',
                'tingkat_pendidikan_id' => 7, // S-1
                'jurusan' => 'Teknik Elektro',
                'bidang_ilmu_id' => 1, // Teknik Informatika
                'tmt_golongan' => Carbon::now()->subYears(3)->subMonths(4),
                'tmt_jabatan' => Carbon::now()->subYears(4)->subMonths(8), // > 4 tahun
            ],
            [
                'nip' => '198906062014062006',
                'nama' => 'RINA WATI, M.PSI',
                'tempat_lahir' => 'Makassar',
                'tanggal_lahir' => '1989-06-06',
                'golongan_id' => 32, // III/b
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Psikolog Klinis Ahli Pertama',
                'unit_kerja' => 'RSUD Kota',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Psikologi Profesi',
                'bidang_ilmu_id' => 7, // Psikologi
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(5),
                'tmt_jabatan' => Carbon::now()->subYears(3)->subMonths(2), // 3-4 tahun
            ],
            [
                'nip' => '198607072010071007',
                'nama' => 'HENDRA KUSUMA, S.SOS, M.AP',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1986-07-07',
                'golongan_id' => 41, // IV/a
                'jenis_jabatan_id' => 30, // Administrator
                'eselon_id' => 32, // III.B
                'jabatan' => 'Kabid Mutasi Pegawai',
                'unit_kerja' => 'Badan Kepegawaian Daerah',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Administrasi Publik',
                'bidang_ilmu_id' => 6, // Administrasi Negara
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(9),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(4), // 2-3 tahun
            ],
        ];

        foreach ($data as $row) {
            Kandidat::create($row);
        }
    }
}
