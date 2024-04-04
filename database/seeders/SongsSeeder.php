<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\PlaylistSong;
use App\Models\Song;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SongsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $songs = [
            ['song_name' => 'Song 1', 'artist_name' => 'Artist 1', 'song_duration' => '1:23'],
            ['song_name' => 'Song 2', 'artist_name' => 'Artist 1', 'song_duration' => '1:23'],
            ['song_name' => 'Song 3', 'artist_name' => 'Artist 1', 'song_duration' => '1:23'],
            ['song_name' => 'Song 4', 'artist_name' => 'Artist 2', 'song_duration' => '1:23'],
            ['song_name' => 'Song 5', 'artist_name' => 'Artist 2', 'song_duration' => '1:23'],
            ['song_name' => 'Song 6', 'artist_name' => 'Artist 3', 'song_duration' => '1:23'],
            ['song_name' => 'Song 7', 'artist_name' => 'Artist 4', 'song_duration' => '1:23'],
            ['song_name' => 'Song 8', 'artist_name' => 'Artist 5', 'song_duration' => '1:23'],
            ['song_name' => 'Song 9', 'artist_name' => 'Artist 6', 'song_duration' => '1:23'],
            ['song_name' => 'Song 10', 'artist_name' => 'Artist 7', 'song_duration' => '1:23']
        ];

        Song::insert($songs);

        //insert songs inside the playlist

        $db_songs = Song::all();
        $playlist = Playlist::latest()->first();
        $order = 1;
        foreach ($db_songs as $song) {
            PlaylistSong::create([
                'playlist_id' => $playlist->id,
                'song_id' => $song->id,
                'order' => $order++
            ]);
        }
    }
}
