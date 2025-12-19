<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // 1. Seed Criteria
        $kriterias = [
            ['kriteria' => 'Pengalaman Kerja', 'bobot' => 30, 'jenis' => 'Benefit'],
            ['kriteria' => 'Pendidikan', 'bobot' => 20, 'jenis' => 'Benefit'],
            ['kriteria' => 'Jarak Domisili', 'bobot' => 10, 'jenis' => 'Cost'],
            ['kriteria' => 'Kompetensi', 'bobot' => 25, 'jenis' => 'Benefit'],
            ['kriteria' => 'Wawancara', 'bobot' => 15, 'jenis' => 'Benefit'],
        ];

        foreach ($kriterias as $k) {
            DB::table('kriterias')->updateOrInsert(
                ['kriteria' => $k['kriteria']],
                $k
            );
        }

        // Get IDs
        $kriteriaIds = DB::table('kriterias')->pluck('id');

        // 2. Seed Candidates
        // Ensure dependencies exist
        $golonganId = DB::table('golongans')->insertGetId(['golongan' => 'III/a', 'pangkat' => 'Penata Muda']);
        $jenisJabatanId = DB::table('jenis_jabatans')->insertGetId(['jenis_jabatan' => 'Fungsional']);
        $tingkatPendidikanId = DB::table('tingkat_pendidikans')->insertGetId(['tingkat' => 'S1']);
        $bidangIlmuId = DB::table('bidang_ilmus')->insertGetId(['bidang' => 'Informatika']);

        for ($i = 0; $i < 5; $i++) {
            $nip = $faker->unique()->numerify('19##########');
            DB::table('kandidats')->updateOrInsert(
                ['nip' => $nip],
                [
                    'nama' => $faker->name,
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date(),
                    'golongan_id' => $golonganId,
                    'jenis_jabatan_id' => $jenisJabatanId,
                    'jabatan' => $faker->jobTitle,
                    'tingkat_pendidikan_id' => $tingkatPendidikanId,
                    'bidang_ilmu_id' => $bidangIlmuId,
                ]
            );

            // 3. Seed Scores (Nilai)
            foreach ($kriteriaIds as $kId) {
                // Determine logic based on criteria to make it realistic
                // e.g. Benefit -> higher is better (60-100), Cost -> lower is better (1-20 km)
                // Simplified random
                $val = 0;
                // cost (index 2 in array above, assuming IDs sequential)
                // But reliable way:
                $kType = DB::table('kriterias')->where('id', $kId)->value('jenis');
                
                if ($kType == 'Cost') {
                    $val = rand(1, 20); // e.g. Distance in KM
                } else {
                    $val = rand(70, 95); // Score
                }

                DB::table('nilais')->updateOrInsert(
                    ['nip' => $nip, 'kriteria_id' => $kId],
                    ['nilai' => $val]
                );
            }
        }
    }
}
