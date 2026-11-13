<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\OrganizationalUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    
    public function index()
    {
        $vacancies = Vacancy::with([
            'departmentUnit',
            'creator'
        ])->latest()->get();

        return view('vacancies.index', compact('vacancies'));
    }


    public function create()
    {
        $departments = OrganizationalUnit::where('type', 'department')
            ->orderBy('name')
            ->get();

        $positions = OrganizationalUnit::where('type', 'position')
            ->with('parent')
            ->orderBy('name')
            ->get();

        return view('vacancies.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department_id' => [
                'required',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'department')
            ],
            'position_id' => [
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'position')
            ],
            'requirements' => 'nullable|string',
            'employment_type' => 'required|string|max:100',
            'quota' => 'required|integer|min:1',
            'closing_date' => 'required|date|after_or_equal:today',
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);

        if (!empty($validated['position_id'])) {
            $position = OrganizationalUnit::find($validated['position_id']);

            if (!$position || $position->parent_id != $validated['department_id']) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'position_id' => 'Posisi tidak sesuai dengan departemen yang dipilih.'
                    ]);
            }
        }

        $validated['created_by'] = Auth::id();

        $validated['department'] = OrganizationalUnit::findOrFail(
            $validated['department_id']
        )->name;

        $validated['deadline'] = $validated['closing_date'];

        Vacancy::create($validated);

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->load([
            'departmentUnit',
            'positionUnit',
            'creator',
            'applications'
        ]);

        return view('vacancies.show', compact('vacancy'));
    }

    public function edit(Vacancy $vacancy)
    {
        $departments = OrganizationalUnit::where('type', 'department')
            ->orderBy('name')
            ->get();

        $positions = OrganizationalUnit::where('type', 'position')
            ->with('parent')
            ->orderBy('name')
            ->get();

        return view('vacancies.edit', compact(
            'vacancy',
            'departments',
            'positions'
        ));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department_id' => [
                'required',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'department')
            ],
            'position_id' => [
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'position')
            ],
            'requirements' => 'nullable|string',
            'employment_type' => 'required|string|max:100',
            'quota' => 'required|integer|min:1',
            'closing_date' => 'required|date',
            'status' => ['required', Rule::in(['open', 'closed'])],
        ]);

        if (!empty($validated['position_id'])) {
            $position = OrganizationalUnit::find($validated['position_id']);

            if (!$position || $position->parent_id != $validated['department_id']) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'position_id' => 'Posisi tidak sesuai dengan departemen yang dipilih.'
                    ]);
            }
        }

        $validated['department'] = OrganizationalUnit::findOrFail(
            $validated['department_id']
        )->name;

        $validated['deadline'] = $validated['closing_date'];

        $vacancy->update($validated);

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    public function destroy(Vacancy $vacancy)
    {
        if ($vacancy->applications()->exists()) {
            return redirect()
                ->route('vacancies.index')
                ->with('error', 'Lowongan tidak dapat dihapus karena sudah memiliki data lamaran.');
        }

        $vacancy->delete();

        return redirect()
            ->route('vacancies.index')
            ->with('success', 'Lowongan kerja berhasil dihapus.');
    }
}
