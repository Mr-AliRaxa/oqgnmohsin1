<x-public-layout>
    @section('title', 'Our Services')

    <section class="py-5 bg-white">
        <div class="container text-center mb-5">
            <h1 class="display-5 fw-bold">Our Services</h1>
            <p class="lead text-secondary">Tailored solutions for modern business management.</p>
        </div>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border shadow-sm hov-scale">
                        <div class="card-body p-4">
                            <div class="mb-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
                                    <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.386 1.764a.5.5 0 0 0 .228 0zM14.5 4a.5.5 0 0 1 .5.5V6.15l-4.5 1.242V7a.5.5 0 0 0-1 0v.392l-4.5-1.242V4.5a.5.5 0 0 1 .5-.5h13z"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Business Management</h5>
                            <p class="text-secondary small text-justify">Comprehensive dashboard to monitor your company's performance, team productivity, and financial health in one place.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border shadow-sm hov-scale">
                        <div class="card-body p-4">
                            <div class="mb-3 text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Automated Payroll</h5>
                            <p class="text-secondary small text-justify">Say goodbye to manual calculations. Our system automates salary processing, bonuses, and generates professional PDF slips.</p>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border shadow-sm hov-scale">
                        <div class="card-body p-4">
                            <div class="mb-3 text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-kanban" viewBox="0 0 16 16">
                                    <path d="M13.5 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h11zm-11-1a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-11z"/>
                                    <path d="M6.5 3a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V3zm-4 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V3zm8 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V3z"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Project Tracking</h5>
                            <p class="text-secondary small text-justify">Keep your projects on schedule. Assign tasks, track progress, and manage invoices seamlessly across multiple projects.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
