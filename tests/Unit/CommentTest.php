<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Tests\TestCase;


class CommentTest extends TestCase
{
    public function test_storeComment(){
        $user = User::factory()->create();
        //コメントに紐づけるTask,Teamを作成
        $dummytask = new Task([
            'title' => 'dummy title',
            'body' => 'dummy body',
            'status' => 0,
            'assignee_id' => null,
        ]);
        $data = [
            'name' => 'dummy name',
        ];
        $team =Team::createWithOwner($user,$data);
        $dummytask->team_id = $team->id;
        $dummytask->save();
        $commentData =  [
            'message' => 'dummy message',
            'kind' =>'0'
        ];
        $comment = Comment::storeComment($user,$commentData,$dummytask);
        $this->assertNotNull($comment);
        $this->assertEquals('dummy message',$comment->message);
        $this->assertEquals(0,$comment->kind);
        $this->assertEquals(0,$dummytask->status);
    }


    public function test_storeCommentAndUpdateStatus(){
        $user = User::factory()->create();
         //コメントに紐づけるTask,Teamを作成
        $dummyTask =new Task([
            'title' => 'dummy title2',
            'body' => 'dummy body2',
            'status' => 1,
            'assignee_id' => null,
        ]);
        $data = [
            'name' => 'dummy name',
        ];
        $team =Team::createWithOwner($user,$data);
        $dummyTask->team_id = $team->id;
        $dummyTask->save();
        $commentData =  [
            'message' => 'dummy message2',
            'kind' =>'1'
        ];
        $comment = Comment::storeComment($user,$commentData,$dummyTask);
        $this->assertNotNull($comment);
        $this->assertEquals('dummy message2',$comment->message);
        $this->assertEquals(1,$comment->kind);
        $this->assertEquals(1,$dummyTask->status);
    }
}
