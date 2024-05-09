<x-layout>
    <x-slot name="title">{{$team->name}}: (id:{{ $team->id }})</x-slot>
    <x-mini-panel>
        <div class="mb-3">
            <h2>{{$team->name}}: (id:{{ $team->id }})</h2>
        </div>
        <div class="text-end mb-2">
            <a href="{{ route('manager.teams.tasks.create',$team) }}" class="btn btn-primary btn-sm">タスクの新規作成</a>
            <a href="{{ route('manager.teams.edit',$team) }}" class="btn btn-primary btn-sm">編集</a>
        </div>
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">タスクid</th>
                    <th scope="col">タイトル</th>
                    <th scope="col">作成日時</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <th scope="row">{{ $task->id }}</th>
                        <td>{{ $task->title }}</td>
                        <td scope="row">{{ $task->created_at }}</td>
                        <td><a href="{{ route('manager.teams.tasks.edit', ['team' => $team->id,'task' => $task->id]) }}" class="btn btn-primary btn-sm">編集</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</x-mini-panel>
</x-layout>
