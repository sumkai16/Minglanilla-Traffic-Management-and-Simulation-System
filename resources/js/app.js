import './bootstrap';
import './report';
import Alpine from 'alpinejs';
import 'leaflet/dist/leaflet.css';
import 'leaflet-draw/dist/leaflet.draw.css';
import L from 'leaflet';
import 'leaflet-draw';

window.Alpine = Alpine;
Alpine.start();

// Expose Leaflet (with Draw plugin) globally for inline scripts
window.L = L;

// Fix for default marker icons in Leaflet with Vite
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

// Make initPublicMap available globally
window.initPublicMap = function (containerId) {
    const map = L.map(containerId).setView([10.245375383221655, 123.7959085935566], 13); // Center on Minglanilla
    // const map = L.map(containerId).setView([10.2833, 123.7972], 13); //Cuanos
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);
    L.tileLayer(
        'https://api.tomtom.com/traffic/map/4/tile/flow/relative0/{z}/{x}/{y}.png?key=ltjHbZJ204oMhEb0TuB2EmoqFVi1sV2Z',
        {
            attribution: '© TomTom',
            maxZoom: 19,
            opacity: 1,
        }
    ).addTo(map);
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
};
// Map picker for report form
window.initReportMapPicker = function () {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const mapContainer = document.getElementById('map-picker');

    if (!mapContainer || !latInput || !lngInput) return;

    // Default center (Minglanilla)
    let defaultLat = 10.2038;
    let defaultLng = 123.7887;

    // Initialize map
    const map = L.map(mapContainer).setView([defaultLat, defaultLng], 19);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);
    let marker;

    // Minglanilla boundary bounds — declared before geolocation callback uses it
    const minglanillaBounds = L.latLngBounds(
        L.latLng(10.2373149, 123.7763826),
        L.latLng(10.2574988, 123.8161265)
    );

    // Try to get user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                if (minglanillaBounds.contains([userLat, userLng])) {
                    map.setView([userLat, userLng], 16);
                    latInput.value = userLat.toFixed(6);
                    lngInput.value = userLng.toFixed(6);

                    if (marker) map.removeLayer(marker);
                    marker = L.marker([userLat, userLng]).addTo(map);
                } else {
                    map.setView([defaultLat, defaultLng], 14);
                }
            },
            (error) => {
                console.log('Location access denied or unavailable, using default location');
            }
        );
    }

    map.on('click', function (e) {
        const { lat, lng } = e.latlng;

        if (!minglanillaBounds.contains([lat, lng])) {
            showOutOfBoundsModal();
            return;
        }

        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);

        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
    });

    // If coordinates already exist (validation error), show marker
    if (latInput.value && lngInput.value) {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 16);
        }
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
}
function showOutOfBoundsModal() {
    // Remove existing modal if any
    const existing = document.getElementById('out-of-bounds-modal');
    if (existing) existing.remove();

    const modal = document.createElement('div');
    modal.id = 'out-of-bounds-modal';
    modal.innerHTML = `
        <div class="fixed inset-0 z-[9999] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" id="oob-backdrop"></div>
            <div class="relative w-full max-w-md bg-gradient-to-br from-[#0c1e3a] to-[#132d5e] rounded-2xl shadow-2xl border border-blue-500/20 overflow-hidden">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-40 h-1 bg-gradient-to-r from-transparent via-red-400 to-transparent rounded-full"></div>
                <div class="p-8 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-red-500/15 border border-red-400/30 flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-9.5 11.25S1.5 17.642 1.5 10.5a8.5 8.5 0 1 1 17 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Outside Minglanilla</h3>
                    <p class="text-blue-200/70 text-sm leading-relaxed mb-8">
                        This system is only available within the Municipality of Minglanilla, Cebu. Please pinpoint a location inside the municipality boundaries.
                    </p>
                    <button id="oob-close-btn"
                        class="px-8 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-lg transition-all duration-200 cursor-pointer">
                        Got it
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    document.getElementById('oob-close-btn').addEventListener('click', () => modal.remove());
    document.getElementById('oob-backdrop').addEventListener('click', () => modal.remove());
}