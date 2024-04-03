<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Playlist Routes
        Route::group(['prefix' => 'playlist'], function () {
            Route::post('/create', [PlaylistController::class, 'create']);
            Route::get('/songs', [PlaylistController::class, 'index']);
            Route::put('/add/song/{playlist_id}/{song_id}', [PlaylistController::class, 'addSong']);
            Route::put('/remove/song/{playlist_id}/{song_id}', [PlaylistController::class, 'removeSong']);
            Route::get('/next', [PlaylistController::class, 'next']);
            Route::get('/previous', [PlaylistController::class, 'previous']);
            Route::get('/play', [PlaylistController::class, 'play']);
            Route::get('/pause', [PlaylistController::class, 'pause']);
            Route::get('/shuffle', [PlaylistController::class, 'shuffle']);
        });

        // Songs Routes
        Route::group(['prefix' => 'songs'], function () {
            Route::post('/create', [SongsController::class, 'create']);
        });
    });

    // User Routes
    Route::group(['prefix' => 'user'], function () {
        Route::post('/login', [UsersController::class, 'login']);
        Route::post('/register', [UsersController::class, 'register']);
    });
});
