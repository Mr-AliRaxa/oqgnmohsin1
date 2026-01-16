<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function bankDetails()
    {
        return $this->hasMany(BankDetail::class);
    }

    public function expenseTypes()
    {
        return $this->hasMany(ExpenseType::class);
    }
}
