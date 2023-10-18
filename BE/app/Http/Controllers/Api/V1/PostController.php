<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function public(Request $request)
    {
        $posts = Post::where('user_id', '!=', $request->user()->id)->get();

    return $posts;
    }

    public function index(Request $request)
    {
        return $request->user()->posts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'caption' => 'required|max:3000'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'caption' => $request->caption
        ]);
        if (!$post) {
            return response()->json(['status' => false, 'message' => 'could not save user']);
        } else {
            return response()->json(['status' => true, 'post' => $post], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id = $request->user()->id) {
            $post->title = $request->title;
            $post->caption = $request->caption;
            $post->save();

            if (!$post) {
                return response()->json(['status' => false, 'message' => 'could not update the post'], 200);
            } else {
                return response()->json(['status' => true], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Request $request)
    {
        if ($request->user()->id == $post->user_id) {
            $post->delete();
            return response()->json(['status' => true, 'message' => 'post deleted successfully!'], 200);
        } else {
            return response()->json(['stauts' => false, 'message' => 'your not allowed to delete this post'], 200);
        }
    }
}
