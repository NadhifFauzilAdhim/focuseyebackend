<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Manage Students</h1>
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-2 text-slate-500 hover:text-primary transition-colors font-medium text-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Dashboard
        </a>
    </div>

    {{-- Add Student Form --}}
    <div class="glass-panel p-6 rounded-3xl shadow-soft mb-8">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Add Student</h2>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="username" class="sr-only">Student Name, Username or Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <span class="material-symbols-outlined">person_search</span>
                    </span>
                    <input wire:model="username" type="text" id="username"
                        placeholder="Search by name, username or email..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 focus:border-primary focus:ring-primary/20 transition-all font-medium text-slate-700 dark:text-slate-200"
                        wire:keydown.enter="addStudent">
                </div>
                @error('username')
                    <span class="text-red-500 text-xs mt-1 block pl-2">{{ $message }}</span>
                @enderror
            </div>
            <button wire:click="addStudent"
                class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">person_add</span>
                Add Student
            </button>
        </div>

        @if ($errorMessage)
            <div
                class="mt-4 p-3 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-300 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                {{ $errorMessage }}
            </div>
        @endif

        @if ($successMessage)
            <div
                class="mt-4 p-3 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-300 rounded-xl text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ $successMessage }}
            </div>
        @endif
    </div>

    {{-- User's Student List --}}
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white px-2">Your Students ({{ $students->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($students as $student)
                <div
                    class="glass-panel p-4 rounded-2xl flex items-center gap-4 group hover:border-primary/30 transition-colors">
                    <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                        alt="{{ $student->name }}"
                        class="w-12 h-12 rounded-full object-cover ring-2 ring-white dark:ring-slate-800 shadow-sm">

                    <div class="flex-1 min-w-0">
                        <h3 class="text-slate-800 dark:text-white font-bold truncate">{{ $student->name }}</h3>
                        <p class="text-slate-500 text-xs truncate">{{ $student->username }}</p>
                    </div>

                    <button wire:click="removeStudent({{ $student->id }})"
                        wire:confirm="Are you sure you want to remove {{ $student->name }}?"
                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                        title="Remove Student">
                        <span class="material-symbols-outlined">person_remove</span>
                    </button>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400">
                    <span class="material-symbols-outlined text-4xl opacity-30 mb-2">groups</span>
                    <p>You haven't added any students yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
