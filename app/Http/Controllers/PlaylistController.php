<?php

namespace App\Http\Controllers;

use App\Services\PlaylistService;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function __construct(
        private readonly PlaylistService $playlistService
    ) {
    }

    public function index()
    {
        $data = $this->playlistService->index();
        return $this->build_response($data);
    }

    public function create(Request $request)
    {
        $data = $this->playlistService->create($request);
        return $this->build_response($data, 'Playlist created');
    }

    public function addSong(int $playlist_id, int $song_id)
    {
        $data = $this->playlistService->addSong($playlist_id, $song_id);
        return $this->build_response($data, 'Song Added');
    }

    public function removeSong(int $playlist_id, int $song_id)
    {
        $data = $this->playlistService->removeSong($playlist_id, $song_id);
        return $this->build_response($data, 'Song Removed');
    }

    public function play()
    {
        $data = $this->playlistService->play();
        return $this->build_response($data);
    }

    public function next()
    {
        $data = $this->playlistService->next();
        return $this->build_response($data);
    }

    public function previous()
    {
        $data = $this->playlistService->previous();
        return $this->build_response($data);
    }

    public function shuffle()
    {
        $data = $this->playlistService->shuffle();
        return $this->build_response($data);
    }
}
