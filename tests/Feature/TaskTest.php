<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class TaskTest extends TestCase
{
    public function test_show_task(){
        $user = User::factory()->create();
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $dummytask->team_id = 1;
        $dummytask->save();
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/tasks/' . $dummytask->id);
        $response->assertStatus(200);
        $json = $response->decodeResponseJson();
        $this->assertEquals('dummy title',$json['title']);
        $this->assertEquals('dummy body',$json['body']);
        $this->assertEquals('0',$json['status']);
        $this->assertEquals(null,$json['assignee_id']);
        $this->assertArrayHasKey('created_at', $json);
        $this->assertArrayHasKey('updated_at', $json);
        $this->assertArrayHasKey('id', $json);
    }
}