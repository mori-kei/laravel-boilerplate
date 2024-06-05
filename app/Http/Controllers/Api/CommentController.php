<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
{
    $comments = Comment::with('author')->where('task_id', $id)->get();
    $commentsWithAuthorname = $comments->map(function ($comment) {
        $author_name = $comment->author ? $comment->author->name : null;
        return [
            'id' => $comment->id,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
            'task_id' => $comment->task_id,
            'author_id' => $comment->author_id,
            'authorname' => $author_name,
            'message' => $comment->message,
            'kind' => $comment->kind
        ];
    });
    
    return response()->json([
        'comments' => $commentsWithAuthorname
    ]);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Task $task)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'message' => 'required|max:50',
            'kind' =>''
        ]);
        $comment = Comment::storeComment($user,$validated,$task);
        $comment->authorname =$user->name;
        return response()->json($comment, 200);
    }
}
