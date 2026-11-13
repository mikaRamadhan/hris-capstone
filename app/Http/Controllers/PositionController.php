<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('department')->latest()->get();

        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        $departments = Department::orderBy('department_name')->get();

        return view('positions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'position_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Posisi berhasil ditambahkan.');
    }

    public function show(Position $position)
    {
        $position->load('department');

        return view('positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        $departments = Department::orderBy('department_name')->get();

        return view('positions.edit', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'position_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Posisi berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        if ($position->employees()->exists() || $position->vacancies()->exists()) {
            return redirect()->route('positions.index')
                ->with('error', 'Posisi masih digunakan oleh karyawan atau lowongan.');
        }

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Posisi berhasil dihapus.');
    }
}