<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" wire:poll.30s>
    @forelse ($students as $student)
        <a href="{{ route('student.detail', $student['slug']) }}"
            class="glass-panel group p-3 rounded-2xl card-hover block relative overflow-hidden">
            <div class="relative w-full aspect-video rounded-xl overflow-hidden mb-3">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                    style='background-image: url("{{ $student['image'] }}");'>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>
                <div
                    class="absolute top-2 right-2 backdrop-blur-md {{ $student['status'] === 'FOCUSED' ? 'bg-white/20 border-white/20' : ($student['status'] === 'DISTRACTED' ? 'bg-red-500/80 border-white/20' : 'bg-orange-500/80 border-white/20') }} border text-white text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                    @if ($student['status'] === 'FOCUSED')
                        <div class="w-1.5 h-1.5 rounded-full bg-green-400 shadow-[0_0_8px_rgba(74,222,128,0.8)]">
                        </div>
                    @elseif($student['status'] === 'DISTRACTED')
                        <span class="material-symbols-outlined text-[12px]">visibility_off</span>
                    @else
                        <span class="material-symbols-outlined text-[12px]">warning</span>
                    @endif
                    {{ $student['status'] }}
                </div>
            </div>
            <div class="px-1">
                <div class="flex justify-between items-start mb-1">
                    <h3
                        class="text-slate-800 dark:text-white text-base font-bold group-hover:text-primary transition-colors">
                        {{ $student['name'] }}</h3>
                    <span
                        class="{{ $student['score'] >= 90 ? 'bg-primary/10 text-primary' : ($student['score'] >= 50 ? 'bg-orange-50 text-orange-600' : 'bg-red-50 text-red-500') }} text-[11px] font-bold px-2 py-0.5 rounded-md">{{ $student['score'] }}%</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <p class="text-slate-500 dark:text-slate-400 text-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">schedule</span> {{ $student['time'] }}
                    </p>
                    <p class="text-slate-500 dark:text-slate-400 text-xs flex items-center gap-1">
                        @if ($student['eye_open'])
                            <span class="material-symbols-outlined text-[14px] text-green-500">visibility</span>
                            Eye Open
                        @else
                            <span
                                class="material-symbols-outlined text-[14px] {{ $student['status'] === 'DISTRACTED' ? 'text-red-500' : 'text-orange-500' }}">visibility_off</span>
                            Eye Closed
                        @endif
                    </p>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full py-12 text-center text-slate-400">
            <span class="material-symbols-outlined text-4xl opacity-30 mb-2">face_retouching_off</span>
            <p>No students to display.</p>
            <a href="{{ route('students.index') }}" class="text-primary hover:underline text-sm mt-2 block">Add students
                to your list</a>
        </div>
    @endforelse
</div>
