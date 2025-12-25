<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRefactorKriteriaSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Parent Menu "Kriteria"
        // Check if exists
        $parent = DB::table('menus')->where('menu_name', 'Kriteria')->where('route', '#')->first();
        
        if (!$parent) {
             // Create "Kriteria" parent
             // Order: After "Kandidat"
             $kandidatMenu = DB::table('menus')->where('menu_name', 'Kandidat')->first();
             $order = $kandidatMenu ? $kandidatMenu->order + 1 : 5;

             $parentId = DB::table('menus')->insertGetId([
                'menu_name' => 'Kriteria',
                'route' => '#',
                'icon' => 'fas fa-list',
                'order' => $order,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $parentId = $parent->id;
        }

        // 2. Move & Rename "Kriteria" -> "Daftar Kriteria" and put under Parent
        // Original route for Kriteria likely 'kriteria.index' or '/kriteria'
        // If route is stored as route name 'kriteria.index'
        DB::table('menus')
            ->where('route', 'kriteria.index')
            ->orWhere('route', '/kriteria')
            ->update([
                'menu_name' => 'Daftar Kriteria',
                'parent_id' => $parentId,
                'order' => 1
            ]);

        // 3. Move "Nilai Kriteria" -> Put under Parent
        // Original route likely 'kriteria-nilai.index' or '/kriteria-nilai'
        DB::table('menus')
            ->where('route', 'kriteria-nilai.index')
            ->orWhere('route', '/kriteria-nilai')
            ->update([
                'parent_id' => $parentId,
                'order' => 2
            ]);
            
        $this->command->info('Menu Kriteria reorganized successfully.');
    }
}
