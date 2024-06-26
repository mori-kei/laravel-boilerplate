<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Task;
use App\Models\Team;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    public function test_index_comment(){
        $user = User::factory()->create();
        //コメントに紐づけるtask,teamを作成
        $team = Team::createWithOwner($user,['name' => 'dummy name',]);
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        //dummyのコメントを作成
        $comment = Comment::factory()->create([
            'message' => 'dummy comment',
            'author_id' => $user->id,
            'task_id' => $dummytask->id,
            'kind' => '0'
        ]);
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/tasks/' . $dummytask->id. '/comments');
        $response->assertStatus(200);
        $json = $response->decodeResponseJson();
        $this->assertEquals($comment->id,$json['comments'][0]['id']);
        $this->assertEquals('dummy comment',$json['comments'][0]['message']);
        $this->assertEquals(0,$json['comments'][0]['kind']);
        $this->assertEquals($user->id,$json['comments'][0]['author_id']);
        $this->assertEquals($dummytask->id,$json['comments'][0]['task_id']);
    }
    
    public function test_store_comment(){
        $user = User::factory()->create();
        //コメントに紐づけるtask,teamを作成
        $data = [
            'name' => 'dummy name',
        ];
        $team = Team::createWithOwner($user,$data);
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        $commentData =  [
            'message' => 'dummy message',
            'kind' =>'0'
        ];
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->postJson('/api/tasks/' . $dummytask->id. '/comments', $commentData);
        $response->assertStatus(200);
        $newComment = Comment::latest()->first();
        $json = $response->decodeResponseJson();
        $this->assertArrayHasKey('id',$json);
        $this->assertEquals('dummy message',$newComment->message);
        $this->assertEquals(0,$newComment->kind);
        $this->assertEquals($user->id,$newComment->author_id);
        $this->assertEquals($dummytask->id,$newComment->task_id);
    }
    public function test_store_comment_updateTaskStatus(){
        $user = User::factory()->create();
        //コメントに紐づけるtask,teamを作成
        $data = [
            'name' => 'dummy name',
        ];
        $team = Team::createWithOwner($user,$data);
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        $commentData =  [
            'message' => 'dummy message',
            'kind' =>'1'
        ];
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->postJson('/api/tasks/' . $dummytask->id. '/comments', $commentData);
        $response->assertStatus(200);
        $newComment = Comment::latest()->first();
        $finishedTask = $dummytask->refresh();
        $json = $response->decodeResponseJson();
        $this->assertArrayHasKey('id',$json);
        $this->assertEquals('dummy message',$newComment->message);
        $this->assertEquals(1,$newComment->kind);
        $this->assertEquals($user->id,$newComment->author_id);
        $this->assertEquals($dummytask->id,$newComment->task_id);
        $this->assertEquals(1,$finishedTask->status);
    }

    public function test_store_validate_null(){
        $user = User::factory()->create();
        //コメントに紐づけるtask,teamを作成
        $data = [
            'name' => 'dummy name',
        ];
        $team = Team::createWithOwner($user,$data);
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        $commentData =  [
            'message' => '',
            'kind' =>'0'
        ];
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->postJson('/api/tasks/' . $dummytask->id. '/comments', $commentData);
        $response->assertStatus(422);
        $response->assertJson(['message' => 'messageは必須です。']);
    }
    public function test_store_validate_max_length_50(){
        $user = User::factory()->create();
        //コメントに紐づけるtask,teamを作成
        $data = [
            'name' => 'dummy name',
        ];
        $team = Team::createWithOwner($user,$data);
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        $commentData =  [
            'message' => str_repeat('a', 51),
            'kind' =>'0'
        ];
        Sanctum::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])->postJson('/api/tasks/' . $dummytask->id. '/comments', $commentData);
        $response->assertStatus(422);
        $response->assertJson(['message' => 'messageは50文字を超えてはいけません。']);
    }
}