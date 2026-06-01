<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Reservation System')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Mono&display=swap" rel="stylesheet">

    {{-- Main stylesheet --}}
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}?v=3">
</head>
<body>

    {{-- ── Navbar ─────────────────────────────────────── --}}
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="nav-brand">
                <span class="brand-icon">📋</span>
                ReserveList
            </a>

            <div class="nav-links">
                <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="nav-link">
                    All Reservations
                </a>

                <a href="{{ secure_url(route('reservations.create', [], false)) }}" class="btn btn-primary btn-sm">
                    + New
                </a>
            </div>
        </div>
    </nav>

    {{-- ── Flash Messages ──────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- ── Page Content ────────────────────────────────── --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- ── Footer ──────────────────────────────────────── --}}
    <footer class="footer">
        <p>ReserveList &mdash; Built with Laravel &bull; BSIT 2024</p>
    </footer>

</body>
</html>