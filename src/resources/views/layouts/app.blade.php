<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header__main">
            <h1 class="header__title">Atte</h1>
        </div>

        @if (Auth::check())
        <div class="header__sub">
            <ul class="header__list">
                <li class="header__item">
                    <a class="header__item-link" href="/">ホーム</a>
                </li>
                <li class="header__item">
                    <a class="header__item-link" href="{{ route('attendance/date') }}">日付一覧</a>
                </li>
                <li class="header__item">
                    <a class="header__item-link" href="{{ route('logout') }}">ログアウト</a>
                </li>
            </ul>
        </div>
        @endif
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <small class="footer__title">Atte, inc.</small>
    </footer>

</body>

</html>