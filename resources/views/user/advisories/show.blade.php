<x-app-nav title="{{ $advisory->title }}" page-title="Traffic Advisory" page-eyebrow="Citizen Portal">

    @push('styles')
        <style>
            #advisory-map {
                height: 420px;
                width: 100%;
                border-radius: 1rem;
                z-index: 0;
            }
        </style>
    @endpush

    <main class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <a href="{{ route('user.announcements.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition mb-8">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to Announcements
            </a>

            {{-- Main Card --}}
            <article
                class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/60 overflow-hidden">
                <div class="p-8 md:p-12">

                    {{-- Badges --}}
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest ring-1 bg-blue-50 text-blue-700 ring-blue-200">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Traffic Advisory
                        </span>
                        <span
                            class="rounded-full px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest ring-1 bg-amber-50 text-amber-700 ring-amber-200">
                            Important
                        </span>
                        <span
                            class="rounded-full px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest ring-1
                            {{ $advisory->status === 'published' ? 'bg-green-50 text-green-700 ring-green-200' : 'bg-slate-50 text-slate-500 ring-slate-200' }}">
                            {{ ucfirst($advisory->status) }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-6">
                        {{ $advisory->title }}
                    </h1>

                    {{-- Meta --}}
                    <div
                        class="flex flex-wrap items-center gap-6 pb-6 mb-8 border-b border-slate-100 text-sm text-slate-500">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-xs">
                                {{ substr($advisory->creator?->first_name ?? 'M', 0, 1) }}
                            </div>
                            <span class="font-semibold text-slate-700">
                                {{ $advisory->creator?->first_name }} {{ $advisory->creator?->last_name }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span>{{ $advisory->start_date->format('F d, Y') }} —
                                {{ $advisory->end_date->format('F d, Y') }}</span>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($advisory->description)
                        <div class="text-slate-700 leading-relaxed text-base mb-8">
                            {!! nl2br(e($advisory->description)) !!}
                        </div>
                    @endif

                    {{-- Map --}}
                    @if($advisory->map_data && (count($advisory->map_data['closures'] ?? []) > 0 || count($advisory->map_data['reroutes'] ?? []) > 0))
                        <div class="border-t border-slate-100 pt-8">
                            <h2 class="text-lg font-bold text-slate-800 mb-2">Affected Area Map</h2>
                            <div class="flex gap-4 text-xs text-slate-400 mb-4">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="inline-block w-4 h-1 bg-red-500 rounded"></span> Road Closure
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="inline-block w-4 h-1 bg-green-500 rounded"></span> Reroute Path
                                </span>
                            </div>
                            <div id="advisory-map"></div>
                        </div>
                    @endif

                </div>
            </article>

        </div>
    </main>

    <x-toast />

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const mapEl = document.getElementById('advisory-map');
                if (!mapEl) return;

                const map = L.map('advisory-map').setView([10.2731, 123.7956], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                const mapData = @json($advisory->map_data);
                const bounds = [];

                function getMidpoint(coordinates) {
                    const mid = Math.floor(coordinates.length / 2);
                    return coordinates[mid];
                }

                function makeIcon(color, label) {
                    return L.divIcon({
                        className: '',
                        html: `
                            <div style="
                                background-color: ${color};
                                width: 36px;
                                height: 36px;
                                border-radius: 50%;
                                border: 3px solid white;
                                box-shadow: 0 3px 8px rgba(0,0,0,0.3);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                    ${label === 'closure'
                                ? '<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />'
                                : '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />'
                            }
                                </svg>
                            </div>
                        `,
                        iconSize: [36, 36],
                        iconAnchor: [18, 18],
                    });
                }

                if (mapData) {
                    if (mapData.closures) {
                        mapData.closures.forEach(function (item) {
                            L.polyline(item.coordinates, {
                                color: '#ef4444',
                                weight: 5,
                                opacity: 0.9
                            }).addTo(map);

                            const mid = getMidpoint(item.coordinates);
                            if (mid) {
                                L.marker(mid, { icon: makeIcon('#ef4444', 'closure') })
                                    .bindPopup(`
                                        <div class="p-2 text-center">
                                            <p class="font-bold text-red-600 text-sm">Road Closure</p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $advisory->title }}</p>
                                        </div>
                                    `)
                                    .addTo(map);
                            }

                            bounds.push(...item.coordinates);
                        });
                    }

                    if (mapData.reroutes) {
                        mapData.reroutes.forEach(function (item) {
                            L.polyline(item.coordinates, {
                                color: '#22c55e',
                                weight: 5,
                                opacity: 0.9
                            }).addTo(map);

                            const mid = getMidpoint(item.coordinates);
                            if (mid) {
                                L.marker(mid, { icon: makeIcon('#22c55e', 'reroute') })
                                    .bindPopup(`
                                        <div class="p-2 text-center">
                                            <p class="font-bold text-green-600 text-sm">Reroute Path</p>
                                            <p class="text-xs text-slate-500 mt-1">{{ $advisory->title }}</p>
                                        </div>
                                    `)
                                    .addTo(map);
                            }

                            bounds.push(...item.coordinates);
                        });
                    }
                }

                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [40, 40] });
                }
            });
        </script>
    @endpush
</x-app-nav>