@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection
@section('content')
<div class="purchase-container">
    <div class="purchase-item__inner">
        <div class="purchase-item__img">
            <img src="{{asset('storage/' . $item->image)}}" alt="商品画像">
        </div>
        <div class="purchase-item__label">
            <p  class="purchase-item__label-name">{{$item->name}}</p>
            <p class="purchase-item__label-price"><small>￥</small>{{ number_format($item->price) }}</p>
        </div>
    </div>
    <form action="{{route('checkout',['item_id' => $item->id])}}" method="post">
        @csrf
        <div class="payment__inner">
            <div class="payment__label">
                <label for="payment_method">支払い方法</label>
            </div>
            <div class="payment__select">
                <select name="payment_method" id="payment_method">
                    <option value="">選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード払い">カード払い</option>
                </select>
            </div>
        </div>
        <div class="address__inner">
            <div class="address__label">
                <p>配送先</p>
            </div>
            <div class="address__link">
                <a href="{{route('purchase.address', $item->id)}}">変更する</a>
            </div>
        </div>
        <div class="address">
            @if($profile)
            <p class="address-info">
                〒{{$profile->post_code}}<br>
                {{$profile->address}}<br>
                {{$profile->building}}
            </p>
            @endif
        </div>
        <div class="price__inner">
            <div class="price-info">
                <div class="price__label">
                    <span>商品代金</span>
                    <span><small>￥</small>{{ number_format($item->price) }}</span>
                </div>
                <div class="price__label">
                    <span>支払い方法</span>
                    <span id="selected_payment_method"></span>
                </div>
            </div>
            <div class="purchase-button">
                <button type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentSelect = document.getElementById('payment_method');
        const displayPayment = document.getElementById('selected_payment_method');

        paymentSelect.addEventListener('change', function () {
            const selected = paymentSelect.value;
            displayPayment.textContent = selected ? selected : '';
        });
    });
</script>
@endsection
