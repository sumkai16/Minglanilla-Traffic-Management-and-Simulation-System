<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
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
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">

        <x-app-nav pageTitle="My Dashboard">
            <a href="{{ route('user.reports.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white text-sm font-semibold hover:bg-blue-400 transition">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10 5.75a.75.75 0 01.75.75v2.75h2.75a.75.75 0 010 1.5h-2.75v2.75a.75.75 0 01-1.5 0v-2.75H6.5a.75.75 0 010-1.5h2.75V6.5A.75.75 0 0110 5.75z" />
                </svg>
                Report Incident

            </a>

        </x-app-nav>

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Welcome Card -->
                <div class="bg-white shadow-sm rounded-2xl border border-blue-100 p-6 mb-6 -mt-4 relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Welcome back,
                                {{ auth()->user()->first_name }}!</h2>
                            <p class="text-blue-700/80 text-sm mt-1">Track your incident reports and view their status</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600">{{ $reports->total() }}</div>
                            <div class="text-xs text-blue-700/70 uppercase tracking-wider mt-1">Total Reports</div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Pending</div>
                                <div class="text-3xl font-semibold text-yellow-600 mt-3">{{ $pendingCount }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Verified</div>
                                <div class="text-3xl font-semibold text-blue-600 mt-3">{{ $verifiedCount }}</div>
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
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Resolved</div>
                                <div class="text-3xl font-semibold text-green-600 mt-3">{{ $resolvedCount }}</div>
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
                </div>
                @if(session('success'))
                    <div
                        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-lg mb-6 shadow-sm animate-fade-in">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <strong class="font-semibold">Success!</strong>
                                <span class="block text-sm mt-0.5">{{ session('success') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Reports Table -->
                <div
                    class="bg-white shadow-sm rounded-2xl border border-blue-100 overflow-hidden border-t-4 border-t-blue-600">
                    <div class="px-6 py-5 border-b border-blue-100">
                        <h2 class="text-lg font-semibold text-slate-900">My Reports</h2>
                        <p class="text-sm text-blue-700/70 mt-1">View all your submitted incident reports</p>
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
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Submitted</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($reports as $report)
                                    <tr class="hover:bg-slate-50/70 transition cursor-pointer"
                                        onclick="window.location='{{ route('user.reports.show', $report) }}'">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ Str::limit($report->location, 40) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full ring-1 ring-inset
                                                                                                        @if($report->status === 'pending') bg-yellow-50 text-yellow-800 ring-yellow-200
                                                                                                        @elseif($report->status === 'verified') bg-blue-50 text-blue-800 ring-blue-200
                                                                                                        @elseif($report->status === 'assigned') bg-purple-50 text-purple-800 ring-purple-200
                                                                                                        @elseif($report->status === 'resolved') bg-green-50 text-green-800 ring-green-200
                                                                                                        @elseif($report->status === 'rejected') bg-red-50 text-red-800 ring-red-200
                                                                                                        @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $report->created_at->format('M d, Y') }}
                                            <br>
                                            <span
                                                class="text-xs text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-slate-400 mb-2">
                                                <svg class="h-12 w-12 mx-auto" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">No reports yet</p>
                                            <p class="text-sm text-slate-400 mt-1">Submit your first incident report to get
                                                started</p>
                                            <a href="{{ route('user.reports.create') }}"
                                                class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                Report Incident
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($reports->hasPages())
                        <div class="px-6 py-4 border-t border-blue-100">
                            {{ $reports->links() }}
                        </div>
                    @endif
                </div>

                <!-- Live Map -->
                <div class="relative overflow-hidden bg-white shadow-xl rounded-2xl p-6 mt-6 border border-blue-100">
                    <div class="absolute inset-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_top_left,rgba(59,130,246,0.25),transparent_55%),radial-gradient(circle_at_bottom_right,rgba(14,165,233,0.2),transparent_55%)]"></div>
                    <div class="relative">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900">Live Traffic Map</h3>
                                <p class="text-sm text-blue-700/80">Browse live incidents around Minglanilla</p>
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
                            <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-blue-500/10 via-transparent to-cyan-500/10"></div>
                            <div id="user-map" class="w-full h-[420px]"></div>
                            <div class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700 shadow">
                                Live Map
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('user-map')) {
                initPublicMap('user-map');
            }
        });
    </script>
</body>

</html>
