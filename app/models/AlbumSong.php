<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumSong extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'song_id', 'album_id'
    ];
}
