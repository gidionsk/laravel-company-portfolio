<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $brand = $settings?->company_short_name ?? 'PORTFOLIO';
        $brandMark = mb_substr($brand, 0, 1);
        $accent = $settings?->accent_color ?? '#2f6b52';
        $accentSecondary = $settings?->accent_color_secondary ?? '#b8613f';
        $resolvedTitle = $title ?? ($settings?->seo_title ?: ($brand.' | Laravel portfolio demo'));
        $resolvedDescription = $metaDescription ?? ($settings?->seo_description ?: ($settings?->hero_description ?? 'Public Laravel portfolio demo with concept case studies and a working CMS.'));
    @endphp
    <meta name="description" content="{{ $resolvedDescription }}">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="theme-color" content="#f3f1ea">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $resolvedTitle }}">
    <meta property="og:description" content="{{ $resolvedDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $settings?->company_name ?? 'Portfolio Demo' }}">
    <meta name="twitter:card" content="summary_large_image">
    <title>{{ $resolvedTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="--accent: {{ $accent }}; --accent-secondary: {{ $accentSecondary }};">
    <a class="skip-link" href="#main-content">Lewati ke konten utama</a>

    <header class="site-header" data-header>
        <div class="container nav-wrap">
            <a href="{{ route('home') }}" class="brand" aria-label="{{ $brand }} home">
                <span class="brand-mark" aria-hidden="true">{{ $brandMark }}</span>
                <span>{{ $brand }}</span>
            </a>

            <nav class="desktop-nav" aria-label="Main navigation">
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('home') }}#services">Build</a>
                <a href="{{ route('projects.index') }}">Case studies</a>
                <a href="{{ route('home') }}#contact">Contact</a>
            </nav>

            <a href="{{ $settings?->cta_url ?: route('home').'#contact' }}" class="btn btn-dark desktop-cta">
                {{ $settings?->cta_label ?: 'Send a message' }}
            </a>

            <button class="menu-toggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-navigation" data-menu-toggle>
                <span></span><span></span>
            </button>
        </div>

        <nav id="mobile-navigation" class="mobile-nav" data-mobile-nav aria-label="Mobile navigation">
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('home') }}#services">Build</a>
            <a href="{{ route('projects.index') }}">Case studies</a>
            <a href="{{ route('home') }}#contact">Contact</a>
        </nav>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <a href="{{ route('home') }}" class="brand brand-footer"><span class="brand-mark" aria-hidden="true">{{ $brandMark }}</span><span>{{ $brand }}</span></a>
                <p>{{ $settings?->tagline ?: 'A working Laravel portfolio demo with concept case studies.' }}</p>
            </div>
            <div class="footer-links">
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('projects.index') }}">Case studies</a>
                <a href="{{ route('home') }}#contact">Contact</a>
            </div>
            <div class="footer-meta">
                @if($settings?->location)<span>{{ $settings->location }}</span>@endif
                @if($settings?->email)<a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>@endif
                @if($settings?->instagram_url)<a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer">Instagram</a>@endif
                @if($settings?->linkedin_url)<a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn</a>@endif
            </div>
        </div>
        <div class="container footer-bottom">
            <span>© {{ date('Y') }} {{ $settings?->company_name ?? 'Portfolio Demo' }}.</span>
            <span>Laravel, Blade, MySQL, Docker.</span>
            <a href="{{ route('login') }}">Admin</a>
        </div>
    </footer>
</body>
</html>
