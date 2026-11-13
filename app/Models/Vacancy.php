<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = [
        'title',
        'description',
        'department',
        'department_id',
        'position_id',
        'requirements',
        'employment_type',
        'quota',
        'deadline',
        'closing_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'closing_date' => 'date',
        'deadline' => 'date',
    ];

    public function departmentUnit()
    {
        return $this->belongsTo(
            OrganizationalUnit::class,
            'department_id',
            'id'
        );
    }

    public function positionUnit()
    {
        return $this->belongsTo(
            OrganizationalUnit::class,
            'position_id',
            'id'
        );
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
