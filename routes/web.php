<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.store');

Route::middleware(['auth', 'verified', 'approval'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'super_admin') {
            return redirect()->route('super_admin.dashboard');
        }
        return redirect()->route('company.dashboard');
    })->name('dashboard');

    // Super Admin Routes
    Route::middleware('role:super_admin')->prefix('admin')->name('super_admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        
        // Registration Management
        Route::get('/registrations', [SuperAdminController::class, 'registrations'])->name('registrations.index');
        Route::post('/registrations/{company}/approve', [SuperAdminController::class, 'approve'])->name('registrations.approve');
        Route::post('/registrations/{company}/reject', [SuperAdminController::class, 'reject'])->name('registrations.reject');
        Route::post('/registrations/{company}/toggle-active', [SuperAdminController::class, 'toggleActive'])->name('registrations.toggle-active');

        Route::get('/companies/create', [SuperAdminController::class, 'create'])->name('companies.create');
        Route::post('/companies', [SuperAdminController::class, 'store'])->name('companies.store');
        Route::get('/companies/{company}/edit', [SuperAdminController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{company}', [SuperAdminController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{company}', [SuperAdminController::class, 'destroy'])->name('companies.destroy');
        Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [SuperAdminController::class, 'updateSettings'])->name('settings.update');
        
        // Project Queries (Super Admin View)
        Route::get('/queries', [\App\Http\Controllers\ProjectQueryController::class, 'index'])->name('queries.index');
        Route::post('/queries/{query}/read', [\App\Http\Controllers\ProjectQueryController::class, 'markAsRead'])->name('queries.mark-read');

        // Contact Messages (Super Admin View)
        Route::get('/contact-messages', [\App\Http\Controllers\SuperAdmin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::post('/contact-messages/{message}/status', [\App\Http\Controllers\SuperAdmin\ContactMessageController::class, 'updateStatus'])->name('contact-messages.update-status');
        Route::delete('/contact-messages/{message}', [\App\Http\Controllers\SuperAdmin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });

    // Project Query (Submission - accessible by any authenticated user)
    Route::post('/project-queries', [\App\Http\Controllers\ProjectQueryController::class, 'store'])->name('project_queries.store');

    // Company Admin Routes
    Route::middleware('role:company_admin')->prefix('company')->name('company.')->group(function () {
         Route::get('/dashboard', [\App\Http\Controllers\CompanyDashboardController::class, 'index'])->name('dashboard');
         Route::resource('teams', \App\Http\Controllers\TeamController::class);
         Route::resource('projects', \App\Http\Controllers\ProjectController::class);
         Route::get('expenses/pdf', [\App\Http\Controllers\ExpenseController::class, 'downloadPDF'])->name('expenses.pdf');
         Route::get('expenses/excel', [\App\Http\Controllers\ExpenseController::class, 'downloadExcel'])->name('expenses.excel');
         Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
         Route::get('salaries/pdf', [\App\Http\Controllers\SalaryController::class, 'downloadPDF'])->name('salaries.pdf');
         Route::resource('salaries', \App\Http\Controllers\SalaryController::class);
         Route::get('projects/{project}/invoices', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');
         Route::get('projects/{project}/invoices/create', [\App\Http\Controllers\InvoiceController::class, 'create'])->name('invoices.create');
         Route::post('projects/{project}/invoices', [\App\Http\Controllers\InvoiceController::class, 'store'])->name('invoices.store');
         Route::get('invoices/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoices.show');
         
         Route::get('settings', [\App\Http\Controllers\SettingController::class, 'edit'])->name('settings.edit');
         Route::post('settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
         Route::resource('settings/bank_details', \App\Http\Controllers\BankDetailController::class, ['as' => 'settings']);
         Route::resource('settings/expense_types', \App\Http\Controllers\ExpenseTypeController::class, ['as' => 'settings']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware(['auth'])->name('pending.approval');

require __DIR__.'/auth.php';
