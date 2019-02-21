<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\PlaylistSong;

class PlaylistController extends Controller
{
    /**
     * Create a new user playlist
     * 
     * @param {Object} Request
     */
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

    /**
     * Add song to playlist
     * 
     * @param {Object} Request
     */
    public function addSong(Request $request, $songId, $playlistId)
    {
        if($playlistId && !Playlist::find($playlistId)) {
            return response()->json([
                'message' => 'Playlist not found'
            ], 404);
        }

        if ($songId && !Song::find($songId)) {
            return response()->json([
                'message' => 'Song not found'
            ], 404);
        }

        if (PlaylistSong::where('song_id', $songId)->where('playlist_id', $playlistId)->first()) {
            return response()->json([
                'message' => 'Song already in playlist'
            ], 409);
        }

        $playlist = PlaylistSong::create([
            'song_id' => $songId,
            'playlist_id' => $playlistId
        ]);

        return response()->json([
            'message' => 'Song added to playlist',
            'playlist' => $playlist
        ], 201);
    }
}
