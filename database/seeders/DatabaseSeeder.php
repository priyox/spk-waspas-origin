<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            RolePermissionSeeder::class,
            MenuRoleSeeder::class,
            JenisJabatanSeeder::class,
            GolonganSeeder::class,
            EselonSeeder::class,
            TingkatPendidikanSeeder::class,
            BidangIlmuSeeder::class,
            JenjangFungsionalSeeder::class, // Added
            KriteriaSeeder::class,
            KriteriaNilaiSeeder::class, // Moved up
            MasaJabatanRangeSeeder::class,
            PersentaseConversionSeeder::class,
            KandidatSeeder::class,
            NilaiSeeder::class,
            SyaratJabatanSeeder::class,
            JabatanFungsionalSeeder::class,
            JabatanPelaksanaSeeder::class,
            UnitKerjaSeeder::class,
            JurusanPendidikanSeeder::class,
            JabatanTargetSeeder::class,
            MenuOrderKriteriaKandidatSeeder::class,
        ]);
    }
}
