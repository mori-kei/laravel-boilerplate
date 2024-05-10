<x-layout>
    <x-slot name="title">タスク作成</x-slot>
    <h2><a href="{{ route('manager.teams.show',$team) }}" >{{$team->name}}</a>/メンバー管理</h2>
    <x-form-error />
    <div class="text-end mb-2">
        <form action="{{ route('manager.teams.members.store',['team' => $team]) }}" method="POST">
            新規メンバー追加
            @csrf
            <select name="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id}}">{{ $user->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">追加</button>
        </form>
    </div>
    <table class="table table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th scope="col">役割</th>
                <th scope="col">名前</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <th scope="row">
                        @if ($member->role === 0)
                            通常
                        @else 
                            管理者
                        @endif
                    </th>
                    <td>{{ $member->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
