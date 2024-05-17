<?php

namespace App\Http\Controllers\Api\Me;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $current_user = Auth::user();
        $tasks = Task::where('assignee_id',$current_user->id)->get();
        return response()->json($tasks,200);
    }
}
