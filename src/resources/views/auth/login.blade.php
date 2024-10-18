@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')

@if (session('message'))
<div class="login__error-message">
    <span class="login__error-message-text">{{ session('message') }}</span>
</div>
@endif

<div class="header__wrap">
    <h2 class="header__text">ログイン</h2>
</div>

<form class="form__wrap" action="/login" method="post">
    @csrf

    <div class="form__item">
        <input class="form__input" type="email" name="email" placeholder="メールアドレス">
    </div>

    <div class="form__error">
        <p class="form__error-message">
            @error('email')
                {{ $message }}
            @enderror
        </p>
    </div>

    <div class="form__item">
        <input class="form__input" type="password" name="password" placeholder="パスワード">
    </div>

    <div class="form__error">
        <p class="form__error-message">
            @error('password')
                {{ $message }}
            @enderror
        </p>
    </div>

    <div class="form__item">
        <button class="form__button" type="submit">ログイン</button>
    </div>
</form>

<div class="link__wrap">
    <div class="link__item">
        <p class="link__text">
            アカウントをお持ちでない方はこちらから
        </p>ん
    </div>

    <div class="link__button">
        <a class="link__btn" href="/register">会員登録</a>
    </div>
</div>

@endsection
