<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title','body'];
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function assignedTo(){
        return $this->belongsTo(User::class, 'assignee_id');
    }
    
}
