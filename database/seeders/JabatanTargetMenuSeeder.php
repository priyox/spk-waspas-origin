<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanTargetMenuSeeder extends Seeder
{
    public function run()
    {
        // Insert menu
        $menuId = DB::table('menus')->insertGetId([
            'menu_name' => 'Jabatan Target',
            'route' => 'jabatan-target.index',
            'icon' => 'bi bi-briefcase',
            'parent_id' => 2, // Master Data
            'order' => 5,
            'permission_name' => 'jabatan-target-manage',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Grant access to Super Admin (1) and Admin Kepegawaian (2)
        DB::table('menu_role')->insert([
            ['menu_id' => $menuId, 'role_id' => 1],
            ['menu_id' => $menuId, 'role_id' => 2]
        ]);
        
        $this->command->info("Jabatan Target menu created with ID: {$menuId} and roles assigned");
    }
}
