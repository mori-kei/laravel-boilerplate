<x-layout>
    <x-slot name="title">Login</x-slot>
    <x-mini-panel>
        @if (Auth::check())
            @php
                $user = Auth::user();
            @endphp
            <span>すでに{{ $user->name }}としてログイン済みです</span>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <input class="form-control" id="password" type="password" name="password" required>
            </div>
            <div class="mb-3">
                <input type="checkbox" name="remember" id="remember">
                <label class="form-label" for="remember">{{ __('Remember Me') }}</label>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
            </div>
        </form>
    </x-mini-panel>
</x-layout>
