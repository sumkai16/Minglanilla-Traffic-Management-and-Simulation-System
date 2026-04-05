<x-app-nav title="Live Traffic Map" page-title="Live Traffic Map" page-eyebrow="System Administration">
    <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Map Container -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden -mt-4 relative z-10">

                    <!-- Map Header with Filters -->
                    <div class="px-6 py-5 border-b border-slate-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">Live Incident Map</h2>
                                <p class="text-sm text-slate-500 mt-1">Click markers to view report details</p>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="flex flex-wrap items-center gap-2" x-data="{ activeFilter: 'all' }">
                                <span class="text-xs font-semibold text-slate-600 mr-2">Filter:</span>
                                <button @click="activeFilter = 'all'; filterMarkers('all')"
                                    :class="activeFilter === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition">
                                    All
                                </button>
                                <button @click="activeFilter = 'pending'; filterMarkers('pending')"
                                    :class="activeFilter === 'pending' ? 'bg-yellow-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition">
                                    Pending
                                </button>
                                <button @click="activeFilter = 'verified'; filterMarkers('verified')"
                                    :class="activeFilter === 'verified' ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition">
                                    Verified
                                </button>
                                <button @click="activeFilter = 'assigned'; filterMarkers('assigned')"
                                    :class="activeFilter === 'assigned' ? 'bg-purple-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition">
                                    Assigned
                                </button>
                                <button @click="activeFilter = 'resolved'; filterMarkers('resolved')"
                                    :class="activeFilter === 'resolved' ? 'bg-green-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition">
                                    Resolved
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div id="admin-map" class="w-full h-[calc(100vh-280px)] min-h-[600px]"></div>

                    <!-- Legend -->
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
    </main>

    @push('scripts')
        <script>
        let map;
        let allMarkers = [];
        let markersLayer;

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize map
            map = L.map('admin-map').setView([10.2833, 123.7972], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            markersLayer = L.layerGroup().addTo(map);

            // Load all reports
            loadReports();
        });

        function loadReports() {
            fetch('/api/reports/map')
                .then(response => response.json())
                .then(reports => {
                    allMarkers = reports;
                    displayMarkers(reports);
                })
                .catch(error => console.error('Error loading reports:', error));
        }

        function displayMarkers(reports) {
            markersLayer.clearLayers();

            reports.forEach(report => {
                const color = getStatusColor(report.status);

                const icon = L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${color}; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15],
                });

                const marker = L.marker([report.latitude, report.longitude], {
                    icon,
                    reportStatus: report.status // Store status for filtering
                });

                const popupContent = `
                    <div class="p-3 min-w-[200px]">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-bold text-sm">${formatIssueType(report.issue_type)}</h3>
                            <span class="px-2 py-0.5 text-xs rounded-full ${getStatusBadgeClass(report.status)}">${report.status}</span>
                        </div>
                        <p class="text-xs text-gray-600 mb-1">📍 ${report.location}</p>
                        <p class="text-xs text-gray-500 mb-3">🕐 ${report.created_at}</p>
                        <a href="/admin/reports/${report.id}" 
                           class="block text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 px-3 rounded transition">
                            View Details →
                        </a>
                    </div>
                `;

                marker.bindPopup(popupContent, {
                    maxWidth: 250,
                    className: 'custom-popup'
                });

                markersLayer.addLayer(marker);
            });
        }

        function filterMarkers(status) {
            if (status === 'all') {
                displayMarkers(allMarkers);
            } else {
                const filtered = allMarkers.filter(report => report.status === status);
                displayMarkers(filtered);
            }
        }

        function getStatusColor(status) {
            const colors = {
                'pending': '#eab308',    // yellow-500
                'verified': '#3b82f6',   // blue-500
                'assigned': '#a855f7',   // purple-500
                'resolved': '#22c55e',   // green-500
                'rejected': '#ef4444',   // red-500
            };
            return colors[status] || '#6b7280';
        }

        function getStatusBadgeClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'verified': 'bg-blue-100 text-blue-800',
                'assigned': 'bg-purple-100 text-purple-800',
                'resolved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800',
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        }

        function formatIssueType(type) {
            return type.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
        }

        // Make filterMarkers globally accessible for Alpine.js
        window.filterMarkers = filterMarkers;
        </script>
    @endpush
</x-app-nav>