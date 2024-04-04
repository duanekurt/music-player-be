<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_name',
        'user_id'
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_songs', 'playlist_id', 'song_id')->withPivot(['state', 'order']);
    }

    public function history()
    {
        return $this->hasMany(PlaylistHistory::class, 'playlist_id', 'id');
    }

    public function playing()
    {
        $song = $this->songs()->wherePivot('playlist_id', '=', $this->id)->wherePivot('state', '=', 1)->first();

        $nextSong = $this->songs()->wherePivot('playlist_id', '=', $this->id)->wherePivot('order', '=', $song->pivot->order + 1)->first();

        // get last played song in the history
        $lastPlayed = $this->history()->latest()->first();

        //build it as the $prevSong
        $prevSong = $this->songs()->wherePivot('playlist_id', '=', $this->id)->wherePivot('song_id', '=', $lastPlayed->song()->first()->id)->first();

        return ['song' => $song, 'next' => $nextSong, 'prev' => $prevSong];
    }

    public function play()
    {
        $song = $this->songs()->wherePivot('playlist_id', '=', $this->id)->wherePivot('order', '=', 1)->latest()->first();
        $song->pivot->state = 1;
        $song->pivot->save();

        return $song;
    }

    public function next()
    {
        $song = $this->playing();
        $nextSong = $song['next'];

        if (!empty($nextSong)) {
            $song['song']->pivot->state = 0;
            $song['song']->pivot->save();

            $nextSong->pivot->state = 1;
            $nextSong->pivot->save();
        } else {

            // if there are no songs in the list go to the first order

            $song['song']->pivot->state = 0;
            $song['song']->pivot->save();

            $this->play();
        }
        // add $nextSong as PlaylistHistory

        $this->history()->create([
            'playlist_id' => $this->id,
            'song_id' => $song['song']->pivot->song_id,
            'status' => 1 //assuming all is skipped
        ]);

        return $song;
    }

    public function previous()
    {
        $song = $this->playing();
        $prevSong = $song['prev'];

        if (!empty($prevSong)) {
            $song['song']->pivot->state = 0;
            $song['song']->pivot->save();

            $prevSong->pivot->state = 1;
            $prevSong->pivot->save();
        }

        return $song;
    }

    public function shuffle()
    {
        $songs = $this->songs()->wherePivot('playlist_id', '=', $this->id);

        $random_song_id = $songs->pluck('id')->shuffle()->first();

        $song = $this->playing();
        $song['song']->pivot->state = 0;
        $song['song']->pivot->save();

        $randomSong = $songs->wherePivot('song_id', $random_song_id)->first();
        $randomSong->pivot->state = 1;
        $randomSong->pivot->save();

        // Save Last Song History here
        $this->history()->create([
            'playlist_id' => $this->id,
            'song_id' => $song['song']->pivot->song_id,
            'status' => 1 //assuming all is skipped
        ]);

        return $song;
    }
}
