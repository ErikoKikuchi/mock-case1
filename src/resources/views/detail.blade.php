@extends('layouts.app')

@section('css')
    @if(!app()->environment('testing'))
        @vite('resources/js/detail.js')
        @endif
@endsection

@section('content')
<div class="container">
    <article class="product-detail">
        <div class="product-image">
            <img class="product__image" src="{{Storage::url($product->image)}}" alt="{{$product->title}}">
        </div>
        <div class="product-detail__inner">
            <h1 class="product__title">{{$product->title}}</h1>
            <p class="product__brand">{{$product->brand}}</p>
            <div class="product__price">
                <div class="mark">￥</div>
                <p class="price">{{number_format($product->price)}}</p>
                <div class="mark">(税込)</div>
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
                    <div class="count">{{$product->comments_count}}</div>
                </div>
            </div>
            <div class="product__purchase">
                <form class="purchase__form" action="{{route('purchase.show',$product->id)}}" method="get">
                    <button class ="purchase__form-button" type="submit">購入手続きへ</button>
                </form>
            </div>
            <h2 class="form-title">商品説明</h2>
            <div class="product__description">
                <p class="description">{{$product->description}}</p>
            </div>
            <h2 class="form-title">商品の情報</h2>
            <div class="product__information">
                <div class="category">
                    <h3 class="form-label">カテゴリー</h3>
                    <div class="category__information">
                        @foreach($product->categories as $category)
                        <p class="category__detail">{{$category->name}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="condition">
                    <h3 class="form-label">商品の状態</h3>
                    <p class="condition__information">{{$product->condition_label}}</p>
                </div>
            </div>
            <div class="comment">
            <h2 class="form-title__comment">コメント</h2>
                <div class="count__comment">
                    <p class="parentheses">(</p>
                    <p class="count__number">{{$product->comments_count}}</p>
                    <p class="parentheses">)</p>
                </div>
            </div>
            <div class="product__comment">
                @forelse($product->comments as $comment)
                <div class="commenter__name">
                    <div class="image-input">
                        <img class="icon" src="{{Storage::url($comment->user?->profile?->image)}}" alt="ユーザーアイコン">
                    </div>
                    <span class="name">
                        {{ $comment->user?->profile?->name ?? '退会ユーザー' }}
                    </span>
                </div>
                <div class="comment__inner">
                    <p class="comment__body">
                    {{ $comment->body }}
                    </p>
                </div>
                @empty
                <div class="comment__inner">
                    <p class="comment-alert">コメントがありません</p>
                </div>
                @endforelse
                <h3 class="new__comment">商品へのコメント</h3>
                <form class="comment__input" action="{{route('comment',$product->id)}}" method="post">@csrf
                    <textarea name="body" id="body" class="textarea__input"></textarea>
                    <div class="error">
                    @foreach($errors->get('body') as $message)
                        <p class="error-message">{{$message}}</p>
                    @endforeach
                </div>
                    <button class="send__comment" type="submit">コメントを送信する</button>
                </form>
            </div>
        </div>
    </article>
</div>
@endsection
