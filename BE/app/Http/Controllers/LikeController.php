<?php

namespace App\Http\Controllers;

use App\Library\SendSMS;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function setLike($postId, Request $request)
    {
        $post = Post::find($postId);
        $likes = $post->likes;
        $userId = $request->user()->id;

        function newLike($postId, $userId)
        {
            $newLike = new Like;
            $newLike->post_id = $postId;
            $newLike->user_id = $userId;
            $newLike->save();
        }

        if ($likes->count() > 0) {
            foreach ($likes as $like) {
                if ($like->user_id == $request->user()->id) {
                    $like->delete();
                    return response()->json(['liked' => false]);
                } else {
                   
                    newLike($postId, $userId);
                    
                    return response()->json(['liked' => true]);
                }
            }
        } else {
            $vc = rand(1111, 9999);
            newLike($postId, $userId);
            SendSMS::sendVerification('09398482612', $vc);
            return response()->json(['liked' => true]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
