<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Applicant;
use App\Models\User;
use App\Models\OrganizationalUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with([
            'applicant',
            'user',
            'department',
            'position'
        ])->latest()->get();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $applicants = Applicant::orderBy('full_name')->get();
        $users = User::orderBy('name')->get();

        $departments = OrganizationalUnit::where('type', 'department')
            ->orderBy('name')
            ->get();

        $positions = OrganizationalUnit::where('type', 'position')
            ->orderBy('name')
            ->get();

        return view('employees.create', compact(
            'applicants',
            'users',
            'departments',
            'positions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number' => [
                'required',
                'string',
                'max:255',
                'unique:employees,employee_number'
            ],

            'full_name' => 'required|string|max:255',

            'applicant_id' => [
                'nullable',
                'exists:applicants,id',
                'unique:employees,applicant_id'
            ],

            'user_id' => [
                'nullable',
                'exists:users,id',
                'unique:employees,user_id'
            ],

            'department_id' => [
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'department')
            ],

            'position_id' => [
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'position')
            ],

            'join_date' => 'required|date',

            'employment_status' => 'required|in:active,inactive,resigned',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee)
    {
        $employee->load([
            'applicant',
            'user',
            'department',
            'position'
        ]);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $applicants = Applicant::orderBy('full_name')->get();
        $users = User::orderBy('name')->get();

        $departments = OrganizationalUnit::where('type', 'department')
            ->orderBy('name')
            ->get();

        $positions = OrganizationalUnit::where('type', 'position')
            ->orderBy('name')
            ->get();

        return view('employees.edit', compact(
            'employee',
            'applicants',
            'users',
            'departments',
            'positions'
        ));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employees', 'employee_number')
                    ->ignore($employee->id),
            ],

            'full_name' => 'required|string|max:255',

            'applicant_id' => [
                'nullable',
                'exists:applicants,id',
                Rule::unique('employees', 'applicant_id')
                    ->ignore($employee->id),
            ],

            'user_id' => [
                'nullable',
                'exists:users,id',
                Rule::unique('employees', 'user_id')
                    ->ignore($employee->id),
            ],

            'department_id' => [
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'department')
            ],

            'position_id' => [
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'position')
            ],

            'join_date' => 'required|date',

            'employment_status' => 'required|in:active,inactive,resigned',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
