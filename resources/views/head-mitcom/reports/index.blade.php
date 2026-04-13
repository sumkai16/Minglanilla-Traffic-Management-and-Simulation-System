<x-app-nav title="Traffic Reports - MITCOM Head" page-title="Traffic Reports" page-eyebrow="Command Center">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $statusColors = ['pending' => 'yellow', 'verified' => 'blue', 'assigned' => 'purple', 'resolved' => 'green'];
            @endphp
            @foreach($statusColors as $status => $color)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ ucfirst($status) }}</p>
                    <p class="text-3xl font-bold text-{{ $color }}-600 mt-1">
                        {{ $stats[$status] ?? 0 }}
                    </p>
                </div>
            @endforeach
        </div>



        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">All Reports</h2>
                        <p class="text-xs text-slate-500 mt-1">Search through civilian reports and filter by status or type</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-400 font-medium px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                            {{ $reports->total() }} total reports
                        </span>
                        <a href="{{ route('head-mitcom.reports.create') }}"
                            class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm shadow-sm">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.75v12.5m6.25-6.25H5.75" />
                            </svg>
                            Report Incident
                        </a>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <form method="GET" action="{{ route('head-mitcom.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search reporter, location..." 
                            class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400">
                    </div>
                    
                    <div>
                        <select name="status" class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="all">All Statuses</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="verified" @selected(request('status') === 'verified')>Verified</option>
                            <option value="assigned" @selected(request('status') === 'assigned')>Assigned</option>
                            <option value="resolved" @selected(request('status') === 'resolved')>Resolved</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <select name="issue_type" class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600 text-ellipsis overflow-hidden">
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
                            <a href="{{ route('head-mitcom.reports.index') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50 transition" title="Clear Filters">
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
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Reporter</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Issue Type</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Location</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Status</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Date</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-400 font-mono text-xs">#{{ $report->id }}</td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $report->user?->first_name ?? $report->reporter_name ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-slate-700">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </span>
                                        @if($report->all_reporters_count > 1)
                                            <div class="flex">
                                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 ring-1 ring-blue-100">
                                                    <svg class="h-2.5 w-2.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                                    </svg>
                                                    {{ $report->all_reporters_count }} Reporters
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-[180px] truncate">
                                    {{ $report->location }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                        @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                                                        @elseif($report->status === 'verified') bg-blue-100 text-blue-700
                                                        @elseif($report->status === 'assigned') bg-purple-100 text-purple-700
                                                        @elseif($report->status === 'resolved') bg-green-100 text-green-700
                                                        @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-xs">
                                    {{ $report->created_at->format('M d, Y') }}<br>
                                    <span class="text-slate-300">{{ $report->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('head-mitcom.reports.show', $report) }}"
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
                                    No reports found.
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