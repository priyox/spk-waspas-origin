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
        // RolePermissionSeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
        MenuSeeder::class,
        RolePermissionSeeder::class,
        MenuRoleSeeder::class,
        ]);
    }
}
