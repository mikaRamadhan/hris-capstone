<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_number',
        'full_name',
        'applicant_id',
        'user_id',
        'department_id',
        'position_id',
        'join_date',
        'employment_status'
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(
            OrganizationalUnit::class,
            'department_id'
        );
    }

    public function position()
    {
        return $this->belongsTo(
            OrganizationalUnit::class,
            'position_id'
        );
    }
}
