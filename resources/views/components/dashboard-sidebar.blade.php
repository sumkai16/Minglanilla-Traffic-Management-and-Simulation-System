@props([
    'navItems' => [],
    'roleLabel' => 'Dashboard',
])

@php
    $user = auth()->user();

    $displayName = $user->role === 'user'
        ? 'Citizen Portal'
        : trim($user->first_name . ' ' . $user->last_name);

    $iconPaths = [
        'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.75 5.75h6.5v6.5h-6.5zm8 0h6.5v3.5h-6.5zm0 5h6.5v8.5h-6.5zm-8 8.5h6.5v-3.5h-6.5z" />',
        'reports' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.75h6m-8 4h9m-9 4h9m-9 4h6M6 3.75h8a2.25 2.25 0 012.25 2.25v12A2.25 2.25 0 0114 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75z" />',
        'map' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 18.25l-5-2.5v-10l5 2.5m0 10l4.5-2.5m-4.5 2.5v-10m4.5 7.5l5 2.5v-10l-5-2.5m0 10v-10" />',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 18.25v-1.5a3.75 3.75 0 00-3.75-3.75h-4.5A3.75 3.75 0 003 16.75v1.5m12-9.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-7.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm12 9.75v-1.5a3.75 3.75 0 00-2.438-3.516M16.5 6.9a2.25 2.25 0 010 4.2" />',
        'enforcers' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75a3 3 0 106 0 3 3 0 00-6 0zm-5.25 9.5a4.75 4.75 0 019.5 0m2.25 0a4.75 4.75 0 014.75-4.75m-3.25-4a2.5 2.5 0 110 5" />',
        'announcements' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6.75a3.75 3.75 0 00-3.75 3.75v1.164c0 .49-.122.973-.355 1.404l-.533.988a1.75 1.75 0 001.54 2.589h6.196a1.75 1.75 0 001.54-2.589l-.533-.988a2.97 2.97 0 01-.355-1.404V10.5a3.75 3.75 0 00-3.75-3.75zM9.25 17.75a1.25 1.25 0 102.5 0h-2.5z" />',
        'advisories' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3h.008v.008H12v-.008zm-.437-10.71L4.175 17.25a1.5 1.5 0 001.312 2.25h14.026a1.5 1.5 0 001.312-2.25L13.437 5.04a1.5 1.5 0 00-2.874 0z" />',
        'simulation' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 5.75v12.5l10-6.25-10-6.25z" />',
        'profile' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 7.5a3 3 0 11-6 0 3 3 0 016 0zm-8.25 10a5.25 5.25 0 1110.5 0v.75H6.75v-.75z" />',
        'create' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 5.75v12.5m6.25-6.25H5.75" />',
    ];
@endphp

<style>
    .dashboard-sidebar-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .dashboard-sidebar-scroll::-webkit-scrollbar {
        display: none;
    }
</style>

<aside {{ $attributes->merge(['class' => 'fixed inset-y-0 left-0 z-40 flex w-72 flex-col border-r border-white/10 bg-slate-950 text-slate-100 shadow-2xl shadow-slate-950/40 transition-transform duration-300 ease-out']) }}>
    <div class="border-b border-white/10 px-6 py-6">
        <div class="flex items-center gap-3">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                <img src="{{ asset('images/second_logo-removebg-preview.png') }}" alt="Minglanilla seal"
                    class="h-12 w-12 object-contain">
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                <img src="{{ asset('images/first_logo-removebg-preview.png') }}" alt="Minglanilla traffic command logo"
                    class="h-12 w-12 object-contain">
            </div>
        </div>
        <div class="mt-5">
            <p class="text-[11px] font-semibold uppercase tracking-[0.35em] text-cyan-300/80">Minglanilla Traffic</p>
            <h2 class="mt-2 text-xl font-bold leading-tight text-white">{{ $roleLabel }}</h2>
            <p class="mt-2 text-sm text-slate-400">Formal command center navigation for reports, advisories, and user actions.</p>
        </div>
    </div>

    <div class="dashboard-sidebar-scroll flex-1 overflow-y-auto px-4 py-5">
        <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.35em] text-slate-500">Navigation</p>
        <nav class="mt-3 space-y-1.5">
            @foreach ($navItems as $item)
                @php
                    $icon = $iconPaths[$item['icon'] ?? 'dashboard'] ?? $iconPaths['dashboard'];
                    $active = $item['active'] ?? false;
                @endphp

                <a href="{{ $item['href'] }}"
                    class="{{ $active ? 'bg-blue-600/20 text-white ring-1 ring-inset ring-blue-400/40' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium transition">
                    <span
                        class="{{ $active ? 'bg-blue-500/20 text-blue-200' : 'bg-white/5 text-slate-400' }} flex h-10 w-10 items-center justify-center rounded-xl transition">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            {!! $icon !!}
                        </svg>
                    </span>
                    <span class="flex-1">{{ $item['label'] }}</span>
                    @if (!empty($item['badge']))
                        <span
                            class="rounded-full bg-white/10 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide text-slate-200">
                            {{ $item['badge'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>
    </div>

    <div class="border-t border-white/10 px-4 py-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Logged In</p>
            <p class="mt-2 text-sm font-semibold text-white">{{ $displayName }}</p>
            <p class="mt-1 text-sm text-slate-400">{{ $user->email }}</p>

            <div class="mt-4 grid grid-cols-2 gap-2">
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-white/10 px-3 py-2 text-xs font-semibold text-slate-200 transition hover:bg-white/10">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-950 transition hover:bg-blue-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
