<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Advisory</title>
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
    <x-app-nav pageTitle="Edit Advisory" />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        <div>
            <a href="{{ route('head-mitcom.advisories.show', $advisory) }}"
                class="text-sm text-slate-500 hover:text-slate-700">← Back to Advisory</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Edit Advisory</h1>
        </div>

        <form action="{{ route('head-mitcom.advisories.update', $advisory) }}" method="POST" id="advisory-form">
            @csrf
            @method('PUT')

            <input type="hidden" name="map_data" id="map_data_input">

            {{-- Fields --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $advisory->title) }}"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $advisory->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Start Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', $advisory->start_date->format('Y-m-d')) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">End Date <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="end_date"
                            value="{{ old('end_date', $advisory->end_date->format('Y-m-d')) }}"
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
                    Existing lines are loaded. Draw new ones or clear all and redraw.
                    <span class="inline-flex items-center gap-1"><span
                            class="inline-block w-3 h-1 bg-red-500 rounded"></span> Red = closed road</span>
                    &nbsp;
                    <span class="inline-flex items-center gap-1"><span
                            class="inline-block w-3 h-1 bg-green-500 rounded"></span> Green = reroute path</span>
                </p>

                <div class="flex gap-2 mb-3">
                    <button type="button" id="btn-closure" onclick="setDrawMode('closure')"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-red-300 bg-red-50 text-red-600 hover:bg-red-100 transition">
                        ✏ Draw Road Closure (Red)
                    </button>
                    <button type="button" id="btn-reroute" onclick="setDrawMode('reroute')"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-500 hover:bg-green-50 hover:border-green-300 hover:text-green-600 transition">
                        ✏ Draw Reroute Path (Green)
                    </button>
                    <button type="button" onclick="clearAllDrawings()"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-400 hover:bg-red-50 hover:text-red-500 transition ml-auto">
                        Clear All
                    </button>
                </div>

                <div id="advisory-map"></div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
                    Save Changes
                </button>
                <a href="{{ route('head-mitcom.advisories.show', $advisory) }}"
                    class="px-6 py-3 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 font-semibold text-sm transition">
                    Cancel
                </a>
            </div>

        </form>
    </main>

    <x-toast />
    <script>
        const map = L.map('advisory-map').setView([10.2731, 123.7956], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const closureLayer = new L.FeatureGroup().addTo(map);
        const rerouteLayer = new L.FeatureGroup().addTo(map);

        // Load existing map data
        const existingData = @json($advisory->map_data);

        if (existingData) {
            if (existingData.closures) {
                existingData.closures.forEach(function (item) {
                    const line = L.polyline(item.coordinates, { color: '#ef4444', weight: 4 });
                    closureLayer.addLayer(line);
                });
            }
            if (existingData.reroutes) {
                existingData.reroutes.forEach(function (item) {
                    const line = L.polyline(item.coordinates, { color: '#22c55e', weight: 4 });
                    rerouteLayer.addLayer(line);
                });
            }
        }

        updateMapData();

        let currentMode = 'closure';
        let drawHandler = null;

        function setDrawMode(mode) {
            currentMode = mode;

            document.getElementById('btn-closure').className = mode === 'closure'
                ? 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-red-400 bg-red-100 text-red-700 transition'
                : 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-500 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition';

            document.getElementById('btn-reroute').className = mode === 'reroute'
                ? 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-green-400 bg-green-100 text-green-700 transition'
                : 'px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 bg-white text-slate-500 hover:bg-green-50 hover:border-green-300 hover:text-green-600 transition';

            if (drawHandler) {
                drawHandler.disable();
            }

            const color = mode === 'closure' ? '#ef4444' : '#22c55e';

            // Create a new polyline draw handler for the selected mode and enable it
            drawHandler = new L.Draw.Polyline(map, {
                shapeOptions: { color: color, weight: 4 },
            });
            drawHandler.enable();
        }

        map.on(L.Draw.Event.CREATED, function (e) {
            const layer = e.layer;
            if (currentMode === 'closure') {
                layer.setStyle({ color: '#ef4444', weight: 4 });
                closureLayer.addLayer(layer);
            } else {
                layer.setStyle({ color: '#22c55e', weight: 4 });
                rerouteLayer.addLayer(layer);
            }
            updateMapData();
        });

        function clearAllDrawings() {
            closureLayer.clearLayers();
            rerouteLayer.clearLayers();
            updateMapData();
        }

        function updateMapData() {
            const closures = [];
            const reroutes = [];

            closureLayer.eachLayer(function (layer) {
                closures.push({ type: 'polyline', color: 'red', coordinates: layer.getLatLngs().map(ll => [ll.lat, ll.lng]) });
            });

            rerouteLayer.eachLayer(function (layer) {
                reroutes.push({ type: 'polyline', color: 'green', coordinates: layer.getLatLngs().map(ll => [ll.lat, ll.lng]) });
            });

            document.getElementById('map_data_input').value = JSON.stringify({ closures, reroutes });
        }

        document.getElementById('advisory-form').addEventListener('submit', function () {
            updateMapData();
        });

        setDrawMode('closure');
    </script>
</body>

</html>