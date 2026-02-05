<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    @if(!app()->environment('testing'))
        @vite('resources/js/register.js')
    @endif
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__title" href="{{route('home')}}">
                <img class="header__logo" src="{{asset('images/COACHTECHヘッダーロゴ.png')}}" type="image" name="logo">
            </a>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <div class ="register-form">
                <h1 class="form__title">会員登録</h1>
                <div class="form__inner">
                    <form class="register-form__inner" action="/register" method="post">@csrf
                        <div class="register-form__name">
                            <div class="label">
                                <label class="label-title" for="name">ユーザー名</label>
                            </div>
                            <div class="input">
                                <input class="input-box" type="text" id="name" name="name" value="{{old('name')}}">
                            </div>
                            <div class="error">
                                @foreach($errors->get('name') as $message)
                                <p class="error-message">{{$message}}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="register-form__email">
                            <div class="label">
                                <label class="label-title" for="email">メールアドレス</label>
                            </div>
                            <div class="input">
                                <input class="input-box" type="text" id="email" name="email" value="{{old('email')}}">
                            </div>
                            <div class="error">
                                @foreach($errors->get('email') as $message)
                                <p class="error-message">{{$message}}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="register-form__password">
                            <div class="label">
                                <label class="label-title" for="password">パスワード</label>
                            </div>
                            <div class="input">
                                <input class="input-box" type="password" id="password" name="password" ">
                            </div>
                            <div class="error">
                                @error('password')
                                <p class="error-message">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="register-form__password_confirmation">
                            <div class="label">
                                <label class="label-title" for="password_confirmation">確認用パスワード</label>
                            </div>
                            <div class="input">
                                <input class="input-box" type="password" id="password_confirmation" name="password_confirmation" >
                            </div>
                            <div class="error">
                                @error('password_confirmation')
                                <p class="error-message">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="button">
                            <button class="register__button" type="submit">登録する</button>
                        </div>
                    </form>
                </div>
                <div class="login">
                    <a class="login-link" href="/login">ログインはこちら</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>