<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    /**
     * Handle user registration request.
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|min:3',
                'username' => 'required|string|min:3|max:255|unique:users|regex:/^\S*$/u',
                'email' => 'required|string|email:dns|unique:users|usercheck:block_disposable',
                'password' => 'required|string|min:5|max:255',
                'role' => 'in:user,student,teacher,admin',
                'avatar' => 'nullable|string',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'] ?? 'student',
                'avatar' => $validatedData['avatar'] ?? null,
            ]);

            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'status' => 201,
                'message' => 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi.',
                'user' => $user,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal karena kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password tidak ditemukan.',
                ], 404);
            }
            if (! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password yang Anda masukkan salah.',
                ], 401);
            }
            if (! $user->hasVerifiedEmail()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login gagal. Silakan verifikasi alamat email Anda terlebih dahulu.',
                ], 403);
            }
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                    'role' => $user->role,
                ],
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal karena kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle user logout request.
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
