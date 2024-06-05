<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title','body','assignee_id'];
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function assignedUser(){
        return $this->belongsTo(User::class, 'assignee_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
