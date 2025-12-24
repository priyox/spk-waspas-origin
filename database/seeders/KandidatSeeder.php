actio
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
            [
                'nip' => '199108082016082008',
                'nama' => 'RIZKI FERNANDA, S.IK',
                'tempat_lahir' => 'Palembang',
                'tanggal_lahir' => '1991-08-08',
                'golongan_id' => 31, // III/a
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Epidemiolog Kesehatan',
                'unit_kerja' => 'Dinas Kesehatan',
                'tingkat_pendidikan_id' => 7, // S-1
                'jurusan' => 'Ilmu Kesehatan Masyarakat',
                'bidang_ilmu_id' => 1, // Teknik Informatika
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(10),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(1),
            ],
            [
                'nip' => '198809092012091009',
                'nama' => 'MEGA PUSPITA, S.KOM, M.TECH',
                'tempat_lahir' => 'Pontianak',
                'tanggal_lahir' => '1988-09-09',
                'golongan_id' => 34, // III/d
                'jenis_jabatan_id' => 30, // Administrator
                'eselon_id' => 31, // III.A
                'jabatan' => 'Kabid Pengembangan SDM',
                'unit_kerja' => 'Dinas Kominfo',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Master of Technology Information',
                'bidang_ilmu_id' => 2, // Sistem Informasi
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(3),
                'tmt_jabatan' => Carbon::now()->subYears(3)->subMonths(2),
            ],
            [
                'nip' => '199010101018101010',
                'nama' => 'FARAH DIBA, S.PD, M.ED',
                'tempat_lahir' => 'Padang',
                'tanggal_lahir' => '1990-10-10',
                'golongan_id' => 32, // III/b
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Widyaiswara Ahli Pertama',
                'unit_kerja' => 'Badan Diklat',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Pendidikan Orang Dewasa',
                'bidang_ilmu_id' => 3, // Manajemen
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(6),
                'tmt_jabatan' => Carbon::now()->subYears(1)->subMonths(11),
            ],
            [
                'nip' => '198711112013112011',
                'nama' => 'BAMBANG SUTRISNO, S.T, M.T',
                'tempat_lahir' => 'Lampung',
                'tanggal_lahir' => '1987-11-11',
                'golongan_id' => 33, // III/c
                'jenis_jabatan_id' => 3, // Pelaksana
                'eselon_id' => null,
                'jabatan' => 'Teknik Sipil Ahli Muda',
                'unit_kerja' => 'Dinas Pekerjaan Umum',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Teknik Sipil',
                'bidang_ilmu_id' => 1, // Teknik Informatika
                'tmt_golongan' => Carbon::now()->subYears(3)->subMonths(7),
                'tmt_jabatan' => Carbon::now()->subYears(4)->subMonths(3),
            ],
            [
                'nip' => '199212122017122012',
                'nama' => 'CHINTYA MUSTIKA, S.KM',
                'tempat_lahir' => 'Batam',
                'tanggal_lahir' => '1992-12-12',
                'golongan_id' => 31, // III/a
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Sanitarian Kesehatan',
                'unit_kerja' => 'Dinas Kesehatan',
                'tingkat_pendidikan_id' => 7, // S-1
                'jurusan' => 'Kesehatan Masyarakat',
                'bidang_ilmu_id' => 6, // Administrasi Negara
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(4),
                'tmt_jabatan' => Carbon::now()->subYears(1)->subMonths(9),
            ],
            [
                'nip' => '198601132010132013',
                'nama' => 'DANNY HARTONO, S.H, M.H',
                'tempat_lahir' => 'Bekasi',
                'tanggal_lahir' => '1986-01-13',
                'golongan_id' => 41, // IV/a
                'jenis_jabatan_id' => 20, // JPT Pratama
                'eselon_id' => 22, // II.B
                'jabatan' => 'Kepala Badan Kepegawaian Daerah',
                'unit_kerja' => 'Badan Kepegawaian Daerah',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Hukum Administrasi Negara',
                'bidang_ilmu_id' => 4, // Hukum
                'tmt_golongan' => Carbon::now()->subYears(4)->subMonths(1),
                'tmt_jabatan' => Carbon::now()->subYears(6)->subMonths(2),
            ],
            [
                'nip' => '199002142019142014',
                'nama' => 'LINDA WIJAYA, S.E, M.M',
                'tempat_lahir' => 'Tangsel',
                'tanggal_lahir' => '1990-02-14',
                'golongan_id' => 32, // III/b
                'jenis_jabatan_id' => 30, // Administrator
                'eselon_id' => 32, // III.B
                'jabatan' => 'Kabag Keuangan',
                'unit_kerja' => 'Sekretariat Daerah',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Manajemen Keuangan',
                'bidang_ilmu_id' => 5, // Ekonomi
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(7),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(9),
            ],
            [
                'nip' => '198803152011152015',
                'nama' => 'WAWAN SETIAWAN, S.T',
                'tempat_lahir' => 'Garut',
                'tanggal_lahir' => '1988-03-15',
                'golongan_id' => 33, // III/c
                'jenis_jabatan_id' => 3, // Pelaksana
                'eselon_id' => null,
                'jabatan' => 'Operator Sistem Informasi',
                'unit_kerja' => 'Dinas Kominfo',
                'tingkat_pendidikan_id' => 7, // S-1
                'jurusan' => 'Teknik Informatika',
                'bidang_ilmu_id' => 1, // Teknik Informatika
                'tmt_golongan' => Carbon::now()->subYears(3)->subMonths(2),
                'tmt_jabatan' => Carbon::now()->subYears(3)->subMonths(8),
            ],
            [
                'nip' => '199104162014162016',
                'nama' => 'SUSAN PRATIWI, S.LING, M.A',
                'tempat_lahir' => 'Cikarang',
                'tanggal_lahir' => '1991-04-16',
                'golongan_id' => 31, // III/a
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Penerjemah Ahli Pertama',
                'unit_kerja' => 'Dinas Komunikasi dan Informatika',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Linguistik Terapan',
                'bidang_ilmu_id' => 2, // Sistem Informasi
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(2),
                'tmt_jabatan' => Carbon::now()->subYears(1)->subMonths(7),
            ],
            [
                'nip' => '198705172012172017',
                'nama' => 'GERRY SUHENDRA, S.E',
                'tempat_lahir' => 'Cirebon',
                'tanggal_lahir' => '1987-05-17',
                'golongan_id' => 32, // III/b
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Aparatur Statistik Ahli Pertama',
                'unit_kerja' => 'Badan Pusat Statistik',
                'tingkat_pendidikan_id' => 7, // S-1
                'jurusan' => 'Statistika Ekonomi',
                'bidang_ilmu_id' => 5, // Ekonomi
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(11),
                'tmt_jabatan' => Carbon::now()->subYears(3)->subMonths(5),
            ],
            [
                'nip' => '199206182015182018',
                'nama' => 'RATNA KUSUMA, S.KIP, M.SI',
                'tempat_lahir' => 'Kuningan',
                'tanggal_lahir' => '1992-06-18',
                'golongan_id' => 31, // III/a
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Arsiparis Ahli Muda',
                'unit_kerja' => 'Dinas Kearsipan dan Perpustakaan',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Ilmu Perpustakaan',
                'bidang_ilmu_id' => 6, // Administrasi Negara
                'tmt_golongan' => Carbon::now()->subYears(1)->subMonths(1),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(3),
            ],
            [
                'nip' => '198804192016192019',
                'nama' => 'JOKO SUWARNO, S.PT, M.SI',
                'tempat_lahir' => 'Indramayu',
                'tanggal_lahir' => '1988-04-19',
                'golongan_id' => 33, // III/c
                'jenis_jabatan_id' => 3, // Pelaksana
                'eselon_id' => null,
                'jabatan' => 'Penyuluh Pertanian Ahli Muda',
                'unit_kerja' => 'Dinas Pertanian dan Pangan',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Penyuluhan Pertanian',
                'bidang_ilmu_id' => 3, // Manajemen
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(8),
                'tmt_jabatan' => Carbon::now()->subYears(3)->subMonths(4),
            ],
            [
                'nip' => '199308202013202020',
                'nama' => 'MAYA SARI, S.FARM, M.FARM',
                'tempat_lahir' => 'Subang',
                'tanggal_lahir' => '1993-08-20',
                'golongan_id' => 31, // III/a
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Apoteker Ahli Pertama',
                'unit_kerja' => 'Dinas Kesehatan',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Farmasi Klinis',
                'bidang_ilmu_id' => 7, // Psikologi
                'tmt_golongan' => Carbon::now()->subYears(1),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(4),
            ],
            [
                'nip' => '198910212011212021',
                'nama' => 'AMIR QUSYAIRI, S.AG, M.PD.I',
                'tempat_lahir' => 'Karawang',
                'tanggal_lahir' => '1989-10-21',
                'golongan_id' => 32, // III/b
                'jenis_jabatan_id' => 2, // Fungsional
                'eselon_id' => null,
                'jabatan' => 'Penyuluh Agama Islam Ahli Pertama',
                'unit_kerja' => 'Kantor Kementerian Agama',
                'tingkat_pendidikan_id' => 8, // S-2
                'jurusan' => 'Magister Pendidikan Islam',
                'bidang_ilmu_id' => 4, // Hukum
                'tmt_golongan' => Carbon::now()->subYears(2)->subMonths(2),
                'tmt_jabatan' => Carbon::now()->subYears(2)->subMonths(10),
            ],
        ];

        foreach ($data as $row) {
            Kandidat::create($row);
        }
    }
}
