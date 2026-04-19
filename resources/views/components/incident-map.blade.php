@props([
    'mapId' => 'incident-map',
    'heightClass' => 'h-[calc(100vh-280px)] min-h-[600px]',
    'title' => 'Live Incident Map',
    'subtitle' => 'Click markers to view report details',
    'showFilters' => true,
    'showTrafficToggle' => true,
])

<div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden relative z-10 w-full" x-data="{ activeFilter: 'all', trafficVisible: false, markersVisible: true }">
    @if($title || $showFilters)
    <!-- Map Header -->
    <div class="px-6 py-5 border-b border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                @if($title) <h2 class="text-xl font-bold text-slate-900">{{ $title }}</h2> @endif
                @if($subtitle) <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p> @endif
            </div>

            @if($showFilters)
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-2">
                @if($showTrafficToggle)
                <button type="button" @click="trafficVisible = !trafficVisible; toggleTrafficLayer('{{ $mapId }}')"
                    :class="trafficVisible ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20 ring-0 ring-offset-0' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50 focus:ring-slate-300'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 flex items-center gap-1.5 focus:outline-none">
                    <span class="w-2.5 h-2.5 rounded-full inline-block shadow-inner"
                        style="background: linear-gradient(to right, #22c55e, #ef4444);"></span>
                    <span x-text="trafficVisible ? 'Hide Traffic Flow' : 'Show Traffic Flow'"></span>
                </button>
                @endif
                <button type="button" @click="markersVisible = !markersVisible; toggleMarkersLayer('{{ $mapId }}')"
                    :class="markersVisible ? 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50 focus:ring-slate-300' : 'bg-slate-800 text-white shadow-md shadow-slate-800/20 ring-0 ring-offset-0'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 flex items-center gap-1.5 focus:outline-none">
                    <span class="w-2.5 h-2.5 rounded-full inline-block shadow-inner"
                        :class="markersVisible ? 'bg-blue-500' : 'bg-slate-400'"></span>
                    <span x-text="markersVisible ? 'Hide Markers' : 'Show Markers'"></span>
                </button>
                <div class="h-6 w-px bg-slate-200 mx-1 hidden sm:block"></div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest mr-1 hidden sm:block">Filter:</span>
                <button @click="activeFilter = 'all'; filterMarkers('all', '{{ $mapId }}')"
                    :class="activeFilter === 'all' ? 'bg-slate-900 text-white shadow-md shadow-slate-900/20' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200">
                    All
                </button>
                <button @click="activeFilter = 'pending'; filterMarkers('pending', '{{ $mapId }}')"
                    :class="activeFilter === 'pending' ? 'bg-yellow-500 text-white shadow-md shadow-yellow-500/20' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200">
                    Pending
                </button>
                <button @click="activeFilter = 'verified'; filterMarkers('verified', '{{ $mapId }}')"
                    :class="activeFilter === 'verified' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200">
                    Verified
                </button>
                <button @click="activeFilter = 'assigned'; filterMarkers('assigned', '{{ $mapId }}')"
                    :class="activeFilter === 'assigned' ? 'bg-purple-500 text-white shadow-md shadow-purple-500/20' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200">
                    Assigned
                </button>
                <button @click="activeFilter = 'resolved'; filterMarkers('resolved', '{{ $mapId }}')"
                    :class="activeFilter === 'resolved' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50'"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-200">
                    Resolved
                </button>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Map Container -->
    <div id="{{ $mapId }}" class="w-full z-0 {{ $heightClass }}"></div>

    <!-- Legend -->
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/80 backdrop-blur-sm">
        <div class="flex flex-wrap items-center gap-6 text-xs">
            <div class="flex items-center gap-3">
                <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Status Legend:</span>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-yellow-500 shadow-sm"></div><span class="text-slate-600 font-medium">Pending</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-sm"></div><span class="text-slate-600 font-medium">Verified</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-purple-500 shadow-sm"></div><span class="text-slate-600 font-medium">Assigned</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm"></div><span class="text-slate-600 font-medium">Resolved</span></div>
                <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-sm"></div><span class="text-slate-600 font-medium">Rejected</span></div>
            </div>
            
            @if($showTrafficToggle)
            <div class="w-px h-4 bg-slate-300 mx-1 hidden sm:block"></div>
            <div class="flex items-center gap-3">
                <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Traffic Flow:</span>
                <div class="flex items-center gap-1.5"><div class="w-4 h-1.5 rounded-full" style="background-color: #06c167;"></div><span class="text-slate-600 font-medium">Free Flow</span></div>
                <div class="flex items-center gap-1.5"><div class="w-4 h-1.5 rounded-full" style="background-color: #ff8c00;"></div><span class="text-slate-600 font-medium">Slow</span></div>
                <div class="flex items-center gap-1.5"><div class="w-4 h-1.5 rounded-full" style="background-color: #ff0000;"></div><span class="text-slate-600 font-medium">Congested</span></div>
            </div>
            @endif
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    window.incidentMaps = window.incidentMaps || {};

    function initIncidentMap(mapId) {
        if (window.incidentMaps[mapId]) return;

        const mapInstance = {
            map: null,
            allMarkers: [],
            markersLayer: null,
            trafficLayer: null,
            trafficVisible: false,
            markersVisible: true,
            
            init() {
                // Initialize map
                this.map = L.map(mapId).setView([10.2833, 123.7972], 13);

                // OpenFreeMap public raster tiles (bright style)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors | Tiles via <a href="https://openfreemap.org" target="_blank">OpenFreeMap</a>',
                    maxZoom: 20,
                    subdomains: 'abc',
                }).addTo(this.map);

                // TomTom layer
                const tomtomApiKey = 'ltjHbZJ204oMhEb0TuB2EmoqFVi1sV2Z';
                this.trafficLayer = L.tileLayer(
                    `https://api.tomtom.com/traffic/map/4/tile/flow/relative0/{z}/{x}/{y}.png?key=${tomtomApiKey}`,
                    {
                        attribution: '© TomTom',
                        maxZoom: 19,
                        opacity: 0.8,
                    }
                );

                this.markersLayer = L.layerGroup().addTo(this.map);

                this.loadReports();
                
                // Set auto refresh interval
                setInterval(() => this.loadReports(), 60000);
            },
            
            loadReports() {
                fetch('/api/reports/map')
                    .then(response => response.json())
                    .then(reports => {
                        this.allMarkers = reports;
                        
                        // Check if we have an active filter on the DOM
                        const alpineWrapper = document.getElementById(mapId).closest('[x-data]');
                        let currentFilter = 'all';
                        if (alpineWrapper && alpineWrapper.__x) {
                           const val = alpineWrapper.__x.$data.activeFilter;
                           if (val) currentFilter = val;
                        }
                        this.filterMarkers(currentFilter);
                        
                        // Dispatch custom event for stats components
                        window.dispatchEvent(new CustomEvent(`reports-loaded-` + mapId, { detail: reports }));
                    })
                    .catch(error => console.error('Error loading map reports:', error));
            },
            
            displayMarkers(reports) {
                this.markersLayer.clearLayers();

                reports.forEach(report => {
                    const color = this.getStatusColor(report.status);

                    const icon = L.divIcon({
                        className: 'custom-marker',
                        html: `<div style="background-color: ${color}; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 6px rgba(0,0,0,0.3); transition: transform 0.2s;"></div>`,
                        iconSize: [28, 28],
                        iconAnchor: [14, 14],
                    });

                    const marker = L.marker([report.latitude, report.longitude], {
                        icon,
                        reportStatus: report.status 
                    });

                    // We link appropriately if in admin or mitcom (using window path)
                    const basePath = window.location.pathname.startsWith('/head-mitcom') ? '/head-mitcom' : '/admin';
                    
                    const popupContent = `
                        <div class="p-4 min-w-[220px] font-sans">
                            <div class="flex items-start justify-between mb-3 gap-2">
                                <h3 class="font-bold text-sm text-slate-800 leading-tight">${this.formatIssueType(report.issue_type)}</h3>
                                <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md ${this.getStatusBadgeClass(report.status)} shadow-sm">${report.status}</span>
                            </div>
                            <div class="space-y-1.5 mb-4">
                                <p class="text-[11px] text-slate-600 flex gap-1.5 items-start">
                                    <span class="text-slate-400 mt-0.5">📍</span>
                                    <span class="leading-tight">${report.location}</span>
                                </p>
                                <p class="text-[11px] text-slate-500 flex gap-1.5 items-center">
                                    <span class="text-slate-400">🕐</span>
                                    <span>${report.created_at}</span>
                                </p>
                            </div>
                            <a href="${basePath}/reports/${report.id}" 
                               class="flex items-center justify-center gap-1.5 w-full bg-slate-900 hover:bg-blue-600 text-white text-xs font-semibold py-2 px-3 rounded-lg transition-colors shadow-sm">
                                View Details 
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    `;

                    marker.bindPopup(popupContent, {
                        maxWidth: 280,
                        className: 'modern-popup',
                        closeButton: false
                    });

                    this.markersLayer.addLayer(marker);
                });
            },
            
            filterMarkers(status) {
                if (status === 'all') {
                    this.displayMarkers(this.allMarkers);
                } else {
                    const filtered = this.allMarkers.filter(report => report.status === status);
                    this.displayMarkers(filtered);
                }
            },
            
            toggleTrafficLayer() {
                if (this.trafficVisible) {
                    this.map.removeLayer(this.trafficLayer);
                    this.trafficVisible = false;
                } else {
                    this.trafficLayer.addTo(this.map);
                    this.trafficVisible = true;
                }
            },
            
            toggleMarkersLayer() {
                if (this.markersVisible) {
                    this.map.removeLayer(this.markersLayer);
                    this.markersVisible = false;
                } else {
                    this.markersLayer.addTo(this.map);
                    this.markersVisible = true;
                }
            },

            getStatusColor(status) {
                const colors = {
                    'pending': '#eab308',    // yellow-500
                    'verified': '#3b82f6',   // blue-500
                    'assigned': '#a855f7',   // purple-500
                    'resolved': '#10b981',   // emerald-500
                    'rejected': '#ef4444',   // red-500
                };
                return colors[status] || '#64748b';
            },

            getStatusBadgeClass(status) {
                const classes = {
                    'pending': 'bg-yellow-100/80 text-yellow-800 border border-yellow-200',
                    'verified': 'bg-blue-100/80 text-blue-800 border border-blue-200',
                    'assigned': 'bg-purple-100/80 text-purple-800 border border-purple-200',
                    'resolved': 'bg-emerald-100/80 text-emerald-800 border border-emerald-200',
                    'rejected': 'bg-red-100/80 text-red-800 border border-red-200',
                };
                return classes[status] || 'bg-slate-100 text-slate-800 border border-slate-200';
            },

            formatIssueType(type) {
                return type.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            }
        };

        mapInstance.init();
        window.incidentMaps[mapId] = mapInstance;
    }

    // Export helpers for Alpine context
    window.filterMarkers = function(status, mapId) {
        if(window.incidentMaps[mapId]) window.incidentMaps[mapId].filterMarkers(status);
    };
    window.toggleTrafficLayer = function(mapId) {
        if(window.incidentMaps[mapId]) window.incidentMaps[mapId].toggleTrafficLayer();
    };
    window.toggleMarkersLayer = function(mapId) {
        if(window.incidentMaps[mapId]) window.incidentMaps[mapId].toggleMarkersLayer();
    };

    // Inject CSS for modern popups
    if (!document.getElementById('modern-popup-styles')) {
        const style = document.createElement('style');
        style.id = 'modern-popup-styles';
        style.textContent = `
            .modern-popup .leaflet-popup-content-wrapper { padding: 0; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
            .modern-popup .leaflet-popup-content { margin: 0; }
            .modern-popup .leaflet-popup-tip { box-shadow: 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        `;
        document.head.appendChild(style);
    }
</script>
@endpush
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function () {
        initIncidentMap('{{ $mapId }}');
    });
</script>
