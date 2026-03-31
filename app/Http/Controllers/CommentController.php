<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, string $postId)
    {
        $post = Post::findOrFail($postId);

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:1000',
        ]);

        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->post()->associate($post);
        $comment->user()->associate(Auth::user());
        $comment->save();

        return redirect("/posts/{$post->id}");
    }

    public function destroy(string $postId, string $commentId)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::findOrFail($commentId);

        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect("/posts/{$post->id}");
    }
}
