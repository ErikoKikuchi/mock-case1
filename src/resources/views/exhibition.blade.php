@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/exhibition.js')

@section('content')
@if ($errors->any())
  <pre>{{ print_r($errors->all(), true) }}</pre>
@endif
<div class="exhibition">
    <h1 class ="form-title">商品の出品</h1>
    <form class="form__inner" action="{{route('exhibition.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="image">
            <span class="form-title">商品画像</span>
            <div class="image__inner">
                <img class="product-image is-hidden" id="productPreview" alt="商品画像">
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg" class="file-input">
                <label for="image" class="upload-btn" id="selectImageButton">画像を選択する</label>
            </div>
        </div>
        <div class="detail">
            <h2 class="form-title">商品の詳細</h2>
            <div class="category-form">
                <span class="form-label">カテゴリー</span>
                <div class="checkbox">
                    <input class="category-input" type="checkbox" id="cat1" name="categories[]" value="1" @checked(in_array(1, old('categories', [])))>
                    <label class="category-label" for="cat1" class="category-btn">ファッション</label>
                    <input class="category-input" type="checkbox" id="cat2" name="categories[]" value="2" @checked(in_array(2, old('categories', [])))>
                    <label class="category-label" for="cat2" class="category-btn">家電</label>
                    <input class="category-input" type="checkbox" id="cat3" name="categories[]" value="3" @checked(in_array(3, old('categories', [])))>
                    <label class="category-label" for="cat3" class="category-btn">インテリア</label>
                    <input class="category-input" type="checkbox" id="cat4" name="categories[]" value="4" @checked(in_array(4, old('categories', [])))>
                    <label class="category-label" for="cat4" class="category-btn">レディース</label>
                    <input class="category-input" type="checkbox" id="cat5" name="categories[]" value="5" @checked(in_array(5, old('categories', [])))>
                    <label class="category-label" for="cat5" class="category-btn">メンズ</label>
                    <input class="category-input" type="checkbox" id="cat6" name="categories[]" value="6" @checked(in_array(6, old('categories', [])))>
                    <label class="category-label" for="cat6" class="category-btn">コスメ</label>
                    <input class="category-input" type="checkbox" id="cat7" name="categories[]" value="7" @checked(in_array(7, old('categories', [])))>
                    <label class="category-label" for="cat7" class="category-btn">本</label>
                    <input class="category-input" type="checkbox" id="cat8" name="categories[]" value="8"
                    @checked(in_array(8, old('categories', [])))>
                    <label class="category-label" for="cat8" class="category-btn">ゲーム</label>
                    <input class="category-input" type="checkbox" id="cat9" name="categories[]" value="9"
                    @checked(in_array(9, old('categories', [])))>
                    <label class="category-label" for="cat9" class="category-btn">スポーツ</label>
                    <input class="category-input" type="checkbox" id="cat10" name="categories[]" value="10" @checked(in_array(10, old('categories', [])))>
                    <label class="category-label" for="cat10" class="category-btn">キッチン</label>
                    <input class="category-input" type="checkbox" id="cat11" name="categories[]" value="11" @checked(in_array(11, old('categories', [])))>
                    <label class="category-label" for="cat11" class="category-btn">ハンドメイド</label>
                    <input class="category-input" type="checkbox" id="cat12" name="categories[]" value="12" @checked(in_array(12, old('categories', [])))>
                    <label class="category-label" for="cat12" class="category-btn">アクセサリー</label>
                    <input class="category-input" type="checkbox" id="cat13" name="categories[]" value="13" @checked(in_array(13, old('categories', [])))>
                    <label class="category-label" for="cat13" class="category-btn">おもちゃ</label>
                    <input class="category-input" type="checkbox" id="cat14" name="categories[]" value="14" @checked(in_array(14, old('categories', [])))>
                    <label class="category-label" for="cat14" class="category-btn">ベビー・キッズ</label>
                </div>
            </div>
            <div class="condition-form">
                <span class="form-label">商品の状態</span>
                <div class="selectbox">
                    <select class="select-condition" name="condition" id="condition">
                        <option class="option" value=""></option>
                        <option class="option" value="1" @selected(old('condition')==='1')>良好</option>
                        <option class="option" value="2" @selected(old('condition')==='2')>目立った傷や汚れなし</option>
                        <option class="option" value="3" @selected(old('condition')==='3')>やや傷や汚れあり</option>
                        <option class="option" value="4" @selected(old('condition')==='4')>状態が悪い</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="description">
            <h2 class="form-title">商品名と説明</h2>
            <div>
                <span class="form-label">商品名</span>
                <input class="input-form" type="text" name="title" id="title" value="{{ old('title') }}">
            </div>
            <div>
                <span class="form-label">ブランド名</span>
                <input class="input-form" type="text" name="brand" id="brand" value="{{ old('brand') }}">
            </div>
            <div>
                <span class="form-label">商品の説明</span>
                <textarea class="textarea-form" type="text" name="description" id="description">{{old('description')}}</textarea>
            </div>
            <div>
                <span class="form-label">販売価格 </span>
                <p class="mark">￥</p>
                <input class="input-form" type="text" name="price" id="price" value="{{old('price')}}">
            </div>
        </div>
        <div class="button">
            <button class="exhibition-button" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection
