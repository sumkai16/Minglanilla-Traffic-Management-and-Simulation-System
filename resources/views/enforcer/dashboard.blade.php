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

<<<<<<< HEAD
                <!-- Welcome Card -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 mb-6 -mt-4 relative z-10">
                    <h2 class="text-lg font-semibold text-slate-900">Welcome, {{ auth()->user()->first_name }}!</h2>
                    <p class="text-slate-600 text-sm mt-1">Monitor your assignments and keep track of incident updates.</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                        <div class="text-xs uppercase tracking-widest text-slate-500">Total Assigned</div>
                        <div class="text-3xl font-semibold text-slate-900 mt-3">{{ $assignedCount }}</div>
                        <p class="text-xs text-slate-400 mt-2">All assignments from Head MITCOM</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                        <div class="text-xs uppercase tracking-widest text-slate-500">Active Assigned</div>
                        <div class="text-3xl font-semibold text-purple-600 mt-3">{{ $activeCount }}</div>
                        <p class="text-xs text-slate-400 mt-2">Currently in progress</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                        <div class="text-xs uppercase tracking-widest text-slate-500">Resolved</div>
                        <div class="text-3xl font-semibold text-green-600 mt-3">{{ $resolvedCount }}</div>
                        <p class="text-xs text-slate-400 mt-2">Completed incidents</p>
                    </div>
                </div>

                <!-- Assigned Incidents -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden mb-6">
                    <div class="px-6 py-5 border-b border-slate-200 bg-purple-50">
                        <h2 class="text-lg font-semibold text-slate-900">Assigned Incidents</h2>
                        <p class="text-sm text-slate-500 mt-1">Assigned by Head MITCOM</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Issue Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Reporter</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Assigned</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($currentAssigned as $report)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($report->location, 35) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $report->user ? $report->user->first_name . ' ' . $report->user->last_name : ($report->reporter_name ?? 'Guest') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ optional($report->assigned_at)->format('M d, Y') ?? $report->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('enforcer.reports.show', $report) }}"
                                                class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                            No assigned incidents yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Live Map -->
                <div class="relative overflow-hidden bg-white shadow-xl rounded-2xl p-6 mb-6 border border-blue-100">
                    <div class="absolute inset-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_top_left,rgba(59,130,246,0.25),transparent_55%),radial-gradient(circle_at_bottom_right,rgba(20,184,166,0.25),transparent_55%)]"></div>
                    <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                    <div class="relative">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900">Live Viewing Map</h3>
                                <p class="text-sm text-blue-700/80">Real-time reports across Minglanilla</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 border border-blue-100">
                                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                    Verified
                                </span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-yellow-50 px-3 py-1 border border-yellow-100">
                                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                    Pending
                                </span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1 border border-green-100">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    Resolved
                                </span>
                            </div>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-inner">
                            <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-blue-500/10 via-transparent to-teal-500/10"></div>
                            <div id="enforcer-map" class="w-full h-[420px]"></div>
                            <div class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700 shadow">
                                Live Map
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignment History -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-900">History of Assigned Incidents</h2>
                        <p class="text-sm text-slate-500 mt-1">Resolved or rejected assignments</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Issue Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Assigned</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($assignmentHistory as $report)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($report->location, 35) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full ring-1 ring-inset
                                                @if($report->status === 'resolved') bg-green-50 text-green-800 ring-green-200
                                                @elseif($report->status === 'rejected') bg-red-50 text-red-800 ring-red-200
                                                @else bg-slate-50 text-slate-700 ring-slate-200
                                                @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ optional($report->assigned_at)->format('M d, Y') ?? $report->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('enforcer.reports.show', $report) }}"
                                                class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 transition">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                            No assignment history yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
=======
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
>>>>>>> 1d914ef388f56be386049aad752c94290edbb82c
                    </div>
                </div>

            </div>
<<<<<<< HEAD
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('enforcer-map') && typeof window.initPublicMap === 'function') {
                window.initPublicMap('enforcer-map');
            }
        });
    </script>
=======
        </div>

    </main>

    <x-toast />
>>>>>>> 1d914ef388f56be386049aad752c94290edbb82c
</body>

</html>
