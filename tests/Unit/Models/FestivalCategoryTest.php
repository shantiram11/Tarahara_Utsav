<?php

namespace Tests\Unit\Models;

use App\Models\FestivalCategory;
use Tests\TestCase;

class FestivalCategoryTest extends TestCase
{
    /**
     * Test festival category can be created
     */
    public function test_festival_category_can_be_created(): void
    {
        $category = FestivalCategory::create([
            'title' => 'Music Festival',
            'description' => 'A celebration of music',
            'color_scheme' => 'blue',
            'is_active' => true,
        ]);

        $this->assertInstanceOf(FestivalCategory::class, $category);
        $this->assertEquals('Music Festival', $category->title);
        $this->assertTrue($category->is_active);
    }

    /**
     * Test festival category slug is auto-generated from title
     */
    public function test_festival_category_slug_auto_generated(): void
    {
        $category = FestivalCategory::create([
            'title' => 'Cultural Dance Festival',
            'description' => 'Traditional dance festival',
        ]);

        $this->assertEquals('cultural-dance-festival', $category->slug);
    }

    /**
     * Test festival category can have custom slug
     */
    public function test_festival_category_can_have_custom_slug(): void
    {
        $category = FestivalCategory::create([
            'title' => 'Art Festival',
            'description' => 'Art exhibition',
            'slug' => 'custom-slug',
        ]);

        $this->assertEquals('custom-slug', $category->slug);
    }

    /**
     * Test active scope only returns active categories
     */
    public function test_active_scope_filters_active_categories(): void
    {
        FestivalCategory::create([
            'title' => 'Active Festival',
            'is_active' => true,
        ]);

        FestivalCategory::create([
            'title' => 'Inactive Festival',
            'is_active' => false,
        ]);

        $activeCategories = FestivalCategory::active()->get();

        $this->assertCount(1, $activeCategories);
        $this->assertEquals('Active Festival', $activeCategories->first()->title);
    }

    /**
     * Test ordered scope returns categories by created_at descending
     */
    public function test_ordered_scope_orders_by_created_at(): void
    {
        $cat1 = FestivalCategory::create(['title' => 'First']);
        sleep(1);
        $cat2 = FestivalCategory::create(['title' => 'Second']);

        $orderedCategories = FestivalCategory::ordered()->get();

        $this->assertEquals('Second', $orderedCategories->first()->title);
        $this->assertEquals('First', $orderedCategories->last()->title);
    }

    /**
     * Test is_active is cast to boolean
     */
    public function test_is_active_cast_to_boolean(): void
    {
        $category = FestivalCategory::create([
            'title' => 'Boolean Test',
            'is_active' => true,
        ]);

        $this->assertIsBool($category->is_active);
        $this->assertTrue($category->is_active);
    }

    /**
     * Test festival category can be updated with new title and slug
     */
    public function test_festival_category_can_be_updated(): void
    {
        $category = FestivalCategory::create([
            'title' => 'Old Title',
            'description' => 'Old description',
        ]);

        $category->update([
            'title' => 'New Title',
            'description' => 'New description',
        ]);

        $this->assertEquals('New Title', $category->title);
        $this->assertEquals('new-title', $category->slug);
    }
}
