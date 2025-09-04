<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mediaItems = [
            [
                'title' => 'BBC News',
                'image' => 'media/bbc-logo.png',
                'website_url' => 'https://www.bbc.com',
                'is_active' => true,
            ],
            [
                'title' => 'The Guardian',
                'image' => 'media/guardian-logo.png',
                'website_url' => 'https://www.theguardian.com',
                'is_active' => true,
            ],
        ];

        foreach ($mediaItems as $media) {
            // Create placeholder images if they don't exist
            if (!Storage::disk('public')->exists($media['image'])) {
                // Create a simple placeholder image using GD
                $image = imagecreate(200, 100);
                $bgColor = imagecolorallocate($image, 240, 240, 240);
                $textColor = imagecolorallocate($image, 100, 100, 100);

                // Fill background
                imagefill($image, 0, 0, $bgColor);

                // Add text
                imagestring($image, 5, 50, 40, $media['title'], $textColor);

                // Save image
                $path = storage_path('app/public/' . $media['image']);
                $dir = dirname($path);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                imagepng($image, $path);
                imagedestroy($image);
            }

            Media::create($media);
        }
    }
}
