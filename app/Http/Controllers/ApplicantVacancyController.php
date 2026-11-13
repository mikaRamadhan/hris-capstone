<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class ApplicantVacancyController extends Controller
{
    /**
     * Daftar lowongan yang tersedia.
     */
    public function index(Request $request)
    {
        $query = Vacancy::with(['departmentUnit', 'positionUnit'])
            ->where('status', 'open');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('title', 'like', "%{$search}%");
        }

        $vacancies = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('applicants.vacancies.index', compact('vacancies'));
    }

    /**
     * Detail lowongan.
     */
    public function show($id)
    {
        $vacancy = Vacancy::with([
            'departmentUnit',
            'positionUnit'
        ])
        ->where('status', 'open')
        ->findOrFail($id);

        return view('applicants.vacancies.show', compact('vacancy'));
    }
}
