<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuReorganizationSeeder extends Seeder
{
    public function run()
    {
        // 1. Reorder Top-Level Menus
        // Dashboard: 1
        DB::table('menus')->where('menu_name', 'Dashboard')->update(['order' => 1]);
        
        // Master Data: 2
        DB::table('menus')->where('menu_name', 'Master Data')->update(['order' => 2]);
        
        // Kriteria (Parent): 3
        DB::table('menus')->where('menu_name', 'Kriteria')->whereNull('parent_id')->update(['order' => 3]);
        
        // Penilaian (Parent): 4
        DB::table('menus')->where('menu_name', 'Penilaian')->whereNull('parent_id')->update(['order' => 4]);
        
        // Laporan: 5
        DB::table('menus')->where('menu_name', 'Laporan')->whereNull('parent_id')->update(['order' => 5]);

        // 2. Rename Submenu under Penilaian
        // "Input Nilai" -> "Nilai Kandidat"
        DB::table('menus')
            ->where('menu_name', 'Input Nilai')
            ->where('route', 'penilaian.input')
            ->update(['menu_name' => 'Nilai Kandidat']);

        $this->command->info('Menu reorganized and renamed successfully.');
    }
}
