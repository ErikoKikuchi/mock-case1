<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    @if(!app()->environment(['testing','dusk.local']) && !config('app.vite_disabled'))
        @vite('resources/js/app.js')
        @yield('css')
    @endif
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__title" href="{{route('home')}}">
                <img class="header__logo" src="{{asset('images/COACHTECHヘッダーロゴ.png')}}" type="image" name="logo">
            </a>
            <div class="search-form">
                <form class="search-form__inner" action="{{route('home')}}" method="get">@csrf
                    <input class="search-form__input" type="search" name="keyword" placeholder="なにをお探しですか？"value="{{ request('keyword') }}" ></input>
                </form>
            </div>
            <div class="nav">
                @auth
                    <div class="logout">
                        <form class="logout__button" action="/logout" method="post">@csrf
                            <button class="logout__button--submit" type="submit">ログアウト</button>
                        </form>
                    </div>
                @else
                    <div class="login">
                        <a href="/login" class="login__button">ログイン</a>
                    </div>
                @endauth
                <div class="mypage">
                    <a href="{{ route('mypage') }}" class="mypage__header-link">マイページ</a>
                </div>
                <div class="exhibition-page">
                    <a href="{{route('sell')}}" class="exhibition-page__link">出品</a>
                </div>
            </div>
        </div>
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>