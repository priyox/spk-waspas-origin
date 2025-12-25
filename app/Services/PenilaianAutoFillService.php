<?php

namespace App\Services;

use App\Models\Kandidat;
use App\Models\JabatanTarget;
use App\Models\SyaratJabatan;
use App\Models\MasaJabatanRange;
use App\Models\PersentaseConversion;
use App\Models\KriteriaNilai;
use Carbon\Carbon;

class PenilaianAutoFillService
{
    /**
     * Hitung Masa Jabatan dari TMT dan convert ke nilai 1-5
     * Kriteria 2
     */
    public function hitungMasaJabatan(Kandidat $kandidat): int
    {
        if (!$kandidat->tmt_jabatan) {
            return 1; // Default jika tidak ada TMT
        }

        // Hitung selisih dalam tahun (decimal)
        $tahun = Carbon::parse($kandidat->tmt_jabatan)->diffInYears(Carbon::now(), true);

        // Cari nilai dari range
        return MasaJabatanRange::getNilaiByMasaJabatan($tahun);
    }

    /**
     * Hitung nilai Pangkat/Golongan berdasarkan syarat jabatan
     * Kriteria 1
     */
    public function getNilaiPangkatGolongan(Kandidat $kandidat, ?JabatanTarget $jabatanTarget): int
    {
        if (!$jabatanTarget || !$kandidat->golongan_id) {
            return 1; // Default
        }

        // Ambil syarat jabatan berdasarkan eselon target
        $syarat = SyaratJabatan::where('eselon_id', $jabatanTarget->id_eselon)->first();

        if (!$syarat) {
            return 1; // Default jika tidak ada syarat
        }

        $minimalGolongan = $syarat->syarat_golongan_id ?? $syarat->minimal_golongan_id;
        $golonganKandidat = $kandidat->golongan_id;

        // Lebih tinggi dari yang dipersyaratkan
        if ($golonganKandidat > $minimalGolongan) {
            return 5;
        }

        // Sama dengan yang dipersyaratkan
        if ($golonganKandidat == $minimalGolongan) {
            // Cek TMT golongan
            if ($kandidat->tmt_golongan) {
                $tahunGolongan = Carbon::parse($kandidat->tmt_golongan)->diffInYears(Carbon::now(), true);
                if ($tahunGolongan > 4) {
                    return 4; // Lebih dari 4 tahun
                } else {
                    return 3; // Kurang dari atau sama dengan 4 tahun
                }
            }
            return 3; // Default jika tidak ada TMT golongan
        }

        // Satu tingkat di bawah
        if ($golonganKandidat == ($minimalGolongan - 1)) {
            return 1;
        }

        // Lebih dari satu tingkat di bawah
        return 1;
    }

    /**
     * Hitung nilai Tingkat Pendidikan
     * Kriteria 3
     */
    public function getNilaiTingkatPendidikan(Kandidat $kandidat): int
    {
        if (!$kandidat->tingkat_pendidikan_id) {
            return 1;
        }

        $tingkat = $kandidat->tingkat_pendidikan_id;

        // S3 atau S2 (ID >= 8)
        if ($tingkat >= 8) {
            return 5;
        }

        // S1/D-IV (ID = 7)
        if ($tingkat == 7) {
            return 4;
        }

        // D-III (ID = 6)
        if ($tingkat == 6) {
            return 3;
        }

        // Di bawah D-III
        return 1;
    }

    /**
     * Hitung nilai Bidang Ilmu
     * Kriteria 8
     */
    public function getNilaiBidangIlmu(Kandidat $kandidat, ?JabatanTarget $jabatanTarget): int
    {
        if (!$jabatanTarget || !$kandidat->bidang_ilmu_id || !$jabatanTarget->id_bidang) {
            return 2; // Default: Tidak sesuai
        }

        // Cek kesesuaian bidang ilmu
        if ($kandidat->bidang_ilmu_id == $jabatanTarget->id_bidang) {
            return 5; // Sesuai
        }

        return 2; // Tidak sesuai
    }

    /**
     * Konversi persentase (0-100) ke nilai (1-5)
     * Untuk Kriteria 9 (Potensi) dan 10 (Kompetensi)
     */
    public function konversiPersentaseKeNilai(float $persentase, int $kriteriaId): int
    {
        return PersentaseConversion::konversi($persentase, $kriteriaId);
    }

    /**
     * Get options untuk dropdown kriteria tertentu
     * Untuk Kriteria 4, 5, 6, 7
     */
    public function getOptionsForKriteria(int $kriteriaId): array
    {
        $options = KriteriaNilai::where('kriteria_id', $kriteriaId)
            ->orderBy('nilai', 'desc')
            ->get();

        return $options->map(function ($item) {
            return [
                'id' => $item->id,
                'kategori' => $item->kategori,
                'nilai' => $item->nilai,
                'label' => "{$item->kategori} (Nilai: {$item->nilai})",
            ];
        })->toArray();
    }

    /**
     * Auto-fill semua kriteria yang bisa di-autofill untuk satu kandidat
     */
    public function autoFillKandidat(Kandidat $kandidat, ?JabatanTarget $jabatanTarget): array
    {
        return [
            1 => $this->getNilaiPangkatGolongan($kandidat, $jabatanTarget), // Pangkat/Golongan
            2 => $this->hitungMasaJabatan($kandidat), // Masa Jabatan
            3 => $this->getNilaiTingkatPendidikan($kandidat), // Tingkat Pendidikan
            4 => $this->getNilaiBidangIlmu($kandidat, $jabatanTarget), // K4: Bidang Ilmu
        ];
    }

