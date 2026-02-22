<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Management</title>
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
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-900 to-slate-900"></div>
            <div
                class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.4),transparent_55%)]">
            </div>
            <div class="absolute inset-0 bg-black/20"></div>

            <!-- Header -->
            <x-app-nav pageTitle="Report Management" />
        </div>

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6">
                        <strong class="font-semibold">Success:</strong> {{ session('success') }}
                    </div>
                @endif

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 -mt-4 relative z-10">
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Total Reports</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">{{ $reports->total() }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-slate-900/5 text-slate-700 ring-1 ring-inset ring-slate-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Pending</div>
                                <div class="text-3xl font-semibold text-yellow-600 mt-3">
                                    {{ \App\Models\Report::where('status', 'pending')->count() }}
                                </div>
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
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Verified</div>
                                <div class="text-3xl font-semibold text-blue-600 mt-3">
                                    {{ \App\Models\Report::where('status', 'verified')->count() }}
                                </div>
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
                                <div class="text-xs uppercase tracking-widest text-slate-500">Resolved</div>
                                <div class="text-3xl font-semibold text-green-600 mt-3">
                                    {{ \App\Models\Report::where('status', 'resolved')->count() }}
                                </div>
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

                <!-- Table -->
                <div x-cloak x-data="{
                    status: '{{ request('status', 'all') }}',
                    issueType: '{{ request('issue_type', 'all') }}'
                }"
                    class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden border-t-4 border-t-red-600">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">All Reports</h2>
                                <p class="text-sm text-slate-500">Filter and manage incident reports from citizens</p>
                            </div>
                        </div>

                        <!-- Filters -->
                        <form method="GET" action="{{ route('admin.reports.index') }}"
                            class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <div class="flex-1">
                                <select name="status" x-model="status"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="all">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="assigned">Assigned</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <select name="issue_type" x-model="issueType"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="all">All Types</option>
                                    <option value="traffic_signal_problem">Traffic Signal Problem</option>
                                    <option value="road_damage">Road Damage / Hazard</option>
                                    <option value="illegal_parking">Illegal Parking</option>
                                    <option value="traffic_obstruction">Traffic Obstruction</option>
                                    <option value="accident">Accident / Incident</option>
                                    <option value="traffic_violation">Traffic Violation</option>
                                    <option value="reckless_driving">Reckless Driving</option>
                                    <option value="public_safety">Public Safety Concern</option>
                                    <option value="infrastructure">Infrastructure Issue</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="px-6 py-2 rounded-xl bg-blue-700 text-white text-sm font-semibold hover:bg-blue-800 transition shadow-sm">
                                Apply Filters
                            </button>
                        </form>
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
                                        Reporter</th>
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
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($reports as $report)
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                @if($report->user)
                                                    {{ $report->user->first_name }} {{ $report->user->last_name }}
                                                @else
                                                    {{ $report->reporter_name ?? 'Guest' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ Str::limit($report->location, 30) }}
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
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right">
                                            <a href="{{ route('admin.reports.show', $report) }}"
                                                class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200 hover:bg-blue-50 transition">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                            No reports found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $reports->links() }}
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>