<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class MenuRoleSeeder extends Seeder
{
    public function run(): void
    {
        // HAPUS DATA LAMA (AMAN DARI FK)
        DB::table('menu_role')->delete();

        // ======================
        // AMBIL ROLE
        // ======================
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin      = Role::where('name', 'Admin Kepegawaian')->first();
        $penilai    = Role::where('name', 'Tim Penilai')->first();
        $pimpinan   = Role::where('name', 'Pimpinan')->first();

        // ======================
        // AMBIL MENU
        // ======================
        $dashboard  = Menu::where('menu_name', 'Dashboard')->first();
        $masterData = Menu::where('menu_name', 'Master Data')->first();
        $penilaian  = Menu::where('menu_name', 'Penilaian')->first();
        $laporan    = Menu::where('menu_name', 'Laporan')->first();

        // SUB MENU
        $dataAsn    = Menu::where('menu_name', 'Data ASN')->first();
        $kriteria   = Menu::where('menu_name', 'Kriteria')->first();
        $subKriteria= Menu::where('menu_name', 'Sub Kriteria')->first();

        $inputNilai = Menu::where('menu_name', 'Input Nilai')->first();
        $proses     = Menu::where('menu_name', 'Perhitungan WASPAS')->first();
        $hasil      = Menu::where('menu_name', 'Hasil Ranking')->first();

        // ======================
        // SUPER ADMIN → SEMUA MENU
        // ======================
        foreach (Menu::all() as $menu) {
            DB::table('menu_role')->insert([
                'menu_id' => $menu->id,
                'role_id' => $superAdmin->id,
            ]);
        }

        // ======================
        // ADMIN KEPEGAWAIAN
        // ======================
        $adminMenus = [
            $dashboard,
            $masterData, $dataAsn, $kriteria, $subKriteria,
            $penilaian, $inputNilai, $proses, $hasil,
            $laporan,
        ];

        foreach ($adminMenus as $menu) {
            DB::table('menu_role')->insert([
                'menu_id' => $menu->id,
                'role_id' => $admin->id,
            ]);
        }

        // ======================
        // TIM PENILAI
        // ======================
        $penilaiMenus = [
            $dashboard,
            $penilaian, $inputNilai, $hasil,
        ];

        foreach ($penilaiMenus as $menu) {
            DB::table('menu_role')->insert([
                'menu_id' => $menu->id,
                'role_id' => $penilai->id,
            ]);
        }

        // ======================
        // PIMPINAN
        // ======================
        $pimpinanMenus = [
            $dashboard,
            $hasil,
            $laporan,
        ];

        foreach ($pimpinanMenus as $menu) {
            DB::table('menu_role')->insert([
                'menu_id' => $menu->id,
                'role_id' => $pimpinan->id,
            ]);
        }
    }
}
