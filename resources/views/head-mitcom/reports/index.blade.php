<x-app-nav title="Traffic Reports - MITCOM Head" page-title="Traffic Reports" page-eyebrow="Command Center">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $statuses = ['pending' => 'yellow', 'verified' => 'blue', 'assigned' => 'purple', 'resolved' => 'green'];
            @endphp
            @foreach($statuses as $status => $color)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ ucfirst($status) }}</p>
                    <p class="text-3xl font-bold text-{{ $color }}-600 mt-1">
                        {{ $reports->where('status', $status)->count() }}
                    </p>
                </div>
            @endforeach
        </div>



        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">All Reports</h2>
                <span class="text-sm text-slate-400">{{ $reports->total() }} total</span>
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