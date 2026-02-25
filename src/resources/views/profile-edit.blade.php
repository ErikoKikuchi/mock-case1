@extends('layouts.app')

@section('css')
    @if(!app()->environment(['testing','dusk.local']) && !config('app.vite_disabled'))
        @vite('resources/js/profile-edit.js')
    @endif
@endsection

@section('content')
<div class="container">
    @if(session('message'))
        <div class="message-box">
            <p class="message">{{session('message')}}</p>
    </div>
    @endif
    <div class="profile__form">
        <h1 class ="form-title">プロフィール設定</h1>
        <form class="form__inner" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
        @method('PATCH')@csrf
            <div class="image">
                <div class="image__inner">
                    <div class="current-image">
                        <img class="icon" src="{{Storage::url($profile?->image)}}" id="profilePreview" alt="{{$profile?->name ?? 'プロフィール画像' }}">
                    </div>
                    <div class="change__icon">
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" class="file-input">
                        <label for="image" class="image-label" id="selectImageButton">画像を選択する</label>
                    </div>
                </div>
                <div class="error">
                    @foreach($errors->get('image') as $message)
                        <p class="error-message">{{$message}}</p>
                    @endforeach
                </div>
            </div>
            <div class="name">
                <label class="form-label" for="post_code">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $profile?->name ?? '') }}" class="input-box">
                <div class="error">
                    @foreach($errors->get('name') as $message)
                        <p class="error-message">{{$message}}</p>
                    @endforeach
                </div>
            </div>
            <div class="post_code">
                <label class="form-label" for="post_code">郵便番号</label>
                <input type="text" name="post_code" id="post_code" value="{{old('post_code', $profile?->post_code ?? '')}}"class="input-box">
                <div class="error">
                    @foreach($errors->get('post_code') as $message)
                        <p class="error-message">{{$message}}</p>
                    @endforeach
                </div>
            </div>
            <div class="address">
                <label class="form-label" for="address">住所</label>
                <input type="text" name="address" id="address" value="{{old('address', $profile?->address ?? '')}}"class="input-box">
                <div class="error">
                    @foreach($errors->get('address') as $message)
                        <p class="error-message">{{$message}}</p>
                    @endforeach
                </div>
            </div>
            <div class="building">
                <label class="form-label" for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{old('building', $profile?->building ?? '')}}"class="input-box">
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
</div>
@endsection
