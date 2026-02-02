<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'FocusEye Premium Dashboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#8b5cf6",
                        "primary-dark": "#7c3aed",
                        "accent": "#f3e8ff",
                        "glass-border": "rgba(255, 255, 255, 0.4)",
                        "glass-bg": "rgba(255, 255, 255, 0.65)",
                        "glass-bg-dark": "rgba(30, 20, 40, 0.6)",
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"],
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "3xl": "2rem",
                    },
                    boxShadow: {
                        "glass": "0 4px 30px rgba(0, 0, 0, 0.05)",
                        "soft": "0 10px 40px -10px rgba(0,0,0,0.05)",
                        "glow": "0 0 15px rgba(139, 92, 246, 0.3)"
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfd 0%, #f5f0fa 50%, #efeaff 100%);
            background-attachment: fixed;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
        }

        .dark .glass-panel {
            background: var(--glass-bg-dark);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.3);
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #8b5cf6;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 99px;
        }

        .nav-link.active::after,
        .nav-link:hover::after {
            width: 80%;
            box-shadow: 0 0 8px rgba(139, 92, 246, 0.6);
        }
    </style>
    @livewireStyles
</head>

<body class="min-h-screen text-slate-800 dark:text-[#faf8fc] selection:bg-primary/20">
    <div class="layout-container flex h-full grow flex-col relative overflow-hidden">
        <div
            class="fixed top-[-20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-purple-200/40 mix-blend-multiply filter blur-3xl opacity-70 pointer-events-none animate-blob">
        </div>
        <div
            class="fixed bottom-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-200/40 mix-blend-multiply filter blur-3xl opacity-70 pointer-events-none animate-blob animation-delay-2000">
        </div>
        <header
            class="sticky top-0 z-50 w-full backdrop-blur-md bg-white/70 dark:bg-slate-900/70 border-b border-white/20 shadow-sm transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 md:px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div
                        class="flex items-center justify-center size-11 rounded-2xl bg-gradient-to-br from-primary via-indigo-500 to-indigo-700 text-white shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/30 transition-all duration-300 ring-1 ring-white/50">
                        <svg class="size-6" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 6H42L36 24L42 42H6L12 24L6 6Z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <h1
                            class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight leading-none group-hover:text-primary transition-colors">
                            FocusEye</h1>
                        <span class="text-[10px] font-semibold tracking-widest text-slate-500 uppercase mt-0.5">Premium
                            Dashboard</span>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="nav-link active text-slate-800 dark:text-white font-semibold text-sm px-1 py-2"
                        href="/">Home</a>
                    <a class="nav-link text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium text-sm px-1 py-2 transition-colors"
                        href="{{ route('students.index') }}">Students</a>
                </nav>
                <div class="flex items-center gap-5">
                    <div class="flex items-center gap-2">
                        <button
                            class="flex items-center justify-center size-9 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-full transition-all relative">
                            <span class="material-symbols-outlined text-[22px]">notifications</span>
                            <span
                                class="absolute top-2 right-2 size-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
                        </button>
                        <button
                            class="flex items-center justify-center size-9 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-full transition-all">
                            <span class="material-symbols-outlined text-[22px]">settings</span>
                        </button>
                    </div>
                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-700 mx-1"></div>
                    <div class="flex items-center gap-3 pl-1 cursor-pointer group">
                        <div class="text-right hidden lg:block">
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200 leading-tight">
                                {{ Auth::user()->name ?? 'Guest' }}
                            </p>
                            <p class="text-[11px] text-slate-400 font-medium">{{ Auth::user()->role ?? 'Visitor' }}</p>
                        </div>
                        <div class="relative">
                            <div
                                class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-11 ring-2 ring-white dark:ring-slate-800 shadow-md group-hover:ring-primary/50 transition-all flex items-center justify-center bg-slate-200">
                                @if (Auth::check() && Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="User Avatar"
                                        class="rounded-full w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-gray-500">person</span>
                                @endif
                            </div>
                            <div
                                class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white dark:border-slate-900 rounded-full">
                            </div>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                                @csrf
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined">logout</span>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 max-w-7xl mx-auto w-full px-4 md:px-6 py-8 relative z-10">
            @yield('content')
        </main>

        <footer
            class="mt-auto border-t border-slate-200/60 dark:border-white/5 py-8 text-center bg-white/40 dark:bg-black/20 backdrop-blur-sm">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">© 2026 FocusEye AI. Designed for
                Excellence.</p>
        </footer>
    </div>
    @livewireScripts
</body>

</html>
