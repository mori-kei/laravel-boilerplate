<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Team;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class MeTeamTest extends TestCase
{
    public function test_index_team(){
        {
            $user = User::factory()->create();
            Sanctum::actingAs($user);
            $team = Team::createWithOwner($user,['name' => 'dummy name']);
            $response = $this->get('/api/me/teams');
            $response->assertStatus(200);
            $response->assertJsonCount(1);
        }
    }
}