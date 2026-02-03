@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/purchase.js')

@section('content')
<div class="container">
    <div class="purchase__content">
        <div class="upper-row">
            <div class="product__information">
                <div class="image">
                    <img class="product__image" src="{{asset('storage/'.$product->image)}}" alt="{{$product->title}}">
                </div>
                <div class="price__information">
                    <span class="product__title">{{$product->title}}</span>
                    <div class="product__price">
                        <div class="mark">￥</div>
                        <p class="price">{{number_format($product->price)}}</p>
                    </div>
                </div>
            </div>
            <div class="selected-payment">
                <div class="selected-payment__inner">
                    <p class="label">商品代金</p>
                    <div class="product__price">
                        <div class="mark">￥</div>
                        <p class="price">{{number_format($product->price)}}</p>
                    </div>
                </div>
                <div class="selected-payment__inner" id="selected_payment_display">
                    <p class="label">支払方法</p>
                    <p class="method">{{ $selectedPayment ?? '支払い方法を選択してください' }}</p>
                </div>
            </div>
        </div>
        <div class="middle-row">
            <form id="purchase-form" method="post" action="{{ route('purchase.store') }}" class="purchase-form">
                @csrf
                <div class="payment-select">
                    <label class="payment-method__inner" for="payment__method">支払い方法</label>
                    <select class="payment-method__select" name="payment_method" id="payment_method_select">
                        <option value="">選択してください</option>
                        <option value="convenience" @selected(old('payment_method', $selectedPayment) === 'convenience')>コンビニ払い</option>
                        <option value="card" @selected(old('payment_method', $selectedPayment) === 'card')>カード支払い</option>
                    </select>
                    <div class="error">
                        @foreach($errors->get('payment_method') as $message)
                            <p class="error-message">{{$message}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="purchase-button">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @if($shippingAddress)
                        <input type="hidden" name="shipping_address_id" value="{{ $shippingAddress->id }}">
                    @endif
                    <button class="purchase-button__submit" type="submit">購入する</button>
                </div>
            </form>
        </div>
        <div class="bottom-row">
            <div class="address__information">
                <div class="label__inner">
                    <span class="address-label">配送先</span>
                    <a class="link" href="{{route('shipping.address.edit', ['item_id' => $product->id])}}">変更する</a>
                </div>
                <div class="address">
                    @if($shippingAddress)
                        <div class="post_code">
                            <p class ="address-information">〒</p>
                            <p class ="address-information">{{ $shippingAddress->post_code }}</p>
                        </div>
                        <p class ="address-information">{{ $shippingAddress->address }}</p>
                        <p class ="address-information">{{ $shippingAddress->building }}</p>
                    @else
                        <div class="post_code">
                            <p class ="address-information">〒</p>
                            <p class ="address-information">{{ $profile->post_code}}</p>
                        </div>
                        <p class ="address-information">{{$profile->address}}</p>
                        <p class ="address-information">{{$profile->building}}</p>
                    @endif
                    </p>
                </div>
            </div>
            <div class="empty"></div>
        </div>
    </div>
</div>
@endsection
