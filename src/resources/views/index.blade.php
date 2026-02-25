@extends('layouts.app')

@section('css')
    @if(!app()->environment(['testing','dusk.local']) && !config('app.vite_disabled'))
        @vite('resources/js/index.js')
    @endif
@endsection


@section('content')
<div class="container">
    <div class = "tab__group">
        <div class="index-tab {{ request('tab') !== 'mylist' ? 'active' : '' }}">
            <a class="index-tab__link" href="{{ route('home', ['keyword' => request('keyword')]) }}">おすすめ</a>
        </div>
        <div class="mylist-tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
            <a class="mylist-tab__link" href="{{ route('home', ['keyword' => request('keyword'), 'tab' => 'mylist']) }}">マイリスト</a>
        </div>
    </div>
    <div class = "product__content">
        @if(session('message'))
            <div class="message-box">
                <p class="message">{{session('message')}}</p>
            </div>
        @endif
        <div class ="product__list">
            @forelse($products as $product)
                <a class="product-card" href="{{route('item.detail',['item_id'=>$product->id])}}">
                    <div class="product-card__inner" >
                        <div class="image">
                            <img class="product__image" src="{{Storage::url($product->image)}}" alt="{{$product->title}}">
                        </div>
                        <p class="product__title">{{ $product->title }}</p>
                    @if($product->isSold())
                        <span  class="product__sold">SOLD</span>
                    @endif
                    </div>
                </a>
            @empty
                @auth
                    @if($tab === 'mylist')
                        <p>マイリストに商品はありません</p>
                    @endif
                @endauth
            @endforelse
        </div>
    </div>
</div>
@endsection
