<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationalUnit extends Model
{
    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'description',
    ];

    // Menghubungkan posisi dengan departemen induknya
    public function parent()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'parent_id');
    }

    // Mengambil daftar posisi dalam departemen
    public function children()
    {
        return $this->hasMany(OrganizationalUnit::class, 'parent_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'department_id');
    }
}
