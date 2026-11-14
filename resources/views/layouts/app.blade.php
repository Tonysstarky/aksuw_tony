<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.brand'))</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="orbs" aria-hidden="true">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
</div>

<canvas class="bubbles" id="bubbles" aria-hidden="true"></canvas>

<div class="flow" id="flow" aria-hidden="true">
    <div class="flow-stream" id="flowStream"></div>
    <div class="flow-drop" id="flowDrop"></div>
    <div class="flow-ripple" id="flowRipple"></div>
</div>

<header class="navbar">
    <div class="container">
        <div class="glass nav-inner">
            <a href="{{ route('home') }}" class="brand">
                <span class="logo3d" id="logo3d" aria-hidden="true">
                    <span class="logo3d-inner" id="logo3dInner">
                        <svg class="l3 l3-back" viewBox="0 0 24 28"><path d="M12 1.5C12 1.5 3.5 11.2 3.5 17.2a8.5 8.5 0 0 0 17 0C20.5 11.2 12 1.5 12 1.5Z" fill="#0a1a9a"/></svg>
                        <svg class="l3 l3-mid" viewBox="0 0 24 28"><defs><radialGradient id="dropGrad" cx="35%" cy="62%" r="75%"><stop offset="0" stop-color="#bfe3ff"/><stop offset=".45" stop-color="#3b9bff"/><stop offset="1" stop-color="#1230d4"/></radialGradient></defs><path d="M12 1.5C12 1.5 3.5 11.2 3.5 17.2a8.5 8.5 0 0 0 17 0C20.5 11.2 12 1.5 12 1.5Z" fill="url(#dropGrad)"/></svg>
                        <svg class="l3 l3-front" viewBox="0 0 24 28"><path d="M7.2 16.2c0-3 2-6 3.6-8" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" opacity=".85"/><ellipse cx="9" cy="20.5" rx="1.6" ry="1" fill="#fff" opacity=".55"/></svg>
                    </span>
                </span>
                <span>{{ __('messages.brand') }}</span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.nav_home') }}</a>
                @auth
                    <a href="{{ route('waters.index') }}" class="nav-link {{ request()->routeIs('waters.*') ? 'active' : '' }}">{{ __('messages.nav_catalog') }}</a>
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">{{ __('messages.nav_categories') }}</a>
                    <a href="{{ route('questions.create') }}" class="nav-link {{ request()->routeIs('questions.create') ? 'active' : '' }}">{{ __('messages.nav_ask') }}</a>
                    <a href="{{ route('questions.my') }}" class="nav-link {{ request()->routeIs('questions.my') ? 'active' : '' }}">{{ __('messages.nav_my_questions') }}</a>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">{{ __('messages.nav_orders') }}</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('questions.index') }}" class="nav-link {{ request()->routeIs('questions.index') ? 'active' : '' }}">{{ __('messages.nav_admin_questions') }}</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="nav-link">🔒 {{ __('messages.nav_catalog') }}</a>
                @endauth
            </nav>

            <div class="nav-right">
                <div class="lang">
                    @foreach(['tm' => 'TM', 'ru' => 'RU', 'en' => 'EN'] as $code => $label)
                        <a href="{{ route('locale.set', $code) }}" class="{{ app()->getLocale() === $code ? 'active' : '' }}">{{ $label }}</a>
                    @endforeach
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('messages.nav_dashboard') }}</a>
                    <a href="{{ route('profile.show') }}" class="user-chip" title="{{ __('messages.nav_profile') }}">👤 {{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">{{ __('messages.nav_logout') }}</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">{{ __('messages.nav_login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('messages.nav_register') }}</a>
                @endauth
            </div>
        </div>
    </div>
</header>

<main class="container page">
    @if(session('success'))
        <div class="alert alert-success glass-soft">✅ <span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="alert alert-error glass-soft">❌ <span>{{ session('error') }}</span></div>
    @endif

    @yield('content')

    <footer class="footer glass-soft">
        <span>&copy; {{ date('Y') }} <strong>{{ __('messages.brand') }}</strong> · {{ __('messages.footer_made_by') }}: <strong>Yusup Gajaýew</strong></span>
        <span>Arçalyk • Goşa Çynar • Teşne • Coca-Cola • Lipton • Red Bull</span>
    </footer>
</main>

<!-- 3D Suw Damjasy Sahypa Geçiş Gatlagy (Smooth Page Transition Loader) -->
<div id="pageWaterLoader" class="page-water-loader" aria-hidden="true">
    <div class="loader-drop-wrapper">
        <svg class="loader-3d-drop" viewBox="0 0 100 120">
            <defs>
                <radialGradient id="drop3dGrad" cx="35%" cy="30%" r="70%">
                    <stop offset="0%" stop-color="#ffffff"/>
                    <stop offset="25%" stop-color="#7dd3fc"/>
                    <stop offset="60%" stop-color="#0284c7"/>
                    <stop offset="100%" stop-color="#075985"/>
                </radialGradient>
                <filter id="dropGlowFilter" x="-40%" y="-40%" width="180%" height="180%">
                    <feGaussianBlur stdDeviation="6" result="blur"/>
                    <feComposite in="SourceGraphic" in2="blur" operator="over"/>
                </filter>
            </defs>
            <path d="M50,10 C42,28 15,65 15,85 C15,104 31,115 50,115 C69,115 85,104 85,85 C85,65 58,28 50,10 Z" 
                  fill="url(#drop3dGrad)" filter="url(#dropGlowFilter)"/>
            <ellipse cx="40" cy="75" rx="6" ry="14" fill="#ffffff" opacity="0.8" transform="rotate(-25 40 75)"/>
        </svg>
        <div class="loader-ripple r1"></div>
        <div class="loader-ripple r2"></div>
        <div class="loader-text">Ak Suw Zawody...</div>
    </div>
</div>

<script>
    // Surat ýüklenmese (ýalňyşlyk bolsa) çalyşma görkezýäris
    const fallback = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0' stop-color='%236c92ff'/><stop offset='1' stop-color='%231230d4'/></linearGradient></defs><rect width='400' height='300' fill='url(%23g)'/><text x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='90'>💧</text></svg>";
    document.querySelectorAll('img[data-fallback]').forEach(function (img) {
        img.addEventListener('error', function () { this.onerror = null; this.src = fallback; });
    });

    // Sahypa açylanda ýumşak aýyrmak
    window.addEventListener('load', function () {
        const loader = document.getElementById('pageWaterLoader');
        if (loader) loader.classList.remove('active');
    });

    // Sahypadan sahypa geçilende suw damjasy çyksyn
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript') || link.target === '_blank') return;
        if (e.ctrlKey || e.metaKey || e.shiftKey) return;

        try {
            const url = new URL(href, window.location.origin);
            if (url.origin === window.location.origin && (url.pathname !== window.location.pathname || url.search !== window.location.search)) {
                const loader = document.getElementById('pageWaterLoader');
                if (loader) loader.classList.add('active');
            }
        } catch (_) {}
    });

    // Form ugradylanda (sargyt, sorag bermek) suw damjasy çyksyn
    document.addEventListener('submit', function (e) {
        const loader = document.getElementById('pageWaterLoader');
        if (loader && !e.defaultPrevented) loader.classList.add('active');
    });
</script>
@stack('scripts')
</body>
</html>
