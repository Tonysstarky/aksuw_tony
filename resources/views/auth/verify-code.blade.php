@extends('layouts.app')

@section('title', __('messages.verify_title').' — '.__('messages.brand'))

@section('content')
<div class="auth-wrap glass pad">
    <div class="center mb">
        <div class="auth-icon">📬</div>
        <h1 class="page-title" style="font-size:28px">{{ __('messages.verify_title') }}</h1>
        <p class="page-sub">{{ __('messages.verify_sent_to') }} <strong>{{ $email }}</strong></p>
        <p class="hint">{{ __('messages.verify_hint') }} ({{ $minutes }} min)</p>
    </div>

    <form method="POST" action="{{ route('password.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="field">
            <label for="code">{{ __('messages.code_label') }}</label>
            <input id="code" type="text" name="code" value="{{ old('code') }}" class="input code-input" maxlength="6" inputmode="numeric" autocomplete="one-time-code" placeholder="------" required autofocus>
            @error('code') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password">{{ __('messages.new_password') }}</label>
            <input id="password" type="password" name="password" class="input" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">{{ __('messages.password_confirm') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.reset_btn') }} →</button>
    </form>

    <div class="row between mt muted" style="font-size:13px">
        <a href="{{ route('password.request') }}">↻ {{ __('messages.resend_code') }}</a>
        <a href="{{ route('login') }}">{{ __('messages.back_login') }}</a>
    </div>
</div>
@endsection
