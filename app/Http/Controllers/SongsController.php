<?php

namespace App\Http\Controllers;

use App\Http\Requests\Song\AddSongRequest;
use App\Services\SongService;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    public function __construct(
        private readonly SongService $songService
    ) {
    }

    public function create(AddSongRequest $request)
    {
        $data = $this->songService->create($request);
        return $this->build_response($data, 'Song Created');
    }
}
