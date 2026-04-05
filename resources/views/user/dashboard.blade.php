@php
    $stats = [
        [
            'label' => 'Pending',
            'value' => $pendingCount,
            'description' => 'Awaiting validation by the operations team.',
            'accent' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
        ],
        [
            'label' => 'Verified',
            'value' => $verifiedCount,
            'description' => 'Confirmed and accepted into the workflow.',
            'accent' => 'bg-blue-50 text-blue-700 border-blue-100',
        ],
        [
            'label' => 'Resolved',
            'value' => $resolvedCount,
            'description' => 'Successfully closed reports.',
            'accent' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        ],
    ];
@endphp

<x-dashboard-shell title="My Dashboard" page-title="Citizen Dashboard" page-eyebrow="Public Reporting"
    page-description="Track your incident submissions, review public announcements, and monitor live traffic activity from one organized citizen dashboard.">
    <x-slot:actions>
        <a href="{{ route('user.announcements.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 2.75a3.75 3.75 0 00-3.75 3.75v1.046c0 .535-.133 1.062-.387 1.532l-.581 1.076A1.75 1.75 0 006.822 13h6.356a1.75 1.75 0 001.54-2.841l-.581-1.076a3.234 3.234 0 01-.387-1.532V6.5A3.75 3.75 0 0010 2.75zM8.25 14.5a1.75 1.75 0 103.5 0h-3.5z"
                    clip-rule="evenodd" />
            </svg>
            Announcements
        </a>
        <a href="{{ route('user.reports.create') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10 5.75a.75.75 0 01.75.75v2.75h2.75a.75.75 0 010 1.5h-2.75v2.75a.75.75 0 01-1.5 0v-2.75H6.5a.75.75 0 010-1.5h2.75V6.5A.75.75 0 0110 5.75z" />
            </svg>
            Report Incident
        </a>
    </x-slot:actions>

    <div class="mx-auto max-w-7xl space-y-6">
        <section
            class="overflow-hidden rounded-[2rem] border border-blue-100 bg-[linear-gradient(135deg,rgba(30,64,175,0.96),rgba(14,116,144,0.92))] px-6 py-7 text-white shadow-xl shadow-blue-900/10">
            <div class="grid gap-6 lg:grid-cols-[1.25fr_0.85fr] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-blue-100/80">Citizen Services</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight">Welcome, {{ auth()->user()->first_name }}.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100/85">
                        Submit incident reports, follow their status, and stay aware of the latest traffic-related advisories from the municipal traffic command.
                    </p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.3em] text-blue-100/70">Total Reports Filed</p>
                    <p class="mt-3 text-4xl font-bold">{{ $reports->total() }}</p>
                    <p class="mt-2 text-sm text-blue-100/80">All records visible in your current dashboard filter.</p>
                </div>
            </div>
        </section>

        @if($urgentAnnouncement)
            <section
                class="relative overflow-hidden rounded-[2rem] border border-rose-200 bg-gradient-to-r from-rose-50 via-white to-amber-50 p-6 shadow-sm">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-rose-200/60 blur-3xl"></div>
                <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-rose-700">
                            Urgent Announcement
                        </span>
                        <h3 class="mt-4 text-2xl font-bold text-slate-950">{{ $urgentAnnouncement->title }}</h3>
                        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $urgentAnnouncement->content }}</p>
                    </div>
                    <div class="rounded-3xl border border-rose-200 bg-white/90 px-5 py-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-rose-600">Published</p>
                        <p class="mt-3 text-sm font-semibold text-slate-900">{{ $urgentAnnouncement->published_at?->format('M d, Y h:i A') }}</p>
                        <a href="{{ route('user.announcements.index') }}"
                            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                            Review all announcements
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Announcement Center</p>
                    <h3 class="mt-2 text-2xl font-bold text-slate-950">Latest community updates</h3>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Stay informed about advisories, emergencies, and route updates published by Head MITCOM.
                    </p>
                </div>
                <a href="{{ route('user.announcements.index') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                    View all announcements
                </a>
            </div>

            @if($latestAnnouncements->count())
                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach($latestAnnouncements as $announcement)
                        <article
                            class="rounded-[1.5rem] border p-5 shadow-sm {{ $announcement->priority === 'urgent' ? 'border-rose-200 bg-rose-50/60' : 'border-slate-200 bg-slate-50/60' }}">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->priority === 'urgent' ? 'bg-rose-100 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-100 text-amber-700 ring-amber-200' : 'bg-blue-50 text-blue-700 ring-blue-200') }}">
                                    {{ ucfirst($announcement->priority) }}
                                </span>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">
                                    {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $announcement->type)) }}
                                </span>
                            </div>
                            <h4 class="mt-4 text-lg font-bold text-slate-900">{{ $announcement->title }}</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                {{ \Illuminate\Support\Str::limit($announcement->content, 140) }}
                            </p>
                            <p class="mt-4 text-xs text-slate-400">
                                Published {{ $announcement->published_at?->diffForHumans() }}
                            </p>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-6 rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                    <p class="font-semibold text-slate-700">No announcements published yet</p>
                    <p class="mt-2 text-sm text-slate-500">Public updates from Head MITCOM will appear here once available.</p>
                </div>
            @endif
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            @foreach ($stats as $stat)
                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $stat['label'] }}</p>
                            <p class="mt-4 text-4xl font-bold text-slate-950">{{ $stat['value'] }}</p>
                            <p class="mt-3 text-sm leading-6 text-slate-500">{{ $stat['description'] }}</p>
                        </div>
                        <span class="rounded-2xl border px-3 py-2 text-xs font-semibold {{ $stat['accent'] }}">
                            Status
                        </span>
                    </div>
                </article>
            @endforeach
        </section>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-emerald-900 shadow-sm">
                <p class="font-semibold">Success</p>
                <p class="mt-1 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Report Records</p>
                        <h3 class="mt-2 text-xl font-bold text-slate-950">My reports</h3>
                        <p class="mt-2 text-sm text-slate-500">Review all submitted incidents and filter the list to find specific cases.</p>
                    </div>
                    <form method="GET" action="{{ route('user.dashboard') }}"
                        class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Issue Type</label>
                            <select name="issue_type"
                                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200">
                                <option value="">All issues</option>
                                @foreach($issueTypes as $type)
                                    <option value="{{ $type['value'] }}" @selected($issueType === $type['value'])>
                                        {{ $type['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Report Status</label>
                            <select name="status"
                                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200">
                                <option value="">All statuses</option>
                                @foreach($statusOptions as $option)
                                    <option value="{{ $option['value'] }}" @selected($status === $option['value'])>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Order</label>
                            <select name="sort"
                                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200">
                                <option value="latest" @selected($sort === 'latest')>Latest</option>
                                <option value="oldest" @selected($sort === 'oldest')>Oldest</option>
                            </select>
                        </div>
                        <div class="flex gap-2 pt-6">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                Apply
                            </button>
                            <a href="{{ route('user.dashboard') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-800">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Issue Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Submitted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($reports as $report)
                            <tr class="cursor-pointer transition hover:bg-slate-50"
                                onclick="window.location='{{ route('user.reports.show', $report) }}'">
                                <td class="px-6 py-4 text-sm text-slate-500">#{{ $report->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                    {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700">
                                    {{ Str::limit($report->location, 40) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset
                                        @if($report->status === 'pending') bg-yellow-50 text-yellow-800 ring-yellow-200
                                        @elseif($report->status === 'verified') bg-blue-50 text-blue-800 ring-blue-200
                                        @elseif($report->status === 'assigned') bg-purple-50 text-purple-800 ring-purple-200
                                        @elseif($report->status === 'resolved') bg-green-50 text-green-800 ring-green-200
                                        @elseif($report->status === 'rejected') bg-red-50 text-red-800 ring-red-200
                                        @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $report->created_at->format('M d, Y') }}
                                    <br>
                                    <span class="text-xs text-slate-400">{{ $report->created_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-slate-400">
                                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-3 font-semibold text-slate-700">No reports yet</p>
                                    <p class="mt-2 text-sm text-slate-500">Submit your first incident report to start using the dashboard.</p>
                                    <a href="{{ route('user.reports.create') }}"
                                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                                        Report Incident
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $reports->links() }}
                </div>
            @endif
        </section>

        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Live Monitoring</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-950">Live traffic map</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Browse live incidents around Minglanilla and watch active report statuses on the map.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-600">
                    <span class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1">Verified</span>
                    <span class="rounded-full border border-yellow-100 bg-yellow-50 px-3 py-1">Pending</span>
                    <span class="rounded-full border border-green-100 bg-green-50 px-3 py-1">Resolved</span>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 shadow-inner">
                <div id="user-map" class="h-[420px] w-full"></div>
            </div>
        </section>
    </div>

    <x-slot:scripts>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (document.getElementById('user-map')) {
                    initPublicMap('user-map');
                }
            });
        </script>
    </x-slot:scripts>
</x-dashboard-shell>
