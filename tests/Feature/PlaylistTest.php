<?php

namespace Tests\Feature;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaylistTest extends TestCase
{
    use RefreshDatabase, WithFaker;
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

    /**
     * Test song creation
     */
    public function test_can_create_song(): void
    {
        $response = $this->json('POST', '/api/v1/songs/create', [
            'song_name' => 'Test Song',
            'song_duration' => '1:32',
            'artist_name' => 'Test Artist'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test if the song can be added in the playlist
     */
    public function test_can_song_be_added_in_playlist(): void
    {
        $playlist = Playlist::create([
            'playlist_name' => $this->faker()->name,
            'user_id' => 1
        ]);

        $sample_song = Song::create([
            'song_name' => $this->faker()->name,
            'artist_name' => $this->faker()->name,
            'song_duration' => '1:23'
        ]);

        $response = $this->json('PUT', '/api/v1/playlist/add/song/' . $playlist->id . '/' . $sample_song->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message'
        ]);
    }

    /**
     * Test if the song can be removed in the playlist
     */
    public function test_can_song_be_removed_in_playlist(): void
    {
        $playlist = Playlist::create([
            'playlist_name' => $this->faker()->name,
            'user_id' => 1
        ]);

        $sample_song = Song::create([
            'song_name' => $this->faker()->name,
            'artist_name' => $this->faker()->name,
            'song_duration' => '1:23'
        ]);

        //add the song first
        $this->json('PUT', '/api/v1/playlist/add/song/' . $playlist->id . '/' . $sample_song->id);

        //remove the song
        $response = $this->json('PUT', '/api/v1/playlist/remove/song/' . $playlist->id . '/' . $sample_song->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message'
        ]);
    }
}
