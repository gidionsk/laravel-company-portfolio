<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Admin Login — Northstar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-login-body">
<div class="admin-login-card">
    <a href="{{ route('home') }}" class="admin-login-brand"><span>N</span><b>NORTHSTAR</b></a>
    <div class="admin-login-copy">
        <small>CONTENT MANAGEMENT</small>
        <h1>Welcome back.</h1>
        <p>Kelola portfolio, services, testimonial, dan inquiry website dari satu tempat.</p>
    </div>

    @if($errors->any())<div class="admin-flash error">Email atau password tidak valid.</div>@endif

    <form method="POST" action="{{ route('admin.login') }}" class="admin-form">
        @csrf
        <label>Email<input type="email" name="email" value="{{ old('email') }}" placeholder="admin@company.com" required autofocus></label>
        <label>Password<input type="password" name="password" placeholder="••••••••" required></label>
        <label class="admin-check"><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="admin-primary-btn" type="submit">Login to dashboard →</button>
    </form>
    <a class="admin-back-site" href="{{ route('home') }}">← Back to website</a>
</div>
</body>
</html>
