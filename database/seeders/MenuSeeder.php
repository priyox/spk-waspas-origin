<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menu::truncate();

        // ===== MENU UTAMA =====
        $dashboard = Menu::create([
            'menu_name' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'bi bi-speedometer2',
            'parent_id' => null,
            'order' => 1,
            'permission_name' => 'dashboard-access',
            'is_active' => true,
        ]);

        $masterData = Menu::create([
            'menu_name' => 'Master Data',
            'route' => null,
            'icon' => 'bi bi-database',
            'parent_id' => null,
            'order' => 2,
            'permission_name' => null,
            'is_active' => true,
        ]);

        $penilaian = Menu::create([
            'menu_name' => 'Penilaian',
            'route' => null,
            'icon' => 'bi bi-clipboard-check',
            'parent_id' => null,
            'order' => 3,
            'permission_name' => 'penilaian-access',
            'is_active' => true,
        ]);

        $laporan = Menu::create([
            'menu_name' => 'Laporan',
            'route' => 'laporan.index',
            'icon' => 'bi bi-file-earmark-text',
            'parent_id' => null,
            'order' => 4,
            'permission_name' => 'laporan-access',
            'is_active' => true,
        ]);

        // ===== SUB MENU MASTER DATA =====
        Menu::create([
            'menu_name' => 'Kandidat',
            'route' => 'kandidat.index',
            'icon' => 'bi bi-people',
            'parent_id' => $masterData->id,
            'order' => 1,
            'permission_name' => 'kandidat-manage',
            'is_active' => true,
        ]);
        Menu::create([
            'menu_name' => 'Jabatan Target',
            'route' => 'jabatan-target.index',
            'icon' => 'bi bi-briefcase',
            'parent_id' => $masterData->id,
            'order' => 2,
            'permission_name' => 'jabatan-target-manage',
            'is_active' => true,
        ]);
        Menu::create([
            'menu_name' => 'Kriteria',
            'route' => 'kriteria.index',
            'icon' => 'bi bi-list-check',
            'parent_id' => $masterData->id,
            'order' => 3,
            'permission_name' => 'kriteria-manage',
            'is_active' => true,
        ]);

        // ===== SUB MENU PENILAIAN =====
        Menu::create([
            'menu_name' => 'Input Nilai',
            'route' => 'penilaian.input',
            'icon' => 'bi bi-pencil-square',
            'parent_id' => $penilaian->id,
            'order' => 1,
            'permission_name' => 'nilai-input',
            'is_active' => true,
        ]);

        Menu::create([
            'menu_name' => 'Perhitungan WASPAS',
            'route' => 'waspas.proses',
            'icon' => 'bi bi-calculator',
            'parent_id' => $penilaian->id,
            'order' => 2,
            'permission_name' => 'waspas-process',
            'is_active' => true,
        ]);

        Menu::create([
            'menu_name' => 'Hasil Ranking',
            'route' => 'waspas.hasil',
            'icon' => 'bi bi-trophy',
            'parent_id' => $penilaian->id,
            'order' => 3,
            'permission_name' => 'waspas-view',
            'is_active' => true,
        ]);
    }
}
