<x-layout>
    <x-slot name="title">チーム新規作成</x-slot>
    <h2>チーム新規作成</h2>
    <x-form-error />
    <x-mini-panel>
        <form action="{{ route('teams.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="teamName">名前</label>
                <input type="text" name="name" value="{{ old('name') }}" id="teamName" class="form-control @error('name') is-invalid @enderror"> 
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" value="作成" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
