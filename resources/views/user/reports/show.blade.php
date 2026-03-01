<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">
        
        <x-app-nav pageTitle="Report #{{ $report->id }}" />

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Report Details -->
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 -mt-4 relative z-10">
                            <h2 class="text-xl font-bold text-slate-900 mb-4">Report Details</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-500">Issue Type</label>
                                    <p class="mt-1 text-lg text-slate-900">{{ ucwords(str_replace('_', ' ', $report->issue_type)) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-500">Description</label>
                                    <p class="mt-1 text-slate-900">{{ $report->description }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-500">Location</label>
                                    <p class="mt-1 text-slate-900">{{ $report->location }}</p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Coordinates: {{ $report->latitude }}, {{ $report->longitude }}
                                    </p>
                                </div>

                                @if($report->image_path)
                                    <div>
                                        <label class="block text-sm font-medium text-slate-500 mb-2">Photo Evidence</label>
                                        <img src="{{ Storage::url($report->image_path) }}" alt="Report evidence" class="rounded-lg shadow-md max-w-md">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                            <h2 class="text-xl font-bold text-slate-900 mb-4">Location on Map</h2>
                            <div id="report-map" class="w-full h-[400px] rounded-lg border-2 border-slate-200"></div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6 -mt-4 lg:mt-0">
                        
                        <!-- Status Card -->
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900 mb-4">Status</h2>
                            
                            <div class="mb-4">
                                <span class="px-3 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($report->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($report->status === 'verified') bg-blue-100 text-blue-800
                                    @elseif($report->status === 'assigned') bg-purple-100 text-purple-800
                                    @elseif($report->status === 'resolved') bg-green-100 text-green-800
                                    @elseif($report->status === 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>

                            <div class="text-sm text-slate-600">
                                @if($report->status === 'pending')
                                    <p>Your report is under review by our team.</p>
                                @elseif($report->status === 'verified')
                                    <p>Your report has been verified and is being processed.</p>
                                @elseif($report->status === 'assigned')
                                    <p>An enforcer has been assigned to this incident.</p>
                                @elseif($report->status === 'resolved')
                                    <p class="text-green-700 font-medium">This incident has been resolved. Thank you for reporting!</p>
                                @elseif($report->status === 'rejected')
                                    <p class="text-red-700">This report was rejected. It may be a duplicate or invalid.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Submission Info -->
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900 mb-4">Submission Info</h2>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-500">Submitted</label>
                                    <p class="mt-1 text-slate-900">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-sm text-slate-500">{{ $report->created_at->diffForHumans() }}</p>
                                </div>

                                @if($report->verified_at)
                                    <div>
                                        <label class="block text-sm font-medium text-slate-500">Last Updated</label>
                                        <p class="mt-1 text-slate-900">{{ $report->verified_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('report-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                .addTo(map)
                .bindPopup(`
                    <div class="p-2">
                        <h3 class="font-bold">{{ ucwords(str_replace('_', ' ', $report->issue_type)) }}</h3>
                        <p class="text-sm">{{ $report->location }}</p>
                    </div>
                `).openPopup();
        });
    </script>
</body>

</html>