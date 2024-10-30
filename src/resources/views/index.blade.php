@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="header__wrap">
    <p class="header__text">
        {{ Auth::user()->name }}さんお疲れ様です！
    </p>
</div>

<form class="form__wrap" action="{{ route('work') }}" method="post">
    @csrf

    <div class="form__item">
        {{-- 勤務開始ボタン --}}
        <input type="checkbox" id="start_work" name="start_work" class="form__item-button"
            {{ $status !== 0 ? 'disabled' : '' }}>
        <label for="start_work" class="form__item-label">勤務開始</label>
    </div>

    <div class="form__item">
        {{-- 勤務終了ボタン --}}
        <input type="checkbox" id="end_work" name="end_work" class="form__item-button"
            {{ $status !== 1 ? 'disabled' : '' }}>
        <label for="end_work" class="form__item-label">勤務終了</label>
    </div>

    <div class="form__item">
        {{-- 休憩開始ボタン --}}
        <input type="checkbox" id="start_rest" name="start_rest" class="form__item-button"
            {{ $status !== 1 ? 'disabled' : '' }}>
        <label for="start_rest" class="form__item-label">休憩開始</label>
    </div>

    <div class="form__item">
        {{-- 休憩終了ボタン --}}
        <input type="checkbox" id="end_rest" name="end_rest" class="form__item-button"
            {{ $status !== 2 ? 'disabled' : '' }}>
        <label for="end_rest" class="form__item-label">休憩終了</label>
    </div>

</form>
@endsection