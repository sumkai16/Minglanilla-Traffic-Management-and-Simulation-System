<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MITCOM Head Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <x-app-nav pageTitle="MITCOM Head Dashboard" />

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6 -mt-4 relative z-10">
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Total Reports</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">{{ $totalReports }}</div>
                            </div>
                            <div class="h-10 w-10 rounded-xl bg-slate-900/5 flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-700" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                                    <path fill-rule="evenodd"
                                        d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Verified</div>
                                <div class="text-3xl font-semibold text-blue-600 mt-3">{{ $verifiedReports }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Assigned</div>
                                <div class="text-3xl font-semibold text-purple-600 mt-3">{{ $assignedReports }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-purple-50 text-purple-700 ring-1 ring-inset ring-purple-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0zm-8 5.5c0-.83.414-1.56 1.046-2H5a3 3 0 00-3 3v.5h3v-.5zm5 0v.5h3v-.5a3 3 0 00-3-3h-2.046A2.5 2.5 0 0111 13.5z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Resolved</div>
                                <div class="text-3xl font-semibold text-green-600 mt-3">{{ $resolvedReports }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-green-50 text-green-700 ring-1 ring-inset ring-green-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Enforcers</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">{{ $activeEnforcers }}</div>
                            </div>
                            <div class="h-10 w-10 rounded-xl bg-slate-900/5 flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-700" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zm8 0a3 3 0 11-6 0 3 3 0 016 0zm-4.07 11c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <a href="{{ route('head-mitcom.reports.index') }}"
                        class="block p-4 bg-white border border-slate-200 rounded-xl hover:border-blue-500 hover:shadow-md hover:-translate-y-0.5 transition group">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-lg bg-slate-900/5 group-hover:bg-blue-50 flex items-center justify-center transition">
                                <svg class="h-5 w-5 text-slate-700 group-hover:text-blue-700" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                                    <path fill-rule="evenodd"
                                        d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-semibold text-slate-900">View All Reports</div>
                        </div>
                        <div class="text-sm text-slate-500">Manage and assign incidents</div>
                    </a>

                    <a href="{{ route('head-mitcom.enforcers.index') }}"
                        class="block p-4 bg-white border border-slate-200 rounded-xl hover:border-blue-500 hover:shadow-md hover:-translate-y-0.5 transition group">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-lg bg-slate-900/5 group-hover:bg-blue-50 flex items-center justify-center transition">
                                <svg class="h-5 w-5 text-slate-700 group-hover:text-blue-700" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zm8 0a3 3 0 11-6 0 3 3 0 016 0zm-4.07 11c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <div class="font-semibold text-slate-900">Manage Enforcers</div>
                        </div>
                        <div class="text-sm text-slate-500">View enforcer workload and assignments</div>
                    </a>

                    <a href="#"
                        class="block p-4 bg-white border border-slate-200 rounded-xl hover:border-blue-500 hover:shadow-md hover:-translate-y-0.5 transition group">
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-lg bg-slate-900/5 group-hover:bg-blue-50 flex items-center justify-center transition">
                                <svg class="h-5 w-5 text-slate-700 group-hover:text-blue-700" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 1a.75.75 0 01.75.75V6h4.5V1.75a.75.75 0 011.5 0V6h1.25A2.75 2.75 0 0118.75 8.75v8.5A2.75 2.75 0 0116 20.25H4A2.75 2.75 0 011.25 17.25v-8.5A2.75 2.75 0 014 6h1.25V1.75A.75.75 0 018 1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-semibold text-slate-900">Live Traffic Map</div>
                        </div>
                        <div class="text-sm text-slate-500">View all incidents on map</div>
                    </a>
                </div>

                <!-- Recent Verified Reports (Ready for Assignment) -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden mb-6">
                    <div class="px-6 py-5 border-b border-slate-200 bg-blue-50">
                        <h2 class="text-lg font-semibold text-slate-900">Verified Reports - Ready for Assignment</h2>
                        <p class="text-sm text-slate-500 mt-1">{{ $verifiedReports }} reports waiting to be assigned</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Issue Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Location</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Reporter</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($recentVerified as $report)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($report->location, 30) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($report->user)
                                                {{ $report->user->first_name }} {{ $report->user->last_name }}
                                            @else
                                                {{ $report->reporter_name ?? 'Guest' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $report->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('head-mitcom.reports.show', $report->id) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                                Assign →
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
                </div>

                <!-- Recent Assigned Reports -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-purple-50">
                        <h2 class="text-lg font-semibold text-slate-900">Recently Assigned Reports</h2>
                        <p class="text-sm text-slate-500 mt-1">Track enforcer assignments</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Issue Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Location</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Assigned To</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Assigned</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($recentAssigned as $report)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($report->location, 30) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($report->assignedEnforcer)
                                                {{ $report->assignedEnforcer->first_name }}
                                                {{ $report->assignedEnforcer->last_name }}
                                            @else
                                                <span class="text-slate-400">Not assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('head-mitcom.reports.show', $report->id) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                                View →
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
                </div>

            </div>
        </main>
    </div>
</body>

</html>