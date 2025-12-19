<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ======================
        // PERMISSIONS
        // ======================
        $permissions = [
            // Dashboard
            'dashboard-access',

            // Master Data
            'kandidat-manage',
            'kriteria-manage',

            // Penilaian
            'penilaian-access',
            'nilai-input',
            'waspas-process',
            'waspas-view',

            // Laporan
            'laporan-access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }


        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin      = Role::firstOrCreate(['name' => 'Admin Kepegawaian']);
        $penilai    = Role::firstOrCreate(['name' => 'Tim Penilai']);
        $pimpinan   = Role::firstOrCreate(['name' => 'Pimpinan']);

        // Super Admin → semua permission
        $superAdmin->syncPermissions(Permission::all());

        // Admin
        $admin->syncPermissions([
            'dashboard-access',
            'kandidat-manage',
            'kriteria-manage',
            'penilaian-access',
            'nilai-input',
            'waspas-process',
            'waspas-view',
            'laporan-access',
        ]);

        // Tim Penilai
        $penilai->syncPermissions([
            'dashboard-access',
            'penilaian-access',
            'nilai-input',
            'waspas-process',
            'waspas-view',
        ]);

        // Pimpinan
        $pimpinan->syncPermissions([
            'dashboard-access',
            'waspas-view',
            'laporan-access',
        ]);
    }
}
