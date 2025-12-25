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
            'dashboard-access',
            'master-data-access',
            'kriteria-manage',
            'kandidat-manage',
            'penilaian-manage',
            'hasil-akhir-view',
            'manajemen-access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin      = Role::where('name', 'Admin Kepegawaian')->first();
        $penilai    = Role::where('name', 'Tim Penilai')->first();
        $pimpinan   = Role::where('name', 'Pimpinan')->first();

        // 1. Super Admin: All permissions
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin Kepegawaian: All EXCEPT Manajemen
        $admin->syncPermissions([
            'dashboard-access',
            'master-data-access',
            'kriteria-manage',
            'kandidat-manage',
            'penilaian-manage',
            'hasil-akhir-view',
        ]);

        // 3. Tim Penilai: Kandidat, Penilaian, Hasil Akhir
        $penilai->syncPermissions([
            'dashboard-access',
            'kandidat-manage',
            'penilaian-manage',
            'hasil-akhir-view',
        ]);

        // 4. Pimpinan: Penilaian, Hasil Akhir
        $pimpinan->syncPermissions([
            'dashboard-access',
            'penilaian-manage',
            'hasil-akhir-view',
        ]);
    }
}
