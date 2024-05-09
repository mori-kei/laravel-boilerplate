<x-layout>
    <x-slot name="title">タスク作成</x-slot>
    <h2><a href="{{ route('manager.teams.show',$team) }}" >{{$team->name}}</a>/タスク作成</h2>
    <x-form-error />
    <x-mini-panel>
        <form action="{{ route('manager.teams.tasks.store', ['team' => $team]) }}" method="post">
            @csrf
            <input type="hidden" name="team_id" value={{$team->id}} id="taskTitle" class="form-control"> 
            <div class="mb-3">
                <label class="form-label" for="taskTitle">タイトル</label>
                <input type="text" name="title" value="" id="taskTitle" class="form-control"> 
            </div>
            <div class="mb-3">
                <label class="form-label" for="taskBody">内容</label>
                <textarea type="text" name="body" value="" id="taskBody" class="form-control"></textarea> 
            </div>
            <input type="submit" value="作成" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
