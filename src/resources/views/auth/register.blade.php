@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection
@section('content')
<h1>会員登録</h1>
<form action="/register" method="post">
    @csrf
    <label>ユーザー名</label>
    <input type="text" name="name" value="{{old('name')}}">
    <p class="register-page__eeror-message">
        @error('name')
        {{$message}}
        @enderror
    </p>

    <label>メールアドレス</label>
    <input type="email" name="email" value="{{old('email')}}">
    <p class="register-page__eeror-message">
        @error('email')
        {{$message}}
        @enderror
    </p>

    <label>パスワード</label>
    <input type="password" name="password" value="{{old('password')}}">
    <p class="register-page__eeror-message">
        @error('password')
        {{$message}}
        @enderror
    </p>

    <label>確認用パスワード</label>
    <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}">
    <button>登録する</button>
    <a href="/login">ログインはこちら</a>
</form>
@endsection