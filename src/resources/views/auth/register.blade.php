@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection
@section('content')
<div class="register-container">
    <h1>会員登録</h1>
    <form action="/register" method="post">
        @csrf
        <label>ユーザー名</label><br>
        <input type="text" name="name" value="{{old('name')}}">
        <p class="register-page__eeror-message">
            @error('name')
            {{$message}}
            @enderror
        </p>

        <label>メールアドレス</label><br>
        <input type="email" name="email" value="{{old('email')}}">
        <p class="register-page__eeror-message">
            @error('email')
            {{$message}}
            @enderror
        </p>

        <label>パスワード</label><br>
        <input type="password" name="password" value="{{old('password')}}">
        <p class="register-page__eeror-message">
            @error('password')
            {{$message}}
            @enderror
        </p>

        <label>確認用パスワード</label><br>
        <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}"><br>
        <button>登録する</button><br>
        <a href="/login">ログインはこちら</a>
    </form>
</div>
@endsection