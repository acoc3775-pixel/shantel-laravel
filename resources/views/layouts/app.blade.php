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

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Main stylesheet --}}
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}?v=8">
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ auth()->check() ? secure_url(route('reservations.index', [], false)) : secure_url(route('login', [], false)) }}">
                <i class="bi bi-clipboard-check me-2"></i> ReserveList
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ secure_url(route('reservations.index', [], false)) }}">
                                <i class="bi bi-list-check me-1"></i> Reservations
                            </a>
                        </li>

                        @if(auth()->user()->is_admin ?? false)
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center ms-2" href="{{ secure_url(route('admin.dashboard', [], false)) }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Admin
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                @if(auth()->user()->avatar)
                                    <img src="{{ secure_asset('uploads/avatars/' . auth()->user()->avatar) }}"
                                         class="rounded-circle me-1"
                                         width="32"
                                         height="32"
                                         style="object-fit:cover;">
                                @else
                                    <i class="bi bi-person-circle me-1 fs-4"></i>
                                @endif

                                {{ auth()->user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                        <i class="bi bi-gear me-1"></i> Profile
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <form method="POST" action="{{ secure_url(route('logout', [], false)) }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ secure_url(route('login', [], false)) }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="{{ secure_url(route('register', [], false)) }}">
                                <i class="bi bi-person-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Toast Notifications --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index:1080;">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-x-circle-fill me-1"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="container mb-5">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer py-3 bg-light border-top mt-auto">
        <div class="container text-center small">
            ReserveList &mdash; Built with Laravel &bull; BSIT 2024
        </div>
    </footer>

    {{-- Profile Modal --}}
    @auth
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-person-circle text-primary me-1"></i> Edit Profile
                        </h5>
                        <p class="text-muted small mb-0">
                            Update your account information, profile image, or password.
                        </p>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ secure_url(route('profile.update', [], false)) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="text-center mb-4">
                            @if(auth()->user()->avatar)
                                <img src="{{ secure_asset('uploads/avatars/' . auth()->user()->avatar) }}"
                                     class="rounded-circle shadow-sm"
                                     width="96"
                                     height="96"
                                     style="object-fit:cover;">
                            @else
                                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:96px;height:96px;background:#eef3ff;color:#2563eb;font-size:2.5rem;font-weight:700;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Profile Image</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <div class="form-text">JPG, PNG, or WebP. Max 2MB.</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           value="{{ old('name', auth()->user()->name) }}"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="{{ old('email', auth()->user()->email) }}"
                                           required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold">
                            <i class="bi bi-lock text-primary me-1"></i>
                            Change Password
                        </h6>
                        <p class="text-muted small">
                            Leave blank if you do not want to change your password.
                        </p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Minimum 8 characters">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Repeat password">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.toast').forEach(toastEl => {
            setTimeout(() => {
                bootstrap.Toast.getOrCreateInstance(toastEl).hide();
            }, 3500);
        });
    </script>

    @yield('scripts')
</body>
</html>