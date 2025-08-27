<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\About;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
        /**
     * Get hero data for frontend display
     *
     * @return array
     */
    public function getHeroData()
    {
        try {

            //get all hero data
            $hero = Hero::latest()->first();
            //this is fallback data
            $data = [
                'hasImages' => false,
                'description' => 'From soulful music to savory bites, this festival is a colorful journey through community, creativity, and culture!',
                'images' => [],
                'fallbackImages' => [
                    asset('assets/art exhibation.jpg'),
                    asset('assets/Live performance.png'),
                    asset('assets/food stalls.png'),
                    asset('assets/culture.png')
                ]
            ];

            if ($hero && !empty($hero->images)) {
                $data['hasImages'] = true;
                $data['description'] = $hero->description ?: $data['description'];
                $data['images'] = collect($hero->images)
                    ->filter() // Remove any null/empty values
                    ->map(fn($path) => Storage::url($path))
                    ->values() // Re-index array to ensure sequential keys
                    ->toArray();
            }

            return $data;
        } catch (\Exception $e) {
            // Log error and return fallback data
            \Log::error('Error fetching hero data: ' . $e->getMessage());
            return $data;
        }
    }

    /**
     * Get about data for frontend display
     *
     * @return array
     */
        public function getAboutData()
    {
        try {
            $about = About::first();
            $data = [
                'title' => 'About Tarahara Utsav',
                'content' => 'Tarahara Utsav 2025 is a vibrant cultural celebration that brings together communities, artists, and culinary talents who make a meaningful impact on our society and local economy. Over three inspiring days, the fair showcases music, dance, art, food, and craftsmanship—celebrating achievers and traditions that inspire future generations with excellence, creativity, and community spirit.',
                'images' => [],
                'hasImages' => false,
                'fallbackImages' => [
                    asset('assets/art exhibation.jpg'),
                    asset('assets/Live performance.png'),
                    asset('assets/food stalls.png'),
                    asset('assets/culture.png')
                ]
            ];

            if ($about) {
                $data['title'] = $about->title ?: $data['title'];
                $data['content'] = $about->content ?: $data['content'];

                if (!empty($about->images)) {
                    $data['hasImages'] = true;
                    $data['images'] = collect($about->images)
                        ->filter() // Remove any null/empty values
                        ->map(fn($path) => Storage::url($path))
                        ->values() // Re-index array to ensure sequential keys
                        ->toArray();
                }
            }

            return $data;
        } catch (\Exception $e) {
            // Log error and return fallback data
            \Log::error('Error fetching about data: ' . $e->getMessage());
            return $data;
        }
    }

    /**
     * Show the home page
     */
    public function home()
    {
        $heroData = $this->getHeroData();
        $aboutData = $this->getAboutData();

        // we can add caching here for better performance
        // $heroData = Cache::remember('hero_data', 300, function () {
        //     return $this->getHeroData();
        // });

        return view('frontend.index', compact('heroData', 'aboutData'));
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('frontend.contact');
    }
}
