@extends('layouts.app')

@section('title', __('messages.dashboard_title').' — '.__('messages.brand'))

@section('content')
<div class="head">
    <div>
        <h1 class="page-title">{{ __('messages.hello', ['name' => $user->name]) }} 👋</h1>
        <p class="page-sub">
            {{ $user->email }} ·
            <span class="pill">{{ $user->isAdmin() ? __('messages.role_admin') : __('messages.role_user') }}</span>
        </p>
    </div>
    <div class="row">
        <a href="{{ route('profile.show') }}" class="btn btn-ghost btn-sm">👤 {{ __('messages.profile_title') }}</a>
    </div>
</div>

<div class="grid cols-4">
    <div class="glass stat"><b>{{ $stats['waters'] }}</b><span>{{ __('messages.stat_waters') }}</span></div>
    <div class="glass stat"><b>{{ $stats['categories'] }}</b><span>{{ __('messages.stat_categories') }}</span></div>
    <div class="glass stat"><b>{{ $stats['my_orders'] }}</b><span>{{ __('messages.stat_my_orders') }}</span></div>
    <div class="glass stat"><b>{{ $stats['my_questions'] }}</b><span>{{ __('messages.stat_my_questions') }}</span></div>
</div>

@if($adminStats)
    <div class="grid cols-2 mt">
        <div class="glass stat"><b>{{ $adminStats['orders'] }}</b><span>{{ __('messages.stat_all_orders') }}</span></div>
        <div class="glass stat"><b>{{ $adminStats['pending_questions'] }}</b><span>{{ __('messages.stat_pending_questions') }}</span></div>
    </div>
@endif

<h2 class="section-title">⚡ {{ __('messages.quick_actions') }}</h2>
<div class="row">
    <a href="{{ route('waters.index') }}" class="btn btn-accent">💧 {{ __('messages.nav_catalog') }}</a>
    <a href="{{ route('questions.create') }}" class="btn btn-ghost">❓ {{ __('messages.nav_ask') }}</a>
    @if($user->isAdmin())
        <a href="{{ route('waters.create') }}" class="btn btn-ghost">➕ {{ __('messages.add_water') }}</a>
        <a href="{{ route('categories.create') }}" class="btn btn-ghost">📁 {{ __('messages.add_category') }}</a>
        <a href="{{ route('questions.index') }}" class="btn btn-ghost">💬 {{ __('messages.nav_admin_questions') }}</a>
    @endif
</div>

<div class="grid cols-2 mt-lg">
    <div class="glass pad">
        <h3 class="card-title mb">📦 {{ __('messages.recent_orders') }}</h3>
        @forelse($myOrders as $order)
            <div class="row between" style="padding:9px 0;border-bottom:1px solid rgba(255,255,255,.14)">
                <div>
                    <strong>{{ $order->water->name }}</strong>
                    <small class="muted" style="display:block">{{ $order->quantity }} × · {{ $order->formatted_total }}</small>
                </div>
                <span class="badge badge-{{ $order->status }}">{{ __('messages.status_'.$order->status) }}</span>
            </div>
        @empty
            <p class="muted">{{ __('messages.no_orders') }}</p>
        @endforelse
    </div>

    <div class="glass pad">
        <h3 class="card-title mb">❓ {{ __('messages.recent_questions') }}</h3>
        @forelse($myQuestions as $question)
            <div class="row between" style="padding:9px 0;border-bottom:1px solid rgba(255,255,255,.14)">
                <strong>{{ \Illuminate\Support\Str::limit($question->subject, 34) }}</strong>
                <span class="badge {{ $question->isAnswered() ? 'badge-answered' : 'badge-awaiting' }}">
                    {{ $question->isAnswered() ? __('messages.answered') : __('messages.awaiting') }}
                </span>
            </div>
        @empty
            <p class="muted">{{ __('messages.no_questions') }}</p>
        @endforelse
    </div>
</div>
@endsection
