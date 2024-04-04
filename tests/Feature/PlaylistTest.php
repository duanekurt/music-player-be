<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaylistTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    protected function setUp(): void
    {
        parent::setUp();
        // set your headers here
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getBearerToken(),
            'Accept' => 'application/json'
        ]);
    }

    protected function getBearerToken()
    {
        $response = $this->json('POST', 'api/v1/user/login', [
            'email' => 'admin@example.com',
            'password' => 'test123'
        ]);

        return $response->json()['token'];
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test Playlist getSongs
     */
    public function test_get_playlist_songs(): void
    {
        $response = $this->get('/api/v1/playlist/songs');
        $response->assertJsonStructure(
            [
                'data' => [
                    'playlist' => [
                        'id',
                        'playlist_name',
                        'user_id',
                        'created_at',
                        'updated_at',
                        'songs' => [
                            [
                                'id',
                                'artist_name',
                                'song_name',
                                'song_duration',
                                'song_status',
                                'created_at',
                                'updated_at',
                                'pivot' => [
                                    'order',
                                    'state',
                                    'song_id',
                                    'playlist_id'
                                ]
                            ]
                        ]
                    ],
                ],
                'message'
            ]
        );
        $response->assertStatus(200);
    }

    public function test_can_create_song(): void
    {
        $response = $this->json('POST', '/api/v1/songs/create', [
            'song_name' => 'Test Song',
            'song_duration' => '1:32',
            'artist_name' => 'Test Artist'
        ]);

        $response->assertStatus(200);
    }
}
