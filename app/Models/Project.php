<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_DRAFT = 'draft';
    const STATUS_CONTINUED = 'continued';
    const STATUS_STOPPED = 'stopped';
    const STATUS_FINISHED = 'finished';
    const STATUS_CANCELLED = 'cancelled';

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_CONTINUED => 'Continued',
            self::STATUS_STOPPED => 'Temporary Stop',
            self::STATUS_FINISHED => 'Finished',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'secondary',
            self::STATUS_CONTINUED => 'primary',
            self::STATUS_STOPPED => 'warning',
            self::STATUS_FINISHED => 'success',
            self::STATUS_CANCELLED => 'danger',
            default => 'info',
        };
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(ProjectItem::class);
    }

    public function terms()
    {
        return $this->hasMany(ProjectTerm::class);
    }

    public function teamMembers()
    {
        return $this->belongsToMany(Team::class, 'project_team');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
