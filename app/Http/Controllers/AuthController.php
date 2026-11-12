<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetCodeMail;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /** Kodyň ýaşaýyş wagty (minut) */
    private const CODE_MINUTES = 15;

    // ───────────────────────── Login ─────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', __('messages.welcome_back', ['name' => auth()->user()->name]));
        }

        return back()
            ->withErrors(['email' => __('messages.login_failed')])
            ->onlyInput('email');
    }

    // ───────────────────────── Register + Gmail kody ─────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'], // User modelindäki hashed cast awtomatiki hash edýär
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Hasap açylansoň göni ulgama girizýäris (Gmail-e diňe paroly unudanda kod barýar)
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', __('messages.account_created'));
    }

    public function showVerifyEmail()
    {
        $email = session('verify_email');

        if (! $email) {
            return redirect()->route('register');
        }

        return view('auth.verify-email', [
            'email' => $email,
            'demoCode' => session('demo_verify_code'),
            'minutes' => self::CODE_MINUTES,
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || $user->isVerified()) {
            return redirect()->route('login');
        }

        $valid = $user->verification_code
            && $user->verification_code_expires_at
            && $user->verification_code_expires_at->isFuture()
            && Hash::check($validated['code'], $user->verification_code);

        if (! $valid) {
            return back()
                ->withErrors(['code' => __('messages.code_invalid')])
                ->withInput($request->only('email'));
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ])->save();

        $request->session()->forget(['verify_email', 'demo_verify_code']);

        // Kod dogry — hasaba girýäris
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', __('messages.email_verified_done'));
    }

    public function resendVerification(Request $request)
    {
        $email = session('verify_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (! $user || $user->isVerified()) {
            return redirect()->route('login');
        }

        $this->sendVerificationCode($user);

        return redirect()->route('email.verify.form')
            ->with('success', __('messages.verify_code_sent', ['email' => $user->email]));
    }

    // ───────────────────────── Logout ─────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', __('messages.logged_out'));
    }

    // ───────────── Paroly unutdym: Gmail-e 6 belgili kod ─────────────

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $validated['email'];
        $user = User::where('email', $email)->first();

        // Ulanyjy ýok bolsa-da şol bir jogap berýäris (e-poçta barlamaga rugsat bermeýäris)
        if ($user) {
            $code = (string) random_int(100000, 999999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                ['token' => Hash::make($code), 'created_at' => now()]
            );

            $this->deliver(
                $email,
                new PasswordResetCodeMail($code, $user->name, self::CODE_MINUTES),
                $code,
                'demo_reset_code'
            );
        }

        session(['reset_email' => $email]);

        return redirect()->route('password.verify.form')
            ->with('success', __('messages.code_sent', ['email' => $email]));
    }

    public function showVerifyCode()
    {
        $email = session('reset_email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-code', [
            'email' => $email,
            'demoCode' => session('demo_reset_code'),
            'minutes' => self::CODE_MINUTES,
        ]);
    }

    public function resetPasswordWithCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $validated['email'])->first();

        $expired = $record && Carbon::parse($record->created_at)->addMinutes(self::CODE_MINUTES)->isPast();

        if (! $record || $expired || ! Hash::check($validated['code'], $record->token)) {
            return back()
                ->withErrors(['code' => __('messages.code_invalid')])
                ->withInput($request->only('email'));
        }

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return redirect()->route('password.request');
        }

        $user->update([
            'password' => $validated['password'],
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);

        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();
        $request->session()->forget(['reset_email', 'demo_reset_code']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', __('messages.password_reset_done'));
    }

    // ───────────── Profil: maglumatlar + paroly üýtgetmek (auth()->user()) ─────────────

    public function showProfile()
    {
        return view('auth.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('profile.show')->with('success', __('messages.profile_updated'));
    }

    public function showChangePassword()
    {
        return redirect()->route('profile.show');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        auth()->user()->update(['password' => $validated['password']]);

        return redirect()->route('profile.show')->with('success', __('messages.password_changed'));
    }

    // ───────────────────────── Kömekçiler ─────────────────────────

    /** Täze 6 belgili tassyklama kody döredip, Gmail-e ugradýar */
    private function sendVerificationCode(User $user): void
    {
        $code = (string) random_int(100000, 999999);

        $user->forceFill([
            'verification_code' => Hash::make($code),
            'verification_code_expires_at' => now()->addMinutes(self::CODE_MINUTES),
        ])->save();

        $this->deliver(
            $user->email,
            new VerificationCodeMail($code, $user->name, self::CODE_MINUTES),
            $code,
            'demo_verify_code'
        );
    }

    /**
     * Hat ugradýar. MAIL_MAILER=log bolsa ýa-da ugradyp bolmasa, APP_DEBUG=true wagtynda
     * kody ekranda hem görkezýäris (synag / sene üçin amatly).
     */
    private function deliver(string $to, $mailable, string $code, string $sessionKey): void
    {
        $showDemo = in_array(config('mail.default'), ['log', 'array'], true);

        try {
            Mail::to($to)->send($mailable);
        } catch (\Throwable $e) {
            Log::warning('E-poçta ugradylmady: '.$e->getMessage());
            $showDemo = true;
        }

        if ($showDemo && config('app.debug')) {
            session([$sessionKey => $code]);
        }
    }
}
