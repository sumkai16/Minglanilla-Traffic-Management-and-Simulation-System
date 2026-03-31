<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD

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
=======
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Detail</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
<div class="min-h-screen">
    <x-app-nav pageTitle="Report Detail" />
    <main class="py-8 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('enforcer.reports.index') }}"
               class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 mb-4">
                ← Back to Reports
            </a>

            <!-- Report Info -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-4 -mt-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">{{ $report->title ?? $report->issue_type }}</h2>
                    <span @class([
                        'text-xs font-semibold px-3 py-1 rounded-full',
                        'bg-yellow-100 text-yellow-700' => $report->status === 'assigned',
                        'bg-blue-100 text-blue-700' => $report->status === 'for_verification',
                        'bg-green-100 text-green-700' => $report->status === 'resolved',
                    ])>
                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                    </span>
                </div>
                <dl class="space-y-2 text-sm">
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Issue Type</dt>
                        <dd class="text-slate-800 font-medium">{{ $report->issue_type }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Location</dt>
                        <dd class="text-slate-800">{{ $report->location }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Description</dt>
                        <dd class="text-slate-800">{{ $report->description }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Assigned</dt>
                        <dd class="text-slate-800">{{ $report->assigned_at ? \Carbon\Carbon::parse($report->assigned_at)->format('M d, Y h:i A') : '—' }}</dd>
                    </div>
                </dl>

                @if($report->image_path)
                    <div class="mt-4">
                        <p class="text-xs text-slate-500 mb-2">Incident Photo</p>
                        <img src="{{ Storage::url($report->image_path) }}" class="rounded-xl max-h-64 object-cover">
                    </div>
                @endif
            </div>

            <!-- Action Section -->
            @if($report->status === 'assigned')
                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-800 mb-1">Submit Proof of Resolution</h3>
                    <p class="text-sm text-slate-500 mb-4">Upload a photo proving the issue has been resolved. Head MITCOM will verify it.</p>
                    <form action="{{ route('enforcer.reports.proof', $report) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Proof Photo <span class="text-red-500">*</span></label>
                            <input type="file" name="proof_image" accept="image/*"
                                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('proof_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition">
                            Submit for Verification
                        </button>
                    </form>
                </div>

            @elseif($report->status === 'for_verification')
                <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6 text-center">
                    <p class="text-blue-700 font-semibold">Proof Submitted</p>
                    <p class="text-blue-600 text-sm mt-1">Awaiting Head MITCOM verification.</p>
                    @if($report->proof_image)
                        <img src="{{ Storage::url($report->proof_image) }}" class="rounded-xl max-h-48 object-cover mx-auto mt-4">
                    @endif
                </div>

            @elseif($report->status === 'resolved')
                <div class="bg-green-50 rounded-2xl border border-green-200 p-6 text-center">
                    <p class="text-green-700 font-semibold">✓ Report Resolved</p>
                    <p class="text-green-600 text-sm mt-1">Verified by Head MITCOM on {{ \Carbon\Carbon::parse($report->resolved_at)->format('M d, Y') }}.</p>
                    @if($report->proof_image)
                        <img src="{{ Storage::url($report->proof_image) }}" class="rounded-xl max-h-48 object-cover mx-auto mt-4">
                    @endif
                </div>
            @endif

        </div>
    </main>
</div>
<x-toast />
</body>
</html>
>>>>>>> 1d914ef388f56be386049aad752c94290edbb82c
