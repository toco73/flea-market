<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>模擬案件初級 フリマアプリ</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
</head>
<body>
    <div class="app">
        <header class="header">
            <a href="/">
                <img src="{{asset('storage/images/COACHTECH.png')}}" alt="">
            </a>
            @if(!Request::is('login') && !Request::is('register'))
            <form class='search' action="">
                @csrf
                <input type="text" name='search' placeholder='何をお探しですか？'>
            </form>
            <nav>
                <ul>
                    @auth
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="/login">ログイン</a>
                    </li>
                    @endauth
                    <li>
                        <a href="/mypage">マイページ</a>
                    </li>
                    <li>
                        <a href="/sell">出品</a>
                    </li>
                </ul>
            </nav>
            @endif
        </header>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>