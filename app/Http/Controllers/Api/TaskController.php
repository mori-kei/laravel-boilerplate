<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Task $task)
    {
        $teamName = $task->team->name;
        return response()->json([
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'body' => $task->body,
                'status' => $task->status,
                'assignee_id' => $task->assignee_id,
                'created_at' => $task->created_at->toDateTimeString(),
                'updated_at' => $task->updated_at->toDateTimeString(),
                'team_name' => $teamName
            ],
        ]);
    }
}
