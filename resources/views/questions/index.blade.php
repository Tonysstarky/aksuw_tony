@extends('layouts.app')

@section('title', __('messages.admin_questions_title').' — '.__('messages.brand'))

@section('content')
<div class="head">
    <h1 class="page-title">💬 {{ __('messages.admin_questions_title') }}</h1>
</div>

@forelse($questions as $question)
    <div class="glass qa">
        <div class="row between">
            <strong style="font-size:17px">{{ $question->subject }}</strong>
            <span class="badge {{ $question->isAnswered() ? 'badge-answered' : 'badge-awaiting' }}">
                {{ $question->isAnswered() ? '✅ '.__('messages.answered') : '⏳ '.__('messages.awaiting') }}
            </span>
        </div>
        <small class="muted">👤 {{ $question->user->name }} · {{ $question->email }} · {{ $question->created_at->format('d.m.Y H:i') }}</small>
        <p style="margin-top:8px">{{ $question->message }}</p>

        <form method="POST" action="{{ route('questions.answer', $question) }}" class="mt">
            @csrf
            <div class="field" style="margin-bottom:10px">
                <label>{{ __('messages.answer') }}</label>
                <textarea name="answer" class="input" style="min-height:70px" placeholder="{{ __('messages.answer_placeholder') }}" required>{{ old('answer', $question->answer) }}</textarea>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-accent btn-sm">{{ __('messages.answer_btn') }}</button>
            </div>
        </form>

        <form method="POST" action="{{ route('questions.destroy', $question) }}" class="mt" onsubmit="return confirm({{ Js::from(__('messages.confirm_delete')) }})">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">🗑️ {{ __('messages.delete') }}</button>
        </form>
    </div>
@empty
    <div class="glass pad center muted">{{ __('messages.no_questions') }}</div>
@endforelse

{{ $questions->links() }}
@endsection
