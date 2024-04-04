<?php

namespace Database\Seeders;

use App\Models\Playlist;
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
            ['song_name' => 'Song 1', 'artist_name' => 'Artist 1', 'duration' => '1:23'],
            ['song_name' => 'Song 2', 'artist_name' => 'Artist 1', 'duration' => '1:23'],
            ['song_name' => 'Song 3', 'artist_name' => 'Artist 1', 'duration' => '1:23'],
            ['song_name' => 'Song 4', 'artist_name' => 'Artist 2', 'duration' => '1:23'],
            ['song_name' => 'Song 5', 'artist_name' => 'Artist 2', 'duration' => '1:23'],
            ['song_name' => 'Song 6', 'artist_name' => 'Artist 3', 'duration' => '1:23'],
            ['song_name' => 'Song 7', 'artist_name' => 'Artist 4', 'duration' => '1:23'],
            ['song_name' => 'Song 8', 'artist_name' => 'Artist 5', 'duration' => '1:23'],
            ['song_name' => 'Song 9', 'artist_name' => 'Artist 6', 'duration' => '1:23'],
            ['song_name' => 'Song 10', 'artist_name' => 'Artist 7', 'duration' => '1:23']
        ];

        Song::create($songs);

        foreach ($songs as $song) {
            $playlist = Playlist::latest()->first();
            $playlist->addSong($playlist->id, $song['id']);
        }
    }
}
