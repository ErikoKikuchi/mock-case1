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
            <form class="purchase__form" action="{{route('purchase.show',$product->id)}}" method="get">@csrf
                <button class ="purchase__form-button" type="submit">購入手続きへ</button>
            </form>
        </div>
        <h2>商品説明</h2>
        <div class="product__description">
            <p class="description">{{$product->description}}</p>
        </div>
        <h2>商品の情報</h2>
        <div class="product__information">
            <div class="category">カテゴリー</div>
            <div class="category__information">
                @foreach($product->categories as $category)
                <p class="category__detail">{{$category->name}}</p>
                @endforeach
            </div>
            <div class="condition">商品の状態</div>
            <p class="condition__information">{{$product->condition_label}}</p>
        </div>
        <h2>コメント</h2>
        <div class="count__comment">
            <p class="parentheses">(</p>
            <p class="count__number">{{$product->comments_count}}</p>
            <p class="parentheses">)</p>
        </div>
        <div class="product__comment">
            @forelse($product->comments as $comment)
            <div class="commenter__name">
                <img class="icon" src="{{Storage::url($comment->user?->profile?->image)}}" alt="ユーザーアイコン">
                <span>
                    {{ $comment->user?->profile?->name ?? '退会ユーザー' }}
                </span>
            </div>
            <p class="comment__body">
                {{ $comment->body }}
            </p>
            @empty
            <p class="comment-alert">コメントがありません</p>
            @endforelse
            <h3 class="new__comment">商品へのコメント</h3>
            <form class="comment__input" action="{{route('comment',$product->id)}}" method="post">@csrf
                <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                <button class="send__comment" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</article>
@endsection
