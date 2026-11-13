<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizationalUnitController extends Controller
{
    // Menampilkan semua departemen dan posisi
    public function index()
    {
        $organizationalUnits = OrganizationalUnit::with('parent')
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('organizational-units.index', compact('organizationalUnits'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        $departments = OrganizationalUnit::where('type', 'department')
            ->orderBy('name')
            ->get();

        return view('organizational-units.create', compact('departments'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['department', 'position'])],
            'parent_id' => [
                'nullable',
                'required_if:type,position',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'department'),
            ],
            'description' => 'nullable|string',
        ]);

        if ($validated['type'] === 'department') {
            $validated['parent_id'] = null;
        }

        OrganizationalUnit::create($validated);

        return redirect()->route('organizational-units.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan detail
    public function show(OrganizationalUnit $organizationalUnit)
    {
        $organizationalUnit->load(['parent', 'children']);

        return view('organizational-units.show', compact('organizationalUnit'));
    }

    // Menampilkan form edit
    public function edit(OrganizationalUnit $organizationalUnit)
    {
        $departments = OrganizationalUnit::where('type', 'department')
            ->where('id', '!=', $organizationalUnit->id)
            ->orderBy('name')
            ->get();

        return view('organizational-units.edit', compact(
            'organizationalUnit',
            'departments'
        ));
    }

    // Memperbarui data
    public function update(Request $request, OrganizationalUnit $organizationalUnit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => [
                Rule::requiredIf($organizationalUnit->type === 'position'),
                'nullable',
                Rule::exists('organizational_units', 'id')
                    ->where('type', 'department'),
            ],
        ]);

        if ($organizationalUnit->type === 'department') {
            $validated['parent_id'] = null;
        }

        $organizationalUnit->update($validated);

        return redirect()->route('organizational-units.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy(OrganizationalUnit $organizationalUnit)
    {
        if ($organizationalUnit->children()->exists()) {
            return redirect()->route('organizational-units.index')
                ->with('error', 'Departemen masih memiliki posisi.');
        }

        if ($organizationalUnit->employees()->exists()
            || $organizationalUnit->vacancies()->exists()) {
            return redirect()->route('organizational-units.index')
                ->with('error', 'Data masih digunakan oleh karyawan atau lowongan.');
        }

        $organizationalUnit->delete();

        return redirect()->route('organizational-units.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
