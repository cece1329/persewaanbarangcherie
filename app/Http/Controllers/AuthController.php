<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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

    public function verifyInstant(Request $request)
    {
        $user = $request->user();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new \Illuminate\Auth\Events\Verified($user));

            return redirect()->route('dashboard')
                ->with('success', 'Akunmu berhasil diverifikasi langsung secara otomatis! Selamat datang di ChérieRent ✨');
        }

        return redirect()->route('dashboard');
    }

    public function redirectToGoogle(Request $request)
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret) || str_contains($clientId, 'YOUR_')) {
            return redirect()->route('login')->with('error', 'Google Sign-In belum dikonfigurasi. Silakan hubungi administrator.');
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $redirectUri = config('services.google.redirect') ?: url('/auth/google/callback');
        $query = http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid profile email',
            'access_type'   => 'online',
            'state'         => $state,
            'prompt'        => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
    }

    public function handleGoogleCallback(Request $request)
    {
        $state = $request->session()->pull('google_oauth_state');
        if (empty($state) || $state !== $request->input('state')) {
            return redirect()->route('login')->with('error', 'Otentikasi Google gagal atau sesi kedaluwarsa. Silakan coba lagi.');
        }

        $code = $request->input('code');
        if (empty($code)) {
            return redirect()->route('login')->with('error', 'Otorisasi akun Google dibatalkan.');
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect') ?: url('/auth/google/callback');

        try {
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'code' => $code,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
            ]);

            if ($tokenResponse->failed()) {
                Log::error('Google OAuth Token Error: '.$tokenResponse->body());

                return redirect()->route('login')->with('error', 'Gagal menukarkan token Google. Silakan coba lagi.');
            }

            $accessToken = $tokenResponse->json('access_token');
            $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if ($userResponse->failed()) {
                Log::error('Google OAuth UserInfo Error: '.$userResponse->body());

                return redirect()->route('login')->with('error', 'Gagal mengambil data akun Google.');
            }

            $googleData = $userResponse->json();

            return $this->loginOrCreateGoogleUser([
                'email' => $googleData['email'],
                'name' => $googleData['name'] ?? 'Google User',
                'avatar' => $googleData['picture'] ?? null,
                'google_id' => $googleData['sub'] ?? null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Google OAuth Exception: '.$e->getMessage());

            return redirect()->route('login')->with('error', 'Terjadi kendala saat login dengan Google: '.$e->getMessage());
        }
    }

    public function quickGoogleSignIn(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $email = strtolower($validated['email']);
        $name = $validated['name'] ?: explode('@', $email)[0];
        $avatar = 'https://api.dicebear.com/7.x/adventurer/svg?seed='.urlencode($email);

        return $this->loginOrCreateGoogleUser([
            'email' => $email,
            'name' => ucwords(str_replace(['.', '_'], ' ', $name)),
            'avatar' => $avatar,
            'google_id' => 'google_sim_'.md5($email),
        ]);
    }

    private function loginOrCreateGoogleUser(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            // Automatically verify email since it's confirmed via Google!
            if (! $user->email_verified_at) {
                $user->email_verified_at = now();
            }
            if (empty($user->avatar) && ! empty($data['avatar'])) {
                $user->avatar = $data['avatar'];
            }
            if (Schema::hasColumn('users', 'google_id') && ! empty($data['google_id'])) {
                $user->google_id = $data['google_id'];
            }
            $user->save();
        } else {
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => now(), // INSTANTLY VERIFIED - NO SPAM/OTP DELAY!
                'password' => Hash::make(Str::random(32)),
                'role' => 'customer',
                'avatar' => $data['avatar'] ?? 'https://api.dicebear.com/7.x/adventurer/svg?seed='.urlencode($data['email']),
            ];

            if (Schema::hasColumn('users', 'google_id') && ! empty($data['google_id'])) {
                $userData['google_id'] = $data['google_id'];
            }

            $user = User::create($userData);
        }

        Auth::login($user, true);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang, '.$user->name.'! Kamu berhasil masuk dengan akun Google (Email langsung aktif & terverifikasi ✨).');
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
