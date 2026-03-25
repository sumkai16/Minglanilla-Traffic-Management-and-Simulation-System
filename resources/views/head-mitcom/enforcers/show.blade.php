<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $enforcer->first_name }} {{ $enforcer->last_name }} - MITCOM Head</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

    <x-app-nav pageTitle="Enforcer Profile">
        <a href="{{ route('head-mitcom.enforcers.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 transition">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" />
            </svg>
            All Enforcers
        </a>
    </x-app-nav>

    <main class="max-w-6xl mx-auto px-4 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Sidebar --}}
            <div class="space-y-5">

                {{-- Profile Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    {{-- Cover --}}
                    <div class="h-20 w-full mb-5"
                        style="background: linear-gradient(135deg, #1d4ed8, #1e3a5f, #0f172a);">
                    </div>
                    {{-- Avatar --}}
                    <div class="px-6 pb-10 mb-5">
                        <div class="flex items-end gap-4 -mt-8 mb-4 ">
                            <div
                                class="h-16 w-16 rounded-2xl border-4 border-white shadow-md bg-gradient-to-br from-blue-700 to-slate-900 flex items-center justify-center text-white text-xl font-bold shrink-0">
                                {{ strtoupper(substr($enforcer->first_name, 0, 1)) }}{{ strtoupper(substr($enforcer->last_name, 0, 1)) }}
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">
                            {{ $enforcer->first_name }} {{ $enforcer->last_name }}
                        </h2>
                        <p class="text-sm text-slate-400 mt-0.5">Traffic Enforcer</p>

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="h-4 w-4 text-slate-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                    <path
                                        d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                </svg>
                                {{ $enforcer->email }}
                            </div>
                            <div class="flex items-center gap-2 text-slate-600">
                                <svg class="h-4 w-4 text-slate-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" />
                                </svg>
                                Joined {{ $enforcer->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stats Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wide">Performance</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-500">Total Assigned</span>
                                <span class="font-bold text-slate-900">{{ $assignedReports->total() }}</span>
                            </div>
                            <div class="h-1.5 bg-slate-100 rounded-full">
                                <div class="h-1.5 bg-blue-500 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-500">Resolved</span>
                                <span class="font-bold text-green-600">
                                    {{ $enforcer->assignedReports()->where('status', 'resolved')->count() }}
                                </span>
                            </div>
                            @php
                                $total = $assignedReports->total();
                                $resolved = $enforcer->assignedReports()->where('status', 'resolved')->count();
                                $pct = $total > 0 ? round(($resolved / $total) * 100) : 0;
                            @endphp
                            <div class="h-1.5 bg-slate-100 rounded-full">
                                <div class="h-1.5 bg-green-500 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-500">Pending</span>
                                <span class="font-bold text-yellow-600">
                                    {{ $enforcer->assignedReports()->where('status', 'assigned')->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Assigned Reports --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900">Assigned Reports</h2>
                        <span class="text-sm text-slate-400">{{ $assignedReports->total() }} total</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="text-left px-6 py-3 font-semibold text-slate-500">#</th>
                                    <th class="text-left px-6 py-3 font-semibold text-slate-500">Issue</th>
                                    <th class="text-left px-6 py-3 font-semibold text-slate-500">Location</th>
                                    <th class="text-left px-6 py-3 font-semibold text-slate-500">Status</th>
                                    <th class="text-left px-6 py-3 font-semibold text-slate-500">Assigned</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($assignedReports as $report)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-slate-400 font-mono text-xs">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 max-w-[160px] truncate">
                                            {{ $report->location }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                                                                @if($report->status === 'assigned') bg-purple-100 text-purple-700
                                                                                                @elseif($report->status === 'resolved') bg-green-100 text-green-700
                                                                                                @else bg-slate-100 text-slate-500 @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-400 text-xs">
                                            {{ $report->assigned_at?->format('M d, Y') ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-slate-300 text-sm">
                                            No reports assigned yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $assignedReports->links() }}
                    </div>
                </div>
            </div>

        </div>
    </main>

    <x-toast />
</body>

</html>