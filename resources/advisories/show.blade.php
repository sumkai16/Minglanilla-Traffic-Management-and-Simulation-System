<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $advisory->title }} — Minglanilla</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-50 min-h-screen">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-8 px-6 shadow">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('advisories.index') }}" class="text-blue-200 text-sm hover:text-white">← Back to
                Advisories</a>
            <h1 class="text-2xl font-bold tracking-tight mt-2">{{ $advisory->title }}</h1>
            <p class="text-blue-100 text-sm mt-1">
                {{ \Carbon\Carbon::parse($advisory->start_date)->format('M d, Y') }}
                @if($advisory->end_date)
                    — {{ \Carbon\Carbon::parse($advisory->end_date)->format('M d, Y') }}
                @endif
            </p>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-6 py-10 space-y-6">

        {{-- Description --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-2">Advisory Details</h2>
            <p class="text-slate-700 leading-relaxed">{{ $advisory->description }}</p>
        </div>

        {{-- Map --}}
        @if(!empty($advisory->map_data))
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">Affected Roads</h2>
                <div id="map" class="w-full h-80 rounded-xl z-0"></div>
            </div>
        @endif

    </div>

    @if(!empty($advisory->map_data))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var map = L.map('map').setView([10.2397, 123.8008], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                var mapData = @json($advisory->map_data);

                if (mapData && mapData.length > 0) {
                    mapData.forEach(function (item) {
                        if (item.type === 'closure') {
                            L.polyline(item.coordinates, { color: 'red', weight: 4 }).addTo(map);
                        } else if (item.type === 'reroute') {
                            L.polyline(item.coordinates, { color: 'green', weight: 4 }).addTo(map);
                        }
                    });
                }
            });
        </script>
    @endif

</body>

</html>