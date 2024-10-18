@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')

@if (session('message'))
<div class="register__error-message">
    <span class="register__error-message-text">{{ session('message') }}</span>
</div>
@endif

<div class="header__wrap">
    <h2 class="header__text">会員登録</h2>
</div>

<form class="form__wrap" action="{{ route('register') }}" method="post">
    @csrf

    <div class="form__item">
        <input class="form__input" type="text" name="name" placeholder="名前" value="{{ old('name') }}">
    </div>
    <div class="form__error">
        <p class="form__error-message">
            @error('name')
            {{ $message }}
            @enderror
        </p>
    </div>

    <div class="form__item">
        <input class="form__input" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
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
        <input class="form__input" type="password" name="password_confirmation" placeholder="確認用パスワード">
    </div>

    <div class="form__item">
        <button class="form__button" type="submit">会員登録</button>
    </div>
</form>

<div class="link__wrap">
    <div class="link__item">
        <p class="link__text">アカウントをお持ちの方はこちら</p>
    </div>
    <div class="link__button">
        <a class="link__btn" href="/login">ログイン</a>
    </div>
</div>
@endsection