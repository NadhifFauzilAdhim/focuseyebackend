@extends('layouts.app')

@section('title', 'FocusEye Premium Dashboard')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">Dashboard</h1>
            <p class="text-slate-500 dark:text-slate-400">Welcome back, {{ Auth::user()->name }}</p>
        </div>

        <button onclick="Livewire.dispatch('openAddStudentModal')"
            class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
            <span class="material-symbols-outlined">person_add</span>
            Add Student
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div
            class="glass-panel p-5 rounded-2xl shadow-glass flex flex-col justify-between group hover:border-primary/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="p-2.5 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-xl text-primary border border-indigo-100 dark:border-indigo-800">
                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                </div>
                <span
                    class="text-green-500 text-xs font-bold bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">+2.4%</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Avg. Engagement
                </p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $avgEngagement }}%</p>
            </div>
        </div>
        <div
            class="glass-panel p-5 rounded-2xl shadow-glass flex flex-col justify-between group hover:border-primary/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="p-2.5 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl text-emerald-600 border border-emerald-100 dark:border-emerald-800">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                </div>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Active Students
                </p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $activeStudentsCount }}</p>
                    <p class="text-sm text-slate-400 font-medium">/ {{ $totalStudents }} Total</p>
                </div>
            </div>
        </div>
        <div
            class="glass-panel p-5 rounded-2xl shadow-glass flex flex-col justify-between group hover:border-primary/30 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="p-2.5 bg-gradient-to-br from-orange-50 to-amber-50 dark:from-orange-900/30 dark:to-amber-900/30 rounded-xl text-orange-600 border border-orange-100 dark:border-orange-800">
                    <span class="material-symbols-outlined text-[20px]">warning</span>
                </div>
                <span
                    class="text-orange-500 text-xs font-bold bg-orange-50 dark:bg-orange-900/20 px-2 py-1 rounded-full">Action
                    needed</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-1">Alerts Today</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $alertsToday }}</p>
            </div>
        </div>
    </div>
    <div class="glass-panel rounded-2xl p-2 mb-8 flex flex-col md:flex-row items-center justify-between gap-4 shadow-soft">
        <div class="flex gap-2 p-1 w-full md:w-auto overflow-x-auto no-scrollbar">
            <button
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-white/10 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/50 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px] text-primary">calendar_today</span>
                Today
                <span class="material-symbols-outlined text-[16px] opacity-50 ml-1">expand_more</span>
            </button>
            <button
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-transparent hover:bg-white/50 dark:hover:bg-white/5 text-sm font-medium text-slate-600 dark:text-slate-300 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px] opacity-70">school</span>
                Class: 10-A
                <span class="material-symbols-outlined text-[16px] opacity-50 ml-1">expand_more</span>
            </button>
            <button
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-transparent hover:bg-white/50 dark:hover:bg-white/5 text-sm font-medium text-slate-600 dark:text-slate-300 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px] opacity-70">filter_list</span>
                Status: Focused
                <span class="material-symbols-outlined text-[16px] opacity-50 ml-1">expand_more</span>
            </button>
        </div>
        <div
            class="flex items-center gap-3 px-4 w-full md:w-auto justify-end border-l-0 md:border-l border-slate-200 dark:border-slate-700">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Sort</span>
            <select
                class="bg-transparent border-none text-sm font-semibold focus:ring-0 text-slate-700 dark:text-slate-200 cursor-pointer pr-8 py-0">
                <option>Most Recent</option>
                <option>Name A-Z</option>
                <option>Low Engagement</option>
            </select>
        </div>
    </div>
    <div class="flex items-center justify-between px-2 pb-6">
        <h2 class="text-slate-800 dark:text-white text-2xl font-bold tracking-tight">Student Feed</h2>
        <div
            class="flex items-center gap-2 bg-white/80 dark:bg-white/10 px-3 py-1.5 rounded-full border border-primary/20 shadow-glow">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span>
            </span>
            <span class="text-primary dark:text-primary-light text-xs font-bold tracking-wide uppercase">Live
                Updates</span>
        </div>
    </div>

    <livewire:student-feed />

    <div class="fixed bottom-8 right-8 z-50">
        <button
            class="flex items-center justify-center h-14 w-14 rounded-full bg-gradient-to-br from-primary to-primary-dark text-white shadow-lg shadow-primary/40 hover:shadow-primary/60 hover:-translate-y-1 transition-all group overflow-hidden"
            onclick="window.location.reload()">
            <span class="material-symbols-outlined group-hover:rotate-180 transition-transform duration-500">refresh</span>
        </button>
    </div>

    <livewire:add-student-modal />
@endsection
