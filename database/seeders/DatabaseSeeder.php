<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Order is important:
     * 1. Roles must be created before Users and Menus
     * 2. Users need Roles to be assigned
     * 3. Menus need Roles for role-based access
     * 4. Master data (Golongan, Eselon, etc.) before Kandidat
     * 5. Kriteria before KriteriaNilai
     * 6. Kandidat before Nilai
     */
    public function run(): void
    {
        $this->call([
            // === AUTHENTICATION & AUTHORIZATION ===
            RoleSeeder::class,              // Create roles first
            UserSeeder::class,              // Create users and assign roles
            RolePermissionSeeder::class,    // Assign permissions to roles
            MenuSeeder::class,              // Create menus with role assignments

            // === MASTER DATA (REFERENCE TABLES) ===
            JenisJabatanSeeder::class,      // Job types (Struktural, Fungsional, etc.)
            GolonganSeeder::class,          // Rank/Grade (I/a, II/b, etc.)
            EselonSeeder::class,            // Echelon levels
            TingkatPendidikanSeeder::class, // Education levels
            JenjangFungsionalSeeder::class, // Functional position levels
            BidangIlmuSeeder::class,        // Fields of study
            JurusanPendidikanSeeder::class, // Education majors
            UnitKerjaSeeder::class,         // Work units
            JabatanPelaksanaSeeder::class,  // Operational positions
            JabatanFungsionalSeeder::class, // Functional positions
            JabatanTargetSeeder::class,     // Target positions for selection

            // === CRITERIA & REQUIREMENTS ===
            KriteriaSeeder::class,          // Assessment criteria
            KriteriaNilaiSeeder::class,     // Criteria value ranges
            SyaratJabatanSeeder::class,     // Position requirements
            MasaJabatanRangeSeeder::class,  // Tenure ranges

            // === CANDIDATES & ASSESSMENTS ===
            // KandidatSeeder::class,          // Candidate data
            // NilaiSeeder::class,             // Assessment scores
        ]);
    }
}
