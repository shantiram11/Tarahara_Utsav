<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\About;
use App\Models\Sponsor;
use App\Models\Media;
use App\Models\EventHighlight;
use App\Models\Advertisement;
use App\Models\FestivalCategory;
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
     * Get media coverage data for frontend display
     *
     * @return array
     */
    public function getMediaData()
    {
        try {
            $items = Media::active()->ordered()->get();

            $data = [
                'hasMedia' => $items->isNotEmpty(),
                'items' => [],
                'fallbackItems' => [
                    ['title' => 'Media 1', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 2', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 3', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 4', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 5', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 6', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                ],
            ];

            if ($items->isNotEmpty()) {
                $data['items'] = $items->map(function ($item) {
                    return [
                        'title' => $item->title,
                        'image' => Storage::url($item->image),
                        'website_url' => $item->website_url,
                    ];
                })->toArray();
            }

            return $data;
        } catch (\Exception $e) {
            \Log::error('Error fetching media data: ' . $e->getMessage());
            return [
                'hasMedia' => false,
                'items' => [],
                'fallbackItems' => [
                    ['title' => 'Media 1', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 2', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 3', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 4', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 5', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                    ['title' => 'Media 6', 'image' => asset('assets/Logo.png'), 'website_url' => null],
                ],
            ];
        }
    }

    /**
     * Get event highlights data for frontend display
     *
     * @return array
     */
    public function getEventHighlightsData()
    {
        try {
            $highlights = EventHighlight::active()->ordered()->get();

            $data = [
                'hasHighlights' => $highlights->isNotEmpty(),
                'highlights' => [],
                'fallbackHighlights' => [
                    [
                        'title' => 'Grand Opening Ceremony',
                        'description' => 'Spectacular inaugural event featuring cultural performances and community leaders.',
                        'date' => 'December 15, 2025',
                        'icon' => '⭐',
                        'color_scheme' => 'amber'
                    ],
                    [
                        'title' => 'Cultural Parade',
                        'description' => 'Vibrant procession showcasing traditional costumes, music, and dance from all cultures.',
                        'date' => 'December 16, 2025',
                        'icon' => '🚩',
                        'color_scheme' => 'emerald'
                    ],
                    [
                        'title' => 'Master Chef Competitions',
                        'description' => 'Culinary showdown featuring the best chefs competing in traditional cooking challenges.',
                        'date' => 'December 17, 2025',
                        'icon' => '👨‍🍳',
                        'color_scheme' => 'rose'
                    ],
                ],
            ];

            if ($highlights->isNotEmpty()) {
                $data['highlights'] = $highlights->map(function ($highlight) {
                    return [
                        'title' => $highlight->title,
                        'description' => $highlight->description,
                        'date' => $highlight->date,
                        'icon' => $highlight->icon,
                        'color_scheme' => $highlight->color_scheme,
                    ];
                })->toArray();
            }

            return $data;
        } catch (\Exception $e) {
            \Log::error('Error fetching event highlights data: ' . $e->getMessage());
            return [
                'hasHighlights' => false,
                'highlights' => [],
                'fallbackHighlights' => [
                    [
                        'title' => 'Grand Opening Ceremony',
                        'description' => 'Spectacular inaugural event featuring cultural performances and community leaders.',
                        'date' => 'December 15, 2025',
                        'icon' => '⭐',
                        'color_scheme' => 'amber'
                    ],
                    [
                        'title' => 'Cultural Parade',
                        'description' => 'Vibrant procession showcasing traditional costumes, music, and dance from all cultures.',
                        'date' => 'December 16, 2025',
                        'icon' => '🚩',
                        'color_scheme' => 'emerald'
                    ],
                    [
                        'title' => 'Master Chef Competitions',
                        'description' => 'Culinary showdown featuring the best chefs competing in traditional cooking challenges.',
                        'date' => 'December 17, 2025',
                        'icon' => '👨‍🍳',
                        'color_scheme' => 'rose'
                    ],
                ],
            ];
        }
    }

    /**
     * Get advertisements data for frontend display
     *
     * @param array $positions Array of positions to include (default: all positions)
     * @return array
     */
    public function getAdvertisementsData($positions = ['top', 'bottom', 'sidebar', 'below_hero'])
    {
        try {
            $advertisements = Advertisement::currentlyActive()->ordered()->get();

            $data = [
                'top' => [],
                'bottom' => [],
                'sidebar' => [],
                'below_hero' => [],
            ];

            if ($advertisements->isNotEmpty()) {
                $grouped = $advertisements->groupBy('position');

                foreach ($positions as $position) {
                    if (in_array($position, ['top', 'bottom', 'sidebar', 'below_hero'])) {
                        $data[$position] = $grouped->get($position, collect())->map(function ($ad) {
                            return [
                                'id' => $ad->id,
                                'title' => $ad->title,
                                'image' => Storage::url($ad->image),
                                'link_url' => $ad->link_url,
                                'position' => $ad->position,
                            ];
                        })->toArray();
                    }
                }
            }

            return $data;
        } catch (\Exception $e) {
            \Log::error('Error fetching advertisements data: ' . $e->getMessage());
            return [
                'top' => [],
                'bottom' => [],
                'sidebar' => [],
                'below_hero' => [],
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
        $mediaData = $this->getMediaData();
        $eventHighlightsData = $this->getEventHighlightsData();
        $advertisementsData = $this->getAdvertisementsData(['top', 'below_hero', 'bottom']); // Include below_hero on home page
        $festivalCategoriesData = $this->getFestivalCategoriesData();

        // we can add caching here for better performance
        // $heroData = Cache::remember('hero_data', 300, function () {
        //     return $this->getHeroData();
        // });

        return view('frontend.index', compact('heroData', 'aboutData', 'sponsorData', 'mediaData', 'eventHighlightsData', 'advertisementsData', 'festivalCategoriesData'));
    }

    /**
     * Get festival categories data for frontend display
     *
     * @return array
     */
    public function getFestivalCategoriesData()
    {
        try {
            $categories = FestivalCategory::active()->ordered()->get();

            $data = [
                'hasCategories' => $categories->isNotEmpty(),
                'categories' => []
            ];

            if ($categories->isNotEmpty()) {
                $data['categories'] = $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'title' => $category->title,
                        'description' => $category->description,
                        'image' => Storage::url($category->image),
                        'slug' => $category->slug,
                        'color_scheme' => $category->color_scheme,
                        'has_content' => !empty($category->content)
                    ];
                })->toArray();
            }

            return $data;
        } catch (\Exception $e) {
            \Log::error('Error fetching festival categories data: ' . $e->getMessage());
            return [
                'hasCategories' => false,
                'categories' => []
            ];
        }
    }

    /**
     * Show festival category detail page
     */
    public function showFestivalCategory(FestivalCategory $festivalCategory)
    {
        if (!$festivalCategory->is_active) {
            abort(404);
        }

        // Get related categories (excluding current one)
        $relatedCategories = FestivalCategory::active()
            ->where('id', '!=', $festivalCategory->id)
            ->ordered()
            ->limit(3)
            ->get();

        // Get advertisement data
        $advertisementsData = $this->getAdvertisementsData(['bottom', 'sidebar']); // Only bottom and sidebar ads for detail page

        return view('frontend.festival-category-detail', compact('festivalCategory', 'relatedCategories', 'advertisementsData'));
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('frontend.contact');
    }
}
