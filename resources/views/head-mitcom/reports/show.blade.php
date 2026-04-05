@php
    use Illuminate\Support\Facades\Storage;

    $issueType = ucwords(str_replace('_', ' ', $report->issue_type));
    $statusLabel = ucwords(str_replace('_', ' ', $report->status));
    $reporterName = $report->user
        ? trim($report->user->first_name . ' ' . $report->user->last_name)
        : ($report->reporter_name ?: 'Guest Reporter');
    $nameParts = preg_split('/\s+/', trim($reporterName)) ?: [];
    $reporterInitials = strtoupper(substr($nameParts[0] ?? 'G', 0, 1) . substr($nameParts[count($nameParts) - 1] ?? 'R', 0, 1));
    $assignedEnforcer = $report->assignedEnforcer;
    $statusClasses = match ($report->status) {
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'verified' => 'bg-blue-50 text-blue-700 ring-blue-200',
        'assigned' => 'bg-violet-50 text-violet-700 ring-violet-200',
        'for_verification' => 'bg-cyan-50 text-cyan-700 ring-cyan-200',
        'resolved' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'rejected' => 'bg-rose-50 text-rose-700 ring-rose-200',
        default => 'bg-slate-100 text-slate-700 ring-slate-200',
    };
    $statusHeadline = match ($report->status) {
        'pending' => 'Pending MITCOM review',
        'verified' => 'Ready for assignment',
        'assigned' => 'Enforcer deployed',
        'for_verification' => 'Proof waiting for approval',
        'resolved' => 'Case resolved',
        'rejected' => 'Report rejected',
        default => 'Status update',
    };
    $statusDescription = match ($report->status) {
        'pending' => 'Review the report details and decide whether it should move into the response workflow.',
        'verified' => 'The report is validated and now waiting for enforcer assignment.',
        'assigned' => 'An enforcer is actively handling this incident in the field.',
        'for_verification' => 'Resolution proof has been submitted and needs MITCOM confirmation.',
        'resolved' => 'The incident has been completed and officially closed.',
        'rejected' => 'The report was marked invalid, duplicate, or not actionable.',
        default => 'Review the report to determine the next step.',
    };
@endphp

