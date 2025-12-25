<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuOrderKriteriaKandidatSeeder extends Seeder
{
    public function run()
    {
        // 1. Find the current order of Kandidat
        $kandidat = DB::table('menus')->where('menu_name', 'Kandidat')->first();
        $kriteria = DB::table('menus')->where('menu_name', 'Kriteria')->whereNull('parent_id')->first();

        if ($kandidat && $kriteria) {
            $kandidatOrder = $kandidat->order;
            
            // Swap orders or just set Kriteria to Kandidat's current order and push Kandidat down
            // But we want Kriteria ABOVE Kandidat.
            
            // Let's explicitly set the top-level order for clarity:
            // 1. Dashboard
            // 2. Kriteria
            // 3. Kandidat
            // 4. Penilaian
            // 5. Laporan
            
            DB::table('menus')->where('menu_name', 'Dashboard')->update(['order' => 1]);
            DB::table('menus')->where('menu_name', 'Master Data')->update(['order' => 2]);
            DB::table('menus')->where('menu_name', 'Kriteria')->whereNull('parent_id')->update(['order' => 3]);
            DB::table('menus')->where('menu_name', 'Kandidat')->whereNull('parent_id')->update(['order' => 4]);
            DB::table('menus')->where('menu_name', 'Penilaian')->whereNull('parent_id')->update(['order' => 5]);
            DB::table('menus')->where('menu_name', 'Laporan')->whereNull('parent_id')->update(['order' => 6]);
        }

        $this->command->info('Menu order updated: Kriteria is now above Kandidat.');
    }
}
