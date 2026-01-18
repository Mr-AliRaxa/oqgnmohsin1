<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-2">
    <div class="container-fluid px-4">
        <!-- 1. Logo (Always Visible) -->
        <a class="navbar-brand me-0" href="{{ route('dashboard') }}">
            <x-application-logo style="height: 40px;" />
        </a>

        <!-- ========================================== -->
        <!--            DESKTOP MENU (>= LG)            -->
        <!--   Guaranteed to show on large screens      -->
        <!-- ========================================== -->
        <div class="d-none d-lg-flex flex-grow-1 align-items-center">
            
            <!-- Center: Navigation Links (Wrapped to Center) -->
            <div class="flex-grow-1 d-flex justify-content-center">
                <ul class="navbar-nav gap-4 align-items-center">
                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('dashboard') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-1x2-fill fs-4 mb-1"></i>
                            <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Dashboard</span>
                        </a>
                    </li>

                    @if(auth()->user()->role === 'company_admin')
                        {{-- Teams --}}
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('company.teams.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('company.teams.index') }}">
                                <i class="bi bi-people-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Teams</span>
                            </a>
                        </li>
                        {{-- Projects --}}
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('company.projects.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('company.projects.index') }}">
                                <i class="bi bi-briefcase-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Projects</span>
                            </a>
                        </li>
                        {{-- Expenses --}}
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('company.expenses.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('company.expenses.index') }}">
                                <i class="bi bi-wallet2 fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Expenses</span>
                            </a>
                        </li>
                        {{-- Salaries --}}
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('company.salaries.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('company.salaries.index') }}">
                                <i class="bi bi-cash-stack fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Salaries</span>
                            </a>
                        </li>
                        {{-- Settings Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center dropdown-toggle shadow-none {{ request()->routeIs('company.settings.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="#" id="settingsDropdownDesk" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Settings</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-center border-0 shadow-lg mt-2" aria-labelledby="settingsDropdownDesk">
                                <li><a class="dropdown-item py-2" href="{{ route('company.settings.edit') }}"><i class="bi bi-palette me-2"></i> Theme & Profile</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('company.settings.bank_details.index') }}"><i class="bi bi-bank me-2"></i> Bank Details</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('company.settings.expense_types.index') }}"><i class="bi bi-tags me-2"></i> Expense Types</a></li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->role === 'super_admin')
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('super_admin.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('super_admin.dashboard') }}">
                                <i class="bi bi-building-fill-check fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Companies</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('super_admin.queries.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('super_admin.queries.index') }}">
                                <i class="bi bi-chat-left-dots-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Queries</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('super_admin.contact-messages.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('super_admin.contact-messages.index') }}">
                                <i class="bi bi-envelope-paper-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Messages</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none {{ request()->routeIs('super_admin.smtp-settings.*') ? 'active text-primary fw-bold' : 'text-muted' }}" href="{{ route('super_admin.smtp-settings.index') }}">
                                <i class="bi bi-envelope-at-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">SMTP</span>
                            </a>
                        </li>
                    @else
                        {{-- Query for Project Update --}}
                        <li class="nav-item">
                            <a class="nav-link text-center px-3 py-1 d-flex flex-column align-items-center shadow-none text-muted" href="#" data-bs-toggle="modal" data-bs-target="#projectQueryModal">
                                <i class="bi bi-question-circle-fill fs-4 mb-1"></i>
                                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Query</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Right: Desktop Logout -->
            <div class="d-flex align-items-center gap-3 ms-0 flex-shrink-0">
                <!-- Language Switcher (Desktop) -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 border-0" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-translate"></i>
                        <span class="d-none d-xl-inline">{{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">
                                <span>English</span>
                                @if(app()->getLocale() == 'en') <i class="bi bi-check lg"></i> @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center justify-content-between {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('language.switch', 'ar') }}">
                                <span>العربية</span>
                                @if(app()->getLocale() == 'ar') <i class="bi bi-check lg"></i> @endif
                            </a>
                        </li>
                    </ul>
                </div>

                <span class="small text-muted">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!--             MOBILE TOGGLER                 -->
        <!-- ========================================== -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobileContent" aria-controls="navbarMobileContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- ========================================== -->
        <!--             MOBILE MENU (< LG)             -->
        <!-- ========================================== -->
        <div class="collapse navbar-collapse d-lg-none" id="navbarMobileContent">
            <ul class="navbar-nav ms-auto mt-3 gap-2">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link text-center border p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-light text-primary fw-bold' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                
                @if(auth()->user()->role === 'company_admin')
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('company.teams.index') }}">Teams</a></li>
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('company.projects.index') }}">Projects</a></li>
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('company.expenses.index') }}">Expenses</a></li>
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('company.salaries.index') }}">Salaries</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-center border p-2 rounded" href="#" id="settingsMobile" role="button" data-bs-toggle="dropdown">Settings</a>
                        <ul class="dropdown-menu w-100 text-center border-0 bg-light">
                            <li><a class="dropdown-item" href="{{ route('company.settings.edit') }}">Theme</a></li>
                            <li><a class="dropdown-item" href="{{ route('company.settings.bank_details.index') }}">Bank Details</a></li>
                            <li><a class="dropdown-item" href="{{ route('company.settings.expense_types.index') }}">Expense Types</a></li>
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->role === 'super_admin')
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('super_admin.dashboard') }}">Companies</a></li>
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('super_admin.queries.index') }}">Queries</a></li>
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('super_admin.contact-messages.index') }}">Messages</a></li>
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="{{ route('super_admin.smtp-settings.index') }}">SMTP</a></li>
                @else
                    <li class="nav-item"><a class="nav-link text-center border p-2 rounded" href="#" data-bs-toggle="modal" data-bs-target="#projectQueryModal">Query</a></li>
                @endif
                
                <!-- Mobile Language Switcher -->
                <li class="nav-item border p-2 rounded mt-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small"><i class="bi bi-translate me-2"></i> Language</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('language.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">En</a>
                            <a href="{{ route('language.switch', 'ar') }}" class="btn {{ app()->getLocale() == 'ar' ? 'btn-primary' : 'btn-outline-primary' }}">Ar</a>
                        </div>
                    </div>
                </li>

                <!-- Mobile Logout -->
                <li class="nav-item mt-2">
                    <div class="text-center mb-2 fw-bold">{{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Project Query Modal --}}
@if(auth()->user()->role !== 'super_admin')
<div class="modal fade" id="projectQueryModal" tabindex="-1" aria-labelledby="projectQueryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="projectQueryModalLabel">
                    <i class="bi bi-patch-question me-2"></i> Project Update / Query
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('project_queries.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Send a message to the Super Admin regarding project status, inquiries, or updates.</p>
                    
                    <div class="mb-3">
                        <label for="project_id" class="form-label fw-semibold">Related Project (Optional)</label>
                        <select class="form-select" id="project_id" name="project_id">
                            <option value="">-- Select a Project (If applicable) --</option>
                            @if(isset($navProjects))
                                @foreach($navProjects as $proj)
                                    <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-semibold">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="e.g. Project 'Skyline' Delay Update" required>
                    </div>

                    <div class="mb-0">
                        <label for="message" class="form-label fw-semibold">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your update or question here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 p-3">
                    <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-modal="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">
                        <i class="bi bi-send-fill me-2"></i> Send to Super Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
    .nav-link { transition: all 0.2s ease; border-radius: 8px; }
    .nav-link:hover { background-color: rgba(13, 110, 253, 0.05); }
    .nav-link.active { position: relative; }
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 20%;
        right: 20%;
        height: 3px;
        background-color: #0d6efd;
        border-radius: 3px;
    }
    @media (min-width: 992px) {
        .dropdown-menu-center { left: 50% !important; transform: translateX(-50%) !important; }
    }
</style>
