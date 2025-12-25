<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixKriteriaNilaiSwapSeeder extends Seeder
{
    public function run()
    {
        // Disable Foreign Key Checks
        Schema::disableForeignKeyConstraints();

        // Swap Kriteria Nilai Parent IDs
        // Original State:
        // ID 4 (Now Named Bidang Ilmu) has Diklat Options (JP ranges)
        // ID 8 (Now Named Diklat) has Bidang Ilmu Options (Sesuai/Tidak Sesuai)
        
        // Goal:
        // ID 4 (Bidang Ilmu) -> Should have Bidang Ilmu Options
        // ID 8 (Diklat) -> Should have Diklat Options

        // 1. Move Items linked to ID 4 (Diklat Options) to Temp 999
        DB::table('kriteria_nilais')->where('kriteria_id', 4)->update(['kriteria_id' => 999]);
        
        // 2. Move Items linked to ID 8 (Bidang Ilmu Options) to ID 4
        DB::table('kriteria_nilais')->where('kriteria_id', 8)->update(['kriteria_id' => 4]);

        // 3. Move Items linked to ID 999 (Diklat Options) to ID 8
        DB::table('kriteria_nilais')->where('kriteria_id', 999)->update(['kriteria_id' => 8]);

        // Enable Foreign Key Checks
        Schema::enableForeignKeyConstraints();

        $this->command->info('Kriteria Nilai references swapped successfully.');
    }
}
