@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection
@section('content')
<h2>商品の出品</h2>
<form action="{{route('items.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="image">商品画像</label>
    <input type="file" name="image" id="image" >
    <h4>商品の詳細</h4>
    <label for="category_id">カテゴリー</label>
    @foreach($categories as $category)
    <label for="">
        <input type="checkbox" name="category_id" value="{{$category->id}}" {{ old('category_id') == $category->id ? 'checked' : '' }}>
        {{$category->name}}
    </label>
    @endforeach
    <label for="condition_id">商品の状態</label>
    <select name="condition_id" id="condition_id">
        <option value="">選択してください</option>
        @foreach($conditions as $condition)
        <option value="{{$condition->id}}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
            {{$condition->product_condition}}
        </option>
        @endforeach
    </select>
    <h4>商品名と説明</h4>
    <label for="name">商品名</label>
    <input type="text" name="name" id="name" value="{{old('name')}}">
    <label for="brand_name">ブランド名</label>
    <input type="text" name="brand_name" id="brand_name" value="{{old('brand_name')}}">
    <label for="description">商品の説明</label>
    <textarea name="description" id="description">{{old('description')}}</textarea>
    <label for="price">販売価格</label>
    <input type="number" name="price" id="price" value="{{old('price')}}">
    <button type="submit">出品する</button>
</form>
@endsection