<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    // Menampilkan daftar departemen
    public function index()
    {
        $departments = Department::latest()->get();

        return view('departments.index', compact('departments'));
    }

    // Form tambah departemen
    public function create()
    {
        return view('departments.create');
    }

    // Menyimpan departemen
    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255|unique:departments,department_name',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    // Detail departemen
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    // Form edit departemen
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    // Memperbarui departemen
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'department_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'department_name')
                    ->ignore($department->id),
            ],
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    // Menghapus departemen
    public function destroy(Department $department)
    {
        if ($department->positions()->exists() ||
            $department->vacancies()->exists()) {

            return redirect()->route('departments.index')
                ->with('error', 'Departemen masih digunakan oleh posisi atau lowongan.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}
