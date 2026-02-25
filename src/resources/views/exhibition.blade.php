@extends('layouts.app')

@section('css')
    @if(!app()->environment(['testing','dusk.local']) && !config('app.vite_disabled'))
        @vite('resources/js/exhibition.js')
    @endif
@endsection

@section('content')
<div class="container">
    <div class="exhibition">
        <h1 class ="form-title__top">商品の出品</h1>
        <form class="form__inner" action="{{route('exhibition.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="image">
                <span class="form-label">商品画像</span>
                <div class="image__inner">
                    <img class="product-image is-hidden" id="productPreview" alt="商品画像">
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" class="file-input">
                    <label for="image" class="upload-btn" id="selectImageButton">画像を選択する</label>
                </div>
            </div>
            <div class="error">
                @foreach($errors->get('image') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
            <div class="detail">
                <h2 class="form-title">商品の詳細</h2>
                <div class="category-form">
                    <span class="form-label">カテゴリー</span>
                    <div class="checkbox">
                        <input class="category-input" type="checkbox" id="cat1" name="categories[]" value="1" @checked(in_array(1, old('categories', [])))>
                        <label class="category-label" for="cat1" >ファッション</label>
                        <input class="category-input" type="checkbox" id="cat2" name="categories[]" value="2" @checked(in_array(2, old('categories', [])))>
                        <label class="category-label" for="cat2" >家電</label>
                        <input class="category-input" type="checkbox" id="cat3" name="categories[]" value="3" @checked(in_array(3, old('categories', [])))>
                        <label class="category-label" for="cat3" >インテリア</label>
                        <input class="category-input" type="checkbox" id="cat4" name="categories[]" value="4" @checked(in_array(4, old('categories', [])))>
                        <label class="category-label" for="cat4" >レディース</label>
                        <input class="category-input" type="checkbox" id="cat5" name="categories[]" value="5" @checked(in_array(5, old('categories', [])))>
                        <label class="category-label" for="cat5">メンズ</label>
                        <input class="category-input" type="checkbox" id="cat6" name="categories[]" value="6" @checked(in_array(6, old('categories', [])))>
                        <label class="category-label" for="cat6" >コスメ</label>
                        <input class="category-input" type="checkbox" id="cat7" name="categories[]" value="7" @checked(in_array(7, old('categories', [])))>
                        <label class="category-label" for="cat7" >本</label>
                        <input class="category-input" type="checkbox" id="cat8" name="categories[]" value="8"
                        @checked(in_array(8, old('categories', [])))>
                        <label class="category-label" for="cat8" >ゲーム</label>
                        <input class="category-input" type="checkbox" id="cat9" name="categories[]" value="9"
                        @checked(in_array(9, old('categories', [])))>
                        <label class="category-label" for="cat9" >スポーツ</label>
                        <input class="category-input" type="checkbox" id="cat10" name="categories[]" value="10" @checked(in_array(10, old('categories', [])))>
                        <label class="category-label" for="cat10" >キッチン</label>
                        <input class="category-input" type="checkbox" id="cat11" name="categories[]" value="11" @checked(in_array(11, old('categories', [])))>
                        <label class="category-label" for="cat11" >ハンドメイド</label>
                        <input class="category-input" type="checkbox" id="cat12" name="categories[]" value="12" @checked(in_array(12, old('categories', [])))>
                        <label class="category-label" for="cat12" >アクセサリー</label>
                        <input class="category-input" type="checkbox" id="cat13" name="categories[]" value="13" @checked(in_array(13, old('categories', [])))>
                        <label class="category-label" for="cat13" >おもちゃ</label>
                        <input class="category-input" type="checkbox" id="cat14" name="categories[]" value="14" @checked(in_array(14, old('categories', [])))>
                        <label class="category-label" for="cat14" >ベビー・キッズ</label>
                    </div>
                    <div class="error">
                        @foreach($errors->get('categories') as $message)
                            <p class="error-message">{{$message}}</p>
                        @endforeach
            </div>
                </div>
                <div class="condition-form">
                    <span class="form-label">商品の状態</span>
                    <div class="selectbox">
                        <select class="select-condition" name="condition" id="condition">
                            <option class="option" value="" selected disabled hidden>選択してください</option>
                            <option class="option" value="1" @selected(old('condition')==='1')>良好</option>
                            <option class="option" value="2" @selected(old('condition')==='2')>目立った傷や汚れなし</option>
                            <option class="option" value="3" @selected(old('condition')==='3')>やや傷や汚れあり</option>
                            <option class="option" value="4" @selected(old('condition')==='4')>状態が悪い</option>
                        </select>
                    </div>
                </div>
                <div class="error">
                    @foreach($errors->get('condition') as $message)
                        <p class="error-message">{{$message}}</p>
                    @endforeach
                </div>
            </div>
            <div class="description">
                <h2 class="form-title">商品名と説明</h2>
                <div class="description-form">
                    <span class="form-label">商品名</span>
                    <input class="input-form" type="text" name="title" id="title" value="{{ old('title') }}">
                </div>
                @foreach($errors->get('title') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
                <div class="description-form">
                    <span class="form-label">ブランド名</span>
                    <input class="input-form" type="text" name="brand" id="brand" value="{{ old('brand') }}">
                </div>
                @foreach($errors->get('brand') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
                <div class="description-form">
                    <span class="form-label">商品の説明</span>
                    <textarea class="textarea-form" type="text" name="description" id="description">{{old('description')}}</textarea>
                </div>
                @foreach($errors->get('description') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
                <div class="price-input">
                    <span class="form-label">販売価格 </span>
                    <p class="mark">￥</p>
                    <input class="input-form" type="text" name="price" id="price" value="{{old('price')}}">
                </div>
                @foreach($errors->get('price') as $message)
                    <p class="error-message">{{$message}}</p>
                @endforeach
            </div>
            <div class="button">
                <button class="exhibition-button" type="submit">出品する</button>
            </div>
        </form>
    </div>
</div>
@endsection
