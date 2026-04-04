<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Simulation</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        #map {
            height: calc(100vh - 280px);
            min-height: 400px;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">
    <x-app-nav pageTitle="Traffic Simulation" />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        {{-- Header --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Head MITCOM</p>
            <h1 class="text-2xl font-bold text-slate-900">Traffic Simulation</h1>
            <p class="text-sm text-slate-500 mt-1">Replay traffic incidents over time based on submitted reports and
                advisories.</p>
        </div>

        {{-- Controls Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="flex flex-wrap items-end gap-4">
                {{-- Date Range --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Start Date</label>
                    <input type="date" id="startDate" value="{{ now()->subDays(30)->format('Y-m-d') }}"
                        class="px-3 py-2 border border-slate-200 rounded-xl text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">End Date</label>
                    <input type="date" id="endDate" value="{{ now()->format('Y-m-d') }}"
                        class="px-3 py-2 border border-slate-200 rounded-xl text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button id="loadBtn"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                    Load Data
                </button>

                {{-- Divider --}}
                <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

                {{-- Playback --}}
                <button id="playBtn" disabled
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition disabled:opacity-40 disabled:cursor-not-allowed">
                    ▶ Play
                </button>
                <button id="pauseBtn" disabled
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-xl transition disabled:opacity-40 disabled:cursor-not-allowed">
                    ⏸ Pause
                </button>
                <button id="resetBtn" disabled
                    class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-semibold rounded-xl transition disabled:opacity-40 disabled:cursor-not-allowed">
                    ↺ Reset
                </button>

                {{-- Speed --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Speed</label>
                    <select id="speedSelect"
                        class="px-3 py-2 border border-slate-200 rounded-xl text-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">1x</option>
                        <option value="5" selected>5x</option>
                        <option value="10">10x</option>
                        <option value="30">30x</option>
                    </select>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="mt-4 flex items-center gap-4">
                <span id="currentTimeLabel" class="text-xs font-semibold text-slate-400 w-44 shrink-0">Not
                    started</span>
                <div class="flex-1 bg-slate-100 rounded-full h-2">
                    <div id="timelineProgress" class="bg-blue-500 h-2 rounded-full transition-all duration-500"
                        style="width: 0%"></div>
                </div>
                <span id="reportCountLabel" class="text-xs text-slate-400 shrink-0">0 reports loaded</span>
            </div>
        </div>

        {{-- Legend + Map Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            {{-- Legend --}}
            <div
                class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center gap-x-[50px] gap-y-3 text-xs text-slate-600 ">
                <span class="font-semibold text-slate-400 uppercase tracking-widest text-[10px] p-2">Legend</span>
                <span class="flex items-center gap-1.5 p-2"><span class="w-3 h-3 rounded-full inline-block shrink-0"
                        style="background:#facc15"></span><span>Pending</span></span>
                <span class="flex items-center gap-1.5 p-2"><span class="w-3 h-3 rounded-full inline-block shrink-0"
                        style="background:#3b82f6"></span><span>Verified</span></span>
                <span class="flex items-center gap-1.5 p-2"><span class="w-3 h-3 rounded-full inline-block shrink-0"
                        style="background:#f97316"></span><span>Assigned</span></span>
                <span class="flex items-center gap-1.5 p-2"><span class="w-3 h-3 rounded-full inline-block shrink-0"
                        style="background:#22c55e"></span><span>Resolved</span></span>
                <span class="flex items-center gap-1.5 p-2"><span class="w-3 h-3 rounded-full inline-block shrink-0"
                        style="background:#ef4444"></span><span>Rejected</span></span>
                <span class="flex items-center gap-1.5 p-2"><span class="inline-block rounded shrink-0"
                        style="width:22px;height:4px;background:#ef4444"></span><span>Road Closure</span></span>
                <span class="flex items-center gap-1.5 p-2"><span class="inline-block rounded shrink-0"
                        style="width:22px;height:4px;background:#22c55e"></span><span>Reroute</span></span>
            </div>
            {{-- Map --}}
            <div id="map"></div>
        </div>

    </main>

    <x-toast />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const map = L.map('map').setView([10.2700, 123.7850], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let allReports = [];
            let allAdvisories = [];
            let startTime = null;
            let endTime = null;
            let simTime = null;
            let simInterval = null;
            let isPlaying = false;
            let activeMarkers = {};
            let advisoryLayers = {};

            const statusColors = {
                pending: '#facc15',
                verified: '#3b82f6',
                assigned: '#f97316',
                resolved: '#22c55e',
                rejected: '#ef4444',
            };

            function makeCircleMarker(report, color) {
                return L.circleMarker([report.latitude, report.longitude], {
                    radius: 8,
                    fillColor: color,
                    color: '#fff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9,
                }).bindPopup(
                    '<strong>' + report.issue_type.replace(/_/g, ' ') + '</strong><br>' +
                    report.location + '<br>' +
                    '<span style="text-transform:capitalize">' + report.status + '</span>'
                );
            }

            function getColorAtTime(report, time) {
                const created = new Date(report.created_at);
                const verified = report.verified_at ? new Date(report.verified_at) : null;
                const assigned = report.assigned_at ? new Date(report.assigned_at) : null;
                const resolved = report.resolved_at ? new Date(report.resolved_at) : null;

                if (report.status === 'rejected' && verified && time >= verified) return statusColors.rejected;
                if (resolved && time >= resolved) return statusColors.resolved;
                if (assigned && time >= assigned) return statusColors.assigned;
                if (verified && time >= verified) return statusColors.verified;
                if (time >= created) return statusColors.pending;
                return null;
            }

            function updateMap() {
                allReports.forEach(function (report) {
                    const created = new Date(report.created_at);

                    if (simTime < created) {
                        if (activeMarkers[report.id]) {
                            map.removeLayer(activeMarkers[report.id]);
                            delete activeMarkers[report.id];
                        }
                        return;
                    }

                    const color = getColorAtTime(report, simTime);
                    if (!color) return;

                    if (activeMarkers[report.id]) {
                        activeMarkers[report.id].setStyle({ fillColor: color });
                    } else {
                        activeMarkers[report.id] = makeCircleMarker(report, color).addTo(map);
                    }
                });

                allAdvisories.forEach(function (advisory) {
                    const start = new Date(advisory.start_date);
                    const end = new Date(advisory.end_date);

                    if (simTime >= start && simTime <= end) {
                        if (!advisoryLayers[advisory.id] && advisory.map_data) {
                            const group = L.layerGroup();
                            const data = advisory.map_data;
                            if (data.closures) {
                                data.closures.forEach(function (item) {
                                    L.polyline(item.coordinates, { color: '#ef4444', weight: 6, opacity: 0.9 }).addTo(group);
                                });
                            }
                            if (data.reroutes) {
                                data.reroutes.forEach(function (item) {
                                    L.polyline(item.coordinates, { color: '#22c55e', weight: 6, opacity: 0.9 }).addTo(group);
                                });
                            }
                            group.addTo(map);
                            advisoryLayers[advisory.id] = group;
                        }
                    } else {
                        if (advisoryLayers[advisory.id]) {
                            map.removeLayer(advisoryLayers[advisory.id]);
                            delete advisoryLayers[advisory.id];
                        }
                    }
                });

                const total = endTime - startTime;
                const elapsed = simTime - startTime;
                const pct = Math.min(100, (elapsed / total) * 100);
                document.getElementById('timelineProgress').style.width = pct + '%';
                document.getElementById('currentTimeLabel').textContent = simTime.toLocaleDateString('en-PH', {
                    month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'
                });

                if (simTime >= endTime) pauseSimulation();
            }

            function playSimulation() {
                if (isPlaying) return;
                isPlaying = true;
                simInterval = setInterval(function () {
                    const speed = parseInt(document.getElementById('speedSelect').value);
                    simTime = new Date(simTime.getTime() + speed * 10 * 60 * 1000);
                    updateMap();
                }, 1000);
                document.getElementById('playBtn').disabled = true;
                document.getElementById('pauseBtn').disabled = false;
            }

            function pauseSimulation() {
                isPlaying = false;
                clearInterval(simInterval);
                document.getElementById('playBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
            }

            function resetSimulation() {
                pauseSimulation();
                simTime = new Date(startTime);
                Object.values(activeMarkers).forEach(m => map.removeLayer(m));
                activeMarkers = {};
                Object.values(advisoryLayers).forEach(l => map.removeLayer(l));
                advisoryLayers = {};
                document.getElementById('timelineProgress').style.width = '0%';
                document.getElementById('currentTimeLabel').textContent = 'Not started';
                updateMap();
            }

            document.getElementById('loadBtn').addEventListener('click', function () {
                const start = document.getElementById('startDate').value;
                const end = document.getElementById('endDate').value;

                fetch('{{ route("head-mitcom.simulation.data") }}?start=' + start + '&end=' + end)
                    .then(r => r.json())
                    .then(function (data) {
                        allReports = data.reports;
                        allAdvisories = data.advisories;
                        startTime = new Date(data.start);
                        endTime = new Date(data.end);
                        simTime = new Date(startTime);

                        Object.values(activeMarkers).forEach(m => map.removeLayer(m));
                        activeMarkers = {};
                        Object.values(advisoryLayers).forEach(l => map.removeLayer(l));
                        advisoryLayers = {};

                        document.getElementById('reportCountLabel').textContent = allReports.length + ' reports loaded';
                        document.getElementById('playBtn').disabled = false;
                        document.getElementById('resetBtn').disabled = false;
                        document.getElementById('pauseBtn').disabled = true;
                        document.getElementById('timelineProgress').style.width = '0%';
                        document.getElementById('currentTimeLabel').textContent = 'Ready — press Play';
                    });
            });

            document.getElementById('playBtn').addEventListener('click', playSimulation);
            document.getElementById('pauseBtn').addEventListener('click', pauseSimulation);
            document.getElementById('resetBtn').addEventListener('click', resetSimulation);
        });
    </script>
</body>

</html>