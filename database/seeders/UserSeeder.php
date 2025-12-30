<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $superadmin = User::create([
            "email" => "superadmin@app.com",
            "password" => bcrypt('password'),
            "name" => "Super Admin"
        ]);

        $superadmin->assignRole(['Super Admin', 'Admin Kepegawaian', 'Pimpinan']);

        $admin = User::create([
            "email" => "admin@app.com",
            "password" => bcrypt('password'),
            "name" => "Administrator"
        ]);
        $admin->assignRole('Admin Kepegawaian');

        $pimpinan = User::create([
            "email" => "pimpinan@app.com",
            "password" => bcrypt('password'),
            "name" => "Pimpinan"
        ]);
        $pimpinan->assignRole('Pimpinan');

    }
}