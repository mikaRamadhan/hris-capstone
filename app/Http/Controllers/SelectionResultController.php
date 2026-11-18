<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\SelectionResult;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SelectionResultController extends Controller
{
    // Menampilkan seluruh tahapan seleksi suatu lamaran
    public function index(Application $application)
    {
        $results = $application->selectionResults()->get();

        return response()->json([
            'message' => 'Data tahapan seleksi berhasil diambil.',
            'data' => $results,
        ]);
    }

    // Menambahkan tahapan seleksi
    public function store(Request $request, Application $application)
    {
        $validated = $request->validate([
            'stage_name' => ['required', 'string', 'max:100'],
            'stage_order' => ['sometimes', 'required', 'integer', 'min:1'],
            'result' => [
                'sometimes',
                'required',
                Rule::in(['pending', 'passed', 'failed']),
            ],
            'notes' => ['nullable', 'string'],
            'selected_at' => ['nullable', 'date'],
        ]);

        $validated['stage_order'] = $validated['stage_order']
            ?? ((int) $application->selectionResults()->max('stage_order') + 1);

        $validated['result'] = $validated['result'] ?? 'pending';

        $selectionResult = $application->selectionResults()->create(
            $validated
        );

        return response()->json([
            'message' => 'Tahapan seleksi berhasil ditambahkan.',
            'data' => $selectionResult,
        ], 201);
    }

    // Mengubah tahapan seleksi
    public function update(
        Request $request,
        Application $application,
        SelectionResult $selectionResult
    ) {
        $this->ensureBelongsToApplication($application, $selectionResult);

        $validated = $request->validate([
            'stage_name' => ['sometimes', 'required', 'string', 'max:100'],
            'stage_order' => ['sometimes', 'required', 'integer', 'min:1'],
            'result' => [
                'sometimes',
                'required',
                Rule::in(['pending', 'passed', 'failed']),
            ],
            'notes' => ['nullable', 'string'],
            'selected_at' => ['nullable', 'date'],
        ]);

        $selectionResult->update($validated);

        return response()->json([
            'message' => 'Tahapan seleksi berhasil diperbarui.',
            'data' => $selectionResult->fresh(),
        ]);
    }

    // Menghapus tahapan seleksi
    public function destroy(
        Application $application,
        SelectionResult $selectionResult
    ) {
        $this->ensureBelongsToApplication($application, $selectionResult);

        $selectionResult->delete();

        return response()->json([
            'message' => 'Tahapan seleksi berhasil dihapus.',
        ]);
    }

    // Memastikan tahapan benar-benar milik lamaran tersebut
    private function ensureBelongsToApplication(
        Application $application,
        SelectionResult $selectionResult
    ): void {
        abort_unless(
            (int) $selectionResult->application_id === (int) $application->id,
            404,
            'Tahapan seleksi tidak ditemukan pada lamaran ini.'
        );
    }
}
