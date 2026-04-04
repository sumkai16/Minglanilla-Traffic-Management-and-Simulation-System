@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'href' => route('head-mitcom.dashboard'),
            'active' => request()->routeIs('head-mitcom.dashboard'),
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Reports',
            'href' => route('head-mitcom.reports.index'),
            'active' => request()->routeIs('head-mitcom.reports.*'),
            'icon' => 'reports',
        ],
        [
            'label' => 'Enforcers',
            'href' => route('head-mitcom.enforcers.index'),
            'active' => request()->routeIs('head-mitcom.enforcers.*'),
            'icon' => 'enforcers',
        ],
        [
            'label' => 'Announcements',
            'href' => route('head-mitcom.announcements.index'),
            'active' => request()->routeIs('head-mitcom.announcements.*'),
            'icon' => 'announcements',
        ],
        [
            'label' => 'Live Map',
            'href' => route('head-mitcom.map'),
            'active' => request()->routeIs('head-mitcom.map'),
            'icon' => 'map',
        ],
        [
            'label' => 'Advisories',
            'href' => route('head-mitcom.advisories.index'),
            'active' => request()->routeIs('head-mitcom.advisories.*'),
            'icon' => 'advisories',
        ],
        [
            'label' => 'Simulation',
            'href' => route('head-mitcom.simulation.index'),
            'active' => request()->routeIs('head-mitcom.simulation.*'),
            'icon' => 'simulation',
        ],
        [
            'label' => 'Profile',
            'href' => route('profile.edit'),
            'active' => request()->routeIs('profile.*'),
            'icon' => 'profile',
        ],
    ];

    $stats = [
        ['label' => 'Total Reports', 'value' => $totalReports, 'tone' => 'bg-slate-100 text-slate-900 border-slate-200'],
        ['label' => 'Verified', 'value' => $verifiedReports, 'tone' => 'bg-blue-50 text-blue-700 border-blue-100'],
        ['label' => 'Assigned', 'value' => $assignedReports, 'tone' => 'bg-violet-50 text-violet-700 border-violet-100'],
        ['label' => 'Resolved', 'value' => $resolvedReports, 'tone' => 'bg-emerald-50 text-emerald-700 border-emerald-100'],
        ['label' => 'Enforcers', 'value' => $activeEnforcers, 'tone' => 'bg-cyan-50 text-cyan-700 border-cyan-100'],
        ['label' => 'Announcements', 'value' => $publishedAnnouncements, 'tone' => 'bg-indigo-50 text-indigo-700 border-indigo-100'],
    ];
@endphp

