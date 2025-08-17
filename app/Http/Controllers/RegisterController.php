<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
class RegisterController extends Controller
{

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
