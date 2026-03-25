<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report #{{ $report->id }} - MITCOM Head</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-100 min-h-screen">

    <x-app-nav pageTitle="Report #{{ $report->id }}">
        <a href="{{ route('head-mitcom.reports.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 transition">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"/>
            </svg>
            All Reports
        </a>
        </x-app-nav>

        <main class="max-w-6xl mx-auto px-4 lg:px-8 py-8">
        
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left Column --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Details Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-5">Report Details</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Issue Type
                                </p>
                                <p class="text-slate-900 font-semibold">
                                    {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Status</p>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($report->status === 'verified') bg-blue-100 text-blue-700
                            @elseif($report->status === 'assigned') bg-purple-100 text-purple-700
                            @elseif($report->status === 'resolved') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Description
                                </p>
                                <p class="text-slate-700 leading-relaxed">{{ $report->description }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Location
                                </p>
                                <p class="text-slate-900">{{ $report->location }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $report->latitude }},
                                    {{ $report->longitude }}
                                </p>
                            </div>
                        </div>

                        @if($report->image_path)
                            <div class="mt-5 pt-5 border-t border-slate-100">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">Photo Evidence
                                </p>
                                <img src="{{ Storage::url($report->image_path) }}"
                                    class="rounded-xl shadow max-h-72 object-cover w-full" />
                            </div>
                        @endif
                    </div>

                    {{-- Map Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">Location on Map</h2>
                        <div id="report-map" class="w-full h-72 rounded-xl border border-slate-200 z-0"></div>
                    </div>
                </div>

                {{-- Right Sidebar --}}
                <div class="space-y-5">

                    {{-- Verify / Reject --}}
                    @if($report->status === 'pending')
                        <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-6">
                            <h2 class="text-base font-bold text-slate-900 mb-1">Action Required</h2>
                            <p class="text-sm text-slate-500 mb-4">Review and verify or reject this report.</p>
                            <div class="flex gap-3">
                                <form method="POST" action="{{ route('head-mitcom.reports.verify', $report) }}" class="flex-1">
                                    @csrf
                                    <button class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"/>
                                        </svg>
                                        Verify
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('head-mitcom.reports.reject', $report) }}" class="flex-1">
                                    @csrf
                                    <button class="w-full inline-flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                    {{-- Assignment --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-base font-bold text-slate-900 mb-4">Assignment</h2>

                        @if($report->status === 'verified')
                            <form method="POST" action="{{ route('head-mitcom.reports.assign', $report) }}">
                                @csrf
                                <p class="text-xs text-slate-500 mb-2">Select an enforcer to handle this report.</p>
                                <select name="enforcer_id" required
                                    class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm mb-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                                    <option value="">Select enforcer...</option>
                                    @foreach($enforcers as $enforcer)
                                        <option value="{{ $enforcer->id }}">
                                            {{ $enforcer->first_name }} {{ $enforcer->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                                    Assign Report
                                </button>
                            </form>

                        @elseif($report->status === 'assigned')
                            <div class="mb-4 p-3 bg-purple-50 rounded-xl border border-purple-200">
                                <p class="text-xs text-purple-500 font-medium">Currently assigned to</p>
                                <p class="font-bold text-purple-900 mt-0.5">
                                    {{ $report->assignedEnforcer?->first_name }} {{ $report->assignedEnforcer?->last_name }}
                                </p>
                                <p class="text-xs text-purple-400 mt-1">{{ $report->assigned_at?->diffForHumans() }}</p>
                            </div>
                            <form method="POST" action="{{ route('head-mitcom.reports.reassign', $report) }}">
                                @csrf
                                <select name="enforcer_id" required
                                    class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm mb-3">
                                    <option value="">Reassign to...</option>
                                    @foreach($enforcers as $enforcer)
                                        <option value="{{ $enforcer->id }}" {{ $report->assigned_to == $enforcer->id ? 'selected' : '' }}>
                                            {{ $enforcer->first_name }} {{ $enforcer->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button
                                    class="w-full bg-slate-700 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                                    Reassign
                                </button>
                            </form>

                        @elseif($report->status === 'resolved')
                            <div class="text-center py-4">
                                <div
                                    class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-green-800">Resolved</p>
                                <p class="text-xs text-green-600 mt-1">This report has been resolved.</p>
                            </div>

                        @else
                            <p class="text-sm text-slate-400 text-center py-4">
                                No assignment available for status: <span class="font-medium">{{ $report->status }}</span>
                            </p>
                        @endif
                    </div>

                    {{-- Reporter Info --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-base font-bold text-slate-900 mb-4">Reporter Info</h2>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Name</p>
                                <p class="text-slate-900 font-medium mt-1">
                                    {{ $report->user
    ? $report->user->first_name . ' ' . $report->user->last_name
    : ($report->reporter_name ?? 'Guest') }}
                                </p>
                            </div>
                            @if($report->reporter_email)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</p>
                                    <p class="text-slate-700 mt-1">{{ $report->reporter_email }}</p>
                                </div>
                            @endif
                            @if($report->reporter_phone)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</p>
                                    <p class="text-slate-700 mt-1">{{ $report->reporter_phone }}</p>
                                </div>
                            @endif
                            <div class="pt-2 border-t border-slate-100">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Submitted</p>
                                <p class="text-slate-900 mt-1">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                                <p class="text-xs text-slate-400">{{ $report->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const map = L.map('report-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors', maxZoom: 19
                }).addTo(map);
                L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                    .addTo(map)
                    .bindPopup('<b>{{ ucwords(str_replace("_", " ", $report->issue_type)) }}</b><br>{{ $report->location }}')
                    .openPopup();
            });
        </script>
  <x-toast />
</body>

</html>