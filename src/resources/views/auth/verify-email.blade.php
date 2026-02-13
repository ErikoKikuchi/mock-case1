<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    @if(!app()->environment('testing'))
        @vite('resources/js/verify-email.js')
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
            <div class="verify-email__form">
                <div class="message">
                    <p class="main-sentence">登録していただいたメールアドレスに認証メールを送付しました。</p>
                    <p class="main-sentence">メール内認証を完了してください。</p>
                </div>
                <form class="verification-form" method="GET" action="{{ route('verification.open') }}">
                    <button class="verification-form__submit" type="submit">認証はこちらから</button>
                </form>
                <form class="verification-resend" method="POST" action="{{ route('verification.send') }}" >@csrf
                    <button class="verification-form__resend" type="submit">認証メールを再送する</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>