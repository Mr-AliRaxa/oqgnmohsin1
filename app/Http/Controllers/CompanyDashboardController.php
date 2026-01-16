<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        if (! $company) {
            abort(403, 'No company assigned.');
        }

        $totalProjects = $company->projects()->count();
        $totalTeam = $company->teams()->count();
        $totalExpenses = $company->expenses()->sum('amount');
        $totalSalaryUsed = $company->salaries()->sum('amount');
        
        $todayExpenses = $company->expenses()->whereDate('date', now()->today())->sum('amount');
        $thisMonthExpenses = $company->expenses()->whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount');
        
        $todaySalary = $company->salaries()->whereDate('date', now()->today())->sum('amount');
        $thisMonthSalary = $company->salaries()->whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount');
        
        $recentProjects = $company->projects()->latest()->take(5)->get();
        
        $todayExpensesRecords = $company->expenses()->whereDate('date', now()->today())->latest()->get();
        $thisMonthSalariesRecords = $company->salaries()->whereYear('date', now()->year)->whereMonth('date', now()->month)->latest()->get();

        $teamMembers = $company->teams()->latest()->get();
        $expenseTypes = $company->expenses()->distinct()->pluck('type');

        // Project Status Counts
        $projectStatusCounts = $company->projects()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Chart Data (Last 6 Months)
        $chartLabels = [];
        $expenseData = [];
        $salaryData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            $year = $date->year;
            $month = $date->month;

            $chartLabels[] = $monthLabel;
            
            $expenseData[] = $company->expenses()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->sum('amount');

            $salaryData[] = $company->salaries()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->sum('amount');
        }

        return view('company.dashboard', compact(
            'totalProjects', 
            'totalTeam', 
            'totalExpenses', 
            'totalSalaryUsed', 
            'todayExpenses',
            'thisMonthExpenses',
            'todaySalary',
            'thisMonthSalary',
            'recentProjects',
            'chartLabels',
            'expenseData',
            'salaryData',
            'todayExpensesRecords',
            'thisMonthSalariesRecords',
            'teamMembers',
            'expenseTypes',
            'projectStatusCounts'
        ));
    }
}
