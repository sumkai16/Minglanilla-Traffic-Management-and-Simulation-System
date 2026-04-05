<x-app-nav title="Report #{{ $report->id }}" page-title="Report #{{ $report->id }}"
    page-eyebrow="Public Reporting">
    <main class="py-12 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-blue-200/40 via-blue-50 to-transparent"></div>
            <div class="absolute -z-10 -top-16 -right-24 h-72 w-72 rounded-full bg-blue-200/30 blur-3xl"></div>
            <div class="absolute -z-10 top-24 -left-24 h-72 w-72 rounded-full bg-cyan-200/30 blur-3xl"></div>
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Report Details -->
                        <div class="bg-white shadow-sm rounded-3xl border border-blue-100 overflow-hidden -mt-4 relative z-10">
                            <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50">
                                <div class="flex items-center gap-3">
                                    <span class="h-10 w-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M4 4.75A1.75 1.75 0 015.75 3h5.586c.464 0 .91.184 1.237.513l3.914 3.914c.329.327.513.773.513 1.237v6.586A1.75 1.75 0 0114.25 17h-8.5A1.75 1.75 0 014 15.25V4.75z" />
                                            <path d="M12 3.5V7a.75.75 0 00.75.75H16" />
                                        </svg>
                                    </span>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-900">Report Details</h2>
                                        <p class="text-sm text-slate-500 mt-1">Summary of your submitted incident</p>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-500 mt-1">Summary of your submitted incident</p>
                            </div>
                            <div class="p-6 space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                        <label class="block text-xs font-semibold uppercase tracking-widest text-slate-500">Issue Type</label>
                                        <p class="mt-2 text-lg font-semibold text-slate-900">{{ ucwords(str_replace('_', ' ', $report->issue_type)) }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                        <label class="block text-xs font-semibold uppercase tracking-widest text-slate-500">Location</label>
                                        <p class="mt-2 text-slate-900">{{ $report->location }}</p>
                                        <p class="mt-1 text-xs text-slate-500">Coordinates: {{ $report->latitude }}, {{ $report->longitude }}</p>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-slate-500">Description</label>
                                    <p class="mt-2 text-slate-900">{{ $report->description }}</p>
                                </div>

                                @if($report->image_path)
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-widest text-slate-500 mb-3">Photo Evidence</label>
                                        <img src="{{ Storage::url($report->image_path) }}" alt="Report evidence" class="rounded-2xl border border-slate-200 shadow-sm w-full max-w-2xl">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="bg-white shadow-sm rounded-3xl border border-blue-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50">
                                <div class="flex items-center gap-3">
                                    <span class="h-10 w-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 2a6 6 0 00-6 6c0 3.73 3.2 7.308 5.106 9.102a1.25 1.25 0 001.788 0C12.8 15.308 16 11.73 16 8a6 6 0 00-6-6zm0 8.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-900">Location on Map</h2>
                                        <p class="text-sm text-slate-500 mt-1">Pinned to your reported coordinates</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-inner">
                                    <div id="report-map" class="w-full h-[420px]"></div>
                                    <div class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700 shadow">
                                        Report Location
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6 -mt-4 lg:mt-0 lg:sticky lg:top-24 lg:self-start">
                        
                        <!-- Status Card -->
                        <div class="bg-white shadow-sm rounded-3xl border border-blue-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50">
                                <div class="flex items-center gap-3">
                                    <span class="h-9 w-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-900">Status</h2>
                                        <p class="text-sm text-slate-500 mt-1">Current review stage</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
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

                                <div class="mt-5 space-y-3">
                                    <div class="flex items-center gap-3">
                                        <span class="h-2.5 w-2.5 rounded-full {{ in_array($report->status, ['pending','verified','assigned','resolved'], true) ? 'bg-blue-600' : 'bg-slate-300' }}"></span>
                                        <span class="text-xs uppercase tracking-widest text-slate-500">Submitted</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="h-2.5 w-2.5 rounded-full {{ in_array($report->status, ['verified','assigned','resolved'], true) ? 'bg-blue-600' : 'bg-slate-300' }}"></span>
                                        <span class="text-xs uppercase tracking-widest text-slate-500">Verified</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="h-2.5 w-2.5 rounded-full {{ in_array($report->status, ['assigned','resolved'], true) ? 'bg-blue-600' : 'bg-slate-300' }}"></span>
                                        <span class="text-xs uppercase tracking-widest text-slate-500">Assigned</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $report->status === 'resolved' ? 'bg-emerald-600' : 'bg-slate-300' }}"></span>
                                        <span class="text-xs uppercase tracking-widest text-slate-500">Resolved</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submission Info -->
                        <div class="bg-white shadow-sm rounded-3xl border border-blue-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-50 via-white to-blue-50">
                                <div class="flex items-center gap-3">
                                    <span class="h-9 w-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M6 2.5a.75.75 0 01.75.75V4h6.5v-.75a.75.75 0 011.5 0V4h.75A1.75 1.75 0 0117.25 5.75v8.5A1.75 1.75 0 0115.5 16H4.5A1.75 1.75 0 012.75 14.25v-8.5A1.75 1.75 0 014.5 4H5v-.75A.75.75 0 016 2.5zm-.75 6a.75.75 0 100 1.5h9.5a.75.75 0 000-1.5h-9.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-900">Submission Info</h2>
                                        <p class="text-sm text-slate-500 mt-1">Timeline details</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                    <label class="block text-xs font-semibold uppercase tracking-widest text-slate-500">Submitted</label>
                                    <p class="mt-2 text-slate-900">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-sm text-slate-500">{{ $report->created_at->diffForHumans() }}</p>
                                </div>

                                @if($report->verified_at)
                                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                        <label class="block text-xs font-semibold uppercase tracking-widest text-slate-500">Last Updated</label>
                                        <p class="mt-2 text-slate-900">{{ $report->verified_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </main>

    @push('scripts')
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
    @endpush
</x-app-nav>
