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

        /* Header Styles */
        header { 
            background: linear-gradient(90deg, var(--theme-color) 0%, var(--theme-color) 100%); 
            color: #ffffff !important; 
            border-bottom: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
        
        /* Specific header colors and text for light themes */
        .theme-yellow header, .theme-white header { 
            background: #ffffff !important; 
            color: #212529 !important; 
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Ensure all text elements in header inherit the color */
        header h2, header h4, header span, header a:not(.btn), header p { color: inherit !important; }
        
        .theme-green header { background-color: #198754 !important; --theme-color: #198754; }
        .theme-red header { background-color: #dc3545 !important; --theme-color: #dc3545; }
        .theme-black header { background-color: #212529 !important; --theme-color: #212529; }
        .theme-purple header { background-color: #6f42c1 !important; --theme-color: #6f42c1; }
        .theme-blue header { background-color: #0d6efd !important; --theme-color: #0d6efd; }
        .theme-yellow header { background-color: #ffc107 !important; --theme-color: #ffc107; }
        
        /* Header Navigation Tabs */
        header .btn-light { background-color: rgba(255, 255, 255, 0.95) !important; color: var(--theme-color) !important; font-weight: 600; }
        header .btn-outline-light { color: rgba(255, 255, 255, 0.8) !important; }
        header .btn-outline-light:hover { background-color: rgba(255, 255, 255, 0.1) !important; color: #ffffff !important; }
        
        /* Light theme adjustments */
        .theme-yellow header .btn-light, .theme-white header .btn-light { background-color: rgba(0, 0, 0, 0.1) !important; color: #212529 !important; }
        .theme-yellow header .btn-outline-light, .theme-white header .btn-outline-light { color: rgba(0, 0, 0, 0.6) !important; }
        .theme-yellow header .btn-outline-light:hover, .theme-white header .btn-outline-light:hover { background-color: rgba(0, 0, 0, 0.05) !important; color: #000000 !important; }
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
        
        <!-- Toast Notification Container -->
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
            @if(session('success'))
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif
            
            @if(session('error'))
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif
            
            @if(session('warning'))
            <div class="toast align-items-center text-white bg-warning border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        {{ session('warning') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-danger text-white border-0">
                        <h5 class="modal-title" id="deleteConfirmModalLabel">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <p class="mb-0" id="deleteConfirmMessage">Are you sure you want to delete this item? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Cancel
                        </button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                            <i class="bi bi-trash-fill me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            // Auto-hide toasts after delay
            document.addEventListener('DOMContentLoaded', function() {
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
            });
            
            // Delete confirmation modal handler
            let deleteForm = null;
            
            function confirmDelete(event, message = null) {
                event.preventDefault();
                deleteForm = event.target.closest('form');
                
                const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                const messageEl = document.getElementById('deleteConfirmMessage');
                
                if (message) {
                    messageEl.textContent = message;
                } else {
                    messageEl.textContent = 'Are you sure you want to delete this item? This action cannot be undone.';
                }
                
                modal.show();
                return false;
            }
            
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });
        </script>
        
        @stack('scripts')
    </body>
</html>
