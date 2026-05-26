<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // Unauthenticated access
    // ---------------------------------------------------------------

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_admin_users(): void
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_admin_heroes(): void
    {
        $response = $this->get('/admin/heroes');
        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_admin_sponsors(): void
    {
        $response = $this->get('/admin/sponsors');
        $response->assertRedirect('/login');
    }

    // ---------------------------------------------------------------
    // Non-admin (regular user) access
    // ---------------------------------------------------------------

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin');
        // Should be forbidden (403) or redirected away
        $response->assertStatus(403);
    }

    public function test_regular_user_cannot_access_admin_users_list(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403);
    }

    // ---------------------------------------------------------------
    // Admin access
    // ---------------------------------------------------------------

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_users_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_heroes_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/heroes');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_sponsors_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/sponsors');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_media_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/media');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_event_highlights_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/event-highlights');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_advertisements_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/advertisements');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_festival_categories_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/festival-categories');
        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // User model helpers
    // ---------------------------------------------------------------

    public function test_user_is_admin_returns_true_for_admin_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isUser());
    }

    public function test_user_is_user_returns_true_for_user_role(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_has_role_returns_correct_result(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertFalse($admin->hasRole('user'));
    }
}
