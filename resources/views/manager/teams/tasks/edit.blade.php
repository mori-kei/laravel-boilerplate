<x-layout>
    <x-slot name="title">{{$team->name}}/タスク編集</x-slot>
    <h2><a href="{{ route('manager.teams.show',$team) }}" >{{$team->name}}</a>/タスク編集</h2>
    <x-mini-panel>
        <x-form-error />
        <form action="{{ route('manager.teams.tasks.update', ['team' => $team->id,'task' => $task->id]) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label class="form-label" for="taskTitle">タイトル</label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}" id="taskTitle"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label" for="taskBody">内容</label>
                <textarea type="text" name="body" id="taskBody" class="form-control">{{ old('body', $task->body) }}</textarea> 
            </div>
            <input type="submit" value="更新" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
