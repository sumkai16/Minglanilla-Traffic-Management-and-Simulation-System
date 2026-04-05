@php
    $stats = [
        [
            'label' => 'Assigned',
            'value' => $assignedCount,
            'description' => 'Cases currently under your response queue.',
            'accent' => 'bg-amber-50 text-amber-700 border-amber-100',
        ],
        [
            'label' => 'For Verification',
            'value' => $forVerificationCount,
            'description' => 'Proof submitted and pending MITCOM review.',
            'accent' => 'bg-blue-50 text-blue-700 border-blue-100',
        ],
        [
            'label' => 'Resolved',
            'value' => $resolvedCount,
            'description' => 'Reports confirmed as completed.',
            'accent' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        ],
    ];
@endphp

<x-dashboard-shell title="Enforcer Dashboard" page-title="Enforcer Dashboard" page-eyebrow="Field Operations"
    page-description="Review your assignments, monitor verification status, and keep response work organized from one formal enforcer workspace.">
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
        <a href="{{ route('enforcer.reports.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M5.75 3.75A1.75 1.75 0 004 5.5v9A1.75 1.75 0 005.75 16.25h8.5A1.75 1.75 0 0016 14.5v-9a1.75 1.75 0 00-1.75-1.75h-8.5zM6.5 7a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h4.25a.75.75 0 010 1.5H6.5z" />
            </svg>
            Open Reports
        </a>
    </x-slot:actions>

    <div class="mx-auto max-w-6xl space-y-6">
        <section
            class="overflow-hidden rounded-[2rem] border border-slate-200 bg-[linear-gradient(135deg,rgba(15,23,42,0.98),rgba(30,64,175,0.94))] px-6 py-7 text-white shadow-xl shadow-slate-900/10">
            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-blue-200">On-Site Response</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight">Good day, {{ auth()->user()->first_name }}.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100/85">
                        Keep track of assigned incidents, submit proof quickly, and stay aligned with Head MITCOM review workflows.
                    </p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.3em] text-blue-100/70">Current Workload</p>
                    <p class="mt-3 text-4xl font-bold">{{ $assignedCount + $forVerificationCount }}</p>
                    <p class="mt-2 text-sm text-blue-100/80">Active items across field response and review.</p>
                </div>
            </div>
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

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Quick Actions</p>
                <h3 class="mt-2 text-xl font-bold text-slate-950">Field workflow shortcuts</h3>

                <div class="mt-6 grid gap-4">
                    <a href="{{ route('enforcer.reports.index') }}"
                        class="group flex items-start gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:border-blue-300 hover:bg-blue-50">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M5.75 3.75A1.75 1.75 0 004 5.5v9A1.75 1.75 0 005.75 16.25h8.5A1.75 1.75 0 0016 14.5v-9a1.75 1.75 0 00-1.75-1.75h-8.5zM6.5 7a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h7a.75.75 0 010 1.5h-7zm0 3.75a.75.75 0 010-1.5h4.25a.75.75 0 010 1.5H6.5z" />
                            </svg>
                        </span>
                        <span>
                            <span class="block text-lg font-semibold text-slate-900">My Assigned Reports</span>
                            <span class="mt-2 block text-sm leading-6 text-slate-500">Open incident records, upload proof, and continue active case handling.</span>
                        </span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="group flex items-start gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:border-blue-300 hover:bg-blue-50">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-white">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd"
                                    d="M2 16.5A4.5 4.5 0 016.5 12h7a4.5 4.5 0 014.5 4.5.75.75 0 01-.75.75H2.75A.75.75 0 012 16.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span>
                            <span class="block text-lg font-semibold text-slate-900">Profile Management</span>
                            <span class="mt-2 block text-sm leading-6 text-slate-500">Update your account details and keep field contact information current.</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Status Guide</p>
                <h3 class="mt-2 text-xl font-bold text-slate-950">Resolution workflow</h3>

                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl border border-amber-100 bg-amber-50 p-4">
                        <p class="text-sm font-semibold text-amber-900">Assigned</p>
                        <p class="mt-2 text-sm leading-6 text-amber-800/80">Report is routed to you for response. Proceed on-site and document your action.</p>
                    </div>
                    <div class="rounded-3xl border border-blue-100 bg-blue-50 p-4">
                        <p class="text-sm font-semibold text-blue-900">For Verification</p>
                        <p class="mt-2 text-sm leading-6 text-blue-800/80">Proof has been submitted and is awaiting confirmation from Head MITCOM.</p>
                    </div>
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-4">
                        <p class="text-sm font-semibold text-emerald-900">Resolved</p>
                        <p class="mt-2 text-sm leading-6 text-emerald-800/80">The case is closed after leadership confirms the submitted completion evidence.</p>
                    </div>
                </div>
            </div>
        </section>

        <x-toast />
    </div>
</x-dashboard-shell>
