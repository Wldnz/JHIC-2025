<?php

namespace App\Http\Controllers\Candidate;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\LoginRequest;
use App\Http\Requests\Candidate\SignupRequest;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    public function signupPage()
    {
        return view('candidate.auth.signup');
    }

    public function signup(SignupRequest $request)
    {
        $validated = $request->validated();
        $newUser = new User();
        $newUser->fullname = $validated['fullname'];
        $newUser->email = $validated['email'];
        $newUser->phone = $validated['phone'] ?? null;
        $newUser->password = Hash::make($validated['password']);
        $newUser->remember_token = Str::random(10);
        $newUser->role = 'candidate';

        $isSaved = $newUser->save();
        if (!$isSaved) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal signup",
                "Gagal signup, akun gagal dibuat",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        Auth::login($newUser, true);
        return redirect()->route('candidate.dashboard');
    }

    public function signupGoogle()
    {
        logger(route('candidate.signup-google-callback'));
        return Socialite::with('google')
            ->redirectUrl(route('candidate.signup-google-callback'))
            ->redirect();
    }

    public function signupGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')
                ->redirectUrl(route('candidate.signup-google-callback'))
                ->stateless()
                ->user();
        } catch (Throwable $th) {
            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal signup",
                "Gagal signup menggunakan akun google",
                $request->session(),
            );
            return redirect()->route('candidate.signup-page');
        }

        $existingUser = User::query()
            ->where('email', '=', $user->getEmail())
            ->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
            return redirect()->route('candidate.dashboard');
        }

        $newUser = new User();
        $newUser->fullname = $user->getName();
        $newUser->email = $user->getEmail();
        $newUser->phone = null;
        $newUser->role = 'candidate';
        $newUser->password = Hash::make(fake()->password(24, 32));
        $newUser->remember_token = Str::random(10);

        $isSaved = $newUser->save();

        if (!$isSaved) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal signup",
                "Gagal signup menggunakan akun google, akun gagal dibuat",
                $request->session(),
            );
            return redirect()->route('candidate.signup-page');
        }

        Auth::login($newUser, true);
        return redirect()->route('candidate.dashboard');
    }

    public function loginPage()
    {
        if (Auth::check()) return redirect()->route('candidate.dashboard');
        return view('candidate.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt($validated, true)) {
            $request->session()->regenerate();
            return redirect()->route('candidate.dashboard');
        }

        AlertDataGenerator::generateAsFlashToSession(
            AlertType::DANGER,
            "Gagal login",
            "Email atau password salah",
            $request->session(),
        );
        return back()->withInput($validated);
    }

    public function loginGoogle(Request $request)
    {
        logger(route('candidate.login-google-callback'));
        return Socialite::with('google')
            ->redirectUrl(route('candidate.login-google-callback'))
            ->redirect();
    }
    public function loginGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')
                ->redirectUrl(route('candidate.login-google-callback'))
                ->stateless()
                ->user();
        } catch (Throwable $th) {
            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal login",
                "Gagal login menggunakan akun google",
                $request->session(),
            );
            return redirect()->route('candidate.login-page');
        }

        $existingUser = User::query()
            ->where('email', '=', $user->getEmail())
            ->first();

        if (!$existingUser) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal login",
                "Gagal login menggunakan akun google, akun tidak ditemukan",
                $request->session(),
            );
            return redirect()->route('candidate.login-page');
        }

        Auth::login($existingUser, true);
        return redirect()->route('candidate.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect()->route('candidate.login-page');
    }
}
