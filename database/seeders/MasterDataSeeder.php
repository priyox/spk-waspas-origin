<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eselon;
use App\Models\Golongan;
use App\Models\JenisJabatan;
use App\Models\TingkatPendidikan;
use App\Models\BidangIlmu;
use App\Models\Kriteria;
use App\Models\Kandidat;
use App\Models\Nilai;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Eselon
        $eselons = [
            ['eselon' => 'Eselon I'],
            ['eselon' => 'Eselon II'],
            ['eselon' => 'Eselon III'],
            ['eselon' => 'Eselon IV'],
        ];
        foreach ($eselons as $e) Eselon::updateOrCreate($e, $e);

        // 2. Golongan
        $golongans = [
            ['golongan' => 'IV/e', 'pangkat' => 'Pembina Utama'],
            ['golongan' => 'IV/d', 'pangkat' => 'Pembina Utama Madya'],
            ['golongan' => 'IV/c', 'pangkat' => 'Pembina Utama Muda'],
            ['golongan' => 'IV/b', 'pangkat' => 'Pembina Tingkat I'],
            ['golongan' => 'IV/a', 'pangkat' => 'Pembina'],
        ];
        foreach ($golongans as $g) Golongan::updateOrCreate(['golongan' => $g['golongan']], $g);

        // 3. Jenis Jabatan
        $jenis = [
            ['jenis_jabatan' => 'Struktural'],
            ['jenis_jabatan' => 'Fungsional'],
        ];
        foreach ($jenis as $j) JenisJabatan::updateOrCreate($j, $j);

        // 4. Tingkat Pendidikan
        $pendidikan = [
            ['tingkat' => 'S3'],
            ['tingkat' => 'S2'],
            ['tingkat' => 'S1'],
            ['tingkat' => 'D4/D3'],
        ];
        foreach ($pendidikan as $p) TingkatPendidikan::updateOrCreate($p, $p);

        // 5. Bidang Ilmu
        $bidang = [
            ['bidang' => 'Teknik Informatika'],
            ['bidang' => 'Sistem Informasi'],
            ['bidang' => 'Manajemen'],
            ['bidang' => 'Hukum'],
            ['bidang' => 'Ekonomi'],
        ];
        foreach ($bidang as $b) BidangIlmu::updateOrCreate($b, $b);

        // 6. Kriteria
        $kriterias = [
            ['kriteria' => 'Tes Potensi Akademik', 'bobot' => 30, 'jenis' => 'Benefit'],
            ['kriteria' => 'Wawancara', 'bobot' => 25, 'jenis' => 'Benefit'],
            ['kriteria' => 'Pengalaman (Tahun)', 'bobot' => 20, 'jenis' => 'Benefit'],
            ['kriteria' => 'Pendidikan Terakhir', 'bobot' => 15, 'jenis' => 'Benefit'],
            ['kriteria' => 'Usia', 'bobot' => 10, 'jenis' => 'Cost'],
        ];
        foreach ($kriterias as $k) Kriteria::updateOrCreate(['kriteria' => $k['kriteria']], $k);

        // 7. Kandidat
        $kandidatData = [
            ['nip' => '199001012015011001', 'nama' => 'Budi Santoso', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '1990-01-01', 'jabatan' => 'Analyst'],
            ['nip' => '199202022016021002', 'nama' => 'Siti Aminah', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '1992-02-02', 'jabatan' => 'Developer'],
            ['nip' => '198803032014031003', 'nama' => 'Andi Wijaya', 'tempat_lahir' => 'Surabaya', 'tanggal_lahir' => '1988-03-03', 'jabatan' => 'Manager'],
            ['nip' => '199504042017042004', 'nama' => 'Dewi Lestari', 'tempat_lahir' => 'Medan', 'tanggal_lahir' => '1995-04-04', 'jabatan' => 'Accountant'],
            ['nip' => '199105052015051005', 'nama' => 'Eko Prasetyo', 'tempat_lahir' => 'Semarang', 'tanggal_lahir' => '1991-05-05', 'jabatan' => 'Consultant'],
        ];

        $g1 = Golongan::first()->id;
        $j1 = JenisJabatan::first()->id;
        $t1 = TingkatPendidikan::first()->id;
        $b1 = BidangIlmu::first()->id;

        foreach ($kandidatData as $kd) {
            Kandidat::updateOrCreate(['nip' => $kd['nip']], array_merge($kd, [
                'golongan_id' => $g1,
                'jenis_jabatan_id' => $j1,
                'tingkat_pendidikan_id' => $t1,
                'bidang_ilmu_id' => $b1
            ]));
        }

        // 8. Nilai (Assessments)
        $kriterias = Kriteria::all();
        $kandidats = Kandidat::all();

        // Sample scores [nip][kriteria_id]
        $scores = [
            '199001012015011001' => [85, 80, 5, 3, 33],
            '199202022016021002' => [90, 75, 4, 3, 31],
            '198803032014031003' => [75, 90, 10, 4, 35],
            '199504042017042004' => [80, 85, 2, 2, 28],
            '199105052015051005' => [88, 82, 6, 3, 32],
        ];

        foreach ($kandidats as $kandidat) {
            if (isset($scores[$kandidat->nip])) {
                foreach ($kriterias as $index => $kriteria) {
                    if (isset($scores[$kandidat->nip][$index])) {
                        Nilai::updateOrCreate([
                            'nip' => $kandidat->nip,
                            'kriteria_id' => $kriteria->id,
                        ], [
                            'nilai' => $scores[$kandidat->nip][$index]
                        ]);
                    }
                }
            }
        }
    }
}
