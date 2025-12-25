<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuOrderKriteriaKandidatSeeder extends Seeder
{
    public function run()
    {
        // 1. Get/Set the Top-Level Kriteria Menu
        $kriteriaParent = DB::table('menus')->where('menu_name', 'Kriteria')->first();
        
        if ($kriteriaParent) {
            // Check if it's already a parent (no route) or needs to be converted
            if ($kriteriaParent->route !== null) {
                // It currently points to kriteria.index. 
                // We'll use this ID as the parent, but rename it and remove route.
                // However, it's safer to keep the name "Kriteria" for the parent and clear the route.
                DB::table('menus')->where('id', $kriteriaParent->id)->update([
                    'route' => null,
                    'parent_id' => null, // Move to TOP
                    'icon' => 'bi bi-list-stars' // Update icon for parent folder
                ]);

                // Now create/update the "Data Kriteria" submenu pointing to kriteria.index
                DB::table('menus')->updateOrInsert(
                    ['route' => 'kriteria.index', 'parent_id' => $kriteriaParent->id],
                    [
                        'menu_name' => 'Data Kriteria',
                        'icon' => 'bi bi-list-check',
                        'order' => 1,
                        'permission_name' => 'kriteria-manage',
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
            
            // 2. Move "Nilai Kriteria" under the Kriteria parent
            DB::table('menus')
                ->where('menu_name', 'Nilai Kriteria')
                ->update([
                    'parent_id' => $kriteriaParent->id,
                    'order' => 2
                ]);
        }

        // 3. Get/Set the Top-Level Kandidat Menu
        $kandidatParent = DB::table('menus')->where('menu_name', 'Kandidat')->first();
        
        if ($kandidatParent) {
            // Convert to parent if it has a route
            if ($kandidatParent->route !== null) {
                DB::table('menus')->where('id', $kandidatParent->id)->update([
                    'route' => null,
                    'parent_id' => null, // Move to TOP
                    'icon' => 'bi bi-people-fill' 
                ]);
            }

            // Submenu: Daftar Kandidat (Always update to ensure correctness)
            DB::table('menus')->updateOrInsert(
                ['menu_name' => 'Daftar Kandidat', 'parent_id' => $kandidatParent->id],
                [
                    'route' => 'kandidat.index',
                    'icon' => 'bi bi-person-lines-fill',
                    'order' => 1,
                    'permission_name' => 'kandidat-manage',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Submenu: Input Nilai Kandidat (Always update to ensure correct route)
            DB::table('menus')->updateOrInsert(
                ['menu_name' => 'Input Nilai Kandidat', 'parent_id' => $kandidatParent->id],
                [
                    'route' => 'kandidat.input-nilai', // Corrected Route
                    'icon' => 'bi bi-pencil-square',
                    'order' => 2,
                    'permission_name' => 'nilai-input',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // 4. Rename 'Input Nilai' to 'Nilai Kandidat' under Penilaian (if it exists)
        DB::table('menus')
            ->where('menu_name', 'Input Nilai')
            ->where('route', 'penilaian.input')
            ->whereNotNull('parent_id') // Ensure we target the one under a parent (likely Penilaian)
            ->update(['menu_name' => 'Nilai Kandidat']);

        // 5. Set the absolute order for top-level menus
        $orderMap = [
            'Dashboard' => 1,
            'Master Data' => 2,
            'Kriteria' => 3,
            'Kandidat' => 4,
            'Penilaian' => 5,
            'Laporan' => 6,
        ];

        foreach ($orderMap as $name => $order) {
            DB::table('menus')
                ->where('menu_name', $name)
                ->whereNull('parent_id')
                ->update(['order' => $order]);
        }

        $this->command->info('Kriteria and Kandidat submenus restored successfully.');
    }
}
