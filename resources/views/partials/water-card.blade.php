<a href="{{ route('waters.show', $water) }}" class="glass card">
    <div class="card-img">
        <img src="{{ $water->image_url }}" alt="{{ $water->name }}" data-fallback loading="lazy">
    </div>
    <div class="card-body">
        <span class="pill" style="align-self:flex-start">{{ $water->category->icon ?? '💧' }} {{ \Illuminate\Support\Str::limit($water->category->name ?? '', 26) }}</span>
        <div class="card-title">{{ $water->name }}</div>
        <div class="row between" style="margin-top:auto">
            <span class="price">{{ $water->formatted_price }}</span>
            <span class="muted" style="font-size:13px">{{ $water->volume }}</span>
        </div>
        <span class="muted" style="font-size:12px">
            {{ $water->isInStock() ? '🟢 '.__('messages.in_stock').': '.$water->stock : '🔴 '.__('messages.out_of_stock') }}
        </span>
    </div>
</a>
