<x-app-nav title="Traffic Risk Analysis" page-title="Traffic Risk Analysis" page-eyebrow="HEAD MITCOM">

    <main class="mx-auto max-w-7xl px-4 py-8 lg:px-8">

        {{-- Summary Cards --}}
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Reports</p>
                <p class="mt-2 text-4xl font-black text-slate-900">{{ $reports->count() }}</p>
                <p class="mt-1 text-xs text-slate-500">All time incident reports</p>
            </div>
            <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Peak Hour</p>
                <p class="mt-2 text-4xl font-black text-amber-900">
                    {{ str_pad($peakHour, 2, '0', STR_PAD_LEFT) }}:00
                </p>
                <p class="mt-1 text-xs text-amber-700">Highest incident frequency</p>
            </div>
            <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-rose-600">Busiest Day</p>
                <p class="mt-2 text-4xl font-black text-rose-900">
                    {{ ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][$peakDay] }}
                </p>
                <p class="mt-1 text-xs text-rose-700">Most reports submitted</p>
            </div>
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Avg Resolution</p>
                <p class="mt-2 text-4xl font-black text-blue-900">
                    {{ $avgResolution ? number_format($avgResolution, 1) . 'h' : 'N/A' }}
                </p>
                <p class="mt-1 text-xs text-blue-700">Average time to resolve</p>
            </div>
        </section>

        {{-- Charts Row 1 --}}
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2 mb-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Incident Frequency</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900">Reports by Hour of Day</h2>
                <p class="mt-1 text-sm text-slate-500">Identifies peak congestion windows across the day.</p>
                <div class="mt-6">
                    <canvas id="hourChart" height="120"></canvas>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Weekly Pattern</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900">Reports by Day of Week</h2>
                <p class="mt-1 text-sm text-slate-500">Reveals which days require higher enforcer deployment.</p>
                <div class="mt-6">
                    <canvas id="dayChart" height="120"></canvas>
                </div>
            </div>
        </section>

        {{-- Charts Row 2 --}}
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2 mb-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Incident Breakdown</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900">Reports by Type</h2>
                <p class="mt-1 text-sm text-slate-500">Most common incident categories reported by citizens.</p>
                <div class="mt-6 flex justify-center">
                    <canvas id="typeChart" height="180"></canvas>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Resolution Pipeline</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900">Reports by Status</h2>
                <p class="mt-1 text-sm text-slate-500">Shows how reports flow through the response workflow.</p>
                <div class="mt-6 flex justify-center">
                    <canvas id="statusChart" height="180"></canvas>
                </div>
            </div>
        </section>

        {{-- Most Common Type --}}
        <section class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Risk Insight</p>
            <p class="mt-2 text-lg font-bold text-emerald-900">
                Most reported incident: <span
                    class="capitalize">{{ ucwords(str_replace('_', ' ', $mostCommonType)) }}</span>
            </p>
            <p class="mt-1 text-sm text-emerald-700">
                Peak reporting hour is <strong>{{ str_pad($peakHour, 2, '0', STR_PAD_LEFT) }}:00</strong>,
                busiest day is
                <strong>{{ ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$peakDay] }}</strong>.
                @if($avgResolution)
                    Average resolution time is <strong>{{ number_format($avgResolution, 1) }} hours</strong>.
                @endif
                Use this data to pre-position enforcers during high-risk windows.
            </p>
        </section>

    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const hourLabels = @json($hourLabels);
                const hourData = @json($hourData);
                const dayLabels = @json($dayLabels);
                const dayData = @json($dayData);
                const typeLabels = @json($typeBreakdown->keys()->map(fn($k) => ucwords(str_replace('_', ' ', $k))));
                const typeData = @json($typeBreakdown->values());
                const statusLabels = @json($statusFunnel->keys()->map(fn($k) => ucwords(str_replace('_', ' ', $k))));
                const statusData = @json($statusFunnel->values());

                // Hour Chart
                new Chart(document.getElementById('hourChart'), {
                    type: 'bar',
                    data: {
                        labels: hourLabels,
                        datasets: [{
                            label: 'Reports',
                            data: hourData,
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderRadius: 6,
                        }]
                    },
                    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
                });

                // Day Chart
                new Chart(document.getElementById('dayChart'), {
                    type: 'bar',
                    data: {
                        labels: dayLabels,
                        datasets: [{
                            label: 'Reports',
                            data: dayData,
                            backgroundColor: 'rgba(239, 68, 68, 0.7)',
                            borderRadius: 6,
                        }]
                    },
                    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
                });

                // Type Chart
                new Chart(document.getElementById('typeChart'), {
                    type: 'doughnut',
                    data: {
                        labels: typeLabels,
                        datasets: [{
                            data: typeData,
                            backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444', '#10b981', '#8b5cf6', '#06b6d4', '#f97316'],
                        }]
                    },
                    options: { plugins: { legend: { position: 'bottom' } } }
                });

                // Status Chart
                new Chart(document.getElementById('statusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusData,
                            backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#06b6d4', '#10b981', '#ef4444'],
                        }]
                    },
                    options: { plugins: { legend: { position: 'bottom' } } }
                });
            });
        </script>
    @endpush

</x-app-nav>