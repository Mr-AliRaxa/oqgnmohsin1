<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('company.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    {{-- Branding & Identity (New) --}}
                    <div class="col-md-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-palette-fill text-primary me-2"></i> Company Branding</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="company_email" class="form-label fw-semibold">Company Email (for PDFs)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                            <input type="email" id="company_email" name="company_email" class="form-control border-start-0" 
                                                   value="{{ $settings['company_email'] ?? auth()->user()->company->email }}" 
                                                   placeholder="e.g. info@yourcompany.com">
                                        </div>
                                        <div class="form-text small">This email will appear on all generated PDFs (Invoices, Salaries).</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pdf_logo" class="form-label fw-semibold">PDF Logo (Official Branding)</label>
                                        <input type="file" id="pdf_logo" name="pdf_logo" class="form-control">
                                        <div class="form-text small">High-quality image for PDF headers. Recommended: PNG with transparent background.</div>
                                        @if(isset($settings['pdf_logo']))
                                            <div class="mt-3 p-2 border rounded bg-light text-center">
                                                <p class="small text-muted mb-2">Current PDF Logo:</p>
                                                <img src="{{ asset('storage/' . $settings['pdf_logo']) }}" class="img-fluid" style="max-height: 80px;" alt="Current PDF Logo">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Theme & Appearance --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-display text-primary me-2"></i> Appearance Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="theme_mode" class="form-label fw-semibold">Display Mode</label>
                                    <select id="theme_mode" name="theme_mode" class="form-select">
                                        <option value="light" {{ ($settings['theme_mode'] ?? '') == 'light' ? 'selected' : '' }}>Light Mode (Default)</option>
                                        <option value="dark" {{ ($settings['theme_mode'] ?? '') == 'dark' ? 'selected' : '' }}>Dark Mode</option>
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label for="theme_color" class="form-label fw-semibold">Theme Color Accent</label>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @php
                                            $colors = [
                                                'blue' => '#0d6efd',
                                                'red' => '#dc3545',
                                                'green' => '#198754',
                                                'purple' => '#6f42c1',
                                                'black' => '#212529',
                                                'yellow' => '#ffc107'
                                            ];
                                            $currentColor = $settings['theme_color'] ?? 'blue';
                                        @endphp
                                        @foreach($colors as $name => $hex)
                                            <div class="form-check form-check-inline p-0 m-0">
                                                <input type="radio" class="btn-check" name="theme_color" id="color_{{ $name }}" value="{{ $name }}" {{ $currentColor == $name ? 'checked' : '' }}>
                                                <label class="btn btn-outline-secondary p-1 rounded-circle d-flex align-items-center justify-content-center" 
                                                       for="color_{{ $name }}" 
                                                       style="width: 40px; height: 40px; border-width: 2px;">
                                                    <span class="rounded-circle d-block" style="width: 28px; height: 28px; background-color: {{ $hex }};"></span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PDF Advanced Settings --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-pdf text-danger me-2"></i> PDF Watermark & Print</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="print_background" class="form-label fw-semibold">A4 Print Background (Watermark)</label>
                                    <input id="print_background" type="file" name="print_background" class="form-control">
                                    <div class="form-text small">Full-page background image used for PDF generation.</div>
                                </div>
                                @if(isset($settings['print_background']))
                                    <div class="mt-3 p-3 border rounded bg-light text-center">
                                        <p class="small text-muted mb-2">Active Watermark Preview:</p>
                                        <div class="position-relative d-inline-block border" style="width: 100px; height: 141px; background: white;">
                                            <img src="{{ asset('storage/' . $settings['print_background']) }}" class="img-fluid w-100 h-100 opacity-25" style="object-fit: cover;" alt="Background Preview">
                                            <div class="position-absolute top-50 start-50 translate-middle small text-muted opacity-50 fw-bold" style="font-size: 0.5rem;">A4 PREVIEW</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="col-12 mt-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 hover-lift transition-all">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded me-3">
                                            <i class="bi bi-bank fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Bank Details</h6>
                                            <p class="small text-muted mb-2">Manage bank accounts for automatic invoice inclusion.</p>
                                            <a href="{{ route('company.settings.bank_details.index') }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold">Manage Accounts</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 hover-lift transition-all">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 text-success p-3 rounded me-3">
                                            <i class="bi bi-tags fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Expense Categories</h6>
                                            <p class="small text-muted mb-2">Define transaction types for better financial tracking.</p>
                                            <a href="{{ route('company.settings.expense_types.index') }}" class="btn btn-sm btn-outline-success px-3 rounded-pill fw-bold">Manage Types</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end border-top pt-4 mb-5">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm fw-bold">
                        <i class="bi bi-save me-2"></i> Save All Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .hover-lift:hover { transform: translateY(-3px); }
        .transition-all { transition: all 0.2s ease; }
        .btn-check:checked + label { border-color: currentColor !important; box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.1); }
    </style>
</x-app-layout>
