<?php

namespace App\Http\Controllers\Api\Me;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $current_user = Auth::user();
        $assigned_tasks = $current_user->assignedTasks()->with('assignedUser')->get();
        return response()->json($assigned_tasks,200);
    }
}
