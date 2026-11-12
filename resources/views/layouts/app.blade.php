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

<header class="navbar">
    <div class="container">
        <div class="glass nav-inner">
            <a href="{{ route('home') }}" class="brand"><span class="drop">💧</span> {{ __('messages.brand') }}</a>

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

<script>
    // Surat ýüklenmese (internet ýok bolsa) owadan çalyşma görkezýäris
    const fallback = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0' stop-color='%236c92ff'/><stop offset='1' stop-color='%231230d4'/></linearGradient></defs><rect width='400' height='300' fill='url(%23g)'/><text x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='90'>💧</text></svg>";
    document.querySelectorAll('img[data-fallback]').forEach(function (img) {
        img.addEventListener('error', function () { this.onerror = null; this.src = fallback; });
        if (img.complete && img.naturalWidth === 0) { img.src = fallback; }
    });
</script>
</body>
</html>
