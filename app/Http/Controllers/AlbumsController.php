<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\User;
use Nexmo\Voice\Message\Message;

class AlbumsController extends Controller
{
    /**
     * Create a new artist album
     * 
     * @param {Object} Request
     */
    public function createAlbum( Request $request)
    {
        $this->validate($request, Album::$albumRule);

        $user = User::find( $request->userId);

        if(!$user ||  $user->type == null) {
            return response()->json([
                'message' => 'You are not an artist'
            ], 403);
        }

        if(Album::where('title', $request->input('title'))->where('user_id', $request->userId)->first()) {
            return response()->json([
                'message' => 'You already have an album with this title'
            ], 409);
        };

        
        $album = Album::create([
            'user_id' => $request->userId,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        
        return response()->json([
            'message' => 'Album created',
            'album' => $album
        ], 201);
    } 
}
