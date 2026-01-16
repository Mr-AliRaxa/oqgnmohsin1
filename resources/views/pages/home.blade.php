<x-public-layout>
    @section('title', 'Home')

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Manage Your Business Like a Pro</h1>
                    <p class="lead text-secondary mb-5">All-in-one platform for team management, salary processing, and expense tracking. Simplify your operations today.</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 gap-3">Get Started</a>
                        <a href="{{ route('services') }}" class="btn btn-outline-secondary btn-lg px-4">Our Services</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Us?</h2>
                <p class="text-secondary">Powerful features designed to help your business grow.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="mb-3">
                             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-people text-primary" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.835 5.835 0 0 0-1.23-.247A3.335 3.335 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724C2.312 10.628 3.282 10 5 10c.035 0 .07 0 .105.002a3.479 3.479 0 0 0-.185.998ZM6 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm1-2a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"/>
                            </svg>
                        </div>
                        <h4 class="fw-bold">Team Management</h4>
                        <p class="text-secondary small">Organize your workforce with customizable team structures and roles.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cash-coin text-success" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.483-.269-.911-.844-1.058l-.441-.117c-.503-.115-.63-.272-.63-.448 0-.219.222-.401.593-.401.372 0 .553.167.623.402h.43c-.07-.601-.52-1.002-1.321-1.059V8.5h-.375v.449c-.752.051-1.32.42-1.32 1.102 0 .43.262.839.814.978l.493.123c.561.14.733.31.733.52 0 .245-.244.49-.634.49-.474 0-.694-.236-.776-.53h-.435zm1.534-1.46c-.015-.022-.032-.045-.049-.066a.44.44 0 0 1-.059-.07c-.012-.02-.023-.04-.033-.06-.01-.02-.02-.042-.026-.064a.276.276 0 0 1-.005-.067c0-.03.003-.06.012-.088.008-.028.02-.055.035-.08a.332.332 0 0 1 .056-.07c.022-.023.048-.043.076-.06.028-.016.059-.028.092-.034a.434.434 0 0 1 .124-.006c.033.003.066.01.097.022.031.012.06.028.086.049.026.02.049.046.068.074a.426.426 0 0 1 .054.1c.015.035.025.072.03.11a.482.482 0 0 1 .006.126.353.353 0 0 1-.013.093.303.303 0 0 1-.035.084.34.34 0 0 1-.056.074.457.457 0 0 1-.078.062c-.028.017-.06.028-.093.035a.443.443 0 0 1-.124.004.38.38 0 0 1-.097-.018.324.324 0 0 1-.086-.046.402.402 0 0 1-.115-.174z"/>
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5H1V4a1 1 0 0 0-1 1v2h1V4z"/>
                            </svg>
                        </div>
                        <h4 class="fw-bold">Salary Processing</h4>
                        <p class="text-secondary small">Process payroll accurately and generate professional reports in seconds.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="mb-3">
                             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-graph-up-arrow text-danger" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5Z"/>
                            </svg>
                        </div>
                        <h4 class="fw-bold">Expense Tracking</h4>
                        <p class="text-secondary small">Monitor your company's spending with real-time analytics and data exports.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
