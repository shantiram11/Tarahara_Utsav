<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create if no About record exists
        if (About::count() === 0) {
            About::create([
                'title' => 'About Tarahara Utsav 2025',
                'content' => 'Tarahara Utsav 2025 is a vibrant cultural celebration that brings together communities, artists, and culinary talents who make a meaningful impact on our society and local economy. Over three inspiring days, the fair showcases music, dance, art, food, and craftsmanship—celebrating achievers and traditions that inspire future generations with excellence, creativity, and community spirit.',
                'images' => [] // Empty images array initially
            ]);

            $this->command->info('About section created successfully!');
        } else {
            $this->command->info('About section already exists.');
        }
    }
}
