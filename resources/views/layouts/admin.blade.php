<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $title ?? 'Admin — Company Portfolio' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $adminSettings = \App\Models\SiteSetting::query()->first();
    $adminBrand = $adminSettings?->company_short_name ?? 'NORTHSTAR';
    $adminMark = mb_substr($adminBrand, 0, 1);
    $newMessageCount = \App\Models\ContactMessage::query()->where('status', 'new')->count();
@endphp
<body class="admin-body" style="--accent: {{ $adminSettings?->accent_color ?? '#7357ff' }}; --accent-secondary: {{ $adminSettings?->accent_color_secondary ?? '#29d3b2' }};">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand"><span>{{ $adminMark }}</span><b>{{ $adminBrand }}</b></a>
        <div class="admin-nav-label">Workspace</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span>⌂</span>Overview</a>
            <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"><span>◇</span>Projects</a>
            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><span>◎</span>Services</a>
            <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"><span>✦</span>Testimonials</a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><span>✉</span>Messages @if($newMessageCount)<i>{{ $newMessageCount }}</i>@endif</a>
            <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><span>⚙</span>Website Settings</a>
        </nav>
        <div class="admin-sidebar-bottom">
            <a href="{{ route('home') }}" target="_blank">View website ↗</a>
            <form action="{{ route('admin.logout') }}" method="POST">@csrf<button type="submit">Logout</button></form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <button class="admin-menu-btn" type="button" data-admin-menu>☰</button>
            <div class="admin-topbar-brand">
                <small>CONTENT STUDIO</small>
                <strong>{{ $adminSettings?->company_name ?? 'Company Portfolio' }}</strong>
            </div>
            <div class="admin-user-chip"><span>{{ mb_substr(auth()->user()->name, 0, 1) }}</span><div><small>Signed in as</small><strong>{{ auth()->user()->name }}</strong></div></div>
        </header>

        <div class="admin-content">
            @if(session('success'))<div class="admin-flash success">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="admin-flash error">
                    <strong>Periksa input berikut:</strong>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
