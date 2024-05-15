<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function owner() {
        return $this->belongsTo(User::class);
    }
    public function tasks() {
        return $this->hasMany(Task::class);
    }
    public function members(){
        return $this->hasMany(Member::class);
    }
    public function isManager($user){
        return $this->members()
            ->where('user_id',$user->id)
            ->where('role', 1)
            ->exists();
    }
    public static function  createWithOwner($user,$validated){
        $user_id = $user->id;
        $team = DB::transaction(function() use ($validated,$user_id){
            $team = new Team($validated);
            $team->owner_id = $user_id;
            $team->save();
            $member = new Member();
            $member->team_id = $team->id;
            $member->user_id = $user_id;
            $member->role = 1;
            $member->save();
            return $team;
        });
        return $team;
    }
}
