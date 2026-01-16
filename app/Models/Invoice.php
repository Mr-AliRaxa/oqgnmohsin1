<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'project_id', 'invoice_number', 'date', 'status', 'notes', 'to_client', 'subject', 'description', 'value_1', 'value_2'];

    protected $casts = [
        'date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function terms()
    {
        return $this->hasMany(InvoiceTerm::class);
    }
    
    // Helper to calculate total
    public function getTotalAttribute()
    {
        return $this->items->sum('amount');
    }
}
