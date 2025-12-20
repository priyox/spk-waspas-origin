<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleSeeder extends Seeder
{
    public function run()
    {
        $roleNames = ['Super Admin', 'Admin Kepegawaian'];
        $menuRoutes = [
            'dashboard',
            'kandidat.index',
            'kriteria.index',
            'bidang-ilmu.index',
            'syarat-jabatan.index',
            'jabatan-target.index'
        ];

        $roles = \Spatie\Permission\Models\Role::whereIn('name', $roleNames)->get();
        $menus = \App\Models\Menu::whereIn('route', $menuRoutes)->get();

        $inserts = [];
        foreach ($roles as $role) {
            foreach ($menus as $menu) {
                $inserts[] = [
                    'menu_id' => $menu->id,
                    'role_id' => $role->id
                ];
            }
        }

        if (!empty($inserts)) {
            DB::table('menu_role')->insertOrIgnore($inserts);
            $this->command->info('Successfully granted access to ' . count($inserts) . ' menu-role combinations');
        } else {
            $this->command->warn('No menus or roles found for mapping.');
        }
    }
}
