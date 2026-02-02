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
    </style>
</head>

<body class="min-h-screen text-slate-800 dark:text-[#faf8fc] selection:bg-primary/20 flex items-center justify-center">
    <div
        class="fixed top-[-20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-purple-200/40 mix-blend-multiply filter blur-3xl opacity-70 pointer-events-none animate-blob">
    </div>
    <div
        class="fixed bottom-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-200/40 mix-blend-multiply filter blur-3xl opacity-70 pointer-events-none animate-blob animation-delay-2000">
    </div>

    <div class="w-full max-w-md p-6 relative z-10">
        @yield('content')
    </div>
</body>

</html>
