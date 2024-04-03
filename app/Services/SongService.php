<?php

namespace App\Services;

use App\Interfaces\Services\SongServiceInterface;
use App\Models\Song;
use Illuminate\Http\Request;

class SongService implements SongServiceInterface
{
    /**
     * Adds a song to the database
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $song = Song::create([
            'artist_name' => $request->artist_name,
            'song_name' => $request->song_name,
            'song_duration' => $request->song_duration
        ]);

        return ['song' => $song];
    }

}
