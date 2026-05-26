<?php

namespace Tests\Unit\Models;

use App\Models\About;
use Tests\TestCase;

class AboutTest extends TestCase
{
    /**
     * Test about page can be created
     */
    public function test_about_can_be_created(): void
    {
        $about = About::create([
            'title' => 'About Us',
            'content' => 'This is the about page content',
            'images' => ['about.jpg'],
        ]);

        $this->assertInstanceOf(About::class, $about);
        $this->assertEquals('About Us', $about->title);
        $this->assertEquals('This is the about page content', $about->content);
    }

    /**
     * Test about images are stored as array
     */
    public function test_about_images_cast_to_array(): void
    {
        $images = ['image1.jpg', 'image2.jpg', 'image3.jpg'];

        $about = About::create([
            'title' => 'Festival Info',
            'content' => 'Content here',
            'images' => $images,
        ]);

        $this->assertIsArray($about->images);
        $this->assertEquals($images, $about->images);
        $this->assertCount(3, $about->images);
    }

    /**
     * Test about can be updated
     */
    public function test_about_can_be_updated(): void
    {
        $about = About::create([
            'title' => 'Old Title',
            'content' => 'Old content',
            'images' => ['old.jpg'],
        ]);

        $about->update([
            'title' => 'New Title',
            'content' => 'New content',
            'images' => ['new.jpg', 'new2.jpg'],
        ]);

        $this->assertEquals('New Title', $about->title);
        $this->assertEquals('New content', $about->content);
        $this->assertCount(2, $about->images);
    }

    /**
     * Test about fillable attributes
     */
    public function test_about_fillable_attributes(): void
    {
        $fillable = ['title', 'content', 'images'];

        $this->assertEquals($fillable, (new About())->getFillable());
    }

    /**
     * Test about with minimal data
     */
    public function test_about_with_minimal_data(): void
    {
        $about = About::create([
            'title' => 'Minimal Title',
            'content' => 'Minimal content',
        ]);

        $this->assertEquals('Minimal Title', $about->title);
        $this->assertIsArray($about->images);
    }
}
