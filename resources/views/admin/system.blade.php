<x-dashboard-shell title="System Overview" page-title="System Overview"
    page-eyebrow="System Administration"
    page-description="High-level view of system activity, report health, and operational metrics.">

    <x-slot:actions>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            ← Back to Dashboard
        </a>
    </x-slot:actions>

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Hero Summary Bar --}}
        <section class="overflow-hidden rounded-[2rem] border border-blue-100 bg-[linear-gradient(135deg,rgba(30,64,175,0.96),rgba(15,23,42,0.96))] px-6 py-7 text-white shadow-xl shadow-blue-900/10">
            <div class="grid gap-6 sm:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-100/70">Total Reports</p>
                    <p class="mt-3 text-4xl font-black">{{ $totalReports }}</p>
                    <p class="mt-1 text-xs text-blue-100/60">Across all statuses</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-100/70">Resolution Rate</p>
                    <p class="mt-3 text-4xl font-black">{{ $resolutionRate }}%</p>
                    <p class="mt-1 text-xs text-blue-100/60">{{ $resolvedReports }} of {{ $totalReports }} resolved</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-100/70">Active Enforcers</p>
                    <p class="mt-3 text-4xl font-black">{{ $activeEnforcers }} <span class="text-lg font-semibold text-blue-100/60">/ {{ $enforcerCount }}</span></p>
                    <p class="mt-1 text-xs text-blue-100/60">With open cases</p>
                </div>
            </div>
        </section>

        {{-- Report Breakdown --}}
        <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Report Breakdown</p>
            <h3 class="mt-1 text-xl font-bold text-slate-950">Incident status distribution</h3>
            <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Pending</p>
                        <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700">Awaiting</span>
                    </div>
                    <p class="mt-3 text-3xl font-black text-amber-900">{{ $pendingReports }}</p>
                </div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Assigned</p>
                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-700">Active</span>
                    </div>
                    <p class="mt-3 text-3xl font-black text-blue-900">{{ $assignedReports }}</p>
                </div>
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Resolved</p>
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700">Done</span>
                    </div>
                    <p class="mt-3 text-3xl font-black text-emerald-900">{{ $resolvedReports }}</p>
                </div>
                <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wide text-rose-600">Rejected</p>
                        <span class="rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-700">Closed</span>
                    </div>
                    <p class="mt-3 text-3xl font-black text-rose-900">{{ $rejectedReports }}</p>
                </div>
            </div>
        </section>

        {{-- Advisory + Enforcer --}}
        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Traffic Advisories</p>
                <h3 class="mt-1 text-xl font-bold text-slate-950">Advisory status</h3>
                <div class="mt-5 grid grid-cols-3 gap-3">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-blue-600">Published</p>
                        <p class="mt-2 text-3xl font-black text-blue-900">{{ $publishedAdvisories }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Draft</p>
                        <p class="mt-2 text-3xl font-black text-slate-800">{{ $draftAdvisories }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-100 p-4 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Archived</p>
                        <p class="mt-2 text-3xl font-black text-slate-600">{{ $archivedAdvisories }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Enforcer Unit</p>
                <h3 class="mt-1 text-xl font-bold text-slate-950">Field personnel</h3>
                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Total Enforcers</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $enforcerCount }}</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-emerald-600">Currently Active</p>
                        <p class="mt-2 text-3xl font-black text-emerald-900">{{ $activeEnforcers }}</p>
                        <p class="mt-1 text-[10px] text-emerald-600">With open cases</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Last Activity --}}
        <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Last System Activity</p>
            <h3 class="mt-1 text-xl font-bold text-slate-950">Recent entries</h3>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div class="flex items-start gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5.75 3.75A1.75 1.75 0 004 5.5v9A1.75 1.75 0 005.75 16.25h8.5A1.75 1.75 0 0016 14.5v-9a1.75 1.75 0 00-1.75-1.75h-8.5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">Latest Report</p>
                        @if($lastReport)
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $lastReport->title ?? $lastReport->issue_type }}</p>
                            <p class="mt-0.5 text-xs text-slate-400">{{ $lastReport->created_at->diffForHumans() }}</p>
                        @else
                            <p class="mt-1 text-sm text-slate-400">No reports yet.</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-start gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">Latest Advisory</p>
                        @if($lastAdvisory)
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $lastAdvisory->title }}</p>
                            <p class="mt-0.5 text-xs text-slate-400">{{ $lastAdvisory->created_at->diffForHumans() }}</p>
                        @else
                            <p class="mt-1 text-sm text-slate-400">No advisories yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-dashboard-shell>