@extends('layouts.app')

@section('title', __('messages.categories_title').' — '.__('messages.brand'))

@section('content')
<div class="head">
    <div>
        <h1 class="page-title">📁 {{ __('messages.categories_title') }}</h1>
        <p class="page-sub">{{ __('messages.categories_sub') }} · {{ __('messages.active_categories') }}: <strong>{{ $activeCategoriesCount }}</strong></p>
    </div>
    <div class="row">
        @if(request()->boolean('has_waters'))
            <a href="{{ route('categories.index') }}" class="btn btn-ghost btn-sm">{{ __('messages.all') }}</a>
        @else
            <a href="{{ route('categories.index', ['has_waters' => 1]) }}" class="btn btn-ghost btn-sm">{{ __('messages.only_with_waters') }}</a>
        @endif
        @if(auth()->user()->isAdmin())
            <a href="{{ route('categories.create') }}" class="btn btn-primary">➕ {{ __('messages.add_category') }}</a>
        @endif
    </div>
</div>

@if($categories->isEmpty())
    <div class="glass pad center muted">{{ __('messages.no_categories') }}</div>
@else
    <div class="grid cols-3">
        @foreach($categories as $category)
            <div class="glass pad-sm card">
                <div class="card-body">
                    <div class="row">
                        <span class="cat-icon">{{ $category->icon }}</span>
                        <span class="pill">{{ $category->waters_count }} {{ __('messages.waters_count') }}</span>
                    </div>
                    <div class="card-title">{{ $category->name }}</div>
                    <p class="muted" style="font-size:13px">{{ \Illuminate\Support\Str::limit($category->description, 130) }}</p>
                    <div class="row" style="margin-top:auto">
                        <a href="{{ route('waters.index', ['category' => $category->id]) }}" class="btn btn-accent btn-sm">{{ __('messages.nav_catalog') }} →</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-ghost btn-sm">✏️</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm({{ Js::from(__('messages.confirm_delete')) }})">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
