@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/profile-edit.js')

@section('content')
<div class="profile__form">
    <div class="message">
        @if(session('message'))
            <p class="message">{{session('message')}}</p>
        @endif
    </div>
    <h1 class ="form-title">プロフィール設定</h1>
    <form class="form__inner" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
        @method('PATCH')@csrf
        <div class="image">
            <div class="image__inner">
                <img class="icon" src="{{Storage::url($profile?->image)}}" id="profilePreview" alt="{{$profile->name}}">
                <div class="change__button">
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg">
                    <button type="button" id="selectImageButton">画像を選択する</button>
                </div>
            </div>
            <div class="error">
                @foreach($errors->get('image') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
            <script>//画像の差し替え
                const fileInput = document.getElementById('image');
                const selectButton = document.getElementById('selectImageButton');
                const previewImg = document.getElementById('profilePreview');
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 10 * 1024 * 1024;
                
                selectButton.addEventListener('click', () => fileInput.click());
                
                fileInput.addEventListener('change', (event) => {
                    const file = event.target.files[0];
                    if (!file) return;
                
                    if (!allowedTypes.includes(file.type)) {
                        alert('JPEG, PNG形式の画像を選択してください');
                    fileInput.value = '';
                    return;
                    }

                    if (file.size > 10 * 1024 * 1024) {
                        alert('10MB以下の画像を選択してください');
                        fileInput.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImg.src = e.target.result; // 左側画像差し替え
                    };
                    reader.readAsDataURL(file);
                });
            </script>
        </div>
        <div class="name">
            <label class="form-label" for="post_code">ユーザー名</label>
            <input type="text" name="name" id="name" value="{{$profile->name}}">
            <div class="error">
                @foreach($errors->get('name') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
        </div>
        <div class="post_code">
            <label class="form-label" for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" value="{{$profile->post_code}}">
            <div class="error">
                @foreach($errors->get('post_code') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
        </div>
        <div class="address">
            <label class="form-label" for="address">住所</label>
            <input type="text" name="address" id="address" value="{{$profile->address}}">
            <div class="error">
                @foreach($errors->get('address') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
        </div>
        <div class="building">
            <label class="form-label" for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{$profile->building}}">
            <div class="error">
                @foreach($errors->get('building') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
        </div>
        <div class="button">
            <button class="update-button" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection
