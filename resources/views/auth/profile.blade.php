@extends('layouts.app')

@section('title', __('messages.profile_title').' — '.__('messages.brand'))

@section('content')
<div class="head">
    <div>
        <h1 class="page-title">👤 {{ __('messages.profile_title') }}</h1>
        <p class="page-sub">{{ $user->email }} · <span class="pill">{{ $user->isAdmin() ? __('messages.role_admin') : __('messages.role_user') }}</span></p>
    </div>
</div>

<div class="grid cols-2">
    {{-- Şahsy maglumatlar --}}
    <div class="glass pad">
        <h2 class="card-title mb" style="font-size:20px">🧾 {{ __('messages.profile_info') }}</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">{{ __('messages.name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="input" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label>{{ __('messages.email') }}</label>
                <input type="email" value="{{ $user->email }}" class="input" disabled>
            </div>

            <div class="field">
                <label for="phone">{{ __('messages.phone') }}</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input">
                @error('phone') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="address">{{ __('messages.address') }}</label>
                <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" class="input">
                @error('address') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        </form>
    </div>

    {{-- Paroly üýtgetmek --}}
    <div class="glass pad">
        <h2 class="card-title mb" style="font-size:20px">🛡️ {{ __('messages.change_password_title') }}</h2>
        <p class="hint mb">{{ __('messages.profile_password_hint') }}</p>

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf

            <div class="field">
                <label for="current_password">{{ __('messages.current_password') }}</label>
                <input id="current_password" type="password" name="current_password" class="input" required>
                @error('current_password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="new_password">{{ __('messages.new_password') }}</label>
                <input id="new_password" type="password" name="password" class="input" required>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="new_password_confirmation">{{ __('messages.password_confirm') }}</label>
                <input id="new_password_confirmation" type="password" name="password_confirmation" class="input" required>
            </div>

            <button type="submit" class="btn btn-accent">{{ __('messages.save') }}</button>
        </form>
    </div>
</div>
@endsection
