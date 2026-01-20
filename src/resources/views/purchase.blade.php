@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/purchase.js')

@section('content')
<div class="purchase__content">
    <div class="upper-row">
        <div class="product__information">
            <div class="product__image">
                <img class="product__image" src="{{asset('storage/'.$product->image)}}" alt="{{$product->title}}">
            </div>
            <div class="price__information">
                <span class="product__title">{{$product->title}}</span>
                <div class="product__price">
                    <div>￥</div>
                    <p>{{$product->price}}</p>
                </div>
            </div>
        </div>
        <div class="selected-payment">
            <div class="selected-payment__inner">
                <p class="label">商品代金</p>
                <div class="product__price">
                    <div>￥</div>
                    <p>{{$product->price}}</p>
                </div>
            </div>
            <div class="selected-payment__inner" id="selected_payment_display">
                <p class="label">支払方法</p>
                @if($selectedPayment)
                    {{ $selectedPayment->payment_method}}
                @else
                <p class ="message">支払い方法を選択してください</p>
                @endif
            </div>
        </div>
    </div>
    <div class="middle-row">
        <div class="payment-select">
            <label class="payment-method__inner" for="payment__method">支払い方法</label>
            <select class="payment-method__select" name="payment_method_id" id="payment_method_select">
                <option value="">選択してください</option>
                <option value="convenience"{{ $selectedPayment?->value == 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                <option value="card" {{ $selectedPayment?->value == 'card' ? 'selected' : '' }}>カード支払い</option>
            </select>
            <!--選択した支払方法を即時表示のためのjavascript-->
            <script>
                const select = document.getElementById('payment_method_select');
                const display = document.getElementById('selected_payment_display');
                const hiddenInput = document.getElementById('hidden_payment_method');
                select.addEventListener('change', function() {
                    const selectedOption = select.options[select.selectedIndex];
                    display.innerHTML = ` ${selectedOption.text}`;
                    hiddenInput.value = selectedOption.value;
            });
            </script>
        </div>
        <div class="purchase-button">
            <form id="purchase-form" method="post" action="{{ route('purchase.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="payment_method_id" id="hidden_payment_method" value="{{ $selectedPayment->id ?? '' }}">
                <button type="submit">購入する</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="address__information">
            <div class="label__inner">
                <span class="label">配送先</span>
                <a class="link" href="{{route('profile.edit')}}"></a>
            </div>
            <div class="address">
                <p>{{$address->user?->profile->post_code}}</p>
                <p>{{$address->user?->profile->address}}</p>
                <p>{{$address->user?->profile->building}}</p>
            </div>
        </div>
        <div class="empty"></div>
    </div>
</div>
@endsection
