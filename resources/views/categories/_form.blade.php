@php($c = $category ?? null)

<div class="form-grid">
    @foreach(['tm', 'ru', 'en'] as $loc)
        <div class="field">
            <label for="name_{{ $loc }}">{{ __('messages.name_'.$loc) }}</label>
            <input id="name_{{ $loc }}" type="text" name="name_{{ $loc }}" value="{{ old('name_'.$loc, $c?->{'name_'.$loc}) }}" class="input" required>
            @error('name_'.$loc) <div class="error">{{ $message }}</div> @enderror
        </div>
    @endforeach

    <div class="field">
        <label for="icon">{{ __('messages.icon') }}</label>
        <input id="icon" type="text" name="icon" value="{{ old('icon', $c?->icon ?? '💧') }}" class="input" maxlength="10">
        @error('icon') <div class="error">{{ $message }}</div> @enderror
    </div>

    @foreach(['tm', 'ru', 'en'] as $loc)
        <div class="field full">
            <label for="description_{{ $loc }}">{{ __('messages.description_'.$loc) }}</label>
            <textarea id="description_{{ $loc }}" name="description_{{ $loc }}" class="input" style="min-height:80px">{{ old('description_'.$loc, $c?->{'description_'.$loc}) }}</textarea>
            @error('description_'.$loc) <div class="error">{{ $message }}</div> @enderror
        </div>
    @endforeach
</div>
