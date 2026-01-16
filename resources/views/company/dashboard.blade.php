<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Company Dashboard') }} - {{ auth()->user()->company->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="row g-4">
                <!-- Sidebar Column (Left) -->
                <div class="col-md-3">
                    <!-- This Month Salary Records (Top) -->
                    <div class="card shadow-sm border-0 mb-4 h-50 overflow-hidden d-flex flex-column">
                        <div class="card-header bg-success bg-opacity-10 text-success py-3 border-0">
                            <h6 class="mb-0 fw-bold">This Month Salaries</h6>
                        </div>
                        <div class="card-body p-0 overflow-auto flex-grow-1" style="max-height: 400px;">
                            <div class="list-group list-group-flush">
                                @forelse($thisMonthSalariesRecords as $salary)
                                    <div class="list-group-item border-0 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold small text-dark">{{ $salary->employee_name ?? 'Employee' }}</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ $salary->date->format('d M') }}</div>
                                            </div>
                                            <div class="fw-bold text-success small">${{ number_format($salary->amount, 2) }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted small">No salary records for this month.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Today's Expenses Records (Down) -->
                    <div class="card shadow-sm border-0 h-50 overflow-hidden d-flex flex-column">
                        <div class="card-header bg-danger bg-opacity-10 text-danger py-3 border-0">
                            <h6 class="mb-0 fw-bold">Today's Expenses</h6>
                        </div>
                        <div class="card-body p-0 overflow-auto flex-grow-1" style="max-height: 400px;">
                            <div class="list-group list-group-flush">
                                @forelse($todayExpensesRecords as $expense)
                                    <div class="list-group-item border-0 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold small text-dark">{{ $expense->type ?? 'Expense' }}</div>
                                                <div class="text-muted text-truncate d-inline-block" style="font-size: 0.75rem; max-width: 120px;">{{ $expense->note }}</div>
                                            </div>
                                            <div class="fw-bold text-danger small">${{ number_format($expense->amount, 2) }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted small">No expenses recorded today.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Column (Center) -->
                <div class="col-md-6">
                    <!-- Expenses Section -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Expenses Overview</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 border-start border-4 border-danger h-100">
                                    <div class="card-body py-3">
                                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">Total Expenses</div>
                                        <div class="h5 fw-bold text-danger mb-0">${{ number_format($totalExpenses, 0) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 border-start border-4 border-danger h-100">
                                    <div class="card-body py-3">
                                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">This Month</div>
                                        <div class="h5 fw-bold text-danger mb-0">${{ number_format($thisMonthExpenses, 0) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 border-start border-4 border-danger h-100">
                                    <div class="card-body py-3">
                                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">Today</div>
                                        <div class="h5 fw-bold text-danger mb-0">${{ number_format($todayExpenses, 0) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Salaries Section -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted fw-bold mb-3 small" style="letter-spacing: 1px;">Salaries Overview</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
                                    <div class="card-body py-3">
                                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">Total Paid</div>
                                        <div class="h5 fw-bold text-success mb-0">${{ number_format($totalSalaryUsed, 0) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
                                    <div class="card-body py-3">
                                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">This Month</div>
                                        <div class="h5 fw-bold text-success mb-0">${{ number_format($thisMonthSalary, 0) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
                                    <div class="card-body py-3">
                                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">Today</div>
                                        <div class="h5 fw-bold text-success mb-0">${{ number_format($todaySalary, 0) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operations Section -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 border-start border-4 border-primary">
                                    <div class="card-body py-3 d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5m1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0M1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">Total Projects</div>
                                            <div class="h5 fw-bold text-dark mb-0">{{ $totalProjects }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 border-start border-4 border-info">
                                    <div class="card-body py-3 d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 text-info p-2 rounded me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.65rem;">Team Members</div>
                                            <div class="h5 fw-bold text-dark mb-0">{{ $totalTeam }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Projects -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-3">Recent Projects</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" style="font-size: 0.85rem;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentProjects as $project)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $project->subject }}</td>
                                            <td>
                                                <span class="badge bg-{{ $project->status_color }} bg-opacity-10 text-{{ $project->status_color }} border border-{{ $project->status_color }} border-opacity-25 px-2 py-1">
                                                    {{ $project->status_label }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-3">No projects found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-3">Financial Overview</h6>
                            <div style="height: 250px;">
                                <canvas id="expenseSalaryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Column -->
                <div class="col-md-3">
                    <!-- Team Members (Top) -->
                    <div class="card shadow-sm border-0 mb-4 overflow-hidden d-flex flex-column" style="height: 300px;">
                        <div class="card-header bg-primary bg-opacity-10 text-primary py-3 border-0">
                            <h6 class="mb-0 fw-bold">Team Members</h6>
                        </div>
                        <div class="card-body p-0 overflow-auto flex-grow-1">
                            <div class="list-group list-group-flush">
                                @forelse($teamMembers as $member)
                                    <div class="list-group-item border-0 border-bottom py-2">
                                        <div class="d-flex align-items-center">
                                            @if($member->image_path)
                                                <img src="{{ asset('storage/' . $member->image_path) }}" class="rounded-circle me-3" style="width: 32px; height: 32px; object-fit: cover;" alt="{{ $member->name }}">
                                            @else
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 fw-bold small" style="width: 32px; height: 32px;">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold small text-dark" style="font-size: 0.8rem;">{{ $member->name }}</div>
                                                <div class="text-muted small" style="font-size: 0.7rem;">{{ $member->designation ?? 'Team Member' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted small">No team members added yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Project Status Summary (New) -->
                    <div class="card shadow-sm border-0 mb-4 h-50 overflow-hidden d-flex flex-column">
                        <div class="card-header bg-warning bg-opacity-10 text-dark py-3 border-0">
                            <h6 class="mb-0 fw-bold">Project Portfolio</h6>
                        </div>
                        <div class="card-body p-0 overflow-auto flex-grow-1">
                            <div class="list-group list-group-flush">
                                @foreach(\App\Models\Project::getStatuses() as $key => $label)
                                    @php $count = $projectStatusCounts[$key] ?? 0; @endphp
                                    <a href="{{ route('company.projects.index', ['status' => $key]) }}" class="list-group-item list-group-item-action border-0 border-bottom d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center text-{{ $key === 'stopped' ? 'dark' : ($key === 'draft' ? 'secondary' : $key) }}">
                                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem;"></i>
                                            <span class="small fw-bold">{{ $label }}</span>
                                        </div>
                                        <span class="badge bg-{{ $key === 'stopped' ? 'warning text-dark' : ($key === 'draft' ? 'secondary' : $key) }} rounded-pill px-3">{{ $count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Expense Types (Down) -->
                    <div class="card shadow-sm border-0 h-50 overflow-hidden d-flex flex-column">
                        <div class="card-header bg-dark bg-opacity-10 text-dark py-3 border-0">
                            <h6 class="mb-0 fw-bold">Expense Categories</h6>
                        </div>
                        <div class="card-body p-3 overflow-auto flex-grow-1" style="max-height: 400px;">
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($expenseTypes as $type)
                                    <span class="badge border text-dark py-2 px-3 fw-normal" style="background-color: #f8f9fa;">
                                        <i class="bi bi-tag-fill me-1 text-secondary"></i> {{ $type }}
                                    </span>
                                @empty
                                    <div class="text-center text-muted small w-100">No expense types found.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('expenseSalaryChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Expenses',
                            data: @json($expenseData),
                            backgroundColor: 'rgba(220, 53, 69, 0.7)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Salaries',
                            data: @json($salaryData),
                            backgroundColor: 'rgba(25, 135, 84, 0.7)',
                            borderColor: 'rgba(25, 135, 84, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
