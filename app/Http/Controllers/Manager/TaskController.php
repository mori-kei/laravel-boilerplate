<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Team $team)
    {
        //学習用にコメントアウト n+1
        // $members = $team->members()->get();
        //eagerLoading
        $members = $team->members()->with('user')->get();
        return view('manager.teams.tasks.create',compact('team','members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Team $team)
    {
        $validated = $request->validate([
            'title' => 'required', 
            'body' => 'required', 
        ]);
        $team_id = $team->id;
        $task = new Task($validated);
        $task->team_id = $team_id;
        $task->save();
        return to_route('manager.teams.show', $team_id)->with('success', 'タスクを作成しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team, Task $task)
    {
        return view('manager.teams.tasks.edit',compact('team','task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Team $team, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required', 
            'body' => 'required', 
        ]);
        $task->update($validated);
        return to_route('manager.teams.show',$team)->with('success', 'タスクを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
