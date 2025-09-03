<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FestivalCategory;
use Illuminate\Support\Facades\Storage;

class FestivalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Music & Dance',
                'description' => 'Traditional and contemporary performances showcasing diverse cultural expressions.',
                'image' => 'festival-categories/music-dance.jpg',
                'content' => 'Experience the soul of our festival through mesmerizing music and dance performances. From classical Indian music to contemporary fusion, our stage comes alive with talented artists who bring stories to life through rhythm and movement. Join us for an evening of cultural celebration that will leave you spellbound.',
                'color_scheme' => 'violet',
                'is_active' => true
            ],
            [
                'title' => 'Food Festival',
                'description' => 'Authentic cuisines from various cultures, cooking demonstrations, and tastings.',
                'image' => 'festival-categories/food-festival.jpg',
                'content' => 'Embark on a culinary journey through the rich flavors of our diverse community. Our food festival features authentic dishes from different cultures, live cooking demonstrations by master chefs, and interactive tasting sessions. From traditional street food to gourmet delicacies, satisfy your taste buds with an array of flavors that tell the story of our heritage.',
                'color_scheme' => 'rose',
                'is_active' => true
            ],
            [
                'title' => 'Arts & Crafts',
                'description' => 'Handmade creations, workshops, and exhibitions by local artisans.',
                'image' => 'festival-categories/arts-crafts.jpg',
                'content' => 'Discover the beauty of handmade artistry and traditional craftsmanship. Our arts and crafts section showcases the incredible talent of local artisans through live demonstrations, interactive workshops, and stunning exhibitions. Learn ancient techniques, create your own masterpieces, and take home unique treasures that celebrate the art of making.',
                'color_scheme' => 'emerald',
                'is_active' => true
            ],
            [
                'title' => 'Fashion & Textiles',
                'description' => 'Traditional clothing displays, fashion shows, and textile demonstrations.',
                'image' => 'festival-categories/fashion-textiles.jpg',
                'content' => 'Step into the world of fashion and textiles where tradition meets contemporary style. Witness stunning fashion shows featuring traditional and modern designs, explore textile demonstrations that showcase centuries-old weaving techniques, and admire the intricate details of handcrafted garments that represent our cultural heritage.',
                'color_scheme' => 'amber',
                'is_active' => true
            ],
            [
                'title' => 'Competitions',
                'description' => 'Cultural contests, talent shows, and interactive challenges for all ages.',
                'image' => 'festival-categories/competitions.jpg',
                'content' => 'Join the excitement of our cultural competitions and talent shows! From traditional dance competitions to modern talent showcases, we have something for everyone. Participate in interactive challenges, cheer for your favorites, and celebrate the incredible talent within our community. Prizes and recognition await the winners!',
                'color_scheme' => 'indigo',
                'is_active' => true
            ],
            [
                'title' => 'Community Events',
                'description' => 'Family activities, workshops, and collaborative cultural experiences.',
                'image' => 'festival-categories/community-events.jpg',
                'content' => 'Connect with your community through engaging family activities and collaborative experiences. Our community events include interactive workshops, cultural games, storytelling sessions, and collaborative art projects that bring people together. Create lasting memories while learning about different cultures and traditions in a fun, inclusive environment.',
                'color_scheme' => 'pink',
                'is_active' => true
            ]
        ];

        foreach ($categories as $categoryData) {
            FestivalCategory::create($categoryData);
        }
    }
}