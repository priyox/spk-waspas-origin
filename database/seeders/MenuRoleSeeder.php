<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleSeeder extends Seeder
{
    public function run()
    {
        $menuIds = [5, 6, 11, 12]; // Kandidat, Kriteria, Bidang Ilmu, Syarat Jabatan
        $roleIds = [1, 2]; // Super Admin, Admin Kepegawaian
        
        $inserts = [];
        foreach ($roleIds as $roleId) {
            foreach ($menuIds as $menuId) {
                $inserts[] = [
                    'menu_id' => $menuId,
                    'role_id' => $roleId
                ];
            }
        }
        
        DB::table('menu_role')->insertOrIgnore($inserts);
        
        $this->command->info('Successfully granted access to ' . count($inserts) . ' menu-role combinations');
    }
}
