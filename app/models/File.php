<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'url'
    ];

    /**
     * upload validation rule
     *
     * @var array
     */
    public static $uploadRules = [
        'name' => 'required|min:5||max:25',
        'file' => 'required|file|max:5120'
    ];

    /**
     * download validation rule
     *
     * @var array
     */
    public static $downloadRules = [
        'url' => 'required',
    ];
}