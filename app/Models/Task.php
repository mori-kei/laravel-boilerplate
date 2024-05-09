<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','body'];
    use HasFactory;
    public function team(){
        return $this->belongsTo(Team::class);
    }
}
