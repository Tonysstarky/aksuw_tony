@extends('layouts.app')

@section('title', __('messages.register_title').' — '.__('messages.brand'))

@section('content')
<div class="auth-wrap glass pad">
    <div class="center mb">
        <div class="auth-icon">✨</div>
        <h1 class="page-title" style="font-size:28px">{{ __('messages.register_title') }}</h1>
        <p class="page-sub">{{ __('messages.register_sub') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label for="name">{{ __('messages.name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="input" required autofocus>
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="email">{{ __('messages.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="name@gmail.com" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password">{{ __('messages.password') }}</label>
            <input id="password" type="password" name="password" class="input" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">{{ __('messages.password_confirm') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.nav_register') }} →</button>
    </form>

    <p class="center muted mt">{{ __('messages.have_account') }} <a href="{{ route('login') }}"><strong>{{ __('messages.nav_login') }}</strong></a></p>
</div>
@endsection
