<?php

namespace Tests\Unit\Models;

use App\Models\Hero;
use Tests\TestCase;

class HeroTest extends TestCase
{
    /**
     * Test hero can be created with description and images
     */
    public function test_hero_can_be_created(): void
    {
        $images = ['image1.jpg', 'image2.jpg'];

        $hero = Hero::create([
            'description' => 'Amazing festival event',
            'images' => $images,
        ]);

        $this->assertInstanceOf(Hero::class, $hero);
        $this->assertEquals('Amazing festival event', $hero->description);
    }

    /**
     * Test hero images are stored as array
     */
    public function test_hero_images_cast_to_array(): void
    {
        $images = ['hero1.jpg', 'hero2.jpg', 'hero3.jpg'];

        $hero = Hero::create([
            'description' => 'Test hero',
            'images' => $images,
        ]);

        $this->assertIsArray($hero->images);
        $this->assertEquals($images, $hero->images);
        $this->assertCount(3, $hero->images);
    }

    /**
     * Test hero can be updated
     */
    public function test_hero_can_be_updated(): void
    {
        $hero = Hero::create([
            'description' => 'Original description',
            'images' => ['old.jpg'],
        ]);

        $hero->update([
            'description' => 'Updated description',
            'images' => ['new1.jpg', 'new2.jpg'],
        ]);

        $this->assertEquals('Updated description', $hero->description);
        $this->assertCount(2, $hero->images);
    }

    /**
     * Test hero fillable attributes
     */
    public function test_hero_fillable_attributes(): void
    {
        $fillable = ['description', 'images'];

        $this->assertEquals($fillable, (new Hero())->getFillable());
    }

    /**
     * Test hero can have empty images array
     */
    public function test_hero_can_have_empty_images_array(): void
    {
        $hero = Hero::create([
            'description' => 'No images hero',
            'images' => [],
        ]);

        $this->assertIsArray($hero->images);
        $this->assertEmpty($hero->images);
    }
}
