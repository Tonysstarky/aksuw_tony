@extends('layouts.app')

@section('title', __('messages.nav_home').' — '.__('messages.brand'))

@section('content')
<section class="glass hero">
    <div class="hero-glass-container">
        <div>
            <span class="hero-badge">💧 {{ __('messages.hero_badge') }}</span>
            <h1>{{ __('messages.hero_title') }}</h1>
            <p>{{ __('messages.hero_text') }}</p>

            <div class="row" style="margin-bottom: 20px;">
                @auth
                    <a href="{{ route('waters.index') }}" class="btn btn-primary">{{ __('messages.hero_cta_catalog') }} →</a>
                    <a href="{{ route('questions.create') }}" class="btn btn-ghost">{{ __('messages.nav_ask') }}</a>
                    <a href="{{ route('orders.index') }}" class="btn btn-ghost">{{ __('messages.nav_orders') }}</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.hero_cta_login') }} →</a>
                    <a href="{{ route('register') }}" class="btn btn-ghost">{{ __('messages.hero_cta_register') }}</a>
                    <a href="{{ route('password.request') }}" class="btn btn-ghost">{{ __('messages.forgot_title') }}</a>
                @endauth
            </div>

            <div class="hero-chips">
                <span class="hero-chip">✨ whereHas() Eloquent</span>
                <span class="hero-chip">🔗 $table->foreignId()</span>
                <span class="hero-chip">👤 auth()->user()</span>
                <span class="hero-chip">🌐 TM • RU • EN</span>
                <span class="hero-chip">✉️ Gmail Code Practice</span>
            </div>
        </div>

        <!-- Reference Glassmorphism Artwork -->
        <div class="hero-art-wrapper">
            <div class="hero-art-pedestal"></div>
            <div class="glassmorphism-card">
                <div class="gc-top">
                    <span>MULTI-RESOLUTION</span>
                    <span>CREATED BY YUSUP GAJAÝEW</span>
                    <span>INFINITE BLENDS</span>
                </div>
                <div class="gc-center">
                    <div class="gc-sub-title">GLASS</div>
                    <div class="gc-main-title">MORPHISM</div>
                    <div class="gc-tagline">AK SUW ZAWODY • ASHGABAT</div>
                </div>
                <div class="gc-bottom">
                    <span>WATER ARTWORK</span>
                    <span class="gc-pill">MODERN GRADIENT MESH</span>
                    <span>PHP 8.5 • L13</span>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="grid cols-4 mt">
    <div class="glass stat"><b>7.4 pH</b><span>{{ __('messages.stat_ph') }}</span></div>
    <div class="glass stat"><b>6</b><span>{{ __('messages.stat_brands') }}</span></div>
    <div class="glass stat"><b>24/7</b><span>{{ __('messages.stat_delivery') }}</span></div>
    <div class="glass stat"><b>{{ \App\Models\Water::count() }}</b><span>{{ __('messages.stat_products') }}</span></div>
</div>

<div class="head mt-lg" style="margin-bottom:14px">
    <div>
        <h2 class="section-title" style="margin:0">🏢 {{ __('messages.brands_title') }}</h2>
        <p class="muted" style="font-size:13px;margin-top:4px">{{ __('messages.brands_sub') }}</p>
    </div>
    @auth
        <a href="{{ route('waters.index') }}" class="btn btn-ghost btn-sm">{{ __('messages.view_all') }} →</a>
    @endauth
</div>

