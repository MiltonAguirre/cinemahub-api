<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieTest extends TestCase
{
    public function testMovies()
    {
        $this->seed();
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

        $data = [
            'title' => 'The Shawshank Redemption',
            'director_id' => 1,
            'categories_id' => [1, 3],
            'actors_id' => [1, 2, 3],
            'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
            'year' => 1994,
            'duration' => '142 min',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST','/api/movies', $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'title',
                     'director_id',
                     'description',
                     'year',
                     'duration',
                 ]);

        // Get movies
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/movies')->assertStatus(200);
        $response->assertJsonStructure([ 
            '*' => [
                'id',
                'title',
                'director_id',
                'description',
                'year',
                'duration',
                'created_at', 
                'updated_at', 
                'director', 
                'actors', 
                'categories',
            ]                
        ]);
    }
}
