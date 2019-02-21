<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    /**
     * validation rule
     *
     * @var array
     */
    public static $albumRule = [
        'title' => 'required|min:1|max:30',
        'description' => 'required|min:5|max:60',
    ];
}
