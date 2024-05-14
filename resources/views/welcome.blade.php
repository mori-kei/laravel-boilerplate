<x-layout>
    <x-slot name="title">Top</x-slot>
    <h2>Welcome!</h2>
    <a href="{{ route('teams.index') }}">チーム一覧</a>
    <a href="{{ route('teams.create') }}">チーム新規作成</a>
</x-layout>
