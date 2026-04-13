<x-app-nav title="My Assigned Reports" page-title="My Reports" page-eyebrow="Field Operations">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Assigned</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Active</p>
                <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $stats['assigned'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">For Verification</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['for_verification'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Resolved</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['resolved'] }}</p>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Assigned Reports</h2>
                        <p class="text-xs text-slate-500 mt-1">Reports assigned to you for field resolution</p>
                    </div>
                    <span class="text-sm text-slate-400 font-medium px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                        {{ $reports->total() }} total
                    </span>
                </div>

                {{-- Filter Bar --}}
                <form method="GET" action="{{ route('enforcer.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search location, issue..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400">
                    </div>

                    <div>
                        <select name="status"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="all">All Statuses</option>
                            <option value="assigned" @selected(request('status') === 'assigned')>Assigned</option>
                            <option value="for_verification" @selected(request('status') === 'for_verification')>For Verification</option>
                            <option value="resolved" @selected(request('status') === 'resolved')>Resolved</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <select name="issue_type"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="all">All Issue Types</option>
                            <option value="traffic_signal_problem" @selected(request('issue_type') === 'traffic_signal_problem')>Traffic Signal Problem</option>
                            <option value="road_damage" @selected(request('issue_type') === 'road_damage')>Road Damage / Hazard</option>
                            <option value="illegal_parking" @selected(request('issue_type') === 'illegal_parking')>Illegal Parking</option>
                            <option value="traffic_obstruction" @selected(request('issue_type') === 'traffic_obstruction')>Traffic Obstruction</option>
                            <option value="accident" @selected(request('issue_type') === 'accident')>Accident / Incident</option>
                            <option value="traffic_violation" @selected(request('issue_type') === 'traffic_violation')>Traffic Violation</option>
                            <option value="reckless_driving" @selected(request('issue_type') === 'reckless_driving')>Reckless Driving</option>
                            <option value="public_safety" @selected(request('issue_type') === 'public_safety')>Public Safety Concern</option>
                            <option value="infrastructure" @selected(request('issue_type') === 'infrastructure')>Infrastructure Issue</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm">
                            Apply
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'issue_type']))
                            <a href="{{ route('enforcer.reports.index') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50 transition" title="Clear Filters">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">#</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Issue Type</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Location</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Reporter</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Status</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Assigned</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-400 font-mono text-xs">#{{ $report->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700">
                                        {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-[180px] truncate">
                                    {{ $report->location }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $report->user?->first_name ?? $report->attributes['reporter_name'] ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span @class([
                                        'px-2.5 py-1 rounded-full text-xs font-semibold',
                                        'bg-yellow-100 text-yellow-700' => $report->status === 'assigned',
                                        'bg-purple-100 text-purple-700' => $report->status === 'for_verification',
                                        'bg-green-100 text-green-700' => $report->status === 'resolved',
                                        'bg-red-100 text-red-700' => $report->status === 'rejected',
                                    ])>
                                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-xs">
                                    @if($report->assigned_at)
                                        {{ $report->assigned_at->format('M d, Y') }}<br>
                                        <span class="text-slate-300">{{ $report->assigned_at->diffForHumans() }}</span>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('enforcer.reports.show', $report) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition">
                                        View
                                        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-slate-300 text-sm">
                                    No reports assigned to you yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $reports->links() }}
            </div>
        </div>
    </main>

    <x-toast />
</x-app-nav>