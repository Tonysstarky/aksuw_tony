@extends('layouts.app')

@section('title', __('messages.forgot_title').' — '.__('messages.brand'))

@section('content')
<div class="auth-wrap glass pad">
    <div class="center mb">
        <div class="auth-icon">🔑</div>
        <h1 class="page-title" style="font-size:28px">{{ __('messages.forgot_title') }}</h1>
        <p class="page-sub">{{ __('messages.forgot_hint') }}</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label for="email">{{ __('messages.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="name@gmail.com" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.send_code') }} →</button>
    </form>

    <p class="center muted mt"><a href="{{ route('login') }}">← {{ __('messages.back_login') }}</a></p>
</div>
@endsection