<div class="factories-grid">
    {{-- 1. ARÇALYK KÄRHANASY --}}
    @php $archalykLink = auth()->check() ? route('waters.index', ['category' => 1]) : route('login'); @endphp
    <a href="{{ $archalykLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src="url" ýerine islendik logo linkini goýup bilersiňiz --}}
            <img src="https://images.unsplash.com/photo-1548839140-29a749e1bc4e?w=200&auto=format&fit=crop&q=80" 
                 alt="Arçalyk Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Arçalyk</div>
        <div class="factory-sub">Pöwrize & Arçi</div>
        <span class="factory-chip">Aşgabat</span>
    </a>

    {{-- 2. GOŞA ÇYNAR KÄRHANASY --}}
    @php $gosaLink = auth()->check() ? route('waters.index', ['category' => 2]) : route('login'); @endphp
    <a href="{{ $gosaLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src="url" ýerine islendik logo linkini goýup bilersiňiz --}}
            <img src="https://images.unsplash.com/photo-1559839914-1b34645a3803?w=200&auto=format&fit=crop&q=80" 
                 alt="Goşa Çynar Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Goşa Çynar</div>
        <div class="factory-sub">Kola & 7 Çynar</div>
        <span class="factory-chip">Büzmeýin</span>
    </a>

    {{-- 3. TEŞNE KÄRHANASY --}}
    @php $teshneLink = auth()->check() ? route('waters.index', ['category' => 3]) : route('login'); @endphp
    <a href="{{ $teshneLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src="url" ýerine islendik logo linkini goýup bilersiňiz --}}
            <img src="https://images.unsplash.com/photo-1523362628745-0c100150b504?w=200&auto=format&fit=crop&q=80" 
                 alt="Teşne Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Teşne</div>
        <div class="factory-sub">Çeşme & Altyn Ýunus</div>
        <span class="factory-chip">Mary</span>
    </a>

    {{-- 4. COCA-COLA BOTTLERS --}}
    @php $cocaLink = auth()->check() ? route('waters.index', ['category' => 4]) : route('login'); @endphp
    <a href="{{ $cocaLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src="url" ýerine islendik logo linkini goýup bilersiňiz --}}
            <img src="https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=200&auto=format&fit=crop&q=80" 
                 alt="Coca-Cola Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Coca-Cola</div>
        <div class="factory-sub">Bonaqua & Cola</div>
        <span class="factory-chip">Bottlers</span>
    </a>

    {{-- 5. LIPTON DRINKS --}}
    @php $liptonLink = auth()->check() ? route('waters.index', ['category' => 5]) : route('login'); @endphp
    <a href="{{ $liptonLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src="url" ýerine islendik logo linkini goýup bilersiňiz --}}
            <img src="https://images.unsplash.com/photo-1556881286-fc6915169721?w=200&auto=format&fit=crop&q=80" 
                 alt="Lipton Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Lipton</div>
        <div class="factory-sub">Ice Tea & Çaýlar</div>
        <span class="factory-chip">Teas</span>
    </a>

    {{-- 6. RED BULL ENERGY --}}
    @php $redbullLink = auth()->check() ? route('waters.index', ['category' => 6]) : route('login'); @endphp
    <a href="{{ $redbullLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src="url" ýerine islendik logo linkini goýup bilersiňiz --}}
            <img src="https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=200&auto=format&fit=crop&q=80" 
                 alt="Red Bull Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Red Bull</div>
        <div class="factory-sub">Original & Editions</div>
        <span class="factory-chip">Energy</span>
    </a>
</div>

@if($featuredWaters->isNotEmpty())
    <h2 class="section-title">
        <span>🆕 {{ __('messages.featured_title') }}</span>
        @auth <a href="{{ route('waters.index') }}" class="btn btn-ghost btn-sm">{{ __('messages.view_all') }} →</a> @endauth
    </h2>
    <div class="grid cols-3">
        @foreach($featuredWaters as $water)
            @auth
                @include('partials.water-card', ['water' => $water])
            @else
                <a href="{{ route('login') }}" class="glass card">
                    <div class="card-img"><img src="{{ $water->image_url }}" alt="{{ $water->name }}" data-fallback loading="lazy"></div>
                    <div class="card-body">
                        <div class="card-title">{{ $water->name }}</div>
                        <span class="muted">🔒 {{ __('messages.locked') }}</span>
                    </div>
                </a>
            @endauth
        @endforeach
    </div>
@endif

@if($categories->isNotEmpty())
    <h2 class="section-title">📁 {{ __('messages.categories_title_home') }}</h2>
    <div class="grid cols-3">
        @foreach($categories as $category)
            <div class="glass pad-sm">
                <div class="row">
                    <span class="cat-icon">{{ $category->icon }}</span>
                    <div>
                        <div class="card-title">{{ $category->name }}</div>
                        <span class="pill">{{ $category->waters_count }} {{ __('messages.waters_count') }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
