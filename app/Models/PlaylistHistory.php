<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'song_id',
        'status'
    ];

    public function playlist_histories()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function playlist_last_played()
    {
        return $this->playlist_histories()->with('song')->latest()->first();
    }

    public function scopeLastPlayed($query)
    {
        return $query->latest()->first();
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
