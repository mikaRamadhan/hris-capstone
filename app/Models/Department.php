<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department_name',
        'description',
    ];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }
}
