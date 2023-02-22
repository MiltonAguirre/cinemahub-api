<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserAuthentication()
    {
        // Create a test user with email and password
        $user = User::factory()->create([
            'name' => 'UnitTest User',
            'email' => 'user@unittest.com',
        ]);
        // Send a POST request to /api/login with email and password
        $response = $this->json('POST', '/api/auth/login', [
            'email' => 'user@unittest.com',
            'password' => 'password',
        ])->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'user',
                'authorization' => [
                    'token',
                    'type'
                ]
            ]);

        $token = $response['authorization']['token'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/auth/refresh');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'user',
                    'authorization' => [
                        'token',
                        'type'
                    ]
                ]);
    }
}
