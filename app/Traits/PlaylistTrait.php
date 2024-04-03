<?php

namespace App\Traits;

use App\Models\PlaylistSong;

trait PlaylistTrait
{
    public function getLastSongOrder($playlist_id): int
    {
        $last_song = PlaylistSong::select(['song_id', 'order'])->where('playlist_id', $playlist_id)->latest()->first();

        return !empty($last_song) ? $last_song->order : 0;
    }
}
