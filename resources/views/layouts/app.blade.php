<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @php
        $company = auth()->user()->company;
        $settings = $company ? $company->settings()->pluck('value', 'key') : [];
        $themeMode = $settings['theme_mode'] ?? 'light';
        $themeColor = $settings['theme_color'] ?? 'blue';
        
        $bodyClass = 'font-sans antialiased';
        if($themeMode === 'dark') {
            $bodyClass .= ' bg-dark text-white';
        } else {
            $bodyClass .= ' bg-light text-dark';
        }
    @endphp
    <style>
        /* Theme Color Overrides */
        .theme-green .text-dark, .theme-green .card-title, .theme-green h2, .theme-green h3, .theme-green h4, .theme-green h5 { color: #198754 !important; }
        .theme-red .text-dark, .theme-red .card-title, .theme-red h2, .theme-red h3, .theme-red h4, .theme-red h5 { color: #dc3545 !important; }
        .theme-black .text-dark, .theme-black .card-title, .theme-black h2, .theme-black h3, .theme-black h4, .theme-black h5 { color: #000000 !important; }
        .theme-white .text-dark, .theme-white .card-title, .theme-white h2, .theme-white h3, .theme-white h4, .theme-white h5 { color: #ffffff !important; }
        .theme-yellow .text-dark, .theme-yellow .card-title, .theme-yellow h2, .theme-yellow h3, .theme-yellow h4, .theme-yellow h5 { color: #ffc107 !important; }
        .theme-purple .text-dark, .theme-purple .card-title, .theme-purple h2, .theme-purple h3, .theme-purple h4, .theme-purple h5 { color: #6f42c1 !important; }
        .theme-blue .text-dark, .theme-blue .card-title, .theme-blue h2, .theme-blue h3, .theme-blue h4, .theme-blue h5 { color: #0d6efd !important; }

        /* Header Background Overrides */
        .theme-green header { background-color: #198754 !important; }
        .theme-red header { background-color: #dc3545 !important; }
        .theme-black header { background-color: #000000 !important; }
        .theme-white header { background-color: #ffffff !important; border-bottom: 1px solid #dee2e6; }
        .theme-yellow header { background-color: #ffc107 !important; }
        .theme-purple header { background-color: #6f42c1 !important; }
        .theme-blue header { background-color: #0d6efd !important; }

        /* Header Text Contrast */
        .theme-green header h2, .theme-red header h2, .theme-black header h2, .theme-purple header h2, .theme-blue header h2 { color: #ffffff !important; }
        .theme-yellow header h2, .theme-white header h2 { color: #212529 !important; }
    </style>
    <body class="{{ $bodyClass }} theme-{{ $themeColor }}">
        <div class="d-flex flex-column min-vh-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="shadow-sm mb-4">
                    <div class="container-fluid px-4 py-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container-fluid px-4">
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>
