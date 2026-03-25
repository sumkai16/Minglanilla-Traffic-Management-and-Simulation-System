<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Incident #{{ $report->id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-100 min-h-screen">
    <x-app-nav pageTitle="Incident Details" />

    <main class="max-w-6xl mx-auto px-4 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-700">Assigned Incident</p>
                            <h2 class="text-xl font-bold text-slate-900 mt-2">Report #{{ $report->id }}</h2>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold w-fit
                            @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($report->status === 'verified') bg-blue-100 text-blue-700
                            @elseif($report->status === 'assigned') bg-purple-100 text-purple-700
                            @elseif($report->status === 'resolved') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Issue Type</p>
                            <p class="text-slate-900 font-semibold">{{ ucwords(str_replace('_', ' ', $report->issue_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Assigned On</p>
                            <p class="text-slate-900 font-semibold">
                                {{ optional($report->assigned_at)->format('M d, Y h:i A') ?? 'Not available' }}
                            </p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Description</p>
                            <p class="text-slate-700 leading-relaxed">{{ $report->description }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-1">Location</p>
                            <p class="text-slate-900">{{ $report->location }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $report->latitude }}, {{ $report->longitude }}</p>
                        </div>
                    </div>

                    @if($report->image_path)
                        <div class="mt-5 pt-5 border-t border-slate-100">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">Photo Evidence</p>
                            <img src="{{ Storage::url($report->image_path) }}"
                                alt="Incident photo"
                                class="rounded-xl shadow max-h-80 object-cover w-full" />
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Location on Map</h2>
                    <div id="report-map" class="w-full h-80 rounded-xl border border-slate-200 z-0"></div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-purple-200 p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-4">Assignment Summary</h2>
                    <div class="space-y-4 text-sm">
                        <div class="rounded-xl bg-purple-50 border border-purple-100 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-purple-500">Assigned Enforcer</p>
                            <p class="text-slate-900 font-semibold mt-1">
                                {{ $report->assignedEnforcer?->first_name }} {{ $report->assignedEnforcer?->last_name }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Assignment Status</p>
                            <p class="text-slate-700 mt-1">This incident is currently part of your active workload.</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Verified By</p>
                            <p class="text-slate-900 mt-1">
                                {{ $report->verifier?->first_name ? $report->verifier->first_name . ' ' . $report->verifier->last_name : 'Not available' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-4">Reporter Information</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Name</p>
                            <p class="text-slate-900 font-medium mt-1">
                                {{ $report->user ? $report->user->first_name . ' ' . $report->user->last_name : ($report->reporter_name ?? 'Guest') }}
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

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-3">Response Notes</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Review the incident details carefully before coordinating a field response. Keep your profile information updated so assignment notices and follow-up communication remain uninterrupted.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('report-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                .addTo(map)
                .bindPopup('<b>{{ ucwords(str_replace("_", " ", $report->issue_type)) }}</b><br>{{ addslashes($report->location) }}')
                .openPopup();
        });
    </script>
</body>

</html>
