<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class PlaylistController extends Controller
{
    public function createplaylist(Request $request) {
        $this->validate($request, Playlist::$createRule);

        $foundPlaylist = Playlist::where('name', $request->input('name'))
            ->where('user_id', $request->userId)
            ->first();

        if($foundPlaylist) {
            return response()->json([
                'message' => 'You have already created a playlist with this title',
            ], 409);
        }

        $playlist = Playlist::create([
            'name' => $request->input('name'),
            'user_id' => $request->userId
        ]);
        
        return response()->json([
            'message' => 'Playlist created',
            'playlist' => $playlist
        ], 201);
    }
}
