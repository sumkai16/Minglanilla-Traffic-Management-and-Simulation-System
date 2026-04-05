<x-app-nav title="My Assigned Reports" page-title="My Reports" page-eyebrow="Field Operations">
    <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 mb-6 -mt-4">
                    <h2 class="text-lg font-semibold text-slate-900">Assigned Reports</h2>
                    <p class="text-slate-500 text-sm mt-1">Reports assigned to you for resolution.</p>
                </div>

                @if($reports->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center text-slate-500">
                        No reports assigned to you yet.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($reports as $report)
                            <a href="{{ route('enforcer.reports.show', $report) }}"
                                class="block bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $report->title ?? $report->issue_type }}</p>
                                        <p class="text-sm text-slate-500 mt-1">{{ $report->location }}</p>
                                    </div>
                                    <span @class([
                                        'text-xs font-semibold px-3 py-1 rounded-full',
                                        'bg-yellow-100 text-yellow-700' => $report->status === 'assigned',
                                        'bg-blue-100 text-blue-700' => $report->status === 'for_verification',
                                        'bg-green-100 text-green-700' => $report->status === 'resolved',
                                    ])>
                                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
    </main>

    <x-toast />
</x-app-nav>