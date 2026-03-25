@if(session('success') || session('error'))
    @php $isSuccess = session('success'); @endphp
    <div x-data="{ show: true, progress: 100 }" x-init="
            let interval = setInterval(() => {
                progress -= 2;
                if (progress <= 0) {
                    show = false;
                    clearInterval(interval);
                }
            }, 100)
        " x-show="show" x-transition:enter="transition ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-500"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed bottom-6 right-6 z-50 w-80 overflow-hidden rounded-2xl shadow-2xl border border-white/20"
        style="background: linear-gradient(135deg, #1d4ed8, #1e3a5f, #0f172a);">
        {{-- Radial glow overlay --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none"
            style="background: radial-gradient(circle at top left, rgba(255,255,255,0.4), transparent 60%);">
        </div>

        {{-- Main Content --}}
        <div class="relative flex items-start gap-3 px-4 pt-4 pb-3">

            {{-- Icon --}}
            <div class="shrink-0 mt-0.5">
                @if($isSuccess)
                    <div class="relative h-8 w-8">
                        <div class="absolute inset-0 rounded-full bg-green-400/30 animate-ping"></div>
                        <div
                            class="relative h-8 w-8 rounded-full bg-green-400/20 border border-green-300/40 flex items-center justify-center">
                            <svg class="h-4 w-4 text-green-300" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                            </svg>
                        </div>
                    </div>
                @else
                    <div class="relative h-8 w-8">
                        <div class="absolute inset-0 rounded-full bg-red-400/30 animate-ping"></div>
                        <div
                            class="relative h-8 w-8 rounded-full bg-red-400/20 border border-red-300/40 flex items-center justify-center">
                            <svg class="h-4 w-4 text-red-300" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" />
                            </svg>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Text --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold {{ $isSuccess ? 'text-green-300' : 'text-red-300' }}">
                    {{ $isSuccess ? 'Action Successful' : 'Something went wrong' }}
                </p>
                <p class="text-sm text-blue-100 mt-0.5 leading-snug">
                    {{ $isSuccess ? session('success') : session('error') }}
                </p>
            </div>

            {{-- Close --}}
            <button @click="show = false" class="shrink-0 text-white/40 hover:text-white/80 transition mt-0.5">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>

        {{-- Progress Bar --}}
        <div class="relative h-0.5 bg-white/10 mx-4 mb-3 rounded-full overflow-hidden">
            <div x-bind:style="`width: ${progress}%`" class="h-full rounded-full transition-all duration-100
                    {{ $isSuccess ? 'bg-green-400' : 'bg-red-400' }}">
            </div>
        </div>
    </div>
@endif