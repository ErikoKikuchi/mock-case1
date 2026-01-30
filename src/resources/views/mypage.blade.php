@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/mypage.js')

@section('content')
<div class="mypage">
    @if(session('message'))
        <div class="message-box">
            <p class="message">{{session('message')}}</p>
        </div>
    @endif
    <div class="user-information">
        <div class="profile-image">
            <img class="icon" src="{{Storage::url($profile->image)}}" alt="{{ $profile->name }}">
        </div>
        <div class="name">
            <p class="user-name">{{$profile->name}}</p>
        </div>
        <div class="profile-edit">
            <form class="profile-edit__form" action="{{route('profile.edit')}}" method="get">
                <button class="profile-edit__button" type="submit">プロフィールを編集</button>
            </form>
        </div>
    </div>
    <div class = "tab__group">
        <div class="mypage-tab {{ request('tab', 'isSellerOf') === 'isSellerOf' ? 'active' : '' }}">
            <a class="mypage__link" href="{{ route('mypage',['tab' => 'isSellerOf']) }}">出品した商品</a>
        </div>
        <div class="mypage-tab {{ request('tab') === 'hasPurchased' ? 'active' : '' }}">
            <a class="mypage__link" href="{{ route('mypage', ['tab' => 'hasPurchased']) }}">購入した商品</a>
        </div>
    </div>
    <div class="mypage-container">
        @foreach($products as $product)
            <a class="product-card" href="{{route('mypage',['item_id'=>$product->id])}}">
                <div class="product-card__inner" >
                    <div class="image">
                        <img class="product__image" src="{{Storage::url($product->image)}}" alt="{{$product->title}}">
                    </div>
                    <p class="product__title">{{ $product->title }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
