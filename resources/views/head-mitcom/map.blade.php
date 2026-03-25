<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Traffic Map - MITCOM Head</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <x-app-nav pageTitle="Live Traffic Map" />

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
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-200">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-900">Map View</h2>
                                        <p class="text-sm text-slate-500 mt-1">Click markers to view report details</p>
                                    </div>
                                    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">
                                        Powered by the same live map as the Citizen dashboard
                                    </div>
                                </div>
                            </div>

                            <div id="head-mitcom-map"
                                class="w-full"
                                style="height: 520px; min-height: 520px;">
                                <div id="map-fallback-message" class="flex items-center justify-center h-full text-sm text-slate-400">
                                    Loading map...
                                </div>
                            </div>

                            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                                <div class="flex flex-wrap items-center gap-4 text-xs">
                                    <span class="font-semibold text-slate-700">Legend:</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                        <span class="text-slate-600">Pending</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                        <span class="text-slate-600">Verified</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                        <span class="text-slate-600">Assigned</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                        <span class="text-slate-600">Resolved</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                        <span class="text-slate-600">Rejected</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </div>

    <script>
        const refreshIntervalMs = 60000;

        document.addEventListener('DOMContentLoaded', function () {
            const mapEl = document.getElementById('head-mitcom-map');
            if (mapEl && typeof window.initPublicMap === 'function') {
                // Reuse the same public map initializer used on the user dashboard
                window.initPublicMap('head-mitcom-map');
            } else if (mapEl && window.L) {
                // Fallback initializer if the bundle didn't load
                initPublicMapFallback('head-mitcom-map');
            }
            const fallback = document.getElementById('map-fallback-message');
            if (fallback) {
                fallback.style.display = 'none';
            }

            loadSummary();
            setInterval(loadSummary, refreshIntervalMs);
        });

        function loadSummary() {
            fetch('/api/reports/map')
                .then(response => response.json())
                .then(reports => {
                    updateCounts(reports);
                    updateLastUpdated();
                })
                .catch(error => console.error('Error loading reports:', error));
        }

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

        function initPublicMapFallback(containerId) {
            const map = L.map(containerId).setView([10.245375383221655, 123.7959085935566], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Â© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            fetch('/api/reports/map')
                .then(response => response.json())
                .then(reports => {
                    reports.forEach(report => {
                        const color = getMarkerColor(report.issue_type);

                        const icon = L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="background-color: ${color}; width: 25px; height: 25px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>`,
                            iconSize: [25, 25],
                            iconAnchor: [12, 12],
                        });

                        const marker = L.marker([report.latitude, report.longitude], { icon }).addTo(map);

                        const popupContent = `
                            <div class="p-2">
                                <h3 class="font-bold text-sm mb-1">${formatIssueType(report.issue_type)}</h3>
                                <p class="text-xs text-gray-600 mb-1">${report.location}</p>
                                <p class="text-xs text-gray-500">${report.created_at}</p>
                                <span class="inline-block px-2 py-1 text-xs rounded mt-1 ${getStatusClass(report.status)}">${report.status}</span>
                            </div>
                        `;

                        marker.bindPopup(popupContent);
                    });
                })
                .catch(error => console.error('Error loading map data:', error));
        }

        function getMarkerColor(issueType) {
            const colors = {
                'traffic_signal_problem': '#f59e0b',
                'road_damage': '#ef4444',
                'illegal_parking': '#8b5cf6',
                'traffic_obstruction': '#f97316',
                'accident': '#dc2626',
                'traffic_violation': '#ec4899',
                'reckless_driving': '#be123c',
                'public_safety': '#ea580c',
                'infrastructure': '#6366f1',
            };
            return colors[issueType] || '#6b7280';
        }

        function formatIssueType(type) {
            return type.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
        }

        function getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'verified': 'bg-blue-100 text-blue-800',
                'assigned': 'bg-purple-100 text-purple-800',
                'resolved': 'bg-green-100 text-green-800',
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        }
    </script>
</body>

</html>
