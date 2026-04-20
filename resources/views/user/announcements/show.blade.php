@php
    $typeLabels = [
        'traffic_advisory' => 'Traffic Advisory',
        'road_closure' => 'Road Closure',
        'emergency' => 'Emergency',
        'system_notice' => 'System Notice',
    ];

    $typeColors = [
        'traffic_advisory' => 'bg-blue-50 text-blue-700 ring-blue-200',
        'road_closure' => 'bg-red-50 text-red-700 ring-red-200',
        'emergency' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'system_notice' => 'bg-slate-50 text-slate-700 ring-slate-200',
    ];
@endphp

<x-app-nav title="{{ $announcement->title }}" page-title="Announcement" :page-eyebrow="ucfirst($prefix) . ' Portal'">

    <main class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <a href="{{ route($prefix . '.announcements.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition mb-8">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to Announcements
            </a>

            {{-- Main Card --}}
            <article
                class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/60 overflow-hidden">

                {{-- Image --}}
                @if($announcement->image ?? null)
                    <div class="h-64 w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-8 md:p-12">

                    {{-- Badges --}}
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest ring-1 {{ $typeColors[$announcement->type] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                            {{ $typeLabels[$announcement->type] ?? 'Announcement' }}
                        </span>
                        <span
                            class="rounded-full px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest ring-1
                            {{ ($announcement->priority ?? '') === 'urgent' ? 'bg-rose-50 text-rose-700 ring-rose-200' : (($announcement->priority ?? '') === 'important' ? 'bg-amber-50 text-amber-700 ring-amber-200' : 'bg-slate-50 text-slate-600 ring-slate-200') }}">
                            {{ $announcement->priority ?? 'normal' }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-6">
                        {{ $announcement->title }}
                    </h1>

                    {{-- Meta --}}
                    <div
                        class="flex flex-wrap items-center gap-6 pb-6 mb-8 border-b border-slate-100 text-sm text-slate-500">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-xs">
                                {{ substr($announcement->author?->first_name ?? 'M', 0, 1) }}
                            </div>
                            <span class="font-semibold text-slate-700">
                                {{ $announcement->author?->first_name }} {{ $announcement->author?->last_name }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ $announcement->published_at?->format('F d, Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ $announcement->published_at?->diffForHumans() ?? '' }}</span>
                        </div>
                    </div>

                    {{-- Advisory Date Range --}}
                    @if(($announcement->is_advisory ?? false) && ($announcement->start_date ?? null))
                        <div class="mb-8 rounded-2xl bg-blue-50/60 border border-blue-100 px-6 py-4">
                            <div class="flex flex-wrap items-center gap-6 text-sm">
                                <div class="flex items-center gap-2 text-blue-700">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span class="font-bold">Effective:</span>
                                    <span>{{ $announcement->start_date?->format('F d, Y') }}</span>
                                    @if($announcement->end_date ?? null)
                                        <span>→</span>
                                        <span>{{ $announcement->end_date?->format('F d, Y') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>

                </div>

                {{-- Advisory Map --}}
                @if(($announcement->is_advisory ?? false) && !empty($announcement->map_data))
                    <div class="border-t border-slate-200">
                        <div class="px-8 md:px-12 py-6">
                            <h2 class="text-lg font-black text-slate-900 mb-1">Affected Area</h2>
                            <p class="text-sm text-slate-500 mb-4">Road closures and alternate reroutes for this advisory.</p>
                        </div>
                        <div id="advisory-map" class="w-full" style="height: 400px;"></div>
                        <div class="px-8 md:px-12 py-4 bg-slate-50 border-t border-slate-100">
                            <div class="flex flex-wrap items-center gap-6 text-xs text-slate-600">
                                <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Legend:</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-block rounded" style="width:20px;height:4px;background:#ef4444;"></span>
                                    <span class="font-medium">Road Closure</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-block rounded" style="width:20px;height:4px;background:#22c55e;"></span>
                                    <span class="font-medium">Reroute / Alternate</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const mapData = @json($announcement->map_data);
                            if (!mapData) return;

                            const map = L.map('advisory-map').setView([10.2833, 123.7972], 14);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                                maxZoom: 20,
                            }).addTo(map);

                            const bounds = L.latLngBounds();

                            // Custom icon builders
                            function startIcon(color) {
                                return L.divIcon({
                                    className: '',
                                    html: `<div style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:${color};border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);color:white;font-weight:900;font-size:12px;font-family:system-ui;">A</div>`,
                                    iconSize: [28, 28],
                                    iconAnchor: [14, 14],
                                });
                            }

                            function endIcon(color) {
                                return L.divIcon({
                                    className: '',
                                    html: `<div style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:${color};border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);color:white;font-weight:900;font-size:12px;font-family:system-ui;">B</div>`,
                                    iconSize: [28, 28],
                                    iconAnchor: [14, 14],
                                });
                            }

                            function addEndpointMarkers(coords, color, label) {
                                if (!coords || coords.length < 2) return;
                                const first = coords[0];
                                const last = coords[coords.length - 1];

                                L.marker(first, { icon: startIcon(color) })
                                    .bindPopup(`<span class="font-bold" style="color:${color}">${label} — Start</span>`)
                                    .addTo(map);

                                L.marker(last, { icon: endIcon(color) })
                                    .bindPopup(`<span class="font-bold" style="color:${color}">${label} — End</span>`)
                                    .addTo(map);
                            }

                            // Draw closures (red)
                            if (mapData.closures && mapData.closures.length) {
                                mapData.closures.forEach(function (item) {
                                    const line = L.polyline(item.coordinates, {
                                        color: '#ef4444',
                                        weight: 6,
                                        opacity: 0.85,
                                        dashArray: '12, 8',
                                    }).addTo(map);
                                    line.bindPopup('<span class="font-bold text-red-700">Road Closure</span>');
                                    bounds.extend(line.getBounds());
                                    addEndpointMarkers(item.coordinates, '#ef4444', 'Closure');
                                });
                            }

                            // Draw reroutes (green)
                            if (mapData.reroutes && mapData.reroutes.length) {
                                mapData.reroutes.forEach(function (item) {
                                    const line = L.polyline(item.coordinates, {
                                        color: '#22c55e',
                                        weight: 6,
                                        opacity: 0.85,
                                    }).addTo(map);
                                    line.bindPopup('<span class="font-bold text-green-700">Alternate Route</span>');
                                    bounds.extend(line.getBounds());
                                    addEndpointMarkers(item.coordinates, '#22c55e', 'Reroute');
                                });
                            }

                            // Fit map to show all polylines
                            if (bounds.isValid()) {
                                map.fitBounds(bounds, { padding: [40, 40] });
                            }
                        });
                    </script>
                    @endpush
                @endif

            </article>

        </div>
    </main>

    <x-toast />
</x-app-nav>