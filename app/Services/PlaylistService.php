<?php

namespace App\Services;

use App\Interfaces\Services\PlaylistServiceInterface;
use App\Models\Playlist;
use App\Models\PlaylistHistory;
use App\Models\PlaylistSong;
use App\Traits\PlaylistTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistService implements PlaylistServiceInterface
{
    use PlaylistTrait;

    public function index()
    {
        // use the first playlist from seeder (since it will be just for testing)
        $playlist = Playlist::with('songs')->first();
        return ['playlist' => $playlist];
    }

    public function create(Request $request)
    {
        $playlist = Playlist::create([
            'playlist_name' => $request->playlist_name,
            'user_id' => Auth::user()->id,
        ]);

        return $playlist;
    }

    /**
     * Get Songs via Playlist ID
     * @param int $id
     * @return array
     */
    public function getSongs(int $id)
    {
        return;
    }

    /**
     * Adds a song to the playlist
     * @param int $id playlist id
     * @param int $song_id song id
     * @return boolean
     */
    public function addSong(int $id, int $song_id)
    {
        PlaylistSong::create([
            'playlist_id' => $id,
            'song_id' => $song_id,
            'order' => $this->getLastSongOrder($id) + 1
        ]);

        return true;
    }

    /**
     * Removes a song on the playlist
     * @param int $id playlist id
     * @param int $song_id song id
     * @return boolean
     */
    public function removeSong(int $id, int $song_id)
    {
        $playlist = Playlist::where('id', $id)->firstOrFail();

        $playlist->songs()->wherePivot('song_id', $song_id)->detach();

        return true;
    }


    /**
     *  Skips the current song state in the playlist and play the next song queued in the playlist
     */
    public function next()
    {
        // get playlist songs (for testing just get the latest playlist)
        $playlist = Playlist::with('songs')->latest()->first();

        $playlist->next();

        return $playlist;
    }

    /**
     * Skips the current song state in the playlist and play the last song played in the playlist
     */
    public function previous()
    {
        // get playlist songs (for testing just get the latest playlist)
        $playlist = Playlist::with('songs')->latest()->first();

        $playlist->previous();

        return $playlist;
    }

    /**
     * Change the song state in the playlist to playing
     */
    public function play()
    {
        // get playlist songs (for testing just get the latest playlist)
        $playlist = Playlist::with('songs')->latest()->first();

        // play the first in order by default
        // if they choose to play another song while the player is playing it will play the selected song
        $playlist->play();

        return $playlist;
    }

    /**
     * Change the song state in the playlist to pause
     */
    public function pause()
    {
        return false;
    }

    /**
     * Skips the current song state in the playlist and play a random song in the playlist
     */
    public function shuffle()
    {
        // get playlist songs (for testing just get the latest playlist)
        $playlist = Playlist::with('songs')->latest()->first();

        $playlist->shuffle();

        return $playlist;
    }
}
