@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection
@section('content')
<div class="mypage-profile">
    <img src="" alt="">
    <h1>{{$profile->username}}</h1>
    <a href="{{route('mypage.profile')}}">プロフィールを編集</a>
</div>
<div class="tabs">
    <a href="{{url('/mypage?page=sell')}}"  class="{{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
    <a href="{{url('/mypage?page=buy')}}"  class="{{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
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
    @endif
</div>
@endsection