<x-app-nav title="Report #{{ $report->id }} - MITCOM Head" page-title="Report #{{ $report->id }}"
    page-eyebrow="Command Center">
    @push('styles')
        <style>
            body.evidence-open #report-map .leaflet-pane,
            body.evidence-open #report-map .leaflet-top,
            body.evidence-open #report-map .leaflet-bottom,
            body.evidence-open #report-map .leaflet-control-container,
            body.evidence-open #report-map .leaflet-popup {
                visibility: hidden !important;
            }

            body.evidence-open #report-map {
                z-index: 0 !important;
            }
        </style>
    @endpush

    <x-slot:actions>
        <a href="{{ route('head-mitcom.reports.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" />
            </svg>
            All Reports
        </a>
    </x-slot:actions>

    <main class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
        <section class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-r from-blue-800 via-slate-900 to-cyan-700"></div>
            <div class="absolute -right-8 top-0 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute left-0 top-8 h-32 w-32 rounded-full bg-cyan-300/20 blur-3xl"></div>

            <div class="relative px-6 pb-8 pt-44 sm:px-8 sm:pt-48">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-blue-100 ring-1 ring-white/20">
                                Incident Report
                            </span>
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClasses }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">{{ $issueType }}
                            </h1>
                            <p class="max-w-3xl text-sm leading-6 text-slate-500 sm:text-base">{{ $statusDescription }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 ring-1 ring-slate-200">
                                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 2a6 6 0 00-6 6c0 3.73 3.2 7.308 5.106 9.102a1.25 1.25 0 001.788 0C12.8 15.308 16 11.73 16 8a6 6 0 00-6-6zm0 8.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $report->location }}
                            </span>
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 ring-1 ring-slate-200">
                                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2.5a.75.75 0 01.75.75V4h6.5v-.75a.75.75 0 011.5 0V4h.75A1.75 1.75 0 0117.25 5.75v8.5A1.75 1.75 0 0115.5 16H4.5A1.75 1.75 0 012.75 14.25v-8.5A1.75 1.75 0 014.5 4H5v-.75A.75.75 0 016 2.5zm-.75 6a.75.75 0 100 1.5h9.5a.75.75 0 000-1.5h-9.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                Submitted {{ $report->created_at->diffForHumans() }}
                            </span>
                            @if($assignedEnforcer)
                                <a href="{{ route('head-mitcom.enforcers.show', $assignedEnforcer) }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 ring-1 ring-slate-200 transition hover:bg-slate-200">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M10 2a4 4 0 100 8 4 4 0 000-8zM4 14a4 4 0 014-4h4a4 4 0 014 4v.5a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 014 14.5V14z" />
                                    </svg>
                                    {{ $assignedEnforcer->first_name }} {{ $assignedEnforcer->last_name }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 xl:min-w-[24rem] xl:max-w-[44rem]">
                        <div class="rounded-2xl border border-blue-100 bg-blue-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Report ID</p>
                            <p class="mt-2 text-3xl font-black text-blue-900">#{{ $report->id }}</p>
                            <p class="mt-1 text-xs text-blue-700">Reference number for coordination and audit.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Current Stage</p>
                            <p class="mt-2 text-lg font-black text-slate-900">{{ $statusHeadline }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $statusLabel }}</p>
                        </div>
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/80 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Coordinates</p>
                            <p class="mt-2 text-sm font-bold text-emerald-900">{{ $report->latitude }},
                                {{ $report->longitude }}
                            </p>
                            <p class="mt-1 text-xs text-emerald-700">Map pin used for on-site validation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-[1.7fr,1fr]">
            <div class="space-y-6">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div
                        class="flex flex-col gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Incident
                                Overview</p>
                            <h2 class="mt-2 text-2xl font-bold text-slate-900">Report Details</h2>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm ring-1 ring-slate-200">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Reporter</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $reporterName }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Issue Type</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">{{ $issueType }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Current Status</p>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold ring-1 {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Description</p>
                            <p class="mt-2 text-sm leading-7 text-slate-700">{{ $report->description }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Location</p>
                            <p class="mt-2 font-semibold text-slate-900">{{ $report->location }}</p>
                            <p class="mt-1 text-xs text-slate-500">Latitude {{ $report->latitude }} and longitude
                                {{ $report->longitude }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($report->image_path)
                    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm"
                        x-data="{ openEvidence: false }">
                        <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Supporting Media
                                </p>
                                <h2 class="mt-2 text-2xl font-bold text-slate-900">Photo Evidence</h2>
                            </div>
                            <button type="button"
                                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                                @click="openEvidence = true; document.body.classList.add('evidence-open')">
                                Open image
                            </button>
                        </div>

                        <div class="mt-6 overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50">
                            <img src="{{ Storage::url($report->image_path) }}"
                                alt="Photo evidence for report #{{ $report->id }}"
                                class="h-[24rem] w-full cursor-zoom-in object-cover"
                                @click="openEvidence = true; document.body.classList.add('evidence-open')">
                        </div>

                        <template x-teleport="body">
                            <div x-show="openEvidence" x-cloak x-transition.opacity
                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 p-4"
                                style="z-index: 99999;"
                                @click="openEvidence = false; document.body.classList.remove('evidence-open')"
                                @keydown.escape.window="openEvidence = false; document.body.classList.remove('evidence-open')">
                                <div class="relative max-w-5xl" style="z-index: 100000;" @click.stop>
                                    <img src="{{ Storage::url($report->image_path) }}"
                                        alt="Expanded photo evidence for report #{{ $report->id }}"
                                        class="max-h-[85vh] w-full rounded-[1.5rem] object-contain shadow-2xl">
                                    <button type="button"
                                        class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/25"
                                        @click="openEvidence = false; document.body.classList.remove('evidence-open')">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4.22 4.22a.75.75 0 011.06 0L10 8.94l4.72-4.72a.75.75 0 111.06 1.06L11.06 10l4.72 4.72a.75.75 0 11-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 11-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 010-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                @endif

                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="border-b border-slate-200 pb-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Map Reference</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">Location on Map</h2>
                        <p class="mt-1 text-sm text-slate-500">Use the pin to validate the reported incident area before
                            assigning field action.</p>
                    </div>
                    <div class="mt-6 overflow-hidden rounded-[1.5rem] border border-slate-200">
                        <div id="report-map" class="h-[420px] w-full"></div>
                    </div>
                </div>

<div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Action Center</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">MITCOM Controls</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Choose the next operational step based on the
                        current report stage.</p>

                    <div class="mt-6">
                        @if($report->status === 'pending')
                            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                                <p class="font-semibold text-amber-900">Verification required</p>
                                <p class="mt-1 text-sm text-amber-700">Confirm whether this report should proceed into the
                                    active workflow.</p>
                                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <form method="POST" action="{{ route('head-mitcom.reports.verify', $report) }}">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                                            Verify report
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('head-mitcom.reports.reject', $report) }}">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-700">
                                            Reject report
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif($report->status === 'verified')
                            <form method="POST" action="{{ route('head-mitcom.reports.assign', $report) }}"
                                class="rounded-2xl border border-violet-200 bg-violet-50 p-4">
                                @csrf
                                <p class="font-semibold text-violet-900">Assign an enforcer</p>
                                <p class="mt-1 text-sm text-violet-700">Choose the field officer who will handle this
                                    incident.</p>
                                <select name="enforcer_id" required
                                    class="mt-4 w-full rounded-xl border border-violet-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-200">
                                    <option value="">Select enforcer...</option>
                                    @foreach($enforcers as $enforcer)
                                        <option value="{{ $enforcer->id }}">{{ $enforcer->first_name }}
                                            {{ $enforcer->last_name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-violet-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-violet-700">
                                    Assign report
                                </button>
                            </form>
                        @elseif($report->status === 'assigned')
                            <div class="space-y-4">
                                <div class="rounded-2xl border border-violet-200 bg-violet-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-violet-500">Assigned
                                        Enforcer</p>
                                    <p class="mt-2 text-lg font-bold text-violet-900">{{ $assignedEnforcer?->first_name }}
                                        {{ $assignedEnforcer?->last_name }}</p>
                                    <p class="mt-1 text-sm text-violet-700">
                                        {{ $report->assigned_at?->diffForHumans() ?? 'Assignment time unavailable' }}</p>
                                </div>

                                <form method="POST" action="{{ route('head-mitcom.reports.reassign', $report) }}"
                                    class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    @csrf
                                    <p class="font-semibold text-slate-900">Reassign this case</p>
                                    <p class="mt-1 text-sm text-slate-500">Move the report if workload or availability
                                        changes.</p>
                                    <select name="enforcer_id" required
                                        class="mt-4 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                        <option value="">Reassign to...</option>
                                        @foreach($enforcers as $enforcer)
                                            <option value="{{ $enforcer->id }}" @selected($report->assigned_to == $enforcer->id)>
                                                {{ $enforcer->first_name }} {{ $enforcer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                        Reassign report
                                    </button>
                                </form>
                            </div>
                        @elseif($report->status === 'for_verification')
                            <div class="space-y-4" x-data="{ openProof: false }">
                                <div class="rounded-2xl border border-cyan-200 bg-cyan-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-cyan-600">Assigned Enforcer
                                    </p>
                                    <p class="mt-2 text-lg font-bold text-cyan-900">{{ $assignedEnforcer?->first_name }}
                                        {{ $assignedEnforcer?->last_name }}</p>
                                    <p class="mt-1 text-sm text-cyan-700">Resolution proof has been submitted and is
                                        awaiting confirmation.</p>
                                </div>

                                <div class="rounded-2xl border border-cyan-200 bg-white p-4">
                                    <p class="font-semibold text-slate-900">Resolution proof submitted</p>
                                    <p class="mt-1 text-sm text-slate-500">Inspect the proof carefully before confirming or
                                        rejecting the closure.</p>

                                    @if($report->proof_image)
                                        <button type="button"
                                            class="mt-4 w-full overflow-hidden rounded-2xl border border-slate-200"
                                            @click="openProof = true; document.body.classList.add('evidence-open')">
                                            <img src="{{ Storage::url($report->proof_image) }}"
                                                alt="Resolution proof for report #{{ $report->id }}"
                                                class="h-56 w-full object-cover">
                                        </button>
                                    @endif

                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <form action="{{ route('head-mitcom.reports.confirm-resolved', $report) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                                Confirm resolved
                                            </button>
                                        </form>
                                        <form action="{{ route('head-mitcom.reports.reject-resolved', $report) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-700">
                                                Reject proof
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if($report->proof_image)
                                    <template x-teleport="body">
                                        <div x-show="openProof" x-cloak x-transition.opacity
                                            class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 p-4"
                                            style="z-index: 99999;"
                                            @click="openProof = false; document.body.classList.remove('evidence-open')"
                                            @keydown.escape.window="openProof = false; document.body.classList.remove('evidence-open')">
                                            <div class="relative max-w-5xl" style="z-index: 100000;" @click.stop>
                                                <img src="{{ Storage::url($report->proof_image) }}"
                                                    alt="Expanded resolution proof for report #{{ $report->id }}"
                                                    class="max-h-[85vh] w-full rounded-[1.5rem] object-contain shadow-2xl">
                                                <button type="button"
                                                    class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/25"
                                                    @click="openProof = false; document.body.classList.remove('evidence-open')">
                                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M4.22 4.22a.75.75 0 011.06 0L10 8.94l4.72-4.72a.75.75 0 111.06 1.06L11.06 10l4.72 4.72a.75.75 0 11-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 11-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 010-1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                @endif
                            </div>
                        @elseif($report->status === 'resolved')
                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                                <p class="font-semibold text-emerald-900">Report closed successfully</p>
                                <p class="mt-1 text-sm text-emerald-700">This report has been resolved and no further action
                                    is required.</p>
                            </div>
                        @else
                            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
                                <p class="font-semibold text-rose-900">No further operational action</p>
                                <p class="mt-1 text-sm text-rose-700">This report is already rejected and will not continue
                                    in the workflow.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6 xl:sticky xl:top-24 xl:self-start">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Reporter Profile</p>
                    <div class="mt-5 flex items-start gap-4">
                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-700 to-slate-900 text-lg font-black text-white">
                            {{ $reporterInitials }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xl font-bold text-slate-900">{{ $reporterName }}</h2>
                            <p class="mt-1 text-sm text-slate-500">Original report submitter</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</p>
                            <p class="mt-2 break-all text-sm font-medium text-slate-800">
                                {{ $report->reporter_email ?: ($report->user?->email ?: 'Not provided') }}
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</p>
                            <p class="mt-2 text-sm font-medium text-slate-800">
                                {{ $report->reporter_phone ?: 'Not provided' }}
                            </p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Submitted</p>
                            <p class="mt-2 text-sm font-medium text-slate-800">
                                {{ $report->created_at->format('M d, Y h:i A') }}
                            </p>
                            <p class="mt-1 text-xs text-slate-500">{{ $report->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Workflow Status</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">{{ $statusHeadline }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ $statusDescription }}</p>

                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 h-3 w-3 rounded-full bg-blue-600"></span>
                            <div>
                                <p class="font-semibold text-slate-900">Submitted</p>
                                <p class="text-sm text-slate-500">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span
                                class="mt-0.5 h-3 w-3 rounded-full {{ in_array($report->status, ['verified', 'assigned', 'for_verification', 'resolved'], true) ? 'bg-blue-600' : 'bg-slate-300' }}"></span>
                            <div>
                                <p class="font-semibold text-slate-900">Verified</p>
                                <p class="text-sm text-slate-500">
                                    {{ $report->verified_at ? $report->verified_at->format('M d, Y h:i A') : 'Waiting for verification' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span
                                class="mt-0.5 h-3 w-3 rounded-full {{ in_array($report->status, ['assigned', 'for_verification', 'resolved'], true) ? 'bg-violet-600' : 'bg-slate-300' }}"></span>
                            <div>
                                <p class="font-semibold text-slate-900">Assigned</p>
                                <p class="text-sm text-slate-500">
                                    {{ $report->assigned_at ? $report->assigned_at->format('M d, Y h:i A') : 'No enforcer assigned yet' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span
                                class="mt-0.5 h-3 w-3 rounded-full {{ $report->status === 'resolved' ? 'bg-emerald-600' : 'bg-slate-300' }}"></span>
                            <div>
                                <p class="font-semibold text-slate-900">Resolved</p>
                                <p class="text-sm text-slate-500">
                                    {{ $report->resolved_at ? \Carbon\Carbon::parse($report->resolved_at)->format('M d, Y h:i A') : 'Not yet closed' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </section>
    </main>

    <x-toast />

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('report-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);

                L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                    .addTo(map)
                    .bindPopup('<b>{{ $issueType }}</b><br>{{ $report->location }}')
                    .openPopup();
            });
        </script>
    @endpush
</x-app-nav>
