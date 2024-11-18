<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Operator',
            'email' => 'operator@mail.com',
            'password' => bcrypt('operator'),
            'role' => 'operator',
        ]);

        User::factory()->create([
            'name' => 'Kepala Kantor',
            'email' => 'kepala@mail.com',
            'password' => bcrypt('kepala'),
            'role' => 'kepala_kantor',
        ]);
        // Alternatif::factory(3)->create();
        // Kriteria::factory(4)->create();

    }
}

