<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicantProfileController extends Controller
{
    /**
     * Menampilkan halaman profil Applicant.
     */
    public function edit()
    {
        $user = Auth::user();

        $applicant = $user->applicant()->firstOrCreate(
            ['user_id' => $user->id],
            ['full_name' => $user->name]
        );

        return view('applicants.profile', compact('user', 'applicant'));
    }

    /**
     * Memperbarui profil Applicant.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:2000',
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'gender' => 'nullable|string|max:20',
            'education' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
            'phone_number.max' => 'Nomor telepon maksimal 20 karakter.',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid.',
            'date_of_birth.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
        ]);

        DB::transaction(function () use ($user, $validated) {

            $applicant = $user->applicant()->firstOrCreate(
                ['user_id' => $user->id],
                ['full_name' => $user->name]
            );

            $applicant->update($validated);

            // Sinkronisasi nama akun dengan nama profil.
            $user->update([
                'name' => $validated['full_name'],
            ]);
        });

        return redirect()
            ->route('applicant.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
