<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Team;
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
        $data = [
            'name' => 'dummy name',
        ];
        $team = Team::createWithOwner($user,$data);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/tasks/' . $dummytask->id);
        $response->assertStatus(200);
        $json = $response->decodeResponseJson();
        $this->assertEquals('dummy title',$json['task']['title']);
        $this->assertEquals('dummy body',$json['task']['body']);
        $this->assertEquals('0',$json['task']['status']);
        $this->assertEquals(null,$json['task']['assignee_id']);
        $this->assertArrayHasKey('created_at', $json['task']);
        $this->assertArrayHasKey('updated_at', $json['task']);
        $this->assertArrayHasKey('id', $json['task']);
        $this->assertEquals('dummy name', $json['task']['team']['name']);
        $this->assertEquals($user->id, $json['task']['team']['owner_id']);
        $this->assertArrayHasKey('created_at', $json['task']['team']);
        $this->assertArrayHasKey('updated_at', $json['task']['team']);
        $this->assertArrayHasKey('id', $json['task']['team']);
    }
}