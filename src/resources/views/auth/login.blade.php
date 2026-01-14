<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    @vite('resources/js/app.js')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__title">
                <img class="header__logo" src="{{asset('images/COACHTECHヘッダーロゴ.png')}}" type="image" name="logo">
            </div>
        </div>
    </header>
    <main>
        <div class="login-form">
            <h1 class="form__title">ログイン</h1>
        </div>
        <form class="login-form__inner" action="/login" method="post">@csrf
            <div class="login-form__email">
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
            <div class="login-form__password">
                <div class="label">
                    <label class="label-title" for="password">パスワード</label>
                </div>
                <div class="input">
                    <input class="input-box" type="password" id="password" name="password">
                </div>
                <div class="error">
                    @error('password')
                        <p class="error-message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="button">
                <button class="login__button" type="submit">ログインする</button>
            </div>
        </form>
        <div class="register">
                <a class="register-link" href="/register">会員登録はこちら</a>
            </div>
    </main>
</body>
</html>