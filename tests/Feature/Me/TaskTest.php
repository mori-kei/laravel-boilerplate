<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Team;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class MeTaskTest extends TestCase
{
    public function test_index_task(){
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $team = Team::createWithOwner($user1,['name' =>'dummy name']);
        Task::factory()->create(['assignee_id' => $user1->id,'team_id' => $team->id ]);
        Task::factory()->create(['assignee_id' => $user1->id,'team_id' => $team->id ]);
        Task::factory()->create(['assignee_id' => $user2->id,'team_id' => $team->id ]);
        Task::factory()->create(['assignee_id' => $user2->id,'team_id' => $team->id ]);
        Sanctum::actingAs($user1);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/me/tasks/');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJson([
            0 => ['assignee_id' => $user1->id]
        ]);
        $response->assertJson([
            1 => ['assignee_id' => $user1->id]
        ]);
    }
}