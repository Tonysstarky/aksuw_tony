@php($isEdit = isset($water))

<div class="form-grid">
    <div class="field full">
        <label for="name">{{ __('messages.product') }}</label>
        <input id="name" type="text" name="name" value="{{ old('name', $water->name ?? '') }}" class="input" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="category_id">{{ __('messages.category') }}</label>
        <select id="category_id" name="category_id" class="input" required>
            <option value="">—</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $water->category_id ?? '') == $category->id)>{{ \Illuminate\Support\Str::limit($category->name, 40) }}</option>
            @endforeach
        </select>
        @error('category_id') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="volume">{{ __('messages.volume') }}</label>
        <input id="volume" type="text" name="volume" value="{{ old('volume', $water->volume ?? '') }}" class="input" placeholder="0.5L" required>
        @error('volume') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="price">{{ __('messages.price') }} (TMT)</label>
        <input id="price" type="number" step="0.01" min="0.01" name="price" value="{{ old('price', $water->price ?? '') }}" class="input" required>
        @error('price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="stock">{{ __('messages.stock') }}</label>
        <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $water->stock ?? 100) }}" class="input" required>
        @error('stock') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="ph_level">{{ __('messages.ph') }}</label>
        <input id="ph_level" type="text" name="ph_level" value="{{ old('ph_level', $water->ph_level ?? '7.4') }}" class="input">
        @error('ph_level') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="mineral_content">{{ __('messages.minerals') }}</label>
        <input id="mineral_content" type="text" name="mineral_content" value="{{ old('mineral_content', $water->mineral_content ?? '') }}" class="input">
        @error('mineral_content') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field full">
        <label for="image">{{ __('messages.image') }}</label>
        @if($isEdit && $water->image_url)
            <img src="{{ $water->image_url }}" alt="" data-fallback style="height:90px;border-radius:12px;margin-bottom:8px">
        @endif
        <input id="image" type="file" name="image" accept="image/*" class="input">
        <div class="hint">{{ __('messages.image_hint') }}</div>
        @error('image') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field full">
        <label for="description">{{ __('messages.description') }}</label>
        <textarea id="description" name="description" class="input">{{ old('description', $water->description ?? '') }}</textarea>
        @error('description') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>
