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

        $superadmin->assignRole('Super Admin');

        $admin = User::create([
            "email" => "admin@app.com",
            "password" => bcrypt('password'),
            "name" => "Administrator"
        ]);
        $admin->assignRole('Admin Kepegawaian');

        $penilai = User::create([
            "email" => "penilai@app.com",
            "password" => bcrypt('password'),
            "name" => "Tim Penilai"
        ]);
        $penilai->assignRole('Tim Penilai');

        $pimpinan = User::create([
            "email" => "pimpinan@app.com",
            "password" => bcrypt('password'),
            "name" => "Pimpinan"
        ]);
        $pimpinan->assignRole('Pimpinan');

    }
}