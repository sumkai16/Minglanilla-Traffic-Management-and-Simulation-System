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
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <x-app-nav pageTitle="Enforcer Dashboard" />

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('enforcer-map') && typeof window.initPublicMap === 'function') {
                window.initPublicMap('enforcer-map');
            }
        });
    </script>
</body>

</html>
