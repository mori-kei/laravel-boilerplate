<x-layout>
    <x-slot name="title">タスク作成</x-slot>
    <h2><a href="{{ route('manager.teams.show',$team) }}" >{{$team->name}}</a>/タスク作成</h2>
    <x-form-error />
    <x-mini-panel>
        <form action="{{ route('manager.teams.tasks.store', ['team' => $team]) }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="taskTitle">タイトル</label>
                <input type="text" name="title" value="{{ old('title') }}" id="taskTitle" class="form-control @error('title') is-invalid @enderror"> 
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="taskBody">内容</label>
                <textarea type="text" name="body" id="taskBody" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea> 
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="taskAssignee_id">担当者</label>
                <select name="assignee_id" id="taskAssignee_id" class="form-control">
                    <option value="">なし</option>
                    @foreach($members as $member) 
                        <option value="{{ $member->user->id}}">{{ $member->user->name}}</option>
                    @endforeach
                </select>   
            </div>
            <input type="submit" value="作成" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
