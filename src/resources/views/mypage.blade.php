@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection
@section('content')
{{-- エラーメッセージの表示 --}}
@if (session('error_message'))
    <div class="alert alert-danger" style="color: red; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        {{ session('error_message') }}
    </div>
@endif

{{-- 成功メッセージ（もしあれば）の表示 --}}
@if (session('message'))
    <div class="alert alert-success" style="color: green; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        {{ session('message') }}
    </div>
@endif
<div class="mypage-profile">
    <img class="profile-icon" src="{{asset('storage/' . ($profile->icon_path ?? ''))}}" alt="">
    <h1>{{$profile->username}}</h1>
    <a href="{{route('profile.edit')}}">プロフィールを編集</a>
</div>
<div class="tabs">
    <a href="{{url('/mypage?page=sell')}}"  class="{{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
    <a href="{{url('/mypage?page=buy')}}"  class="{{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
    <a href="{{url('/mypage?page=transaction')}}"  class="{{ $page === 'transaction' ? 'active' : '' }}">
        取引中の商品
        @if(isset($transaction_count) && $transaction_count > 0)
            <span class="tab-count">{{ $transaction_count }}</span>
        @endif
    </a>
</div>
<div class="item-grid">
    @if($page === 'sell')
        @foreach($items as $item)
            <div class="item-card">
                <a href="{{route('item',$item->id)}}">
                    <img class="item-card__image" src="{{asset('storage/' . $item->image)}}" alt="商品画像">
                    <p  class="item-card__label">{{$item->name}}</p>
                </a>  
            </div>
        @endforeach
    @elseif($page === 'buy')
        @foreach($items as $item)
            <div class="item-card">
                <a href="{{route('item',$item->id)}}">
                    <img class="item-card__image" src="{{asset('storage/' . $item->image)}}" alt="商品画像">
                    <p  class="item-card__label">{{$item->name}}</p>
                </a>  
            </div>
        @endforeach
    @elseif($page === 'transaction')
        @foreach($items as $item)
            <div class="item-card">
                <a href="{{route('transaction.chat', $item->id)}}}">
                    <img class="item-card__image" src="{{asset('storage/' . $item->image)}}" alt="商品画像">
                    <p  class="item-card__label">{{$item->name}}</p>
                </a>
            </div>
        @endforeach
    @endif
</div>
@endsection