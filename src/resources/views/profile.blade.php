@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
@section('content')
<h2>プロフィール設定</h2>
<form action="">
    @csrf
    <img src="" alt="">
    <label for="">
        画像を選択する
        <input type="file">
    </label>
    <label for="">ユーザー名</label>
    <input type="text" name="name">
    <label for="">郵便番号</label>
    <input type="text" name="post_code">
    <label for="">住所</label>
    <input type="text" name="address">
    <label for="">建物名</label>
    <input type="text" name="building">
    <button>更新する</button>
</form>
@endsection