<x-app-nav title="Edit Station - MITCOM Head" page-title="Edit Station Assignment" page-eyebrow="Command Center">
    <main class="max-w-4xl mx-auto px-4 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('head-mitcom.enforcer-stations.index') }}"
               class="text-sm text-blue-600 hover:underline">← Back to Stations</a>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-8 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Edit Assignment</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">Update station details</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Move the pin to change location, update the enforcer, or extend the assignment period.
            </p>

            <form method="POST" action="{{ route('head-mitcom.enforcer-stations.update', $enforcerStation) }}" class="mt-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Enforcer --}}
                <div>
                    <label class="text-sm font-semibold text-slate-700">Enforcer</label>
                    <select name="enforcer_id" required
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Select Enforcer --</option>
                        @foreach($enforcers as $enforcer)
                            <option value="{{ $enforcer->id }}"
                                {{ old('enforcer_id', $enforcerStation->enforcer_id) == $enforcer->id ? 'selected' : '' }}>
                              {{ $enforcer->first_name }} {{ $enforcer->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('enforcer_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Station Label --}}
                <div>
                    <label class="text-sm font-semibold text-slate-700">Station Label</label>
                    <input type="text" name="label" required
                        value="{{ old('label', $enforcerStation->label) }}"
                        placeholder="e.g. Poblacion Junction, Natalio B. Bacalso Ave."
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    @error('label')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Map Picker --}}
                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        Station Location
                        <span class="font-normal text-slate-400 ml-1">(click the map to move the pin)</span>
                    </label>
                    <div id="station-map" class="mt-2 w-full h-80 rounded-2xl border border-slate-300 z-0"></div>
                    <p class="mt-2 text-xs text-slate-400" id="coords-display">
                        Current: {{ old('latitude', $enforcerStation->latitude) }}, {{ old('longitude', $enforcerStation->longitude) }}
                    </p>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $enforcerStation->latitude) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $enforcerStation->longitude) }}">
                    @error('latitude')
                        <p class="mt-1 text-xs text-rose-600">Please pin a location on the map.</p>
                    @enderror
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Start Date</label>
                        <input type="date" name="assigned_at" required
                            value="{{ old('assigned_at', $enforcerStation->assigned_at->format('Y-m-d')) }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        @error('assigned_at')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">End Date</label>
                        <input type="date" name="expires_at" required
                            value="{{ old('expires_at', $enforcerStation->expires_at->format('Y-m-d')) }}"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        @error('expires_at')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Active Toggle --}}
                <div>
                    <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $enforcerStation->is_active) ? 'checked' : '' }}
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>
                            <span class="block text-sm font-semibold text-slate-800">Mark as active</span>
                            <span class="mt-1 block text-xs text-slate-500">Uncheck to deactivate this assignment without deleting it.</span>
                        </span>
                    </label>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        Notes
                        <span class="font-normal text-slate-400 ml-1">(optional)</span>
                    </label>
                    <textarea name="notes" rows="3"
                        placeholder="Any special instructions for this station..."
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('notes', $enforcerStation->notes) }}</textarea>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="inline-flex items-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Update Assignment
                    </button>
                </div>

            </form>
        </div>
    </main>

    <x-toast />
</x-app-nav>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const existingLat = {{ old('latitude', $enforcerStation->latitude) }};
        const existingLng = {{ old('longitude', $enforcerStation->longitude) }};

        const map = L.map('station-map').setView([existingLat, existingLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([existingLat, existingLng]).addTo(map);

        map.on('click', function (e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            marker.setLatLng([lat, lng]);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('coords-display').textContent = 'Pinned: ' + lat + ', ' + lng;
        });
    });
</script>