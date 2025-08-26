<?php

namespace App\Http\Controllers;

use App\Models\Hero;
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
                    ->toArray();
            }

            return $data;
        } catch (\Exception $e) {
            // Log error and return fallback data
            \Log::error('Error fetching hero data: ' . $e->getMessage());
        }
    }

    /**
     * Show the home page
     */
    public function home()
    {
        $heroData = $this->getHeroData();

        // we can add caching here for better performance
        // $heroData = Cache::remember('hero_data', 300, function () {
        //     return $this->getHeroData();
        // });

        return view('frontend.index', compact('heroData'));
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('frontend.contact');
    }
}
