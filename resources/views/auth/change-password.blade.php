@extends('layouts.app')

@section('title', __('messages.change_password_title').' — '.__('messages.brand'))

@section('content')
<div class="auth-wrap glass pad">
    <div class="center mb">
        <div class="auth-icon">🛡️</div>
        <h1 class="page-title" style="font-size:28px">{{ __('messages.change_password_title') }}</h1>
    </div>

    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf

        <div class="field">
            <label for="current_password">{{ __('messages.current_password') }}</label>
            <input id="current_password" type="password" name="current_password" class="input" required>
            @error('current_password') <div class="error">{{ $message }}</div> @enderror
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

        <div class="row">
            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
            <a href="{{ route('dashboard') }}" class="btn btn-ghost">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
