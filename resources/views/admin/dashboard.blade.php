@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Manage Users',
            'href' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*'),
            'icon' => 'users',
        ],
        [
            'label' => 'Traffic Reports',
            'href' => route('admin.reports.index'),
            'active' => request()->routeIs('admin.reports.*'),
            'icon' => 'reports',
        ],
        [
            'label' => 'Live Traffic Map',
            'href' => route('admin.map'),
            'active' => request()->routeIs('admin.map'),
            'icon' => 'map',
        ],
        [
            'label' => 'Profile',
            'href' => route('profile.edit'),
            'active' => request()->routeIs('profile.*'),
            'icon' => 'profile',
        ],
    ];

    $statCards = [
        ['label' => 'Total Users', 'value' => $totalUsers, 'tone' => 'text-blue-700 bg-blue-50 border-blue-100'],
        ['label' => 'Admins', 'value' => $adminCount, 'tone' => 'text-slate-900 bg-slate-100 border-slate-200'],
        ['label' => 'Head MITCOM', 'value' => $headMitcomCount, 'tone' => 'text-violet-700 bg-violet-50 border-violet-100'],
        ['label' => 'Enforcers', 'value' => $enforcerCount, 'tone' => 'text-emerald-700 bg-emerald-50 border-emerald-100'],
    ];
@endphp

<x-dashboard-shell title="Admin Dashboard" page-title="Admin Dashboard" page-eyebrow="System Administration"
    page-description="Oversee accounts, manage reports, and monitor the command center from one formal control panel."
    :nav-items="$navItems" role-label="Admin Control">
    <x-slot:actions>
        <a href="{{ route('profile.edit') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 8a3 3 0 100-6 3 3 0 000 6z" />
                <path fill-rule="evenodd"
                    d="M2 16.5A4.5 4.5 0 016.5 12h7a4.5 4.5 0 014.5 4.5.75.75 0 01-.75.75H2.75A.75.75 0 012 16.5z"
                    clip-rule="evenodd" />
            </svg>
            Profile
        </a>
        <a href="{{ route('admin.map') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.31-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.352 7.584a13.731 13.731 0 002.274 1.765 11.842 11.842 0 00.757.433l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"
                    clip-rule="evenodd" />
            </svg>
            Open Live Map
        </a>
    </x-slot:actions>

    <div class="mx-auto max-w-7xl space-y-6">
        <section
            class="overflow-hidden rounded-[2rem] border border-blue-100 bg-[linear-gradient(135deg,rgba(30,64,175,0.96),rgba(15,23,42,0.96))] px-6 py-7 text-white shadow-xl shadow-blue-900/10">
            <div class="grid gap-6 lg:grid-cols-[1.3fr_0.9fr] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-blue-200">Formal Operations Overview</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight">Welcome back, {{ auth()->user()->first_name }}.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100/85">
                        This admin workspace centralizes account governance, role assignments, and report monitoring for the Minglanilla Traffic Management and Simulation System.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.28em] text-blue-100/70">Users</p>
                        <p class="mt-3 text-3xl font-bold">{{ $totalUsers }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.28em] text-blue-100/70">Operational Roles</p>
                        <p class="mt-3 text-3xl font-bold">{{ $headMitcomCount + $enforcerCount }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($statCards as $card)
                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">{{ $card['label'] }}</p>
                            <p class="mt-4 text-4xl font-bold text-slate-950">{{ $card['value'] }}</p>
                        </div>
                        <span class="rounded-2xl border px-3 py-2 text-xs font-semibold {{ $card['tone'] }}">
                            Active
                        </span>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Quick Actions</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-950">Administrative tools</h3>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="group rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:border-blue-300 hover:bg-blue-50">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 3a3 3 0 100 6 3 3 0 000-6zM4 15.5A3.5 3.5 0 017.5 12h5A3.5 3.5 0 0116 15.5v.25a.75.75 0 01-.75.75h-10.5a.75.75 0 01-.75-.75v-.25z" />
                            </svg>
                        </div>
                        <h4 class="mt-4 text-lg font-semibold text-slate-900">Manage Users</h4>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Create accounts, update roles, and keep the user base organized.</p>
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                        class="group rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:border-blue-300 hover:bg-blue-50">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M5.75 3.75A1.75 1.75 0 004 5.5v9A1.75 1.75 0 005.75 16.25h8.5A1.75 1.75 0 0016 14.5v-9a1.75 1.75 0 00-1.75-1.75h-8.5zM6.5 7a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h4.25a.75.75 0 010 1.5H6.5z" />
                            </svg>
                        </div>
                        <h4 class="mt-4 text-lg font-semibold text-slate-900">Traffic Reports</h4>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Inspect report activity and keep oversight on incident records.</p>
                    </a>

                    <a href="{{ route('admin.map') }}"
                        class="group rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:border-blue-300 hover:bg-blue-50 sm:col-span-2">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-600 text-white">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.31-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.352 7.584a13.731 13.731 0 002.274 1.765 11.842 11.842 0 00.757.433l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="mt-4 text-lg font-semibold text-slate-900">Live Traffic Map</h4>
                                <p class="mt-2 text-sm leading-6 text-slate-500">Open the interactive map for a visual overview of incidents across Minglanilla.</p>
                            </div>
                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">Interactive</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Admin Notes</p>
                <h3 class="mt-2 text-xl font-bold text-slate-950">Control room priorities</h3>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">User governance</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Review accounts regularly to ensure only the correct personnel have elevated access.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Route visibility</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Use the map to quickly inspect report density before coordinating with MITCOM leadership.</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Dashboard consistency</p>
                        <p class="mt-2 text-sm leading-6 text-slate-500">This admin view now shares the same reusable sidebar system used by the other role dashboards.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Live Monitoring</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Traffic map overview</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Monitor live incident markers and status distribution without leaving the dashboard.</p>
                </div>
                <div class="flex flex-wrap gap-2 text-xs font-semibold text-slate-600">
                    <span class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1">Verified</span>
                    <span class="rounded-full border border-yellow-100 bg-yellow-50 px-3 py-1">Pending</span>
                    <span class="rounded-full border border-green-100 bg-green-50 px-3 py-1">Resolved</span>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
                <div id="admin-map" class="h-[420px] w-full"></div>
            </div>
        </section>
    </div>

    <x-slot:scripts>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (document.getElementById('admin-map')) {
                    initPublicMap('admin-map');
                }
            });
        </script>
    </x-slot:scripts>
</x-dashboard-shell>
