<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:500'
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        //投稿者に通知を送信
        $post->user->Notify(new CommentNotification($post));

        return redirect()->route('posts.show', $post->id);


    }
}
