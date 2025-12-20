<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TingkatPendidikan;

class TingkatPendidikanSeeder extends Seeder
{
    public function run(): void
    {
        TingkatPendidikan::query()->delete();

        $data = [
            ['id' => 1, 'tingkat' => 'SD'],
            ['id' => 2, 'tingkat' => 'SLTP'],
            ['id' => 3, 'tingkat' => 'SLTA'],
            ['id' => 4, 'tingkat' => 'D-I'],
            ['id' => 5, 'tingkat' => 'D-II'],
            ['id' => 6, 'tingkat' => 'D-III'],
            ['id' => 7, 'tingkat' => 'D-IV / S-1'],
            ['id' => 8, 'tingkat' => 'S-2'],
            ['id' => 9, 'tingkat' => 'S-3'],
        ];

        foreach ($data as $row) {
            TingkatPendidikan::create($row);
        }
    }
}
