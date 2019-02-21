<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];

    /**
     * add playlist validation rule
     *
     * @var array
     */
    public static $createRule = [
        'name' => 'required|min:4|max:25',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the user that owns the phone.
     */
    public function playlistSongs()
    {
        return $this->hasMany( 'App\Models\playlistSong');
    }
}
