<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Applicant;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Menampilkan seluruh data lamaran.
     */
    public function index(Request $request)
{
    $query = Application::with([
        'applicant',
        'vacancy.departmentUnit',
    ]);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('applicant', function ($subQuery) use ($search) {
                $subQuery->where('full_name', 'like', "%{$search}%");
            })->orWhereHas('vacancy', function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', "%{$search}%");
            });
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $applications = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('applications.index', compact('applications'));
}

    /**
     * Menampilkan form tambah lamaran.
     */
    public function create()
    {
        $applicants = Applicant::orderBy('full_name')->get();

        $vacancies = Vacancy::where('status', 'open')
            ->orderBy('title')
            ->get();

        return view('applications.create', compact(
            'applicants',
            'vacancies'
        ));
    }

    /**
     * Menyimpan lamaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'vacancy_id' => 'required|exists:vacancies,id',
            'status' => 'required|in:submitted,reviewing,accepted,rejected',
            'applied_at' => 'nullable|date',
            'document_type' => 'nullable|string|max:255',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        $application = Application::create([
            'applicant_id' => $validated['applicant_id'],
            'vacancy_id' => $validated['vacancy_id'],
            'status' => $validated['status'],
            'applied_at' => $validated['applied_at'] ?? now(),
        ]);

        $this->saveDocuments($request, $application);

        return redirect()
            ->route('applications.show', $application->id)
            ->with('success', 'Data lamaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lamaran.
     */
    public function show(string $id)
    {
        $application = Application::with([
            'applicant.user',
            'vacancy.departmentUnit',
            'vacancy.positionUnit',
            'documents',
        ])->findOrFail($id);

        return view('applications.show', compact('application'));
    }

    /**
     * Menampilkan form edit lamaran.
     */
    public function edit(string $id)
    {
        $application = Application::with([
            'applicant',
            'vacancy',
            'documents',
        ])->findOrFail($id);

        $applicants = Applicant::orderBy('full_name')->get();
        $vacancies = Vacancy::orderBy('title')->get();

        return view('applications.edit', compact(
            'application',
            'applicants',
            'vacancies'
        ));
    }

    /**
     * Memperbarui data lamaran.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);

        $validated = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'vacancy_id' => 'required|exists:vacancies,id',
            'status' => 'required|in:submitted,reviewing,accepted,rejected',
            'applied_at' => 'nullable|date',
            'document_type' => 'nullable|string|max:255',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        $application->update([
            'applicant_id' => $validated['applicant_id'],
            'vacancy_id' => $validated['vacancy_id'],
            'status' => $validated['status'],
            'applied_at' => $validated['applied_at'] ?? $application->applied_at,
        ]);

        $this->saveDocuments($request, $application);

        return redirect()
            ->route('applications.show', $application->id)
            ->with('success', 'Data lamaran berhasil diperbarui.');
    }

    /**
     * Menghapus lamaran beserta dokumennya.
     */
    public function destroy(string $id)
    {
        $application = Application::with('documents')->findOrFail($id);

        foreach ($application->documents as $document) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();
        }

        $application->delete();

        return redirect()
            ->route('applications.index')
            ->with('success', 'Data lamaran berhasil dihapus.');
    }

    /**
     * Menyimpan dokumen lamaran.
     */
    private function saveDocuments(Request $request, Application $application)
    {
        if (!$request->hasFile('documents')) {
            return;
        }

        foreach ($request->file('documents') as $file) {
            if (!$file->isValid()) {
                continue;
            }

            $path = $file->store('application-documents', 'public');

            $application->documents()->create([
                'document_type' => $request->input(
                    'document_type',
                    'Dokumen Pendukung'
                ),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
            ]);
        }
    }
}