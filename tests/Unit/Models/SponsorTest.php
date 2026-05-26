<?php

namespace Tests\Unit\Models;

use App\Models\Sponsor;
use Tests\TestCase;

class SponsorTest extends TestCase
{
    /**
     * Test sponsor can be created with all attributes
     */
    public function test_sponsor_can_be_created(): void
    {
        $sponsor = Sponsor::create([
            'title' => 'Tech Company',
            'image' => 'logo.png',
            'amount' => 50000,
            'label' => 'Gold Sponsor',
            'tier' => 'gold',
            'website_url' => 'https://techcompany.com',
            'is_active' => true,
        ]);

        $this->assertInstanceOf(Sponsor::class, $sponsor);
        $this->assertEquals('Tech Company', $sponsor->title);
        $this->assertEquals(50000, $sponsor->amount);
        $this->assertEquals('gold', $sponsor->tier);
    }

    /**
     * Test sponsor is_active is cast to boolean
     */
    public function test_sponsor_is_active_cast_to_boolean(): void
    {
        $sponsor = Sponsor::create([
            'title' => 'Sponsor',
            'is_active' => true,
        ]);

        $this->assertIsBool($sponsor->is_active);
        $this->assertTrue($sponsor->is_active);
    }

    /**
     * Test active scope only returns active sponsors
     */
    public function test_active_scope_filters_active_sponsors(): void
    {
        Sponsor::create([
            'title' => 'Active Sponsor',
            'is_active' => true,
        ]);

        Sponsor::create([
            'title' => 'Inactive Sponsor',
            'is_active' => false,
        ]);

        $activeSponsor = Sponsor::active()->get();

        $this->assertCount(1, $activeSponsor);
        $this->assertEquals('Active Sponsor', $activeSponsor->first()->title);
    }

    /**
     * Test byTier scope filters sponsors by tier
     */
    public function test_by_tier_scope_filters_by_tier(): void
    {
        Sponsor::create([
            'title' => 'Gold Sponsor',
            'tier' => 'gold',
        ]);

        Sponsor::create([
            'title' => 'Silver Sponsor',
            'tier' => 'silver',
        ]);

        Sponsor::create([
            'title' => 'Another Gold',
            'tier' => 'gold',
        ]);

        $goldSponsors = Sponsor::byTier('gold')->get();

        $this->assertCount(2, $goldSponsors);
        $goldSponsors->each(function ($sponsor) {
            $this->assertEquals('gold', $sponsor->tier);
        });
    }

    /**
     * Test sponsor can be updated
     */
    public function test_sponsor_can_be_updated(): void
    {
        $sponsor = Sponsor::create([
            'title' => 'Old Company',
            'amount' => 10000,
            'tier' => 'bronze',
        ]);

        $sponsor->update([
            'title' => 'Updated Company',
            'amount' => 25000,
            'tier' => 'silver',
        ]);

        $this->assertEquals('Updated Company', $sponsor->title);
        $this->assertEquals(25000, $sponsor->amount);
        $this->assertEquals('silver', $sponsor->tier);
    }

    /**
     * Test sponsor fillable attributes
     */
    public function test_sponsor_fillable_attributes(): void
    {
        $fillable = ['title', 'image', 'amount', 'label', 'tier', 'website_url', 'is_active'];

        $this->assertEquals($fillable, (new Sponsor())->getFillable());
    }

    /**
     * Test combining active and byTier scopes
     */
    public function test_combining_active_and_by_tier_scopes(): void
    {
        Sponsor::create([
            'title' => 'Active Gold',
            'tier' => 'gold',
            'is_active' => true,
        ]);

        Sponsor::create([
            'title' => 'Inactive Gold',
            'tier' => 'gold',
            'is_active' => false,
        ]);

        $activeGoldSponsors = Sponsor::active()->byTier('gold')->get();

        $this->assertCount(1, $activeGoldSponsors);
        $this->assertEquals('Active Gold', $activeGoldSponsors->first()->title);
    }
}
