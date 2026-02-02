@extends('layouts.auth')

@section('title', 'Login - FocusEye')

@section('content')
    <div
        class="glass-panel p-8 rounded-3xl shadow-glass border border-white/40 dark:border-white/10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-indigo-500"></div>

        <div class="mb-8 text-center">
            <div
                class="inline-flex items-center justify-center size-12 rounded-2xl bg-gradient-to-br from-primary via-indigo-500 to-indigo-700 text-white shadow-lg shadow-indigo-500/30 mb-4 ring-1 ring-white/50">
                <svg class="size-6" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 6H42L36 24L42 42H6L12 24L6 6Z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Welcome Back</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">Sign in to continue to FocusEye</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 ml-1">Email
                    Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">mail</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 dark:border-white/10 bg-white/50 dark:bg-black/20 text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-primary/20 focus:bg-white dark:focus:bg-black/40 transition-all text-sm @error('email') border-red-500 @enderror"
                        placeholder="name@example.com">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5 ml-1">
                    <label for="password"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <a href="#"
                        class="text-xs font-medium text-primary hover:text-primary-dark transition-colors">Forgot
                        password?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">lock</span>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 dark:border-white/10 bg-white/50 dark:bg-black/20 text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-primary/20 focus:bg-white dark:focus:bg-black/40 transition-all text-sm @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center ml-1">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-slate-300 text-primary focus:ring-primary/20 bg-transparent">
                <label for="remember_me" class="ml-2 block text-sm text-slate-600 dark:text-slate-400">Remember me</label>
            </div>

            <button type="submit"
                class="w-full py-2.5 px-4 bg-gradient-to-r from-primary to-indigo-600 hover:from-primary-dark hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                <span>Sign In</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-white/10 text-center">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Don't have an account?
                <a href="{{ route('register') }}"
                    class="font-semibold text-primary hover:text-primary-dark transition-colors">Create one</a>
            </p>
        </div>
    </div>
@endsection
