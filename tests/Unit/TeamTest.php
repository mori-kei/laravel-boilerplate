<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use App\Models\Member;

class TeamTest extends TestCase
{
    public function test_createWithOwner()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'dummy name',
        ];
        $team_count = Team::count();
        $member_count = Member::count();
        $team = Team::createWithOwner($user, $data);
        $this->assertEquals($team_count + 1, Team::count()); 
        $this->assertNotNull($team);
        $this->assertEquals('dummy name', $team->name);
        $this->assertEquals($user->id, $team->owner_id); 
        $storedMember = $team->members()->latest()->first();
        $this->assertEquals($member_count + 1, Member::count()); 
        $this->assertEquals($team->id,$storedMember->team_id);
        $this->assertEquals($user->id,$storedMember->user_id);
        $this->assertEquals(1,$storedMember->role);
    }
}
