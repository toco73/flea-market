@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/verify.css')}}">
@endsection
@section('content')
<p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>
<form action="">
    @csrf
    <button>認証はこちらから</button>
    <a href="">認証メールを再送する</a>
</form>
@endsection