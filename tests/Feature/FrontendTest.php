<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // Welcome / Home
    // ---------------------------------------------------------------

    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // Contact
    // ---------------------------------------------------------------

    public function test_contact_page_loads(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // TU Info
    // ---------------------------------------------------------------

    public function test_tu_info_index_loads(): void
    {
        $response = $this->get('/tu-info');
        $response->assertStatus(200);
    }

    public function test_tu_info_show_loads_with_valid_slug(): void
    {
        $response = $this->get('/tu-info/bimal-chaudhary');
        $response->assertStatus(200);
    }

    public function test_tu_info_show_loads_with_unknown_slug(): void
    {
        // Unknown slugs fall back to a generated title — should still return 200
        $response = $this->get('/tu-info/some-unknown-person');
        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // OTP password reset — form pages
    // ---------------------------------------------------------------

    public function test_otp_form_page_loads(): void
    {
        $response = $this->get('/password/otp');
        $response->assertStatus(200);
    }
}