    /**
     * Get auto-fill explanation untuk debugging/display
     */
    public function getAutoFillExplanation(Kandidat $kandidat, ?JabatanTarget $jabatanTarget): array
    {
        $explanations = [];

        // K1: Pangkat/Golongan
        $nilai1 = $this->getNilaiPangkatGolongan($kandidat, $jabatanTarget);
        $explanations[1] = "Golongan ID: {$kandidat->golongan_id} → Nilai: {$nilai1}";

        // K2: Masa Jabatan
        if ($kandidat->tmt_jabatan) {
            $tahun = Carbon::parse($kandidat->tmt_jabatan)->diffInYears(Carbon::now(), true);
            $nilai2 = $this->hitungMasaJabatan($kandidat);
            $explanations[2] = "TMT: {$kandidat->tmt_jabatan}, Masa: " . number_format($tahun, 1) . " tahun → Nilai: {$nilai2}";
        } else {
            $explanations[2] = "TMT tidak ada → Nilai: 1";
        }

        // K3: Tingkat Pendidikan
        $nilai3 = $this->getNilaiTingkatPendidikan($kandidat);
        $explanations[3] = "Tingkat Pendidikan ID: {$kandidat->tingkat_pendidikan_id} → Nilai: {$nilai3}";

        // K4: Bidang Ilmu
        $nilai8 = $this->getNilaiBidangIlmu($kandidat, $jabatanTarget);
        if ($jabatanTarget) {
            $match = ($kandidat->bidang_ilmu_id == $jabatanTarget->id_bidang) ? 'Sesuai' : 'Tidak Sesuai';
            $explanations[4] = "Bidang Ilmu: {$kandidat->bidang_ilmu_id} vs Target: {$jabatanTarget->id_bidang} → {$match} → Nilai: {$nilai8}";
        } else {
            $explanations[4] = "Tidak ada jabatan target → Nilai: {$nilai8}";
        }

        return $explanations;
    }

    /**
     * Get kategori/label untuk nilai auto-fill
     */
    public function getAutoFillCategories(Kandidat $kandidat, ?JabatanTarget $jabatanTarget): array
    {
        $categories = [];

        // K1: Pangkat/Golongan
        $nilai1 = $this->getNilaiPangkatGolongan($kandidat, $jabatanTarget);
        $golonganNama = $kandidat->golongan->golongan ?? '-';
        $categories[1] = [
            'nilai' => $nilai1,
            'kategori' => $this->getKategoriPangkat($nilai1),
            'detail' => $golonganNama,
        ];

        // K2: Masa Jabatan
        $nilai2 = $this->hitungMasaJabatan($kandidat);
        $masaJabatan = $kandidat->tmt_jabatan
            ? number_format(Carbon::parse($kandidat->tmt_jabatan)->diffInYears(Carbon::now(), true), 1) . ' thn'
            : '-';
        $categories[2] = [
            'nilai' => $nilai2,
            'kategori' => $this->getKategoriMasaJabatan($nilai2),
            'detail' => $masaJabatan,
        ];

        // K3: Tingkat Pendidikan
        $nilai3 = $this->getNilaiTingkatPendidikan($kandidat);
        $pendidikanNama = $kandidat->tingkat_pendidikan->tingkat_pendidikan ?? '-';
        $categories[3] = [
            'nilai' => $nilai3,
            'kategori' => $this->getKategoriPendidikan($nilai3),
            'detail' => $pendidikanNama,
        ];

        // K8 -> K4: Bidang Ilmu
        $nilai8 = $this->getNilaiBidangIlmu($kandidat, $jabatanTarget);
        $bidangNama = $kandidat->bidang_ilmu->nama ?? '-';
        $categories[4] = [  // ID 4
            'nilai' => $nilai8,
            'kategori' => $nilai8 == 5 ? 'Sesuai' : 'Tidak Sesuai',
            'detail' => $bidangNama,
        ];

        return $categories;
    }

    /**
     * Get kategori untuk nilai Pangkat/Golongan
     */
    private function getKategoriPangkat(int $nilai): string
    {
        return match($nilai) {
            5 => 'Di atas syarat',
            4 => 'Sesuai (>4 thn)',
            3 => 'Sesuai (≤4 thn)',
            2 => '1 tingkat di bawah',
            1 => 'Di bawah syarat',
            default => '-',
        };
    }

    /**
     * Get kategori untuk nilai Masa Jabatan
     */
    private function getKategoriMasaJabatan(int $nilai): string
    {
        return match($nilai) {
            5 => '> 4 tahun',
            4 => '3-4 tahun',
            3 => '2-3 tahun',
            1 => '< 2 tahun',
            default => '-',
        };
    }

    /**
     * Get kategori untuk nilai Tingkat Pendidikan
     */
    private function getKategoriPendidikan(int $nilai): string
    {
        return match($nilai) {
            5 => 'S2/S3',
            4 => 'S1/D-IV',
            3 => 'D-III',
            1 => 'Di bawah D-III',
            default => '-',
        };
    }
}
