<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|min:3',
            'username' => 'required|min:3|max:255|unique:users|regex:/^\S*$/u',
            'email' => 'required|email:dns|unique:users|usercheck:block_disposable',
            'password' => 'required|min:5|max:255',
            'role' => 'in:user,student,teacher,admin', // optional
            'avatar' => 'nullable|string',
            'cf-turnstile-response' => ['required', Rule::turnstile()]
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user',
                'avatar' => $request->avatar ?? null
            ]);

            // Trigger event untuk email verification
            event(new Registered($user));

            Auth::login($user);

            return redirect('/email/verify')->with('success', 'Verify your email first.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification email. SERVER ERROR: ' . $e->getMessage());
        }
    }

    public function verifyemail()
    {
        if (Auth::check() && Auth::user()->email_verified_at !== null) {
            return redirect('/email/verify-success');
        }
        return view('auth.verify-email', [
            'title' => 'Verify Email'
        ]);
    }

    public function emailVerificationRequest(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/email/verify-success');
    }

    public function verificationResend(Request $request)
    {
        if (Auth::user()->email_verified_at !== null) {
            return redirect('/');
        }

        try {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('resendsuccess', 'Email verifikasi telah dikirim ulang. Silakan cek email Anda.');
        } catch (\Exception $e) {
            return back()->with('resenderror', 'Gagal mengirim ulang email verifikasi. Silakan coba lagi nanti. SERVER ERROR');
        }
    }

    public function verificationSuccess()
    {
        return view('auth.verify-success', [
            'title' => 'Email Verification Success'
        ]);
    }
}
