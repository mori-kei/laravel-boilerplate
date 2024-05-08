<x-layout>
    <x-slot name="title">{{$team->name}}編集</x-slot>
   
    <h2>{{$team->name}}編集 </h2>
  
    <x-mini-panel>
        <x-form-error />
        <form action="{{ route('manager.teams.update', $team) }}" method="post">
            @csrf
            @method('patch')
            <input type="hidden" name="owner_id" value={{auth()->id()}} id="owner_id"
            class="form-control">
            <div class="mb-3">
                <label class="form-label" for="teamName">名前</label>
                <input type="text" name="name" value="{{ old('name', $team->name) }}" id="teamName"
                    class="form-control">
            </div>
            <input type="submit" value="更新" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
