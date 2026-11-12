@extends('layouts.app')

@section('title', __('messages.verify_email_title').' — '.__('messages.brand'))

@section('content')
<div class="auth-wrap glass pad">
    <div class="center mb">
        <div class="auth-icon">📧</div>
        <h1 class="page-title" style="font-size:28px">{{ __('messages.verify_email_title') }}</h1>
        <p class="page-sub">{{ __('messages.verify_sent_to') }} <strong>{{ $email }}</strong></p>
        <p class="hint">{{ __('messages.verify_email_hint') }}</p>
        <p class="hint">{{ __('messages.verify_hint') }} ({{ $minutes }} min)</p>
    </div>

    <form method="POST" action="{{ route('email.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="field">
            <label for="code">{{ __('messages.code_label') }}</label>
            <input id="code" type="text" name="code" value="{{ old('code') }}" class="input code-input" maxlength="6" inputmode="numeric" autocomplete="one-time-code" placeholder="------" required autofocus>
            @error('code') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.verify_btn') }} →</button>
    </form>

    <div class="row between mt muted" style="font-size:13px">
        <form method="POST" action="{{ route('email.verify.resend') }}">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm">↻ {{ __('messages.resend_code') }}</button>
        </form>
        <a href="{{ route('login') }}">{{ __('messages.back_login') }}</a>
    </div>
</div>
@endsection
