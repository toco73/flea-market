@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection
@section('content')
<div class="login-container">
    <h1>ログイン</h1>
    <form action="/login" method="post">
        @csrf
        <label>メールアドレス</label><br>
        <input type="email" name="email" value="{{old('email')}}">
        <p class="login-page__eeror-message">
            @error('email')
            {{$message}}
            @enderror
        </p>
        <label>パスワード</label><br>
        <input type="password" name="password" value="{{old('password')}}">
        <p class="login-page__eeror-message">
            @error('password')
            {{$message}}
            @enderror
        </p>
        <button>ログインする</button><br>
        <a href="/register">会員登録はこちら</a>
    </form>
</div>
@endsection