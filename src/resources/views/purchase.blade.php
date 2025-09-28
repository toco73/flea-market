@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection
@section('content')
<img src="{{asset('storage/' . $item->image)}}" alt="商品画像">
<p  class="item-card__label">{{$item->name}}</p>
<p><small>￥</small>{{ number_format($item->price) }}</p>


<form action="{{route('checkout',['item_id' => $item->id])}}" method="post">
    @csrf
    <label for="payment_method">支払い方法</label>
    <select name="payment_method" id="payment_method">
        <option value="">選択してください</option>
        <option value="コンビニ払い">コンビニ払い</option>
        <option value="カード払い">カード払い</option>
    </select>
    

<p>配送先</p>
<a href="{{route('purchase.address', $item->id)}}">変更する</a>
@if($profile)
<p>
    〒{{$profile->post_code}}<br>
    {{$profile->address}}<br>
    {{$profile->building}}
</p>
@endif
<span>商品代金</span>
<span><small>￥</small>{{ number_format($item->price) }}</span>
<span>支払い方法</span>
<span id="selected_payment_method"></span>


<button type="submit">購入する</button>
</form>

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
