<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@taraharautsav.com',
            'password' => Hash::make('P@ssw0rd123'),
            'role' => 'admin',
        ]);

        $this->call([
            AboutSeeder::class,
            SponsorSeeder::class,
            FestivalCategorySeeder::class,
            MediaSeeder::class,
        ]);
    }
}
