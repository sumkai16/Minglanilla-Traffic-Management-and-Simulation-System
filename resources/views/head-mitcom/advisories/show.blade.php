<x-app-nav :title="$advisory->title" page-title="Advisory Detail" page-eyebrow="Command Center">
    @push('styles')
        <style>
            #advisory-map {
                height: 380px;
                width: 100%;
                border-radius: 1rem;
                z-index: 0;
            }
        </style>
    @endpush

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-5">

        <div class="flex items-center justify-between">
            <a href="{{ route('head-mitcom.advisories.index') }}" class="text-sm text-slate-500 hover:text-slate-700">←
                Back to Advisories</a>
            <a href="{{ route('head-mitcom.advisories.edit', $advisory) }}"
                class="text-sm font-semibold text-blue-600 hover:underline">Edit</a>
        </div>

        {{-- Info Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <h1 class="text-xl font-bold text-slate-900">{{ $advisory->title }}</h1>
                <span @class([
                    'text-xs font-semibold px-3 py-1 rounded-full flex-shrink-0',
                    'bg-green-100 text-green-700' => $advisory->status === 'published',
                    'bg-yellow-100 text-yellow-700' => $advisory->status === 'draft',
                    'bg-slate-100 text-slate-500' => $advisory->status === 'archived',
                ])>
                {{ ucfirst($advisory->status) }}
                </span>
            </div>

            @if($advisory->description)
                <p class="text-sm text-slate-600">{{ $advisory->description }}</p>
            @endif

            <div class="flex gap-6 text-sm">
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">Start Date</p>
                    <p class="font-semibold text-slate-700">{{ $advisory->start_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">End Date</p>
                    <p class="font-semibold text-slate-700">{{ $advisory->end_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">Created by</p>
                    <p class="font-semibold text-slate-700">{{ $advisory->creator->first_name }}
                        {{ $advisory->creator->last_name }}</p>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex gap-3 pt-2 border-t border-slate-100">
                @if($advisory->status === 'draft')
                    <form action="{{ route('head-mitcom.advisories.publish', $advisory) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                            Publish
                        </button>
                    </form>
                @elseif($advisory->status === 'published')
                    <form action="{{ route('head-mitcom.advisories.unpublish', $advisory) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                            Unpublish
                        </button>
                    </form>
                    <form action="{{ route('head-mitcom.advisories.archive', $advisory) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-slate-400 hover:bg-slate-500 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                            Archive
                        </button>
                    </form>
                @endif

                <form action="{{ route('head-mitcom.advisories.destroy', $advisory) }}" method="POST"
                    onsubmit="return confirm('Delete this advisory?')" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-semibold text-red-500 hover:underline px-2 py-2">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Map --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-1">Map</h3>
            <div class="flex gap-4 text-xs text-slate-400 mb-3">
                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block w-4 h-1 bg-red-500 rounded"></span> Road Closure
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block w-4 h-1 bg-green-500 rounded"></span> Reroute Path
                </span>
            </div>
            <div id="advisory-map"></div>
        </div>

    </main>

    <x-toast />

    @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('advisory-map').setView([10.2731, 123.7956], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            const mapData = @json($advisory->map_data);

            if (mapData) {
                if (mapData.closures) {
                    mapData.closures.forEach(function (item) {
                        L.polyline(item.coordinates, { color: '#ef4444', weight: 4 }).addTo(map);
                    });
                }
                if (mapData.reroutes) {
                    mapData.reroutes.forEach(function (item) {
                        L.polyline(item.coordinates, { color: '#22c55e', weight: 4 }).addTo(map);
                    });
                }
            }
        });
        </script>
    @endpush
</x-app-nav>