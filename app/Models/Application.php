<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'applicant_id',
        'vacancy_id',
        'status',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function selectionResults()
    {
        return $this->hasMany(SelectionResult::class);
    }
}