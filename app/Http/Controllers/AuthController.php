<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->isAdmin()) {
                Log::info('Admin authenticated successfully.', [
                    'user_id' => Auth::id(),
                    'email' => Auth::user()->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                return redirect()->route('admin.dashboard')->with('success', 'Welcome back to the Atelier Dashboard.');
            }

            if (! Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')->with('warning', 'Silakan verifikasi email kamu terlebih dahulu untuk mengaktifkan akun.');
            }

            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back to ChérieRent.');
        }

        $targetUser = User::where('email', $credentials['email'])->first();
        if ($targetUser && $targetUser->isAdmin()) {
            Log::warning('Failed login attempt on admin account.', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'customer',
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed='.urlencode($validated['name']),
        ]);

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email verifikasi ke '.$user->email.': '.$e->getMessage());
        }

        Auth::login($user);

        return redirect()->route('verification.notice')->with('success', 'Akun berhasil dibuat! Silakan cek kotak masuk email kamu untuk mengaktifkannya.');
    }

    public function showVerificationNotice(Request $request)
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Validasi cryptographic signature (mendukung relative signature agar tahan domain proxy/custom domain)
        if (! $request->hasValidSignature() && ! $request->hasValidRelativeSignature()) {
            abort(403, 'Tautan verifikasi sudah kedaluwarsa atau tidak valid.');
        }

        // Validasi hash email
        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403, 'Tautan verifikasi email tidak valid.');
        }

        // Tandai sebagai terverifikasi jika belum
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        // Selalu loginkan browser sebagai user yang akunnya diverifikasi
        Auth::login($user);

        // Tampilkan halaman konfirmasi sukses (mengingatkan user untuk me-refresh web sebelumnya)
        return view('auth.verified-success', [
            'user' => $user,
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Silakan masukkan 6 angka kode verifikasi.',
            'code.size'     => 'Kode verifikasi harus terdiri dari 6 angka.',
        ]);

        $user = $request->user();

        if (! $user->isValidEmailOtp($request->code)) {
            return back()->withErrors([
                'code' => 'Kode verifikasi salah atau sudah kedaluwarsa. Silakan periksa kembali email kamu.',
            ])->onlyInput('code');
        }

        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));

        return redirect()->route('dashboard')->with('success', 'Selamat! Email kamu berhasil diverifikasi. Akunmu sekarang sudah aktif sepenuhnya! ✨');
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        try {
            $request->user()->sendEmailVerificationNotification();
            $status = 'Tautan verifikasi baru telah berhasil dikirimkan ke email kamu. 💌';
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim ulang email verifikasi: '.$e->getMessage());
            $status = 'Gagal mengirim email verifikasi ('.$e->getMessage().'). Cek konfigurasi SMTP.';
        }

        return back()->with('status', $status);
    }

    public function quickDemoLogin($role)
    {
        if (app()->isProduction()) {
            abort(404);
        }

        if ($role === 'admin' && ! app()->environment('testing')) {
            return redirect()->route('login')->with('error', 'Demi keamanan, bypass login admin melalui tombol demo dinonaktifkan. Silakan gunakan form login resmi.');
        }

        $email = match ($role) {
            'admin' => 'rentcherie@gmail.com',
            default => 'user@cherierent.com',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Authenticated as Atelier Administrator.');
            }

            return redirect()->route('dashboard')->with('success', 'Authenticated as Client Demo.');
        }

        return redirect()->route('login')->with('error', 'Demo account not found.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out.');
    }
}
