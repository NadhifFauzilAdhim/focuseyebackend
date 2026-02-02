@extends('layouts.auth')

@section('title', 'Register - FocusEye')

@section('content')
    <div
        class="glass-panel p-8 rounded-3xl shadow-glass border border-white/40 dark:border-white/10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-indigo-500"></div>

        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Create Account</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">Join FocusEye today</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 ml-1">Full
                    Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">person</span>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 dark:border-white/10 bg-white/50 dark:bg-black/20 text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-primary/20 focus:bg-white dark:focus:bg-black/40 transition-all text-sm @error('name') border-red-500 @enderror"
                        placeholder="John Doe">
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="username"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 ml-1">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">alternate_email</span>
                    </div>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 dark:border-white/10 bg-white/50 dark:bg-black/20 text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-primary/20 focus:bg-white dark:focus:bg-black/40 transition-all text-sm @error('username') border-red-500 @enderror"
                        placeholder="johndoe">
                </div>
                @error('username')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 ml-1">Email
                    Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">mail</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 dark:border-white/10 bg-white/50 dark:bg-black/20 text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-primary/20 focus:bg-white dark:focus:bg-black/40 transition-all text-sm @error('email') border-red-500 @enderror"
                        placeholder="name@example.com">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 ml-1">Password</label>
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

            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 ml-1">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">lock_reset</span>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block w-full pl-10 pr-3 py-2.5 rounded-xl border-slate-200 dark:border-white/10 bg-white/50 dark:bg-black/20 text-slate-900 dark:text-white placeholder-slate-400 focus:border-primary focus:ring-primary/20 focus:bg-white dark:focus:bg-black/40 transition-all text-sm"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit"
                class="w-full py-2.5 px-4 bg-gradient-to-r from-primary to-indigo-600 hover:from-primary-dark hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 mt-2">
                <span>Create Account</span>
                <span class="material-symbols-outlined text-[18px]">person_add</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-white/10 text-center">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}"
                    class="font-semibold text-primary hover:text-primary-dark transition-colors">Sign in</a>
            </p>
        </div>
    </div>
@endsection
