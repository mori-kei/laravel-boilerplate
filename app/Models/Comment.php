<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
