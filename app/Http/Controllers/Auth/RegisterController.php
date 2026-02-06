<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validatedData['password']),
            'role' => 'teacher',
        ]);

        auth()->login($user);

        return redirect('/')->with('success', 'Registration successful! Welcome to FocusEye.');
    }

    public function emailVerificationRequest(Request $request, $id, $hash)
    {
        $user = User::find($id);
        if (! $user) {
            abort(404, 'User not found');
        }
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/email/verify-success')->with('status', 'Email Anda sudah terverifikasi sebelumnya.');
        }

        $user->markEmailAsVerified();

        return redirect('/email/verify-success')->with('status', 'Email Berhasil Diverifikasi');
    }

    public function emailVerificationSuccess()
    {
        return view('email_verification.verification-success');
    }
}