<x-dashboard-shell title="MITCOM Head Dashboard" page-title="MITCOM Head Dashboard"
    page-eyebrow="Command Center"
    page-description="Coordinate incidents, direct enforcers, publish public information, and monitor live traffic operations from one formal leadership dashboard."
    :nav-items="$navItems" role-label="Head MITCOM">
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
        <a href="{{ route('head-mitcom.announcements.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 2.75a3.75 3.75 0 00-3.75 3.75v1.046c0 .535-.133 1.062-.387 1.532l-.581 1.076A1.75 1.75 0 006.822 13h6.356a1.75 1.75 0 001.54-2.841l-.581-1.076a3.234 3.234 0 01-.387-1.532V6.5A3.75 3.75 0 0010 2.75zM8.25 14.5a1.75 1.75 0 103.5 0h-3.5z"
                    clip-rule="evenodd" />
            </svg>
            Announcement Center
        </a>
    </x-slot:actions>

    <div class="mx-auto max-w-7xl space-y-6">
        <section
            class="overflow-hidden rounded-[2rem] border border-blue-100 bg-[linear-gradient(135deg,rgba(30,64,175,0.98),rgba(15,23,42,0.96))] px-6 py-7 text-white shadow-xl shadow-blue-900/10">
            <div class="grid gap-6 lg:grid-cols-[1.25fr_0.85fr] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-blue-200">Leadership Overview</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight">Operational command at a glance.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100/85">
                        Use this dashboard to oversee verification, assignments, public communication, advisory publishing, and the overall pace of traffic response work.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.28em] text-blue-100/70">Waiting For Assignment</p>
                        <p class="mt-3 text-3xl font-bold">{{ $verifiedReports }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.28em] text-blue-100/70">Published Notices</p>
                        <p class="mt-3 text-3xl font-bold">{{ $publishedAnnouncements }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
            @foreach ($stats as $stat)
                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $stat['label'] }}</p>
                            <p class="mt-4 text-4xl font-bold text-slate-950">{{ $stat['value'] }}</p>
                        </div>
                        <span class="rounded-2xl border px-3 py-2 text-xs font-semibold {{ $stat['tone'] }}">
                            Live
                        </span>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <a href="{{ route('head-mitcom.reports.index') }}"
                class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:bg-blue-50">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M5.75 3.75A1.75 1.75 0 004 5.5v9A1.75 1.75 0 005.75 16.25h8.5A1.75 1.75 0 0016 14.5v-9a1.75 1.75 0 00-1.75-1.75h-8.5zM6.5 7a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h4.25a.75.75 0 010 1.5H6.5z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-950">View All Reports</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">Manage verification, assignments, and escalation decisions from the reports center.</p>
            </a>

            <a href="{{ route('head-mitcom.enforcers.index') }}"
                class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:bg-blue-50">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10 3a3 3 0 100 6 3 3 0 000-6zM4 15.5A3.5 3.5 0 017.5 12h5A3.5 3.5 0 0116 15.5v.25a.75.75 0 01-.75.75h-10.5a.75.75 0 01-.75-.75v-.25z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-950">Manage Enforcers</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">Review workloads, assignments, and team readiness for field response.</p>
            </a>

            <a href="{{ route('head-mitcom.simulation.index') }}"
                class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-300 hover:bg-blue-50">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-600 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-950">Traffic Simulation</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">Replay incidents and review how road activity evolves over time.</p>
            </a>
        </section>

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-indigo-50 px-6 py-5">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Citizen Announcement Board</h2>
                        <p class="mt-1 text-sm text-slate-500">Your latest published and draft updates for the public dashboard</p>
                    </div>
                    <a href="{{ route('head-mitcom.announcements.index') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-indigo-200 bg-white px-4 py-2 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50">
                        Open announcement center
                    </a>
                </div>
            </div>

            @if($recentAnnouncements->count())
                <div class="grid gap-4 px-6 py-6 md:grid-cols-3">
                    @foreach($recentAnnouncements as $announcement)
                        <article class="rounded-3xl border border-slate-200 bg-slate-50/80 p-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->is_published ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                    {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                </span>
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->priority === 'urgent' ? 'bg-rose-50 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-50 text-amber-700 ring-amber-200' : 'bg-blue-50 text-blue-700 ring-blue-200') }}">
                                    {{ ucfirst($announcement->priority) }}
                                </span>
                            </div>
                            <h3 class="mt-3 text-base font-bold text-slate-900">{{ $announcement->title }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                {{ \Illuminate\Support\Str::limit($announcement->content, 120) }}
                            </p>
                            <p class="mt-3 text-xs text-slate-400">
                                {{ $announcement->published_at ? 'Published ' . $announcement->published_at->diffForHumans() : 'Saved as draft' }}
                            </p>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <p class="text-slate-500">No announcements yet. Publish the first citizen update from the announcement center.</p>
                </div>
            @endif
        </section>

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-blue-50 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">Verified Reports - Ready for Assignment</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $verifiedReports }} reports waiting to be assigned</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Issue Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Reporter</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($recentVerified as $report)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-500">#{{ $report->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                    {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ Str::limit($report->location, 30) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @if($report->user)
                                        {{ $report->user->first_name }} {{ $report->user->last_name }}
                                    @else
                                        {{ $report->reporter_name ?? 'Guest' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $report->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('head-mitcom.reports.show', $report->id) }}"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                        Assign report
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    No verified reports waiting for assignment
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-violet-50 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">Recently Assigned Reports</h2>
                <p class="mt-1 text-sm text-slate-500">Track enforcer assignments</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Issue Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Assigned</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($recentAssigned as $report)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-slate-500">#{{ $report->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                    {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">{{ Str::limit($report->location, 30) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @if($report->assignedEnforcer)
                                        {{ $report->assignedEnforcer->first_name }} {{ $report->assignedEnforcer->last_name }}
                                    @else
                                        <span class="text-slate-400">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('head-mitcom.reports.show', $report->id) }}"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                        View report
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    No assigned reports yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-dashboard-shell>
