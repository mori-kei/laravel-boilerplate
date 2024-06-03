<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Parser\Handler\CommentHandler;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
{
    $comments = Comment::where('task_id', $id)->get();

    $commentsWithAuthorname = $comments->map(function ($comment) {
        $user = User::find($comment->author_id);
        $author_name = $user ? $user->name : null;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|max:50'
        ]);
        $comment = new Comment($validated);
        $comment->task_id = $request->input('task_id');
        $comment->author_id = $request->input('author_id');
        $comment->kind = $request->input('kind');
        $comment->save();
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
