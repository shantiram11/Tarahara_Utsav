<?php

namespace Tests\Feature;

use App\Mail\PasswordOtpMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordOtpTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // sendOtp
    // ---------------------------------------------------------------

    public function test_send_otp_fails_validation_without_email(): void
    {
        $response = $this->post('/password/otp/send', []);
        $response->assertSessionHasErrors('email');
    }

    public function test_send_otp_fails_with_invalid_email_format(): void
    {
        $response = $this->post('/password/otp/send', ['email' => 'not-an-email']);
        $response->assertSessionHasErrors('email');
    }

    public function test_send_otp_fails_when_user_not_found(): void
    {
        $response = $this->post('/password/otp/send', ['email' => 'nobody@example.com']);
        $response->assertSessionHasErrors('email');
    }

    public function test_send_otp_succeeds_and_sends_mail_for_existing_user(): void
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->post('/password/otp/send', ['email' => 'user@example.com']);

        $response->assertRedirect(route('password.otp.form'));
        $response->assertSessionHas('status');
        Mail::assertSent(PasswordOtpMail::class, fn ($mail) => $mail->hasTo('user@example.com'));
    }

    public function test_send_otp_stores_otp_in_session(): void
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->post('/password/otp/send', ['email' => 'user@example.com']);

        $response->assertSessionHas('password_otp');
        $sessionData = session('password_otp');
        $this->assertEquals('user@example.com', $sessionData['email']);
        $this->assertArrayHasKey('otp', $sessionData);
        $this->assertArrayHasKey('expires_at', $sessionData);
    }

    public function test_send_otp_is_case_insensitive_for_email(): void
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->post('/password/otp/send', ['email' => 'USER@EXAMPLE.COM']);

        $response->assertRedirect(route('password.otp.form'));
    }

    // ---------------------------------------------------------------
    // verifyOtp
    // ---------------------------------------------------------------

    public function test_verify_otp_fails_without_otp_field(): void
    {
        $response = $this->post('/password/otp/verify', []);
        $response->assertSessionHasErrors('otp');
    }

    public function test_verify_otp_fails_with_non_digit_otp(): void
    {
        $response = $this->post('/password/otp/verify', ['otp' => 'abcdef']);
        $response->assertSessionHasErrors('otp');
    }

    public function test_verify_otp_fails_with_wrong_length(): void
    {
        $response = $this->post('/password/otp/verify', ['otp' => '123']);
        $response->assertSessionHasErrors('otp');
    }

    public function test_verify_otp_fails_when_no_session_exists(): void
    {
        $response = $this->post('/password/otp/verify', ['otp' => '123456']);
        $response->assertSessionHasErrors('otp');
    }

    public function test_verify_otp_fails_with_wrong_otp(): void
    {
        $this->withSession([
            'password_otp' => [
                'email'      => 'user@example.com',
                'otp'        => '999999',
                'expires_at' => now()->addMinutes(10),
            ],
        ]);

        $response = $this->post('/password/otp/verify', ['otp' => '123456']);
        $response->assertSessionHasErrors('otp');
    }

    public function test_verify_otp_fails_when_expired(): void
    {
        $this->withSession([
            'password_otp' => [
                'email'      => 'user@example.com',
                'otp'        => '123456',
                'expires_at' => now()->subMinutes(1), // already expired
            ],
        ]);

        $response = $this->post('/password/otp/verify', ['otp' => '123456']);
        $response->assertSessionHasErrors('otp');
    }

    public function test_verify_otp_succeeds_with_correct_otp(): void
    {
        $this->withSession([
            'password_otp' => [
                'email'      => 'user@example.com',
                'otp'        => '123456',
                'expires_at' => now()->addMinutes(10),
            ],
        ]);

        $response = $this->post('/password/otp/verify', ['otp' => '123456']);

        $response->assertRedirect(route('password.otp.reset.form'));
        $response->assertSessionHas('password_otp_verified', true);
    }

    // ---------------------------------------------------------------
    // showResetForm
    // ---------------------------------------------------------------

    public function test_reset_form_redirects_without_verified_session(): void
    {
        $response = $this->get('/password/otp/reset');
        $response->assertRedirect(route('password.otp.form'));
    }

    public function test_reset_form_loads_with_valid_session(): void
    {
        $response = $this->withSession([
            'password_otp'          => ['email' => 'user@example.com', 'otp' => '123456', 'expires_at' => now()->addMinutes(10)],
            'password_otp_verified' => true,
        ])->get('/password/otp/reset');

        $response->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // resetWithOtp
    // ---------------------------------------------------------------

    public function test_reset_password_fails_without_verified_session(): void
    {
        $response = $this->post('/password/otp/reset', [
            'password'              => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);
        $response->assertRedirect(route('password.otp.form'));
    }

    public function test_reset_password_fails_validation_without_password(): void
    {
        $this->withSession([
            'password_otp'          => ['email' => 'user@example.com', 'otp' => '123456', 'expires_at' => now()->addMinutes(10)],
            'password_otp_verified' => true,
        ]);

        $response = $this->post('/password/otp/reset', []);
        $response->assertSessionHasErrors('password');
    }

    public function test_reset_password_fails_when_passwords_dont_match(): void
    {
        $this->withSession([
            'password_otp'          => ['email' => 'user@example.com', 'otp' => '123456', 'expires_at' => now()->addMinutes(10)],
            'password_otp_verified' => true,
        ]);

        $response = $this->post('/password/otp/reset', [
            'password'              => 'newpassword',
            'password_confirmation' => 'differentpassword',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_reset_password_fails_when_password_too_short(): void
    {
        $this->withSession([
            'password_otp'          => ['email' => 'user@example.com', 'otp' => '123456', 'expires_at' => now()->addMinutes(10)],
            'password_otp_verified' => true,
        ]);

        $response = $this->post('/password/otp/reset', [
            'password'              => 'short',
            'password_confirmation' => 'short',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function test_reset_password_succeeds_and_updates_user(): void
    {
        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->withSession([
            'password_otp'          => ['email' => 'user@example.com', 'otp' => '123456', 'expires_at' => now()->addMinutes(10)],
            'password_otp_verified' => true,
        ])->post('/password/otp/reset', [
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');

        // Verify password was actually changed
        $user->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $user->password));
    }

    public function test_reset_password_clears_session_after_success(): void
    {
        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->withSession([
            'password_otp'          => ['email' => 'user@example.com', 'otp' => '123456', 'expires_at' => now()->addMinutes(10)],
            'password_otp_verified' => true,
        ])->post('/password/otp/reset', [
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionMissing('password_otp');
        $response->assertSessionMissing('password_otp_verified');
    }
}
