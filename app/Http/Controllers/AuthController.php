<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password yang kamu masukkan salah.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'hrd', 'applicant'], true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Role akun belum terdaftar dalam sistem.',
                ]);
        }

        return $this->redirectByRole($user->role);
    }

    /**
     * Halaman registrasi Applicant.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi Applicant.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'applicant',
            ]);

            Applicant::create([
                'user_id' => $user->id,
                'full_name' => $validated['name'],
            ]);

            return $user;
        });

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('applicant.dashboard')
            ->with('success', 'Registrasi berhasil. Selamat datang di HRIS.');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }

    /**
     * Pengalihan berdasarkan role.
     */
    private function redirectByRole(string $role)
{
    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');

        case 'hrd':
            return redirect()->route('hrd.dashboard');

        case 'applicant':
            return redirect()->route('applicant.dashboard');

        default:
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Role akun tidak dikenali.',
                ]);
    }
}
}