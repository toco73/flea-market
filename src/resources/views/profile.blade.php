@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
@section('content')
<div class="profile-container">
    <h1>プロフィール設定</h1>
    <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="plofile__icon">
            <img src="" alt="プロフィール画像">
            <label class="plofile__icon-label" for="icon_path">
                画像を選択する
            </label><br>
            <input type="file" name="icon_path" id="icon_path"><br>
        </div>
        <label for="username">ユーザー名</label><br>
        <input type="text" name="username" value="{{$profile->username ?? ''}}"><br>
        
        <label for="post_code">郵便番号</label><br>
        <input type="text" name="post_code" value="{{ old('post_code', $profile->post_code ?? '') }}"><br>

        <label for="">住所</label><br>
        <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}"><br>

        <label for="">建物名</label><br>
        <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}"><br>
        <button type="submit">更新する</button>
    </form>
</div>
@endsection