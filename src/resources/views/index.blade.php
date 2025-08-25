@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection
@section('content')
<div class="content">
    <div class="tabs">
        <a href="">おすすめ</a>
        <a href="">マイリスト</a>
    </div>
    <div class="item-grid">
        <div class="item-card">
            <a href="">
                <img src="" alt="商品画像" class="item-card__image">
                <label  class="item-card__label">商品名</label>
            </a>  
        </div>
    </div>
</div>
@endsection