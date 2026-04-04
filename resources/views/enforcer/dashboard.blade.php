<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enforcer Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(12px);
            animation: fadeUp 0.45s ease forwards;
        }

        .fade-up:nth-child(1) {
            animation-delay: 0.04s;
        }

        .fade-up:nth-child(2) {
            animation-delay: 0.10s;
        }

        .fade-up:nth-child(3) {
            animation-delay: 0.16s;
        }

        .fade-up:nth-child(4) {
            animation-delay: 0.22s;
        }

        .fade-up:nth-child(5) {
            animation-delay: 0.28s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.02em;
            font-variant-numeric: tabular-nums;
        }

        .action-card {
            transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
        }

        .action-card:hover {
            box-shadow: 0 4px 16px 0 rgba(37, 99, 235, 0.07);
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">

    <x-app-nav pageTitle="Dashboard" />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        {{-- Header --}}
        <div class="fade-up">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Enforcer Portal</p>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                Good day, {{ auth()->user()->first_name }}.
            </h1>
            <p class="text-slate-500 text-sm mt-1">Here's your current assignment overview.</p>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-3 gap-3 sm:gap-4 fade-up">

            {{-- Assigned --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs font-semibold uppercase tracking-widest text-slate-400 hidden sm:block">Assigned</span>
                    <div
                        class="h-8 w-8 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center">
                        <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="stat-number text-amber-600">{{ $assignedCount }}</p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Assigned</p>
                </div>
            </div>

            {{-- For Verification --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs font-semibold uppercase tracking-widest text-slate-400 hidden sm:block">Review</span>
                    <div class="h-8 w-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center">
                        <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="stat-number text-blue-600">{{ $forVerificationCount }}</p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">For Verification</p>
                </div>
            </div>

            {{-- Resolved --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs font-semibold uppercase tracking-widest text-slate-400 hidden sm:block">Resolved</span>
                    <div
                        class="h-8 w-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="stat-number text-emerald-600">{{ $resolvedCount }}</p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Resolved</p>
                </div>
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="fade-up bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-widest mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                <a href="{{ route('enforcer.reports.index') }}"
                    class="action-card group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50">
                    <div
                        class="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-150">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 text-sm">My Assigned Reports</p>
                        <p class="text-xs text-slate-400 mt-0.5 truncate">View and manage your cases</p>
                    </div>
                    <svg class="h-4 w-4 text-slate-300 ml-auto flex-shrink-0 group-hover:text-blue-400 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('enforcer.reports.index') }}"
                    class="action-card group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50">
                    <div
                        class="h-10 w-10 rounded-xl bg-amber-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-150">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 text-sm">Pending Verification</p>
                        <p class="text-xs text-slate-400 mt-0.5 truncate">Proof submitted, awaiting MITCOM</p>
                    </div>
                    <svg class="h-4 w-4 text-slate-300 ml-auto flex-shrink-0 group-hover:text-amber-400 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

            </div>
        </div>

        {{-- Status Guide --}}
        <div class="fade-up bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-widest mb-4">Report Status Guide</h2>
            <div class="divide-y divide-slate-100">

                <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                    <span class="mt-1.5 h-2.5 w-2.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Assigned</p>
                        <p class="text-xs text-slate-400 mt-0.5">Report is assigned to you. Respond on-site and upload
                            proof when resolved.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                    <span class="mt-1.5 h-2.5 w-2.5 rounded-full bg-blue-400 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">For Verification</p>
                        <p class="text-xs text-slate-400 mt-0.5">You submitted proof. Head MITCOM is reviewing your
                            resolution.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                    <span class="mt-1.5 h-2.5 w-2.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Resolved</p>
                        <p class="text-xs text-slate-400 mt-0.5">Head MITCOM confirmed your proof. Case is officially
                            closed.</p>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <x-toast />
</body>

</html>