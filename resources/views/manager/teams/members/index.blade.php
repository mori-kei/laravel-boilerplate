<x-layout>
    <x-slot name="title">タスク作成</x-slot>
    <h2><a href="{{ route('manager.teams.show',$team) }}" >{{$team->name}}</a>/メンバー管理</h2>
    <x-form-error />
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
