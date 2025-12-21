@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/item.css')}}">
@endsection
@section('content')
<div class="item-container">
    <div class="item__inner">
        <img class="item-card__image" src="{{asset('storage/' . $item->image)}}" alt="商品画像">
    </div>
    <div class="item__inner">
        <h1  class="item-card__label">{{$item->name}}</h1>
        <p class="item-card__brand">{{$item->brand_name}}</p>
        <p class="item-card__price"><small>￥</small>{{ number_format($item->price) }}<small>(税込)</small></p>
        <div class="item-card__like-comennt">
            <div class="item-card__like">
            @if(auth()->check())
                @if(auth()->user()->likedItems->contains($item->id))
                <form action="{{route('items.unlike',$item->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <img class="liked-button" src="{{asset('storage/images/like.png')}}" alt="">
                        {{$item->likes_count}}
                    </button>
                </form>
                @else
                <form action="{{route('items.like',$item->id)}}" method="post">
                    @csrf
                    <button type="submit">
                        <img class="like-button" src="{{asset('storage/images/like.png')}}" alt="">
                        {{$item->likes_count}}
                    </button>
                </form>
                @endif
            @else
                <span>
                    <img class="like-button" src="{{asset('storage/images/like.png')}}" alt="">
                    {{$item->likes_count}}
                </span>
            @endif
            </div>
            <div>
                <img class="comment-button" src="{{asset('storage/images/comment.png')}}" alt="">
                {{$commentCount}}
            </div>
        </div>
        <div class="purchase-link">
            <a class="purchase" href="{{route('purchase.show',$item->id)}}">購入手続きへ</a>
        </div>
        <h2>商品説明</h2>
        <p>{{$item->description}}</p>
        <h2>商品の情報</h2>
        <div class="item-info">
            <h4>カテゴリー</h4>
            <p class="item-info__category">{{$item->category->name ?? ''}}</p>
        </div>
        <div class="item-info">
            <h4>商品の状態</h4>
            <p class="item-info__condition">{{$item->condition->product_condition}}</p>
        </div>
        <h2 class="item__comment-label">コメント({{$commentCount}})</h2>
        @foreach($item->comments as $comment)
        <img class="profile-icon" src="{{asset('storage/' . ($comment->user->profile->icon_path ?? ''))}}" alt="">
        <strong>{{$comment->user->profile->username ?? ''}}</strong>
        <p class="item__comment-content">{{$comment->content}}</p>
        @endforeach
        <h3>商品へのコメント</h3>
        
        <form action="{{route('comment')}}" method="post">
            @csrf
            <input type="hidden" name="item_id" value="{{$item->id}}">
            <textarea name="content" id="" cols="55" rows="15"></textarea><br>
            <button class="comment-form__button" type="submit">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection