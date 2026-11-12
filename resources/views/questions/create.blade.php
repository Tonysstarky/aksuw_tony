@extends('layouts.app')

@section('title', __('messages.ask_title').' — '.__('messages.brand'))

@section('content')
<div class="glass pad" style="max-width:720px;margin:0 auto">
    <h1 class="page-title" style="font-size:28px">❓ {{ __('messages.ask_title') }}</h1>
    <p class="page-sub mb">{{ __('messages.ask_sub') }}</p>

    <form method="POST" action="{{ route('questions.store') }}">
        @csrf
        <div class="form-grid">
            <div class="field">
                <label for="name">{{ __('messages.name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="email">{{ __('messages.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="input" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="phone">{{ __('messages.phone') }}</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="input">
                @error('phone') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="field">
                <label for="subject">{{ __('messages.subject') }}</label>
                <input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="input" required>
                @error('subject') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="field full">
                <label for="message">{{ __('messages.message') }}</label>
                <textarea id="message" name="message" class="input" required>{{ old('message') }}</textarea>
                @error('message') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary">{{ __('messages.send_question') }} →</button>
            <a href="{{ route('questions.my') }}" class="btn btn-ghost">{{ __('messages.nav_my_questions') }}</a>
        </div>
    </form>
</div>
@endsection
