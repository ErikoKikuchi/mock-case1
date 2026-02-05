<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout()
        {
            $user = User::factory()->create([
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ]);
            $this->post('/login',
                [
                    'email' => 'user@example.com',
                    'password' => 'password',
                ]
            );
            $this->assertAuthenticatedAs($user);

            $response = $this->post('/logout');
            $this->assertGuest();
            $response->assertRedirect('/login');
        }
}