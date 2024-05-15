<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
class TeamTest extends TestCase
{
    public function test_createWithOwner()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'dummy name',
        ];
        $team = Team::createWithOwner($user, $data);
        $this->assertNotNull($team);
        $this->assertEquals($data['name'], $team->name);
        $this->assertEquals($user->name, $team->owner->name); 
    }
}
