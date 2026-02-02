@extends('layouts.app')

@section('title', 'Student Detail - ' . $student->name)

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-2 text-slate-500 hover:text-primary transition-colors font-medium">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Dashboard
        </a>
        <div class="flex items-center gap-2">
            <span
                class="px-3 py-1 bg-white dark:bg-slate-800 rounded-full text-xs font-semibold text-slate-500 border border-slate-200 dark:border-slate-700">Student
                ID: {{ $student->username }}</span>
        </div>
    </div>

    {{-- Profile & Stats Header --}}
    <div class="glass-panel p-6 rounded-3xl shadow-soft mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-10">
            <div class="relative">
                <div class="w-24 h-24 rounded-full p-1 bg-white dark:bg-slate-800 shadow-lg ring-2 ring-primary/20">
                    <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                        alt="{{ $student->name }}" class="w-full h-full rounded-full object-cover">
                </div>
                <div
                    class="absolute bottom-1 right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-900 bg-green-500">
                </div>
            </div>

            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $student->name }}</h1>
                <p class="text-slate-500 font-medium">{{ $student->email }}</p>

                <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 text-sm font-medium">
                        <span class="material-symbols-outlined text-[16px]">school</span>
                        Class 10-A
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 text-sm font-medium">
                        <span class="material-symbols-outlined text-[16px]">history</span>
                        Joined {{ $student->created_at->format('M Y') }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full md:w-auto">
                <div class="bg-white/50 dark:bg-slate-800/50 p-4 rounded-2xl border border-white/20 shadow-sm text-center">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Avg Score</p>
                    <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $avgFocusScore }}%</p>
                </div>
                <div class="bg-white/50 dark:bg-slate-800/50 p-4 rounded-2xl border border-white/20 shadow-sm text-center">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Sessions</p>
                    <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalSessions }}</p>
                </div>
                <div
                    class="bg-white/50 dark:bg-slate-800/50 p-4 rounded-2xl border border-white/20 shadow-sm text-center col-span-2 md:col-span-1">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Status</p>
                    <p class="text-sm font-bold text-slate-800 dark:text-white mt-1">{{ $status }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Session History --}}
    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">history_edu</span>
        Session History
    </h2>

    <div class="space-y-4">
        @forelse($analytics as $session)
            <div
                class="glass-panel p-5 rounded-2xl shadow-sm hover:shadow-md transition-all border border-transparent hover:border-primary/20">
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Session Info --}}
                    <div class="flex-none md:w-64">
                        <div class="flex items-center gap-2 mb-2">
                            <span
                                class="px-2.5 py-0.5 rounded-md text-xs font-bold {{ ($session->focus_duration / $session->duration) * 100 >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ round(($session->focus_duration / $session->duration) * 100) }}% Focused
                            </span>
                            <span class="text-xs text-slate-400">{{ $session->created_at->format('d M, H:i') }}</span>
                        </div>
                        <div class="space-y-1 text-sm text-slate-600 dark:text-slate-300">
                            <div class="flex justify-between">
                                <span>Total Duration:</span>
                                <span class="font-semibold">{{ gmdate('H:i:s', $session->duration) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-600">Focused:</span>
                                <span class="font-semibold">{{ gmdate('H:i:s', $session->focus_duration) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-red-500">Distracted:</span>
                                <span class="font-semibold">{{ gmdate('H:i:s', $session->unfocus_duration) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Capture Thumbnails --}}
                    <div class="flex-1 overflow-x-auto pb-2">
                        <p class="text-xs font-semibold text-slate-400 mb-2 uppercase">Captures</p>
                        <div class="flex gap-3">
                            @forelse($session->captureHistory as $capture)
                                @if ($capture->image_path)
                                    <div
                                        class="relative group flex-none w-32 aspect-video rounded-lg overflow-hidden cursor-pointer">
                                        <img src="{{ asset('storage/' . $capture->image_path) }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                        <div
                                            class="absolute bottom-0 inset-x-0 bg-black/60 p-1 text-[10px] text-white text-center">
                                            {{ $capture->capture_time }}
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div
                                    class="flex items-center justify-center w-full h-20 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-dashed border-slate-300 text-slate-400 text-xs">
                                    No captures recorded
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-slate-500">
                <span class="material-symbols-outlined text-4xl opacity-50 mb-2">event_busy</span>
                <p>No study sessions recorded yet.</p>
            </div>
        @endforelse
    </div>
@endsection
