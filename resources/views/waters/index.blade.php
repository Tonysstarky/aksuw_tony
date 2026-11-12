@extends('layouts.app')

@section('title', __('messages.catalog_title').' — '.__('messages.brand'))

@section('content')
<div class="head">
    <div>
        <h1 class="page-title">💧 {{ __('messages.catalog_title') }}</h1>
        <p class="page-sub">{{ __('messages.catalog_sub') }}</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('waters.create') }}" class="btn btn-primary">➕ {{ __('messages.add_water') }}</a>
    @endif
</div>

<form method="GET" action="{{ route('waters.index') }}" class="glass pad-sm mb">
    <div class="grid" style="grid-template-columns: 2fr 1.4fr 1fr auto; align-items:end">
        <div class="field" style="margin:0">
            <label>{{ __('messages.search_label') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" class="input" placeholder="{{ __('messages.search_placeholder') }}">
        </div>
        <div class="field" style="margin:0">
            <label>{{ __('messages.category') }}</label>
            <select name="category" class="input">
                <option value="">{{ __('messages.all_categories') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ \Illuminate\Support\Str::limit($category->name, 32) }}</option>
                @endforeach
            </select>
        </div>
        <div class="field" style="margin:0">
            <label>{{ __('messages.volume') }}</label>
            <select name="volume" class="input">
                <option value="">{{ __('messages.all_volumes') }}</option>
                @foreach($volumes as $volume)
                    <option value="{{ $volume }}" @selected(request('volume') == $volume)>{{ $volume }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-accent">🔍 {{ __('messages.search') }}</button>
    </div>
</form>

@if($waters->isEmpty())
    <div class="glass pad center muted">{{ __('messages.no_waters') }}</div>
@else
    <div class="grid cols-4">
        @foreach($waters as $water)
            @include('partials.water-card', ['water' => $water])
        @endforeach
    </div>
    {{ $waters->links() }}
@endif
@endsection
