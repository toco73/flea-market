<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>模擬案件初級 フリマアプリ</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/layouts/common.css')}}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header flex">
            <a href="/">
                <img src="{{asset('storage/images/COACHTECH.png')}}" alt="">
            </a>
            @if(!Request::is('login') && !Request::is('register') && !Request::is('verify-email'))
            <form class='header__search' action="{{url('/')}}" method="get">
                @csrf
                <input type="text" name='keyword' value="{{request('keyword')}}" placeholder='なにをお探しですか？'>
                <input type="hidden" name="tab" value="{{$tab ?? ''}}">
            </form>
            <nav>
                <ul class="header__nav-ul flex">
                    @auth
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="/login" class="header__nav-login">ログイン</a>
                    </li>
                    @endauth
                    <li>
                        <a href="/mypage" class="header__nav-mypage">マイページ</a>
                    </li>
                    <li>
                        <a href="/sell" class="header__nav-sell">出品</a>
                    </li>
                </ul>
            </nav>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
        @yield('scripts')
    </main>
</body>
</html>