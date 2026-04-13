<x-app-nav title="Station Detail - MITCOM Head" page-title="Station Assignment Detail" page-eyebrow="Command Center">
    <main class="max-w-6xl mx-auto px-4 lg:px-8 py-8">

        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('head-mitcom.enforcer-stations.index') }}"
               class="text-sm text-blue-600 hover:underline">← Back to Stations</a>
            <div class="flex items-center gap-2">
                <a href="{{ route('head-mitcom.enforcer-stations.edit', $enforcerStation) }}"
                   class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-white">
                    Edit
                </a>
                <form method="POST" action="{{ route('head-mitcom.enforcer-stations.destroy', $enforcerStation) }}"
                      onsubmit="return confirm('Remove this station assignment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                        Remove
                    </button>
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_1.4fr]">

            {{-- Left column --}}
            <div class="space-y-6">

                {{-- Enforcer card --}}
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Assigned Enforcer</p>
                    <div class="mt-4 flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-700 to-slate-900 flex items-center justify-center text-white text-lg font-bold shrink-0">
                            {{ strtoupper(substr($enforcerStation->enforcer->first_name, 0, 1)) }}{{ strtoupper(substr($enforcerStation->enforcer->last_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-bold text-slate-900">
                                {{ $enforcerStation->enforcer->first_name }} {{ $enforcerStation->enforcer->last_name }}
                            </p>
                            <p class="text-sm text-slate-500">{{ $enforcerStation->enforcer->email }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">Enforcer · MITCOM</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('head-mitcom.enforcers.show', $enforcerStation->enforcer) }}"
                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition">
                            View Enforcer Profile →
                        </a>
                    </div>
                </div>

                {{-- Station details --}}
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Station Details</p>

                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-500">Location</p>
                        <p class="mt-1 text-lg font-bold text-blue-900">{{ $enforcerStation->label }}</p>
                        <p class="text-xs text-blue-400 mt-0.5">{{ $enforcerStation->latitude }}, {{ $enforcerStation->longitude }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Start Date</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">{{ $enforcerStation->assigned_at->format('M d, Y') }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">End Date</p>
                            <p class="mt-1 text-sm font-semibold text-slate-800">{{ $enforcerStation->expires_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div>
                        @if($enforcerStation->is_active && !$enforcerStation->isExpired())
                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3">
                                <p class="text-xs font-semibold text-emerald-700">✓ Active — {{ $enforcerStation->expires_at->diffForHumans() }} remaining</p>
                            </div>
                        @elseif($enforcerStation->isExpired())
                            <div class="rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3">
                                <p class="text-xs font-semibold text-rose-700">⚠ Expired {{ $enforcerStation->expires_at->diffForHumans() }}</p>
                            </div>
                        @else
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <p class="text-xs font-semibold text-slate-600">Inactive</p>
                            </div>
                        @endif
                    </div>

                    @if($enforcerStation->notes)
                        <div class="rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-amber-600 mb-1">Notes</p>
                            <p class="text-sm text-amber-800">{{ $enforcerStation->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right column --}}
            <div class="space-y-6">

                {{-- Map --}}
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400 mb-4">Station Location</p>
                    <div id="station-map" class="w-full h-72 rounded-2xl border border-slate-200 z-0"></div>
                </div>

                {{-- Assignment history --}}
                <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Assignment History</p>
                        <h3 class="mt-1 text-lg font-bold text-slate-900">Past Stations</h3>
                    </div>

                    @if($history->count())
                        <div class="divide-y divide-slate-100">
                            @foreach($history as $past)
                                <div class="px-6 py-4 flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-800">{{ $past->label }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">
                                            {{ $past->assigned_at->format('M d, Y') }} → {{ $past->expires_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="shrink-0">
                                        @if($past->is_active && !$past->isExpired())
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                        @elseif($past->isExpired())
                                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-rose-200">Expired</span>
                                        @else
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-10 text-center">
                            <p class="text-sm text-slate-400">No previous station assignments for this enforcer.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </main>

    <x-toast />
</x-app-nav>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $enforcerStation->latitude }};
        const lng = {{ $enforcerStation->longitude }};

        const map = L.map('station-map', { zoomControl: true, dragging: false, scrollWheelZoom: false }).setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup('<strong>{{ addslashes($enforcerStation->label) }}</strong><br>{{ $enforcerStation->enforcer->first_name }} {{ $enforcerStation->enforcer->last_name }}')
            .openPopup();
    });
</script>