<x-app-nav title="View Report #{{ $report->id }}" page-title="View Report" page-eyebrow="System Administration">
    <main class="py-8 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($report->parent_id)
                <div class="mb-6 flex items-center justify-between gap-4 rounded-xl border border-blue-200 bg-blue-50/50 p-4 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-blue-900">Duplicate Report</p>
                            <p class="text-[10px] text-blue-700 uppercase tracking-widest font-semibold">Linked Incident</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.show', $report->parent_id) }}" 
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-900 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-800 shadow-md">
                        Return to Main Incident
                    </a>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Report Details</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Issue Type</label>
                                <p class="mt-1 text-lg text-gray-900">
                                    {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Description</label>
                                <p class="mt-1 text-gray-900">{{ $report->description }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Location</label>
                                <p class="mt-1 text-gray-900">{{ $report->location }}</p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Coordinates: {{ $report->latitude }}, {{ $report->longitude }}
                                </p>
                            </div>

                            @if ($report->image_path)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Photo Evidence</label>
                                    <img src="{{ Storage::url($report->image_path) }}" alt="Report evidence"
                                        class="rounded-lg shadow-md max-w-md">
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($report->duplicates->isNotEmpty())
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Additional Reporters ({{ $report->duplicates->count() }})</h2>
                            <div class="space-y-4">
                                @foreach($report->duplicates as $duplicate)
                                    <div class="p-4 border border-gray-100 rounded-lg bg-gray-50 flex flex-col gap-3">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-800">
                                                {{ $duplicate->user ? $duplicate->user->first_name . ' ' . $duplicate->user->last_name : ($duplicate->reporter_name ?: 'Guest') }}
                                            </span>
                                            <div class="flex items-center gap-4">
                                                <span class="text-xs text-gray-500">{{ $duplicate->created_at->diffForHumans() }}</span>
                                                <a href="{{ route('admin.reports.show', $duplicate) }}" 
                                                   class="text-xs font-bold text-blue-700 hover:text-blue-900 transition underline underline-offset-4 decoration-blue-200">
                                                    Full Report
                                                </a>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700 italic">"{{ $duplicate->description }}"</p>
                                        @if($duplicate->image_path)
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($duplicate->image_path) }}" class="h-24 rounded-lg shadow-sm" alt="Duplicate image">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Location on Map</h2>
                        <div id="report-map" class="w-full h-[400px] rounded-lg border-2 border-gray-200 z-0"></div>
                    </div>
                </div>

                <div class="space-y-6">

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Status</h2>

                        <div class="mb-4">
                            <span
                                class="px-3 py-2 inline-flex text-sm leading-5 font-semibold rounded-full
                                @if ($report->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($report->status === 'verified') bg-blue-100 text-blue-800
                                @elseif($report->status === 'assigned') bg-purple-100 text-purple-800
                                @elseif($report->status === 'resolved') bg-green-100 text-green-800
                                @elseif($report->status === 'rejected') bg-red-100 text-red-800
                                @elseif($report->status === 'for_verification') bg-cyan-100 text-cyan-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('admin.reports.updateStatus', $report) }}">
                            @csrf
                            @method('PATCH')

                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Change
                                Status</label>
                            <select name="status" id="status"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-4">
                                <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>Verified
                                </option>
                                <option value="assigned" {{ $report->status === 'assigned' ? 'selected' : '' }}>Assigned
                                </option>
                                <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved
                                </option>
                                <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>

                            <button type="submit"
                                class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Reporter Information</h2>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Name</label>
                                <p class="mt-1 text-gray-900">
                                    @if ($report->user)
                                        {{ $report->user->first_name }} {{ $report->user->last_name }}
                                    @else
                                        {{ $report->reporter_name ?? 'Guest' }}
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-gray-900">
                                    @if ($report->user)
                                        {{ $report->user->email }}
                                    @else
                                        {{ $report->reporter_email ?? 'N/A' }}
                                    @endif
                                </p>
                            </div>

                            @if ($report->reporter_phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Phone</label>
                                    <p class="mt-1 text-gray-900">{{ $report->reporter_phone }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Submitted</label>
                                <p class="mt-1 text-gray-900">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                                <p class="text-sm text-gray-500">{{ $report->created_at->diffForHumans() }}</p>
                            </div>

                        </div>
                        @if ($report->verified_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="mt-1 text-gray-900">{{ $report->verified_at->format('M d, Y h:i A') }}</p>
                                <p class="text-sm text-gray-500">{{ $report->verified_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($report->verified_by)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Verification Info</h2>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Verified By</label>
                                    <p class="mt-1 text-gray-900">{{ $report->verifier->first_name }}
                                        {{ $report->verifier->last_name }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Verified At</label>
                                    <p class="mt-1 text-gray-900">{{ $report->verified_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('report-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19,
                }).addTo(map);

                L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                    .addTo(map)
                    .bindPopup(`
                    <div class="p-2">
                        <h3 class="font-bold">{{ ucwords(str_replace('_', ' ', $report->issue_type)) }}</h3>
                        <p class="text-sm">{{ $report->location }}</p>
                    </div>
                `).openPopup();
            });
        </script>
    @endpush
</x-app-nav>
