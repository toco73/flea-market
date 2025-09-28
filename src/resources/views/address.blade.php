@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/address.css')}}">
@endsection
@section('content')
<div class="address-container">
    <h2>住所の変更</h2><br>
    <form action="{{route('purchase.address.update',$item->id)}}" method="post">
        @csrf
        @method('PATCH')
        <label for="post_code">郵便番号</label><br>
        <input type="text" name="post_code" value="{{old('post_code',$profile->post_code)}}"><br>
        <label for="address">住所</label><br>
        <input type="text" name="address" value="{{old('address',$profile->address)}}"><br>
        <label for="building">建物名</label><br>
        <input type="text" name="building" value="{{old('building',$profile->building)}}"><br>
        <button type="submit">更新する</button>
    </form>
</div>
@endsection