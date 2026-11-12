@extends('layouts.app')

@section('title', __('messages.login_title').' — '.__('messages.brand'))

@section('content')
<div class="auth-wrap glass pad">
    <div class="center mb">
        <div class="auth-icon">🔐</div>
        <h1 class="page-title" style="font-size:28px">{{ __('messages.login_title') }}</h1>
        <p class="page-sub">{{ __('messages.login_sub') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="email">{{ __('messages.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="name@gmail.com" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password">{{ __('messages.password') }}</label>
            <input id="password" type="password" name="password" class="input" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <label class="check"><input type="checkbox" name="remember" value="1"> {{ __('messages.remember') }}</label>

        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.nav_login') }} →</button>
    </form>

    <p class="center muted mt"><a href="{{ route('password.request') }}"><u>{{ __('messages.forgot_link') }}</u></a></p>
    <p class="center muted mt">{{ __('messages.no_account') }} <a href="{{ route('register') }}"><strong>{{ __('messages.nav_register') }}</strong></a></p>
</div>
@endsection
