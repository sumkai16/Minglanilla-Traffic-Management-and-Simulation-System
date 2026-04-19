<x-app-nav title="Live Traffic Map - MITCOM Head" page-title="Live Traffic Map" page-eyebrow="Command Center">
    <main class="py-8 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 -mt-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Live Incident Map</h1>
                    <p class="text-sm text-slate-500 mt-1">Monitor incidents in real time across Minglanilla.</p>
                </div>
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm text-xs font-semibold text-slate-700">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Last updated: <span id="last-updated">--</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8">
                    <x-incident-map 
                        mapId="head-mitcom-map" 
                        heightClass="h-[520px]"
                        title="Map View"
                        :showFilters="true"
                    />
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Live Summary</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Visible</p>
                                <p class="text-2xl font-bold text-slate-900 mt-2" id="count-visible">0</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">All Reports</p>
                                <p class="text-2xl font-bold text-slate-900 mt-2" id="count-all">0</p>
                            </div>
                            <div class="rounded-xl border border-yellow-200 bg-yellow-50/40 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-yellow-700">Pending</p>
                                <p class="text-2xl font-bold text-yellow-700 mt-2" id="count-pending">0</p>
                            </div>
                            <div class="rounded-xl border border-blue-200 bg-blue-50/40 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">Verified</p>
                                <p class="text-2xl font-bold text-blue-700 mt-2" id="count-verified">0</p>
                            </div>
                            <div class="rounded-xl border border-purple-200 bg-purple-50/40 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-purple-700">Assigned</p>
                                <p class="text-2xl font-bold text-purple-700 mt-2" id="count-assigned">0</p>
                            </div>
                            <div class="rounded-xl border border-green-200 bg-green-50/40 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-green-700">Resolved</p>
                                <p class="text-2xl font-bold text-green-700 mt-2" id="count-resolved">0</p>
                            </div>
                        </div>
                    </div>



                    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Map Specifications</h3>
                        <div class="space-y-3 text-sm text-slate-600">
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-semibold text-slate-700">Coverage</span>
                                <span>Minglanilla, Cebu</span>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-semibold text-slate-700">Data Source</span>
                                <span>Incident reports database</span>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-semibold text-slate-700">Refresh Interval</span>
                                <span>Every 60 seconds</span>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-semibold text-slate-700">Map Provider</span>
                                <span>OpenStreetMap</span>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-semibold text-slate-700">Status Filters</span>
                                <span>Pending, Verified, Assigned, Resolved</span>
                            </div>
                            <div class="flex items-start justify-between gap-4">
                                <span class="font-semibold text-slate-700">Marker Style</span>
                                <span>Color-coded by status</span>
                            </div>
                        </div>
                        <div class="mt-5 rounded-xl bg-slate-50 border border-slate-200 p-4 text-xs text-slate-500">
                            Tip: Use filters to focus on urgent statuses and click markers to jump to detailed reports.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.addEventListener('reports-loaded-head-mitcom-map', function(e) {
                    updateCounts(e.detail);
                    updateLastUpdated();
                });
            });

            function updateCounts(reports) {
                const counts = {
                    pending: 0,
                    verified: 0,
                    assigned: 0,
                    resolved: 0,
                    rejected: 0,
                };

                reports.forEach(report => {
                    if (counts[report.status] !== undefined) {
                        counts[report.status] += 1;
                    }
                });

                document.getElementById('count-visible').textContent = reports.length;
                document.getElementById('count-all').textContent = reports.length;
                document.getElementById('count-pending').textContent = counts.pending;
                document.getElementById('count-verified').textContent = counts.verified;
                document.getElementById('count-assigned').textContent = counts.assigned;
                document.getElementById('count-resolved').textContent = counts.resolved;
            }

            function updateLastUpdated() {
                const now = new Date();
                const formatted = now.toLocaleString('en-PH', {
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                document.getElementById('last-updated').textContent = formatted;
            }
        </script>
    @endpush
</x-app-nav>