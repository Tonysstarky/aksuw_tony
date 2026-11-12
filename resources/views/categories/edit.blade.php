@extends('layouts.app')

@section('title', __('messages.edit_category').' — '.__('messages.brand'))

@section('content')
<div class="glass pad" style="max-width:820px;margin:0 auto">
    <h1 class="page-title mb" style="font-size:28px">✏️ {{ __('messages.edit_category') }}</h1>
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')
        @include('categories._form')
        <div class="row">
            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
            <a href="{{ route('categories.index') }}" class="btn btn-ghost">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
