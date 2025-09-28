@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection
@section('content')
<div class="tabs">
    <a href="{{url('/?tab=recommend&keyword=' . request('keyword'))}}" class="{{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
    <a href="{{url('/?tab=mylist&keyword=' . request('keyword'))}}" class="{{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>
<div class="item-grid">
    @if($tab === 'recommend')
        @foreach($items as $item)
        <div class="item-card">
            <a href="{{route('item',$item->id)}}">
                <img class="item-card__image" src="{{asset('storage/' . $item->image)}}" alt="商品画像">
                <p  class="item-card__label">{{$item->name}}</p>

                @if($item->isSold())
                <span>Sold</span>
                @endif
            </a>  
        </div>
        @endforeach
    @elseif($tab === 'mylist')
        @if($myList->count() > 0)
            @foreach($myList as $item)
            <div class="item-card">
                <a href="{{route('item',$item->id)}}">
                    <img class="item-card__image" src="{{asset('storage/' . $item->image)}}" alt="商品画像">
                    <p  class="item-card__label">{{$item->name}}</p>

                    @if($item->isSold())
                    <span>Sold</span>
                    @endif
                </a>  
            </div>
            @endforeach
        @endif
    @endif
</div>
@endsection