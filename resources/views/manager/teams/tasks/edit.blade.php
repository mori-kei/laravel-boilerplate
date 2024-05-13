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
                <input type="text" name="title" value="{{ old('title', $task->title) }}" id="taskTitle" class="form-control @error('title') is-invalid @enderror">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="taskBody">内容</label>
                <textarea type="text" name="body" id="taskBody" class="form-control @error('body') is-invalid @enderror">{{ old('body', $task->body) }}</textarea> 
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="taskBody">担当者</label>
                <select name="assignee_id" class="form-control">
                    <option value="">なし</option>
                    @foreach($members as $member) 
                        <option value="{{ $member->user->id}}">{{ $member->user->name}}</option>
                    @endforeach
                </select>   
            </div>
            <input type="submit" value="更新" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
