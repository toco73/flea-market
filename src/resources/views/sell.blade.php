@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection
@section('content')
<div class="sell-container">
    <h1>商品の出品</h1>
    <form action="{{route('items.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="sell__image">
            <div>
                <label for="image">商品画像</label>
            </div>
            <div class="sell__image-input">
                <label class="sell__image-label" for="">画像を選択する</label>
                <input type="file" name="image" id="image">
            </div>
        </div>
        <h2>商品の詳細</h2>
        <h3 for="category_id">カテゴリー</h3>
        @foreach($categories as $category)
        <div class="category">
            <input type="checkbox" name="category_id" value="{{$category->id}}" {{ old('category_id') == $category->id ? 'checked' : '' }}>
            <label for="caategory_id">
                {{$category->name}}
            </label>
        </div>
        @endforeach
        <h3 for="condition_id">商品の状態</h3>
        <select name="condition_id" id="condition_id">
            <option value="">選択してください</option>
            @foreach($conditions as $condition)
            <option value="{{$condition->id}}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                {{$condition->product_condition}}
            </option>
            @endforeach
        </select>
        <div class="item-info">
            <h2>商品名と説明</h2>
            <h3 for="name">商品名</h3>
            <input type="text" name="name" id="name" value="{{old('name')}}">
            <h3 for="brand_name">ブランド名</h3>
            <input type="text" name="brand_name" id="brand_name" value="{{old('brand_name')}}">
            <h3 for="description">商品の説明</h3>
            <textarea name="description" id="description" cols="58" rows="8">{{old('description')}}</textarea>
            <h3 for="price">販売価格</h3>
            <input type="number" name="price" id="price" value="{{old('price')}}">
        </div>
        <button type="submit">出品する</button>
    </form>
</div>
@endsection