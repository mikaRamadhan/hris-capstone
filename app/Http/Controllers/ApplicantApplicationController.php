<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicantApplicationController extends Controller
{
    public function index()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()
                ->route('applicant.profile.edit')
                ->with('error', 'Lengkapi profil terlebih dahulu.');
        }

        $applications = Application::with([
            'vacancy.departmentUnit',
            'documents'
        ])
            ->where('applicant_id', $applicant->id)
            ->latest('applied_at')
            ->paginate(10);

        return view(
            'applicants.applications.index',
            compact('applications')
        );
    }

    public function create($vacancyId)
    {
        $vacancy = Vacancy::with([
            'departmentUnit',
            'positionUnit'
        ])
            ->where('status', 'open')
            ->findOrFail($vacancyId);

        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()
                ->route('applicant.profile.edit')
                ->with('error', 'Lengkapi profil terlebih dahulu sebelum melamar.');
        }

        $alreadyApplied = Application::where(
            'applicant_id',
            $applicant->id
        )
            ->where('vacancy_id', $vacancy->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()
                ->route('applicant.applications.index')
                ->with('error', 'Kamu sudah melamar lowongan ini.');
        }

        return view(
            'applicants.applications.create',
            compact('vacancy', 'applicant')
        );
    }

    public function store(Request $request, $vacancyId)
    {
        $vacancy = Vacancy::where('status', 'open')
            ->findOrFail($vacancyId);

        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()
                ->route('applicant.profile.edit')
                ->with('error', 'Lengkapi profil terlebih dahulu.');
        }

        $alreadyApplied = Application::where(
            'applicant_id',
            $applicant->id
        )
            ->where('vacancy_id', $vacancy->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()
                ->route('applicant.applications.index')
                ->with('error', 'Kamu sudah melamar lowongan ini.');
        }

        $validated = $request->validate([
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx|max:5120',
        ], [
            'documents.*.file' => 'Dokumen yang diunggah tidak valid.',
            'documents.*.mimes' => 'Dokumen harus berformat PDF, DOC, atau DOCX.',
            'documents.*.max' => 'Ukuran setiap dokumen maksimal 5 MB.',
        ]);

        $storedPaths = [];

        try {
            DB::transaction(function () use (
                $vacancy,
                $applicant,
                $request,
                &$storedPaths
            ) {
                $application = Application::create([
                    'applicant_id' => $applicant->id,
                    'vacancy_id' => $vacancy->id,
                    'status' => 'submitted',
                    'applied_at' => now(),
                ]);

                if ($request->hasFile('documents')) {
                    foreach ($request->file('documents') as $file) {
                        $path = $file->store(
                            'application-documents',
                            'public'
                        );

                        $storedPaths[] = $path;

                        ApplicationDocument::create([
                            'application_id' => $application->id,
                            'document_type' => 'Dokumen Pendukung',
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            foreach ($storedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        return redirect()
            ->route('applicant.applications.index')
            ->with('success', 'Lamaran berhasil dikirim.');
    }

    public function show($id)
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()
                ->route('applicant.profile.edit');
        }

        $application = Application::with([
            'applicant',
            'vacancy.departmentUnit',
            'vacancy.positionUnit',
            'documents'
        ])
            ->where('applicant_id', $applicant->id)
            ->findOrFail($id);

        return view(
            'applicants.applications.show',
            compact('application')
        );
    }
}