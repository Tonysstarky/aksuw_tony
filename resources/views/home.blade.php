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

        <!-- Reference Glassmorphism Artwork with Custom Photo / Logo & 3D Interactive Parallax -->
        <div class="hero-art-wrapper" id="heroArtWrapper">
            <div class="hero-art-pedestal" id="heroPedestal"></div>
            <div class="glassmorphism-card" id="heroGlassCard">
                <!-- 3D Specular Light Glare (Mousa görä ýagtylyk düşýär) -->
                <div class="gc-glare" id="gcGlare"></div>

                <div class="gc-top">
                    <span>AK SUW</span>
                    <span>YUSUP GAJAÝEW</span>
                    <span>2026</span>
                </div>

                {{-- 📸 FOTOGRAF ÝA-DA LOGO: Eger öz suratyňyzy goýmak isleseňiz, aşakdaky src="..." ýerine suratyň adyny ýa-da linkini ýazyň --}}
                <div class="gc-media-container">
                    <div class="hero-drop-interactive" id="heroDropInteractive">
                        <canvas id="bottleCanvas" class="bottle-canvas" role="img" aria-label="3D suw şişesi"></canvas>
                    </div>
                </div>

                <div class="gc-bottom">
                    <span>AŞGABAT</span>
                    <span class="gc-pill">SUW KÄRHANASY</span>
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
    {{-- 1. ARÇALYK KÄRHANASY (Resmi: https://tm.archalyk.com/) --}}
    @php $archalykLink = auth()->check() ? route('waters.index', ['category' => 1]) : route('login'); @endphp
    <a href="{{ $archalykLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src ýerine islendik logo linkini ýa-da faýlyny goýup bilersiňiz --}}
            <img src="{{ asset('images/logos/archalyk.svg') }}" 
                 alt="Arçalyk Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Arçalyk</div>
        <div class="factory-sub">Pöwrize & Arçi</div>
        <span class="factory-chip">Aşgabat</span>
    </a>

    {{-- 2. GOŞA ÇYNAR KÄRHANASY (Resmi: https://100haryt.com/tk/ag/brands/gosa-cynar-246/products) --}}
    @php $gosaLink = auth()->check() ? route('waters.index', ['category' => 2]) : route('login'); @endphp
    <a href="{{ $gosaLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src ýerine islendik logo linkini ýa-da faýlyny goýup bilersiňiz --}}
            <img src="{{ asset('images/logos/gosa_cynar.svg') }}" 
                 alt="Goşa Çynar Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Goşa Çynar</div>
        <div class="factory-sub">Kola & 7 Çynar</div>
        <span class="factory-chip">Büzmeýin</span>
    </a>

    {{-- 3. TEŞNE KÄRHANASY (Siziň oklan suratyňyz: «Iýeniňi siňdirýär») --}}
    @php $teshneLink = auth()->check() ? route('waters.index', ['category' => 3]) : route('login'); @endphp
    <a href="{{ $teshneLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Siziň oklan resmi Teşne logosy --}}
            <img src="{{ asset('images/logos/tesne.svg') }}" 
                 alt="Teşne Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Teşne</div>
        <div class="factory-sub">Nar, Limon & Miweli</div>
        <span class="factory-chip">Iýeniňi siňdirýär</span>
    </a>

    {{-- 4. COCA-COLA BOTTLERS (Bonaqua & Cola) --}}
    @php $cocaLink = auth()->check() ? route('waters.index', ['category' => 4]) : route('login'); @endphp
    <a href="{{ $cocaLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src ýerine islendik logo linkini ýa-da faýlyny goýup bilersiňiz --}}
            <img src="{{ asset('images/logos/coca_cola.svg') }}" 
                 alt="Coca-Cola Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Coca-Cola</div>
        <div class="factory-sub">Bonaqua & Cola</div>
        <span class="factory-chip">Bottlers</span>
    </a>

    {{-- 5. LIPTON ICE TEA (Lipton çaýlary we salkyn içgileri) --}}
    @php $liptonLink = auth()->check() ? route('waters.index', ['category' => 5]) : route('login'); @endphp
    <a href="{{ $liptonLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src ýerine islendik logo linkini ýa-da faýlyny goýup bilersiňiz --}}
            <img src="{{ asset('images/logos/lipton.svg') }}" 
                 alt="Lipton Logo" class="factory-logo-img" data-fallback loading="lazy">
        </div>
        <div class="factory-name">Lipton</div>
        <div class="factory-sub">Ice Tea & Çaýlar</div>
        <span class="factory-chip">Ice Tea</span>
    </a>

    {{-- 6. RED BULL ENERGY (Resmi: https://www.redbull.com/ie-en/energydrink) --}}
    @php $redbullLink = auth()->check() ? route('waters.index', ['category' => 6]) : route('login'); @endphp
    <a href="{{ $redbullLink }}" class="factory-card">
        <div class="factory-logo-wrapper">
            {{-- LOGO SURATY: Aşakdaky src ýerine islendik logo linkini ýa-da faýlyny goýup bilersiňiz --}}
            <img src="{{ asset('images/logos/red_bull.svg') }}" 
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
                        <div class="row" style="margin-top:auto; justify-content:space-between; align-items:center;">
                            <span class="price">{{ number_format($water->price, 2) }} {{ __('messages.currency') }}</span>
                            <span class="badge badge-awaiting" style="font-size:11px">🔒 {{ __('messages.locked') }}</span>
                        </div>
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

@push('scripts')
<script src="{{ asset('js/bottle.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('heroArtWrapper');
    const card = document.getElementById('heroGlassCard');
    const drop = document.getElementById('heroDropInteractive');
    const glare = document.getElementById('gcGlare');
    const pedestal = document.getElementById('heroPedestal');

    if (!wrapper || !card || !drop) return;

    let targetRotX = 0, targetRotY = 0;
    let targetDropX = 0, targetDropY = 0;
    let currentRotX = 0, currentRotY = 0;
    let currentDropX = 0, currentDropY = 0;
    let isHovered = false;

    // Myskany nirä hereket etdirseň, damja we 3D glass kartoçka şol tarapa egrelýär
    wrapper.addEventListener('mousemove', function (e) {
        const rect = wrapper.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // Normalised coordinates (-1 to +1) from center
        const normX = Math.max(-1, Math.min(1, ((x / rect.width) * 2) - 1));
        const normY = Math.max(-1, Math.min(1, ((y / rect.height) * 2) - 1));

        isHovered = true;
        targetRotX = -normY * 18; // Max 18deg 3D tilt
        targetRotY = normX * 18;
        targetDropX = normX * 32; // Suw damjasy myskanyň yzyndan hereket edýär
        targetDropY = normY * 32;

        if (glare) {
            const glareX = ((x / rect.width) * 100).toFixed(1);
            const glareY = ((y / rect.height) * 100).toFixed(1);
            glare.style.opacity = '1';
            glare.style.background = `radial-gradient(circle at ${glareX}% ${glareY}%, rgba(255, 255, 255, 0.45) 0%, rgba(255, 255, 255, 0.12) 35%, transparent 70%)`;
        }

        if (pedestal) {
            pedestal.style.transform = `rotate(-14deg) skewX(${-12 + (normX * 9)}deg) scale(${1 + (normY * 0.04)})`;
        }
    });

    wrapper.addEventListener('mouseleave', function () {
        isHovered = false;
        targetRotX = 0;
        targetRotY = 0;
        targetDropX = 0;
        targetDropY = 0;
        if (glare) {
            glare.style.opacity = '0';
        }
        if (pedestal) {
            pedestal.style.transform = 'rotate(-14deg) skewX(-12deg)';
        }
    });

    // 60 FPS ýumşak LERP fiziki animasiýa
    function renderLoop() {
        const factor = isHovered ? 0.14 : 0.08;
        currentRotX += (targetRotX - currentRotX) * factor;
        currentRotY += (targetRotY - currentRotY) * factor;
        currentDropX += (targetDropX - currentDropX) * factor;
        currentDropY += (targetDropY - currentDropY) * factor;

        card.style.transform = `perspective(1000px) rotateX(${currentRotX.toFixed(2)}deg) rotateY(${currentRotY.toFixed(2)}deg)`;
        drop.style.transform = `translate3d(${currentDropX.toFixed(2)}px, ${currentDropY.toFixed(2)}px, 50px) scale(${isHovered ? 1.04 : 1})`;

        requestAnimationFrame(renderLoop);
    }
    requestAnimationFrame(renderLoop);
});
</script>
@endpush
