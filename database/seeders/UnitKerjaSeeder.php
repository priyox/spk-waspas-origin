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
            ['id' => 3, 'unit_kerja' => 'Inspektorat Daerah'],
            ['id' => 4, 'unit_kerja' => 'Dinas Pendidikan, Pemuda dan Olahraga'],
            ['id' => 5, 'unit_kerja' => 'Dinas Kesehatan'],
            ['id' => 6, 'unit_kerja' => 'Dinas Pekerjaan Umum dan Penataan Ruang'],
            ['id' => 7, 'unit_kerja' => 'Dinas Perumahan, Kawasan Permukiman dan Perhubungan'],
            ['id' => 8, 'unit_kerja' => 'Dinas Sosial, Pemberdayaan Masyarakat dan Desa'],
            ['id' => 9, 'unit_kerja' => 'DPPKBPPPA'],
            ['id' => 10, 'unit_kerja' => 'Dinas Pangan, Pertanian dan Perikanan'],
            ['id' => 11, 'unit_kerja' => 'Dinas Lingkungan Hidup'],
            ['id' => 12, 'unit_kerja' => 'Dinas Kependudukan dan Pencatatan Sipil'],
            ['id' => 13, 'unit_kerja' => 'Dinas Komunikasi dan Informatika'],
            ['id' => 14, 'unit_kerja' => 'Dinas Perdagangan, Koperasi, Usaha Kecil dan Menengah'],
            ['id' => 15, 'unit_kerja' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu'],
            ['id' => 16, 'unit_kerja' => 'Dinas Tenaga Kerja, Perindustrian dan Transmigrasi'],
            ['id' => 17, 'unit_kerja' => 'Dinas Kearsipan dan Perpustakaan Daerah'],
            ['id' => 18, 'unit_kerja' => 'Dinas Pariwisata dan Kebudayaan'],
            ['id' => 19, 'unit_kerja' => 'Satuan Polisi Pamong Praja'],
            ['id' => 20, 'unit_kerja' => 'Badan Perencanaan Pembangunan Daerah'],
            ['id' => 21, 'unit_kerja' => 'Badan Pengelolaan Pendapatan, Keuangan dan Aset Daerah'],
            ['id' => 22, 'unit_kerja' => 'Badan Kepegawaian Daerah'],
            ['id' => 23, 'unit_kerja' => 'Badan Kesatuan Bangsa dan Politik'],
            ['id' => 24, 'unit_kerja' => 'Badan Penanggulangan Bencana Daerah'],
            ['id' => 25, 'unit_kerja' => 'Rumah Sakit Umum Daerah KRT. Setjonegoro'],
            ['id' => 26, 'unit_kerja' => 'Kecamatan Wonosobo'],
            ['id' => 27, 'unit_kerja' => 'Kecamatan Kertek'],
            ['id' => 28, 'unit_kerja' => 'Kecamatan Selomerto'],
            ['id' => 29, 'unit_kerja' => 'Kecamatan Leksono'],
            ['id' => 30, 'unit_kerja' => 'Kecamatan Garung'],
            ['id' => 31, 'unit_kerja' => 'Kecamatan Kejajar'],
            ['id' => 32, 'unit_kerja' => 'Kecamatan Mojotengah'],
            ['id' => 33, 'unit_kerja' => 'Kecamatan Watumalang'],
            ['id' => 34, 'unit_kerja' => 'Kecamatan Kalikajar'],
            ['id' => 35, 'unit_kerja' => 'Kecamatan Sapuran'],
            ['id' => 36, 'unit_kerja' => 'Kecamatan Kepil'],
            ['id' => 37, 'unit_kerja' => 'Kecamatan Kaliwiro'],
            ['id' => 38, 'unit_kerja' => 'Kecamatan Wadaslintang'],
            ['id' => 39, 'unit_kerja' => 'Kecamatan Sukoharjo'],
            ['id' => 40, 'unit_kerja' => 'Kecamatan Kalibawang'],
        ];

        foreach ($data as $row) {
            UnitKerja::create($row);
        }
    }
}
