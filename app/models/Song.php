<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'user_id', 'url', 'genre', 'artist'
    ];

    /**
     * upload validation rule
     *
     * @var array
     */
    public static $uploadRules = [
        'title' => 'required|min:5|max:25',
        'file' => 'required|file|max:5120',
        'genre' => 'required|min:2|max:25',
        'artist' => 'required|min:2|max:25',
    ];

    /**
     * download validation rule
     *
     * @var array
     */
    public static $urlRules = [
        'url' => 'required',
    ];

    // /**
    //  * Get the user that owns the phone.
    //  */
    // public function Playlist()
    // {
    //     return $this->belongsToMany('App\Models\Playlist');
    // }

    // /**
    //  * Get the post that owns the comment.
    //  */
    // public function user()
    // {
    //     return $this->belongsTo('App\Model\User', 'user_id');
    // }
}
