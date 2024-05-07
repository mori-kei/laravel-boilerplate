<x-layout>
    <x-slot name="title">User: (id:{{ $user->id }})/edit</x-slot>
    <h2><a href="{{ route('admin.users.index') }}">Admin/Users</a> / {{ $user->name }}(id:{{ $user->id }})</h2>
    <x-mini-panel>
        <x-form-error />
        <form action="{{ route('admin.users.update', $user) }}" method="post">
            @csrf
            @method('patch')

            @include('components.admin.user-fields')

            <div class="mb-3">
                <label class="form-label" for="userPassword">パスワード（変更したい場合に入力）</label>
                <input type="password" name="password" value="" id="userPassword"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input type="submit" value="更新" class="btn btn-primary">
        </form>
    </x-mini-panel>
</x-layout>
