<x-layout>
    <x-slot name="title">{{$team->name}}: (id:{{ $team->id }})</x-slot>
    
    <x-mini-panel>
        <div class="mb-3">
            <h2>{{$team->name}}: (id:{{ $team->id }})</h2>
        </div>
        <a href="{{ route('manager.teams.edit',$team) }}" class="btn btn-primary btn-sm">編集</a>
</x-mini-panel>
</x-layout>
