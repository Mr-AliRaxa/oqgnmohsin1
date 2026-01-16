<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Welcome')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Style -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-section { padding: 80px 0; background-color: #f8f9fa; }
        .footer { background-color: #212529; color: #fff; padding: 40px 0; }
        .navbar-brand { font-weight: 700; color: #0d6efd !important; }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <x-application-logo class="d-inline-block align-top" style="height: 30px; width: auto;" />
                <span class="ms-2">{{ config('app.name') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active fw-bold' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active fw-bold' : '' }}" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-bold' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">About {{ config('app.name') }}</h5>
                    <p class="small text-secondary">Providing professional management solutions for companies and teams worldwide.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-secondary text-decoration-none">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-secondary text-decoration-none">Services</a></li>
                        <li><a href="{{ route('contact') }}" class="text-secondary text-decoration-none">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Contact info</h5>
                    <p class="small text-secondary mb-1">Email: contact@example.com</p>
                    <p class="small text-secondary">Phone: +1 234 567 890</p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small text-secondary">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
