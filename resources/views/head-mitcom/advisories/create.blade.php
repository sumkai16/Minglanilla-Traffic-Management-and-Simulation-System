<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Advisory</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    {{-- Leaflet styles are bundled via Vite --}}

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        #advisory-map {
            height: 420px;
            width: 100%;
            border-radius: 1rem;
            z-index: 0;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">
    <x-app-nav pageTitle="Create Advisory" />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        <div>
            <a href="{{ route('head-mitcom.advisories.index') }}" class="text-sm text-slate-500 hover:text-slate-700">←
                Back to Advisories</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Create Traffic Advisory</h1>
        </div>

        <form action="{{ route('head-mitcom.advisories.store') }}" method="POST" id="advisory-form">
            @csrf

            {{-- Hidden map data field --}}
            <input type="hidden" name="map_data" id="map_data_input">

            {{-- Title --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g. Road Closure - Poblacion Main Street">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Describe the affected roads and reason for closure...">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Start Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">End Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Map --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-4">
                <h3 class="font-semibold text-slate-800 mb-1">Map Drawing</h3>
                <p class="text-xs text-slate-400 mb-3">
                    Use the toolbar on the map to draw road closures and reroutes.
                    <span class="inline-flex items-center gap-1"><span
                            class="inline-block w-3 h-1 bg-red-500 rounded"></span> Red = closed road</span>
                    &nbsp;
                    <span class="inline-flex items-center gap-1"><span
                            class="inline-block w-3 h-1 bg-green-500 rounded"></span> Green = reroute path</span>
                </p>

                {{-- Tool selector --}}
                <div class="flex gap-2 mb-3" id="draw-mode-selector">
                    <button type="button" id="btn-closure" onclick="setDrawMode('closure')"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-red-300 bg-red-50 text-red-600 hover:bg-red-100 transition">
                        ✏ Draw Road Closure (Red)
                    </button>
                    <button type="button" id="btn-reroute" onclick="setDrawMode('reroute')"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-500 hover:bg-green-50 hover:border-green-300 hover:text-green-600 transition">
                        ✏ Draw Reroute Path (Green)
                    </button>
                    <button type="button" id="btn-undo" onclick="undoLastVertex()"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-400 hover:bg-yellow-50 hover:border-yellow-300 hover:text-yellow-600 transition"
                        disabled>
                        ↩ Undo
                    </button>
                    <button type="button" onclick="clearRed()"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-400 hover:bg-red-50 hover:border-red-300 hover:text-red-500 transition ml-auto">
                        Clear Red
                    </button>
                    <button type="button" onclick="clearGreen()"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-400 hover:bg-green-50 hover:border-green-300 hover:text-green-500 transition">
                        Clear Green
                    </button>
                </div>

                <div id="advisory-map" class="w-full rounded-xl" style="height: 400px;"></div>
                <p id="draw-hint" class="text-xs text-slate-400 mt-1 italic">
                    Click on the map to start drawing. Double-click to finish.
                </p>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
                    Save as Draft
                </button>
                <a href="{{ route('head-mitcom.advisories.index') }}"
                    class="px-6 py-3 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 font-semibold text-sm transition">
                    Cancel
                </a>
            </div>

        </form>
    </main>

    <x-toast />
    <script>
        let map;
        let closureLayer;
        let rerouteLayer;
        let currentMode = 'closure';

        // Snapping state
        let isDrawing = false;
        let currentPolyline = null;
        let currentLatLngs = [];
        let snappingCursor = null; // visual preview dot

        function setDrawMode(mode) {
            if (isDrawing && mode !== currentMode) {
                const confirmed = confirm('You have an unfinished line. Switching modes will discard it. Continue?');
                if (!confirmed) return;
            }

            currentMode = mode;

            document.getElementById('btn-closure').className = mode === 'closure'
                ? 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-red-400 bg-red-100 text-red-700 transition'
                : 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-500 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition';

            document.getElementById('btn-reroute').className = mode === 'reroute'
                ? 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-green-400 bg-green-100 text-green-700 transition'
                : 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-500 hover:bg-green-50 hover:border-green-300 hover:text-green-600 transition';

            cancelCurrentDrawing();
        }

        function cancelCurrentDrawing() {
            if (currentPolyline) {
                map.removeLayer(currentPolyline);
            }
            if (snappingCursor) {
                map.removeLayer(snappingCursor);
            }
            currentPolyline = null;
            currentLatLngs = [];
            snappingCursor = null;
            isDrawing = false;
            updateStatusHint();
        }
        function undoLastVertex() {
            if (!isDrawing || currentLatLngs.length === 0) return;

            // Remove the last point
            currentLatLngs.pop();

            // Remove the cursor dot
            if (snappingCursor) {
                map.removeLayer(snappingCursor);
                snappingCursor = null;
            }

            // Remove and redraw the preview polyline
            if (currentPolyline) {
                map.removeLayer(currentPolyline);
                currentPolyline = null;
            }

            if (currentLatLngs.length === 0) {
                // Nothing left — fully cancel
                isDrawing = false;
                document.getElementById('btn-undo').disabled = true;
                updateStatusHint();
                return;
            }

            // Redraw preview with remaining points
            const color = currentMode === 'closure' ? '#ef4444' : '#22c55e';

            if (currentLatLngs.length >= 2) {
                currentPolyline = L.polyline(currentLatLngs, {
                    color: color,
                    weight: 6,
                    opacity: 0.9,
                }).addTo(map);
            }

            // Re-place cursor dot at the new last point
            const last = currentLatLngs[currentLatLngs.length - 1];
            snappingCursor = L.circleMarker(last, {
                radius: 5,
                color: color,
                fillColor: color,
                fillOpacity: 1,
                weight: 2,
            }).addTo(map);

            updateStatusHint();
        }

        function clearRed() {
            if (isDrawing && currentMode === 'closure') {
                cancelCurrentDrawing();
            }
            closureLayer.clearLayers();
            updateMapData();
        }

        function clearGreen() {
            if (isDrawing && currentMode === 'reroute') {
                cancelCurrentDrawing();
            }
            rerouteLayer.clearLayers();
            updateMapData();
        }
        function clearAllDrawings() {
            cancelCurrentDrawing();
            closureLayer.clearLayers();
            rerouteLayer.clearLayers();
            updateMapData();
        }

        function updateMapData() {
            const closures = [];
            const reroutes = [];

            closureLayer.eachLayer(function (layer) {
                closures.push({
                    type: 'polyline',
                    color: 'red',
                    coordinates: layer.getLatLngs().map(ll => [ll.lat, ll.lng])
                });
            });

            rerouteLayer.eachLayer(function (layer) {
                reroutes.push({
                    type: 'polyline',
                    color: 'green',
                    coordinates: layer.getLatLngs().map(ll => [ll.lat, ll.lng])
                });
            });

            document.getElementById('map_data_input').value = JSON.stringify({ closures, reroutes });
        }

        function updateStatusHint() {
            const hint = document.getElementById('draw-hint');
            const undoBtn = document.getElementById('btn-undo');

            if (hint) {
                if (!isDrawing) {
                    hint.textContent = 'Click on the map to start drawing. Double-click to finish.';
                } else {
                    hint.textContent = `${currentLatLngs.length} point(s) placed. Click to add more. Double-click to finish.`;
                }
            }

            if (undoBtn) {
                undoBtn.disabled = !isDrawing || currentLatLngs.length === 0;
            }
        }

        async function snapToRoad(lat, lng) {
            try {
                const url = `https://router.project-osrm.org/nearest/v1/driving/${lng},${lat}?number=1`;
                const response = await fetch(url);
                const data = await response.json();

                if (data.code === 'Ok' && data.waypoints && data.waypoints.length > 0) {
                    const snapped = data.waypoints[0].location; // [lng, lat]
                    return { lat: snapped[1], lng: snapped[0] };
                }
            } catch (err) {
                console.warn('OSRM snap failed, using raw coordinates:', err);
            }

            // Fallback: return original coords if OSRM fails
            return { lat, lng };
        }

        async function handleMapClick(e) {
            const rawLat = e.latlng.lat;
            const rawLng = e.latlng.lng;

            // Show a temporary loading dot while snapping
            if (snappingCursor) {
                map.removeLayer(snappingCursor);
            }
            snappingCursor = L.circleMarker([rawLat, rawLng], {
                radius: 5,
                color: '#94a3b8',
                fillColor: '#cbd5e1',
                fillOpacity: 0.8,
                weight: 1,
            }).addTo(map);

            // Snap to nearest road
            const snapped = await snapToRoad(rawLat, rawLng);

            // Remove the loading dot and replace with snapped dot
            if (snappingCursor) {
                map.removeLayer(snappingCursor);
            }

            const color = currentMode === 'closure' ? '#ef4444' : '#22c55e';

            snappingCursor = L.circleMarker([snapped.lat, snapped.lng], {
                radius: 5,
                color: color,
                fillColor: color,
                fillOpacity: 1,
                weight: 2,
            }).addTo(map);

            currentLatLngs.push([snapped.lat, snapped.lng]);
            isDrawing = true;

            // Draw or update the live polyline preview
            if (currentPolyline) {
                map.removeLayer(currentPolyline);
            }

            if (currentLatLngs.length >= 2) {
                currentPolyline = L.polyline(currentLatLngs, {
                    color: color,
                    weight: 6,
                    opacity: 0.9,
                }).addTo(map);
            }

            updateStatusHint();
        }

        function finishCurrentDrawing() {
            if (currentLatLngs.length < 2) {
                cancelCurrentDrawing();
                return;
            }

            const color = currentMode === 'closure' ? '#ef4444' : '#22c55e';

            // Finalize the polyline and add to the correct layer group
            const finalPolyline = L.polyline(currentLatLngs, {
                color: color,
                weight: 6,
                opacity: 0.9,
            });

            if (currentMode === 'closure') {
                closureLayer.addLayer(finalPolyline);
            } else {
                rerouteLayer.addLayer(finalPolyline);
            }

            // Clean up working state
            if (currentPolyline) {
                map.removeLayer(currentPolyline);
            }
            if (snappingCursor) {
                map.removeLayer(snappingCursor);
            }

            currentPolyline = null;
            currentLatLngs = [];
            snappingCursor = null;
            isDrawing = false;

            updateMapData();
            updateStatusHint();
        }

        document.addEventListener('DOMContentLoaded', function () {
            map = L.map('advisory-map').setView([10.2731, 123.7956], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            closureLayer = new L.FeatureGroup().addTo(map);
            rerouteLayer = new L.FeatureGroup().addTo(map);

            let clickTimer = null;

            map.on('click', function (e) {
                if (clickTimer) return;

                clickTimer = setTimeout(function () {
                    clickTimer = null;
                    handleMapClick(e);
                }, 250);
            });

            map.on('dblclick', function (e) {
                L.DomEvent.stopPropagation(e);

                if (clickTimer) {
                    clearTimeout(clickTimer);
                    clickTimer = null;
                }

                finishCurrentDrawing();
            });

            document.getElementById('advisory-form').addEventListener('submit', function () {
                // Finalize any in-progress drawing before submitting
                if (isDrawing) {
                    finishCurrentDrawing();
                }
                updateMapData();
            });

            updateStatusHint();
            setDrawMode('closure');
        });
    </script>
</body>

</html>