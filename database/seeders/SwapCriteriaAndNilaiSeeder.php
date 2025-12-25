<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SwapCriteriaAndNilaiSeeder extends Seeder
{
    public function run()
    {
        // 1. Swap Kriteria Definition (Names/Bobot)
        // Store original K4
        $k4 = DB::table('kriterias')->where('id', 4)->first();
        $k8 = DB::table('kriterias')->where('id', 8)->first();

        if ($k4 && $k8) {
            // 1. Rename K4 to Temp
            DB::table('kriterias')->where('id', 4)->update([
                'kriteria' => 'TEMP_SWAP_PLACEHOLDER'
            ]);

            // 2. Update K8 with K4 data (Diklat)
            DB::table('kriterias')->where('id', 8)->update([
                'kriteria' => $k4->kriteria,
                'bobot' => $k4->bobot,
                'jenis' => $k4->jenis,
                'keterangan' => $k4->keterangan,
            ]);

            // 3. Update K4 (Temp) with K8 data (Bidang Ilmu)
            DB::table('kriterias')->where('id', 4)->update([
                'kriteria' => $k8->kriteria,
                'bobot' => $k8->bobot,
                'jenis' => $k8->jenis,
                'keterangan' => $k8->keterangan,
            ]);
        }

        // 2. Swap Kriteria Nilai Parent IDs
        // Move K4 items to 999 (Temp)
        DB::table('kriteria_nilais')->where('kriteria_id', 4)->update(['kriteria_id' => 999]);
        
        // Move K8 items to 4
        DB::table('kriteria_nilais')->where('kriteria_id', 8)->update(['kriteria_id' => 4]);

        // Move 999 items (Old K4) to 8
        DB::table('kriteria_nilais')->where('kriteria_id', 999)->update(['kriteria_id' => 8]);

        $this->command->info('Criteria 4 and 8 swapped successfully.');
    }
}
