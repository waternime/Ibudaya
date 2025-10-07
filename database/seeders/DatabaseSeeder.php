<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // <-- WAJIB ditambahkan

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Contoh user manual
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'birth_date' => '2000-01-01',
            'gender' => 'male',
        ]);

        // Contoh pakai factory generate 10 user
        User::factory(10)->create();
    }
};