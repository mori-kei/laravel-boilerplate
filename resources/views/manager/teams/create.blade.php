<x-layout>
    <x-slot name="title">チーム新規作成</x-slot>
    <h2>チーム新規作成</h2>
    <x-form-error />
    <x-mini-panel>
        <form action="{{ route('manager.teams.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="teamName">名前</label>
                <input type="text" name="name" value="" id="teamName"
                    class="form-control"> 
            </div>
            <input type="submit" value="作成" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
