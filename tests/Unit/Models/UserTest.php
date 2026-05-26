<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user can be created with required attributes
     */
    public function test_user_can_be_created(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('admin', $user->role);
    }

    /**
     * Test user password is hashed
     */
    public function test_user_password_is_hashed(): void
    {
        $plainPassword = 'secret123';

        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => $plainPassword,
        ]);

        $this->assertTrue(Hash::check($plainPassword, $user->password));
        $this->assertNotEquals($plainPassword, $user->password);
    }

    /**
     * Test user password is hidden in serialization
     */
    public function test_user_password_hidden_in_serialization(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $userData = $user->toArray();
        $this->assertArrayNotHasKey('password', $userData);
    }

    /**
     * Test user fillable attributes
     */
    public function test_user_fillable_attributes(): void
    {
        $fillable = ['name', 'email', 'password', 'role'];

        $this->assertEquals($fillable, User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'pass',
        ])->getFillable());
    }

    /**
     * Test user with different roles
     */
    public function test_user_can_have_different_roles(): void
    {
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $guestUser = User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => 'password',
            'role' => 'guest',
        ]);

        $this->assertEquals('admin', $adminUser->role);
        $this->assertEquals('guest', $guestUser->role);
    }
}
