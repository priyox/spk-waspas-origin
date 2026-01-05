<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Menu::truncate();
        DB::table('menu_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get Roles
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $adminKepegawaian = Role::where('name', 'Admin Kepegawaian')->first();
        $pimpinan = Role::where('name', 'Pimpinan')->first();

        $allRoles = [$superAdmin->id, $adminKepegawaian->id, $pimpinan->id];
        $adminRoles = [$superAdmin->id, $adminKepegawaian->id];
        $penilaiRoles = [$superAdmin->id, $adminKepegawaian->id]; // Includes Super Admin
        $pimpinanRoles = [$superAdmin->id, $adminKepegawaian->id, $pimpinan->id]; // Includes Super Admin

        // 1. DASHBOARD
        $dashboard = Menu::create([
            'menu_name' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'bi bi-grid-fill',
            'parent_id' => null,
            'order' => 1,
            'permission_name' => 'dashboard-access',
            'is_active' => true,
        ]);
        $dashboard->roles()->sync($allRoles);

        // 2. MASTER DATA
        $masterData = Menu::create([
            'menu_name' => 'Master Data',
            'route' => null,
            'icon' => 'bi bi-database-fill',
            'parent_id' => null,
            'order' => 2,
            'permission_name' => 'master-data-access',
            'is_active' => true,
        ]);
        $masterData->roles()->sync($adminRoles);

        $this->createSubMenu($masterData->id, 'Jabatan Pelaksana', 'jabatan-pelaksana.index', 'bi bi-person-workspace', 1, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Jabatan Fungsional', 'jabatan-fungsional.index', 'bi bi-person-gear', 2, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Golongan', 'golongan.index', 'bi bi-chevron-double-up', 3, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Unit Kerja', 'unit-kerja.index', 'bi bi-building', 4, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Bidang Ilmu', 'bidang-ilmu.index', 'bi bi-journal-text', 5, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Jabatan Target', 'jabatan-target.index', 'bi bi-target', 6, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Syarat Jabatan', 'syarat-jabatan.index', 'bi bi-card-checklist', 7, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Eselon', 'eselon.index', 'bi bi-bar-chart-steps', 8, $adminRoles, 'master-data-access');
        $this->createSubMenu($masterData->id, 'Jurusan Pendidikan', 'jurusan-pendidikan.index', 'bi bi-mortarboard', 9, $adminRoles, 'master-data-access');

        // 3. KRITERIA
        $kriteriaParent = Menu::create([
            'menu_name' => 'Kriteria',
            'route' => null,
            'icon' => 'bi bi-list-stars',
            'parent_id' => null,
            'order' => 3,
            'permission_name' => 'kriteria-manage',
            'is_active' => true,
        ]);
        $kriteriaParent->roles()->sync($adminRoles);

        $this->createSubMenu($kriteriaParent->id, 'Daftar Kriteria', 'kriteria.index', 'bi bi-list-check', 1, $adminRoles, 'kriteria-manage');
        $this->createSubMenu($kriteriaParent->id, 'Nilai Kriteria', 'kriteria-nilai.index', 'bi bi-star-half', 2, $adminRoles, 'kriteria-manage');

        // 4. KANDIDAT (Parent menu with submenus)
        $kandidatParent = Menu::create([
            'menu_name' => 'Kandidat',
            'route' => null,
            'icon' => 'bi bi-people-fill',
            'parent_id' => null,
            'order' => 4,
            'permission_name' => 'kandidat-manage',
            'is_active' => true,
        ]);
        $kandidatParent->roles()->sync([$superAdmin->id, $adminKepegawaian->id]); // Super Admin view-only, Admin Kepegawaian full access

        $this->createSubMenu($kandidatParent->id, 'Daftar Kandidat', 'kandidat.index', 'bi bi-person-lines-fill', 1, [$superAdmin->id, $adminKepegawaian->id], 'kandidat-manage'); // Super Admin view-only


        // 5. PENILAIAN
        $penilaian = Menu::create([
            'menu_name' => 'Penilaian',
            'route' => null,
            'icon' => 'bi bi-clipboard2-check-fill',
            'parent_id' => null,
            'order' => 5,
            'permission_name' => 'penilaian-manage',
            'is_active' => true,
        ]);
        $penilaian->roles()->sync($pimpinanRoles); // No Super Admin

        $this->createSubMenu($penilaian->id, 'Nilai Kandidat', 'penilaian.input', 'bi bi-star-fill', 1, $penilaiRoles, 'penilaian-manage');
        $this->createSubMenu($penilaian->id, 'Perhitungan WASPAS', 'waspas.proses', 'bi bi-calculator', 2, $penilaiRoles, 'penilaian-manage');
        $this->createSubMenu($penilaian->id, 'Hasil Ranking', 'waspas.hasil', 'bi bi-trophy', 3, $penilaiRoles, 'penilaian-manage');

        // 6. HASIL AKHIR
        $hasilAkhir = Menu::create([
            'menu_name' => 'Hasil Akhir',
            'route' => 'hasil-akhir',
            'icon' => 'bi bi-file-earmark-pdf-fill',
            'parent_id' => null,
            'order' => 6,
            'permission_name' => 'hasil-akhir-view',
            'is_active' => true,
        ]);
        $hasilAkhir->roles()->sync($pimpinanRoles); // No Super Admin

        // 7. MANAJEMEN
        $manajemen = Menu::create([
            'menu_name' => 'Manajemen',
            'route' => null,
            'icon' => 'bi bi-gear-fill',
            'parent_id' => null,
            'order' => 7,
            'permission_name' => 'manajemen-access',
            'is_active' => true,
        ]);
        $manajemen->roles()->sync([$superAdmin->id]);

        $this->createSubMenu($manajemen->id, 'Users', 'users.index', 'bi bi-person-bounding-box', 1, [$superAdmin->id], 'manajemen-access');
        $this->createSubMenu($manajemen->id, 'Roles & Permissions', 'roles.index', 'bi bi-shield-lock-fill', 2, [$superAdmin->id], 'manajemen-access');
    }

    private function createSubMenu($parentId, $name, $route, $icon, $order, $roles, $permission = null)
    {
        $menu = Menu::create([
            'menu_name' => $name,
            'route' => $route,
            'icon' => $icon,
            'parent_id' => $parentId,
            'order' => $order,
            'permission_name' => $permission,
            'is_active' => true,
        ]);
        $menu->roles()->sync($roles);
        return $menu;
    }
}
