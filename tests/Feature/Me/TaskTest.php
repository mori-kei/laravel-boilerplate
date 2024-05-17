<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class MeTaskTest extends TestCase
{
    public function test_index_task(){
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Task::factory()->create(['assignee_id' => $user1->id]);
        Task::factory()->create(['assignee_id' => $user1->id]);
        Task::factory()->create(['assignee_id' => $user2->id]);
        Task::factory()->create(['assignee_id' => $user2->id]);
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