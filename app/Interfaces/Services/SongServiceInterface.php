<?php

namespace App\Interfaces\Services;

use Illuminate\Http\Request;

interface SongServiceInterface
{
    public function create(Request $request);

}
