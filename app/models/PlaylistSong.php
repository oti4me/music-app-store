<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistSong extends Model
{
    protected $table = 'playlist_song';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'song_id', 'playlist_id'
    ];

    /**
     * Get the user that owns the phone.
     */
    // public function song()
    // {
    //     return $this->belongsTo('App\Models\Song');
    // }

    /**
     * Get the user that owns the phone.
     */
    // public function Playlist()
    // {
    //     return $this->belongsTo('App\Models\Playlist');
    // }
}
