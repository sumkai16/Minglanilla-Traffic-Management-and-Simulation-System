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

    // Try to get user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                // Center map on user's location
                map.setView([userLat, userLng], 16);
                // Place marker at user's location
                latInput.value = userLat.toFixed(6);
                lngInput.value = userLng.toFixed(6);
                // Remove any existing marker first
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([userLat, userLng]).addTo(map);
            },
            (error) => {
                console.log('Location access denied or unavailable, using default location');
                // Keep default Minglanilla center
            }
        );
    }

    // Click map to place/move marker
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;

        // Update inputs
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);

        // Remove old marker if exists
        if (marker) {
            map.removeLayer(marker);
        }

        // Add new marker
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
};
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