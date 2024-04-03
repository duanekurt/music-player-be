<?php

namespace App\Interfaces\Services;

use Illuminate\Http\Request;

interface PlaylistServiceInterface
{
    public function index();
    public function create(Request $request);
    public function getSongs(int $id);
    public function addSong(int $id, int $song_id);
    public function removeSong(int $id, int $song_id);
    public function play();
    public function pause();
    public function shuffle();
    public function next();
    public function previous();
}
