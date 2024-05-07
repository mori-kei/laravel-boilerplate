<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? env('APP_NAME') . " - {$title} -" : env('APP_NAME') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body class="bg-light">
    <div class="container">
        <header class="mb-2">
            @if (Auth::check())
                @php
                    $user = Auth::user();
                @endphp
                <div>
                    <h1><a href="/">{{ env('APP_NAME') }}</a></h1>
                </div>
                <nav class="text-end">
                    <span>{{ $user->name }}(id:{{ $user->id }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="submit" value="ログアウト" class="btn btn-secondary">
                    </form>
                    @if ($user->isAdmin())
                        <a class="btn btn-primary" href="{{ route('admin.users.index') }}">ユーザー管理</a>
                    @endif
                </nav>
            @else
                <a href="{{ route('login') }}">ログイン</a>
            @endif
        </header>
        <main>
            <x-flash-message />

            {{ $slot }}
        </main>
    </div>
</body>

</html>
