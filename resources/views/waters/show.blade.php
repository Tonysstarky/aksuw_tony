@extends('layouts.app')

@section('title', $water->name.' — '.__('messages.brand'))

@section('content')
<a href="{{ route('waters.index') }}" class="muted">← {{ __('messages.back') }}</a>

<div class="glass pad mt detail">
    <div class="detail-img">
        <img src="{{ $water->image_url }}" alt="{{ $water->name }}" data-fallback>
    </div>

    <div>
        <span class="pill">{{ $water->category->icon ?? '💧' }} {{ $water->category->name ?? '' }}</span>
        <h1 class="page-title mt" style="font-size:30px">{{ $water->name }}</h1>
        <div class="price mt" style="font-size:30px">{{ $water->formatted_price }}</div>

        <div class="kv">
            <div><small>{{ __('messages.volume') }}</small><strong>{{ $water->volume }}</strong></div>
            <div><small>{{ __('messages.ph') }}</small><strong>{{ $water->ph_level ?: '—' }}</strong></div>
            <div><small>{{ __('messages.stock') }}</small><strong>{{ $water->isInStock() ? $water->stock : __('messages.out_of_stock') }}</strong></div>
            <div><small>{{ __('messages.minerals') }}</small><strong style="font-size:13px">{{ $water->mineral_content ?: '—' }}</strong></div>
        </div>

        @if($water->description)
            <p class="muted">{{ $water->description }}</p>
        @endif

        @if(auth()->user()->isAdmin())
            <div class="row mt">
                <a href="{{ route('waters.edit', $water) }}" class="btn btn-ghost btn-sm">✏️ {{ __('messages.edit') }}</a>
                <form method="POST" action="{{ route('waters.destroy', $water) }}" onsubmit="return confirm({{ Js::from(__('messages.confirm_delete')) }})">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">🗑️ {{ __('messages.delete') }}</button>
                </form>
            </div>
        @endif
    </div>
</div>

@if($water->isInStock())
    <div class="glass pad mt">
        <h2 class="card-title mb" style="font-size:20px">🛒 {{ __('messages.order_form_title') }}</h2>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="hidden" name="water_id" value="{{ $water->id }}">
            <div class="form-grid">
                <div class="field">
                    <label for="quantity">{{ __('messages.quantity') }}</label>
                    <input id="quantity" type="number" name="quantity" min="1" max="{{ $water->stock }}" value="{{ old('quantity', 1) }}" class="input" required>
                    @error('quantity') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="phone">{{ __('messages.phone') }}</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="input" placeholder="+993 6x xxxxxx" required>
                    @error('phone') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field full">
                    <label for="delivery_address">{{ __('messages.delivery_address') }}</label>
                    <input id="delivery_address" type="text" name="delivery_address" value="{{ old('delivery_address', auth()->user()->address) }}" class="input" required>
                    @error('delivery_address') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field full">
                    <label for="notes">{{ __('messages.notes') }}</label>
                    <input id="notes" type="text" name="notes" value="{{ old('notes') }}" class="input">
                    @error('notes') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            @error('water_id') <div class="error mb">{{ $message }}</div> @enderror
            <button type="submit" class="btn btn-accent">🛒 {{ __('messages.place_order') }}</button>
        </form>
    </div>
@endif

@if($relatedWaters->isNotEmpty())
    <h2 class="section-title">✨ {{ __('messages.related') }}</h2>
    <div class="grid cols-4">
        @foreach($relatedWaters as $related)
            @include('partials.water-card', ['water' => $related->setRelation('category', $water->category)])
        @endforeach
    </div>
@endif
@endsection
