@php
    $fullName = trim($enforcer->first_name . ' ' . $enforcer->last_name);
    $initials = strtoupper(substr($enforcer->first_name, 0, 1) . substr($enforcer->last_name, 0, 1));
    $totalAssigned = $assignedReports->total();
    $resolvedCount = $enforcer->assignedReports()->where('status', 'resolved')->count();
    $activeCount = $enforcer->assignedReports()->where('status', 'assigned')->count();
    $reviewCount = $enforcer->assignedReports()->where('status', 'for_verification')->count();
    $completionRate = $totalAssigned > 0 ? round(($resolvedCount / $totalAssigned) * 100) : 0;
    $latestAssignment = $assignedReports->first();
@endphp

<x-app-nav title="{{ $fullName }} - MITCOM Head" page-title="Enforcer Profile" page-eyebrow="Command Center">
    <x-slot:actions>
        <a href="{{ route('head-mitcom.enforcers.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" />
            </svg>
            All Enforcers
        </a>
    </x-slot:actions>

    <main class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
        <section class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-r from-blue-800 via-slate-900 to-cyan-700"></div>
            <div class="absolute right-0 top-0 h-28 w-28 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute left-10 top-6 h-20 w-20 rounded-full bg-cyan-300/20 blur-3xl"></div>

            <div class="relative px-6 pb-6 pt-28 sm:px-8 sm:pt-28">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                        <div
                            class="flex h-24 w-24 items-center justify-center rounded-[1.75rem] border-4 border-white bg-gradient-to-br from-blue-600 via-blue-700 to-slate-900 text-2xl font-black text-white shadow-xl">
                            {{ $initials }}
                        </div>

                        <div class="space-y-3">
                            <div class="space-y-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-200">Traffic
                                    Enforcement Unit</p>
                                <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                                    {{ $fullName }}
                                </h1>
                                <p class="text-sm text-slate-500 sm:text-base">Operational profile, workload, and
                                    assigned incident queue.</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 ring-1 ring-slate-200">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Active enforcer
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 ring-1 ring-slate-200">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                        <path
                                            d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                    </svg>
                                    {{ $enforcer->email }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 ring-1 ring-slate-200">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" />
                                    </svg>
                                    Joined {{ $enforcer->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-5 xl:min-w-[24rem] xl:max-w-[56rem]">
                        <div class="rounded-2xl border border-blue-100 bg-blue-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Total Cases</p>
                            <p class="mt-2 text-3xl font-black text-blue-900">{{ $totalAssigned }}</p>
                            <p class="mt-1 text-xs text-blue-700">All reports assigned.</p>
                        </div>
                        <div class="rounded-2xl border border-amber-100 bg-amber-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Active Queue</p>
                            <p class="mt-2 text-3xl font-black text-amber-900">{{ $activeCount + $reviewCount }}</p>
                            <p class="mt-1 text-xs text-amber-700">Open incidents in progress.</p>
                        </div>
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Completion Rate
                            </p>
                            <p class="mt-2 text-3xl font-black text-emerald-900">{{ $completionRate }}%</p>
                            <p class="mt-1 text-xs text-emerald-700">Resolved vs total assigned.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-600">Avg Resolution</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">
                                {{ $avgResolutionMinutes ?? '—' }}
                            </p>
                            <p class="mt-1 text-xs text-slate-600">
                                {{ $avgResolutionMinutes ? 'minutes per case' : 'No resolved cases yet' }}
                            </p>
                        </div>
                        <div class="rounded-2xl border border-rose-100 bg-rose-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-rose-600">Rejections</p>
                            <p class="mt-2 text-3xl font-black text-rose-900">{{ $totalRejections }}</p>
                            <p class="mt-1 text-xs text-rose-700">Proof uploads rejected.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-6">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5 sm:px-8">
                    <div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Assigned Reports
                            </p>
                            <h2 class="mt-2 text-2xl font-bold text-slate-900">Incident Work Queue</h2>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                                A roomier view of every report this enforcer has handled or is still processing, with
                                quick context for status, location, and assignment timeline.
                            </p>
                        </div>

                    </div>
                </div>

                @if($assignedReports->count())
                    <div class="space-y-4 px-6 py-6 sm:px-8">
                        @foreach($assignedReports as $report)
                            <article
                                class="group rounded-[1.5rem] border border-slate-200 bg-gradient-to-br from-white to-slate-50/70 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md">
                                <div class="flex flex-col gap-5">
                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-[1.25rem] bg-slate-900 text-sm font-black text-white shadow-sm">
                                                #{{ $report->id }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex flex-wrap items-center gap-3">
                                                    <h3 class="text-lg font-bold text-slate-900">
                                                        {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                                    </h3>
                                                    <span
                                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1
                                                                                @if($report->status === 'assigned') bg-amber-50 text-amber-700 ring-amber-200
                                                                                @elseif($report->status === 'for_verification') bg-blue-50 text-blue-700 ring-blue-200
                                                                                @elseif($report->status === 'resolved') bg-emerald-50 text-emerald-700 ring-emerald-200
                                                                                @elseif($report->status === 'verified') bg-indigo-50 text-indigo-700 ring-indigo-200
                                                                                @elseif($report->status === 'rejected') bg-rose-50 text-rose-700 ring-rose-200
                                                                                @else bg-slate-100 text-slate-600 ring-slate-200 @endif">
                                                        {{ ucwords(str_replace('_', ' ', $report->status)) }}
                                                    </span>
                                                </div>
                                                <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">
                                                    {{ $report->description }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="lg:pl-4">
                                            <a href="{{ route('head-mitcom.reports.show', $report) }}"
                                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-100">
                                                View report
                                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="grid gap-3 md:grid-cols-3">
                                        <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                                Location</p>
                                            <p class="mt-2 text-sm font-semibold text-slate-800">{{ $report->location }}</p>
                                            <p class="mt-1 text-xs text-slate-500">Reported
                                                {{ $report->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                                                Assignment Timeline</p>
                                            <p class="mt-2 text-sm font-semibold text-slate-800">
                                                {{ $report->assigned_at?->format('M d, Y') ?? 'Not assigned' }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $report->assigned_at?->format('h:i A') ?? 'No assignment time recorded' }}
                                            </p>
                                        </div>

                                        <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Queue
                                                Status</p>
                                            <p class="mt-2 text-sm font-semibold text-slate-800">
                                                @if($report->status === 'assigned')
                                                    Active field response
                                                @elseif($report->status === 'for_verification')
                                                    Awaiting MITCOM validation
                                                @elseif($report->status === 'resolved')
                                                    Case completed
                                                @elseif($report->status === 'verified')
                                                    Verified and ready for action
                                                @elseif($report->status === 'rejected')
                                                    Rejected from the workflow
                                                @else
                                                    Status recorded in workflow
                                                @endif
                                            </p>
                                            <p class="mt-1 text-xs text-slate-500">
                                                Keep track of where this report currently sits in the incident pipeline.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-16 text-center sm:px-8">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-400 ring-1 ring-slate-200">
                            <svg class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 3.5a1.5 1.5 0 00-1.5 1.5v.634A5.502 5.502 0 004.5 11v3.25A2.75 2.75 0 007.25 17h5.5a2.75 2.75 0 002.75-2.75V11a5.502 5.502 0 00-4-5.266V5A1.5 1.5 0 0010 3.5zM7 8.75a3 3 0 116 0v.514c-.319-.085-.655-.129-1-.129H8c-.345 0-.681.044-1 .129V8.75z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">No assigned reports yet</h3>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            This enforcer does not have any report history at the moment. Once assignments are made, they
                            will appear here in a structured queue.
                        </p>
                    </div>
                @endif

                <div class="border-t border-slate-200 px-6 py-4 sm:px-8">
                    {{ $assignedReports->links() }}
                </div>
            </div>
        </section>
    </main>

    <x-toast />
</x-app-nav>