@props(['pageTitle' => 'Dashboard'])

@php
    $showDashboardLink = !request()->routeIs([
        'admin.dashboard*',
        'user.dashboard*',
        'head-mitcom.dashboard*',
        'enforcer.dashboard*',
    ]);

    $dashboardRoute = match (auth()->user()->role) {
        'admin' => route('admin.dashboard'),
        'head-mitcom' => route('head-mitcom.dashboard'),
        'enforcer' => route('enforcer.dashboard'),
        'user' => route('user.dashboard'),
        default => route('user.dashboard'),
    };

    $showEnforcerProfileLink = auth()->user()->role === 'enforcer';

    $userDisplayName = auth()->user()->role === 'user'
        ? 'Citizen'
        : trim(auth()->user()->first_name . ' ' . auth()->user()->last_name);
@endphp

<div class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-800 via-blue-900 to-slate-950"></div>
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.35),transparent_55%)]"></div>
    <div class="absolute -top-20 -left-20 h-56 w-56 rounded-full bg-blue-500/25 blur-3xl"></div>
    <div class="absolute -bottom-16 -right-16 h-56 w-56 rounded-full bg-cyan-400/20 blur-3xl"></div>

    <!-- Header -->
    <header class="relative">
        <div class="max-w-7xl mx-auto p-5 lg:px-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-17 w-17 rounded-2xl bg-white/10 border border-white/20 shadow-lg flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/second_logo-removebg-preview.png') }}"
                                alt="Minglanilla Official Seal" class="h-20 w-20 object-contain">
                        </div>
                        <div
                            class="h-17 w-17 rounded-2xl bg-white/10 border border-white/20 shadow-lg flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/first_logo-removebg-preview.png') }}"
                                alt="Minglanilla Shield Logo" class="h-20 w-20 object-contain">
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-[0.2em] text-blue-100">LIHOK PADULONG</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-blue-200">Minglanilla Traffic Command</p>
                        <h1 class="text-3xl md:text-4xl font-black text-white">{{ $pageTitle }}</h1>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @if ($showDashboardLink)
                        <a href="{{ $dashboardRoute }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 hover:-translate-y-0.5 transition">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.78 4.22a.75.75 0 010 1.06L7.56 9.5H16a.75.75 0 010 1.5H7.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Back to Dashboard
                        </a>
                    @endif

                    @if($showEnforcerProfileLink)
                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 hover:-translate-y-0.5 transition shadow-sm">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 8a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd"
                                    d="M2 16.5A4.5 4.5 0 016.5 12h7a4.5 4.5 0 014.5 4.5.75.75 0 01-.75.75H2.75A.75.75 0 012 16.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Profile Management
                        </a>
                    @endif

                    {{ $slot }}

                    <div class="flex items-center gap-3 rounded-full bg-white/10 border border-white/20 px-4 py-2 shadow">
                        <span class="text-white text-sm whitespace-nowrap">
                            {{ $userDisplayName }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-white text-blue-900 px-4 py-2 rounded-full text-xs font-semibold hover:bg-blue-50 hover:-translate-y-0.5 transition shadow">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.5 3.25A2.25 2.25 0 005.25 5.5v9A2.25 2.25 0 007.5 16.75h3a.75.75 0 000-1.5h-3a.75.75 0 01-.75-.75v-9a.75.75 0 01.75-.75h3a.75.75 0 000-1.5h-3z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M11.72 6.22a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9.5a.75.75 0 010-1.5h3.94l-1.72-1.72a.75.75 0 010-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
