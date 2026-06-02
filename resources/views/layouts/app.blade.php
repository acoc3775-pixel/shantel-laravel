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

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Main stylesheet --}}
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}?v=5">
</head>
<body>

    {{-- ── Navbar ─────────────────────────────────────── --}}
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ auth()->check() ? secure_url(route('reservations.index', [], false)) : secure_url(route('login', [], false)) }}" class="nav-brand">
                <span class="brand-icon">
                    <i class="bi bi-clipboard-check"></i>
                </span>
                ReserveList
            </a>

            <div class="nav-links">
                @auth
                    <a href="{{ secure_url(route('reservations.index', [], false)) }}" class="nav-link">
                        <i class="bi bi-list-check"></i>
                        All Reservations
                    </a>

                    <a href="{{ secure_url(route('reservations.create', [], false)) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i>
                        New
                    </a>

                    @if(auth()->user()->is_admin ?? false)
                        <a href="{{ secure_url(route('admin.dashboard', [], false)) }}" class="nav-link">
                            <i class="bi bi-speedometer2"></i>
                            Admin
                        </a>
                    @endif

                    @if(Route::has('profile.edit'))
                        <a href="{{ secure_url(route('profile.edit', [], false)) }}" class="nav-link">
                            <i class="bi bi-person-circle"></i>
                            Profile
                        </a>
                    @endif

                    <span class="nav-user">
                        <i class="bi bi-person-badge"></i>
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ secure_url(route('logout', [], false)) }}" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>
                    </form>
                @else
                    @if(Route::has('login'))
                        <a href="{{ secure_url(route('login', [], false)) }}" class="nav-link">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </a>
                    @endif

                    @if(Route::has('register'))
                        <a href="{{ secure_url(route('register', [], false)) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-person-plus"></i>
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- ── Flash Messages ──────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="bi bi-x-circle-fill"></i>
            {{ session('error') }}
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