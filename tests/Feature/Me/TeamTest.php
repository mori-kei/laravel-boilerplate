<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Team;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class MeTeamTest extends TestCase
{
    public function test_index_team(){
        {
            $user1 = User::factory()->create();
            $user2 = User::factory()->create();
            Sanctum::actingAs($user1);
            $team1 = Team::createWithOwner($user1,['name' => 'dummy name']);
            $team2 = Team::createWithOwner($user2,['name' => 'dummy name2']);
            $team3 = Team::createWithOwner($user2,['name' => 'dummy name3']);
            $teamUser1 = new Member();
            $teamUser1->team_id = $team2->id;
            $teamUser1->user_id = $user1->id;
            $teamUser1->save();
            $response = $this->get('/api/me/teams');
            $response->assertStatus(200);
            $response->assertJsonCount(2);
            $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'owner_id',
                'created_at',
                'updated_at',
                'pivot',
                ]
            ]);
            $response->assertJson([0 => [
                'id' => $team1->id,
                'name' => 'dummy name',
            ]]);
            $response->assertJson([1 => [
                'id' => $team2->id,
                'name' => 'dummy name2',
            ]]);
        }
    }
}