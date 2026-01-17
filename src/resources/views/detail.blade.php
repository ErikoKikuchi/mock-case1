@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/detail.js')

@section('content')
<article class="product-detail">
    <div class="product-image">
        <img class="product__image" src="{{asset('storage/'.$product->image)}}" alt="{{$product->title}}">
    </div>
    <div class="product-detail__inner">
        <h1 class="product__title">{{$product->title}}</h1>
        <p class="product__brand">{{$product->brand}}</p>
        <div class="product__price">
            <div>￥</div>
            <p>{{$product->price}}</p>
            <div>(税込)</div>
        </div>
        <div class="product__interaction">
            <div class="like-product">
                <form class="like-product__button" method="POST" action="{{ route('like.product', $product) }}">@csrf
                    @if(auth()->user()?->hasliked($product->id))
                        <button type="submit">
                        <img class="like__icon" src="{{asset('images/ハートロゴ_ピンク.png')}}" alt="いいね解除"></button>
                    @else
                        <button type="submit">
                            <img class="unlike__icon" src="{{asset('images/ハートロゴ_デフォルト.png')}}" alt="いいね" >
                        </button>
                    @endif
                </form>
                <div class="like-counts">{{$product->likes_count}}</div>
            </div>
            <div class="comment-counts">
                <img class="comments-icon" src="{{asset('images/ふきだしロゴ.png')}}" alt="コメント数" >
                <div class>{{$product->comments_count}}</div>
            </div>
        </div>
        <div class="product__purchase">
            <form action="" method="post">
                <input type="hidden" name="" value="">
                <button type="submit"></button>
            </form>
        </div>
        <h2></h2>
        <div class="product__description">
            <div></div>
        </div>
        <h2></h2>
        <div class="product__information">
            <div></div>
            <div></div>
        </div>
        <h2></h2>
        <div class="count__comment">
        <div class="product__comment">
            <div class="commenter__name"></div>
            <div class="comment__content"></div>
            <form action="" method="post">
                <textarea name="" id="" cols="30" rows="10"></textarea>
                <button type="submit"></button>
            </form>
        </div>
    </div>
</article>
@endsection
