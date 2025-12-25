<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class MenuReorganizationSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Create new Parent Menu "Kandidat"
        // Check order of existing headers: Dashboard(1), Master Data(2), Penilaian(3), Laporan(4)
        // Let's Insert "Kandidat" after Master Data, so Order 3. Shift Penilaian and Laporan.
        
        $penilaian = Menu::where('menu_name', 'Penilaian')->whereNull('parent_id')->first();
        if ($penilaian) {
            $penilaian->update(['order' => 4]);
        }
        $laporan = Menu::where('menu_name', 'Laporan')->whereNull('parent_id')->first();
        if ($laporan) {
            $laporan->update(['order' => 5]);
        }

        $parentKandidat = Menu::create([
            'menu_name' => 'Kandidat',
            'route' => null,
            'icon' => 'bi bi-person-lines-fill',
            'parent_id' => null,
            'order' => 3,
            'permission_name' => 'kandidat-access', // New permission if needed, or null
            'is_active' => true,
        ]);

        // 2. Move existing "Kandidat" menu from "Master Data" to new "Kandidat" parent
        // And rename it to "Daftar Kandidat"
        $menuDaftar = Menu::where('menu_name', 'Kandidat')->whereNotNull('parent_id')->first();
        if ($menuDaftar) {
            $menuDaftar->update([
                'menu_name' => 'Daftar Kandidat',
                'parent_id' => $parentKandidat->id,
                'order' => 1
            ]);
        }

        // 3. Add "Input Nilai Kandidat" menu to new "Kandidat" parent
        Menu::create([
            'menu_name' => 'Input Nilai Kandidat',
            'route' => 'kandidat.input-nilai', // This route needs to be registered
            'icon' => 'bi bi-pencil-square',
            'parent_id' => $parentKandidat->id,
            'order' => 2,
            'permission_name' => 'nilai-input', // Reusing existing permission or create new
            'is_active' => true,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
