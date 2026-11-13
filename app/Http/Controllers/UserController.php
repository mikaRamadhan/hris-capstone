<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private array $roles = ['admin', 'hrd', 'applicant'];

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roles;

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in($this->roles)],
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $user = User::with(['applicant', 'employee'])->findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = $this->roles;

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in($this->roles)],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Jangan menghapus akun yang masih terhubung dengan data lain.
        if ($user->applicant()->exists()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Akun tidak dapat dihapus karena masih terhubung dengan data pelamar.');
        }

        if ($user->employee()->exists()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Akun tidak dapat dihapus karena masih terhubung dengan data karyawan.');
        }

        if ($user->createdVacancies()->exists()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Akun tidak dapat dihapus karena pernah membuat data lowongan.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Admin terakhir tidak boleh dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}