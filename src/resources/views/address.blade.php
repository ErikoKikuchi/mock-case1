@extends('layouts.app')

@vite('resources/js/app.js')
@vite('resources/js/address.js')

@section('content')
<div class="shipping-address__form">
    <h1 class ="form-title">住所の変更</h1>
    <form class="form__inner" action="{{route('update.shipping-address', $product->id)}}" method="POST">
        @method('PATCH')@csrf
        <div class="post_code">
            <label class="form-label" for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" value="{{ $user->shippingAddress->post_code ?? '' }}">
        </div>
        <div class="address">
            <label class="form-label" for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ $user->shippingAddress->address ?? '' }}">
        </div>
        <div class="building">
            <label class="form-label" for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ $user->shippingAddress->building ?? '' }}">
        </div>
        <div class="button">
            <button class="update-button" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection
