<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Team;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTaskTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_task(){
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $team = Team::createWithOwner($user1,['name' =>'dummy name']);
        $task1 =Task::factory()->create(['assignee_id' => $user1->id,'team_id' => $team->id ]);
        $task2 =Task::factory()->create(['assignee_id' => $user1->id,'team_id' => $team->id ]);
        Task::factory()->create(['assignee_id' => $user2->id,'team_id' => $team->id ]);
        Task::factory()->create(['assignee_id' => $user2->id,'team_id' => $team->id ]);
        Sanctum::actingAs($user1);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/me/tasks/');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJson([
            0 => [
                    'assigned_user' => [
                        'name' => $user1->name,
                    ],
                    'id' => $task1->id,
                    'assignee_id' => $user1->id,
                    'team' => [
                        'id' => $team->id,
                        'name' => $team->name,
                    ],
                ]
        ]);
        $response->assertJson([
            1 => [
                    'assigned_user' => [
                        'name' => $user1->name,
                    ],
                    'id' => $task2->id,
                    'assignee_id' => $user1->id,
                    'team' => [
                        'id' => $team->id,
                        'name' => $team->name,
                    ],
                ]
        ]);
    }
}