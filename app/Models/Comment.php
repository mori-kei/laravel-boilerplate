<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $fillable = ['message','kind','task_id','author_id'];
    use HasFactory;
    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function author(){
        return $this->belongsTo(User::class,'author_id');
    }
    public static function storeComment($user,$validated,$task){
        $comment = DB::transaction(function()use($user,$validated,$task){
            $comment = new Comment($validated);
            $comment->task_id = $task->id;
            $comment->author_id = $user->id;
            $comment->save();
            $comment->authorname = $user->name; 
            if($comment->kind == 1){
                $task->status = 1;
                $task->save();
            }
            return $comment;
        });
        return $comment;
    }
}
