@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
@section('content')
<div class="profile-container">
    <h1>プロフィール設定</h1>
    <div class="profile__innner">
        <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="profile__icon">
                <img class="profile__icon-img" src="{{asset('storage/' . ($profile->icon_path ?? ''))}}" alt="プロフィール画像">
                <label class="profile__icon-label" for="icon_path">
                    画像を選択する
                </label>
                <input type="file" name="icon_path" id="icon_path">
            </div>
            <div>
                <label for="username">ユーザー名</label><br>
                <input type="text" name="username" value="{{old('username',$profile->username ?? '')}}" id="username">
            </div>
            <div>
                <label for="post_code">郵便番号</label><br>
                <input type="text" name="post_code" value="{{old('post_code',$profile->post_code ?? '')}}" id="post_code">
            </div>
            <div>
                <label for="">住所</label><br>
                <input type="text" name="address" value="{{old('address',$profile->address ?? '')}}" id="address">
            </div>
            <div>
                <label for="">建物名</label><br>
                <input type="text" name="building" value="{{old('building', $profile->building ?? '')}}" id="building">
            </div>
            <div>
                <button type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection