@extends('layouts.app')

@section('title', __('messages.my_questions_title').' — '.__('messages.brand'))

@section('content')
<div class="head">
    <h1 class="page-title">📋 {{ __('messages.my_questions_title') }}</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary">❓ {{ __('messages.nav_ask') }}</a>
</div>

@forelse($questions as $question)
    <div class="glass qa">
        <div class="row between">
            <strong style="font-size:17px">{{ $question->subject }}</strong>
            <span class="badge {{ $question->isAnswered() ? 'badge-answered' : 'badge-awaiting' }}">
                {{ $question->isAnswered() ? '✅ '.__('messages.answered') : '⏳ '.__('messages.awaiting') }}
            </span>
        </div>
        <p class="muted" style="margin-top:6px">{{ $question->message }}</p>
        <small class="muted">{{ $question->created_at->format('d.m.Y H:i') }}</small>

        @if($question->isAnswered())
            <div class="qa-answer"><strong>💬 {{ __('messages.answer') }}:</strong> {{ $question->answer }}</div>
        @endif
    </div>
@empty
    <div class="glass pad center muted">{{ __('messages.no_questions') }}</div>
@endforelse

{{ $questions->links() }}
@endsection
