<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicantController extends Controller
{
    /**
     * Menampilkan daftar pelamar.
     */
    public function index(Request $request)
    {
        $query = Applicant::with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('university', 'like', "%{$search}%");
            });
        }

        $applicants = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('applicants.index', compact('applicants'));
    }

    /**
     * Menampilkan form tambah pelamar.
     */
    public function create()
    {
        $users = User::where('role', 'applicant')
            ->whereDoesntHave('applicant')
            ->orderBy('name')
            ->get();

        return view('applicants.create', compact('users'));
    }

    /**
     * Menyimpan data pelamar.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'applicant'),
                'unique:applicants,user_id',
            ],
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'education' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
        ], [
            'user_id.required' => 'Akun pengguna wajib dipilih.',
            'user_id.exists' => 'Akun yang dipilih harus memiliki role Applicant.',
            'user_id.unique' => 'Akun tersebut sudah terhubung dengan profil pelamar lain.',
            'full_name.required' => 'Nama lengkap pelamar wajib diisi.',
        ]);

        Applicant::create($validated);

        return redirect()
            ->route('applicants.index')
            ->with('success', 'Data pelamar berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pelamar.
     */
    public function show(string $id)
    {
        $applicant = Applicant::with([
            'user',
            'applications.vacancy',
        ])->findOrFail($id);

        return view('applicants.show', compact('applicant'));
    }

    /**
     * Menampilkan form edit pelamar.
     */
    public function edit(string $id)
    {
        $applicant = Applicant::findOrFail($id);

        $users = User::where('role', 'applicant')
            ->where(function ($query) use ($applicant) {
                $query->whereDoesntHave('applicant')
                    ->orWhere('id', $applicant->user_id);
            })
            ->orderBy('name')
            ->get();

        return view('applicants.edit', compact('applicant', 'users'));
    }

    /**
     * Memperbarui data pelamar.
     */
    public function update(Request $request, string $id)
    {
        $applicant = Applicant::findOrFail($id);

        $validated = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'applicant'),
                Rule::unique('applicants', 'user_id')->ignore($applicant->id),
            ],
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'education' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
        ], [
            'user_id.required' => 'Akun pengguna wajib dipilih.',
            'user_id.exists' => 'Akun yang dipilih harus memiliki role Applicant.',
            'user_id.unique' => 'Akun tersebut sudah terhubung dengan profil pelamar lain.',
            'full_name.required' => 'Nama lengkap pelamar wajib diisi.',
        ]);

        $applicant->update($validated);

        return redirect()
            ->route('applicants.index')
            ->with('success', 'Data pelamar berhasil diperbarui.');
    }

    /**
     * Menghapus data pelamar.
     */
    public function destroy(string $id)
    {
        $applicant = Applicant::findOrFail($id);

        if ($applicant->applications()->exists()) {
            return redirect()
                ->route('applicants.index')
                ->with(
                    'error',
                    'Data pelamar tidak dapat dihapus karena sudah memiliki riwayat lamaran.'
                );
        }

        $applicant->delete();

        return redirect()
            ->route('applicants.index')
            ->with('success', 'Data pelamar berhasil dihapus.');
    }
}