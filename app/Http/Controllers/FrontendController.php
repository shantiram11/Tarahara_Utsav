<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\About;
use App\Models\Sponsor;
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
     * Get sponsor data for frontend display
     *
     * @return array
     */
    public function getSponsorData()
    {
        try {
            $sponsors = Sponsor::active()->latest()->get();

            $data = [
                'tier1' => [],
                'tier2' => [],
                'hasSponsors' => false,
                'fallbackSponsors' => [
                    'tier1' => [
                        ['title' => 'Premium Sponsor 1', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Premium Sponsor 2', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Premium Sponsor 3', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Premium Sponsor 4', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ],
                    'tier2' => [
                        ['title' => 'Standard Sponsor 1', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 2', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 3', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 4', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 5', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 6', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ]
                ]
            ];

            if ($sponsors->isNotEmpty()) {
                $data['hasSponsors'] = true;

                $data['tier1'] = $sponsors->where('tier', 'tier1')
                    ->map(function($sponsor) {
                        return [
                            'title' => $sponsor->title,
                            'image' => Storage::url($sponsor->image),
                            'website_url' => $sponsor->website_url,
                            'added_date' => $sponsor->created_at->format('M d, Y')
                        ];
                    })
                    ->values()
                    ->toArray();

                $data['tier2'] = $sponsors->where('tier', 'tier2')
                    ->map(function($sponsor) {
                        return [
                            'title' => $sponsor->title,
                            'image' => Storage::url($sponsor->image),
                            'website_url' => $sponsor->website_url,
                            'added_date' => $sponsor->created_at->format('M d, Y')
                        ];
                    })
                    ->values()
                    ->toArray();
            }

            return $data;
        } catch (\Exception $e) {
            // Log error and return fallback data
            \Log::error('Error fetching sponsor data: ' . $e->getMessage());
            return [
                'tier1' => [],
                'tier2' => [],
                'hasSponsors' => false,
                'fallbackSponsors' => [
                    'tier1' => [
                        ['title' => 'Premium Sponsor 1', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Premium Sponsor 2', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Premium Sponsor 3', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Premium Sponsor 4', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ],
                    'tier2' => [
                        ['title' => 'Standard Sponsor 1', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 2', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 3', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 4', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 5', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                        ['title' => 'Standard Sponsor 6', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ]
                ]
            ];
        }
    }

    /**
     * Show the home page
     */
    public function home()
    {
        $heroData = $this->getHeroData();
        $aboutData = $this->getAboutData();
        $sponsorData = $this->getSponsorData();

        // we can add caching here for better performance
        // $heroData = Cache::remember('hero_data', 300, function () {
        //     return $this->getHeroData();
        // });

        return view('frontend.index', compact('heroData', 'aboutData', 'sponsorData'));
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('frontend.contact');
    }
}
