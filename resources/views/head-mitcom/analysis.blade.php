<x-app-nav title="Traffic Risk Analysis" page-title="Traffic Risk Analysis" page-eyebrow="HEAD MITCOM">

    <main class="mx-auto max-w-7xl px-4 py-8 lg:px-8 space-y-8">

        {{-- Page Header --}}
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Traffic Risk Analysis</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Data-driven insights from citizen incident reports — use this to plan enforcer deployment and manage traffic flow proactively.
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-700 self-start sm:self-auto">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Live Data
            </span>
        </div>

        {{-- Summary Cards --}}
        <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">

            {{-- Total Reports --}}
            <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Total Reports</p>
                        <p class="mt-3 text-4xl font-black text-slate-900 tabular-nums">{{ $reports->count() }}</p>
                        <p class="mt-1.5 text-xs text-slate-500">All-time incident reports</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600 shrink-0" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Peak Hour --}}
            <div class="group relative overflow-hidden rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Peak Hour</p>
                        <p class="mt-3 text-4xl font-black text-amber-900 tabular-nums">
                            {{ str_pad($peakHour, 2, '0', STR_PAD_LEFT) }}:00
                        </p>
                        <p class="mt-1.5 text-xs text-amber-700">Highest incident frequency</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700 shrink-0" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Busiest Day --}}
            <div class="group relative overflow-hidden rounded-2xl border border-rose-200 bg-gradient-to-br from-rose-50 to-pink-50 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-rose-600">Busiest Day</p>
                        <p class="mt-3 text-4xl font-black text-rose-900">
                            {{ ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][$peakDay] }}
                        </p>
                        <p class="mt-1.5 text-xs text-rose-700">Most reports submitted</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 text-rose-700 shrink-0" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                        </svg>
                    </span>
                </div>
            </div>

            {{-- Avg Resolution --}}
            <div class="group relative overflow-hidden rounded-2xl border border-blue-200 bg-gradient-to-br from-blue-50 to-indigo-50 p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">Avg Resolution</p>
                        <p class="mt-3 text-4xl font-black text-blue-900 tabular-nums">
                            {{ $avgResolution ? number_format($avgResolution, 1) . 'h' : 'N/A' }}
                        </p>
                        <p class="mt-1.5 text-xs text-blue-700">Average time to resolve</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700 shrink-0" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
            </div>

        </section>

        {{-- What do these numbers mean? Help section --}}
        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                <svg class="h-4 w-4 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                How to Read This Dashboard
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs text-slate-600">
                <div class="flex gap-2 items-start">
                    <span class="text-slate-400 mt-0.5 shrink-0" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h3.75A2.25 2.25 0 0111.25 6v3.75A2.25 2.25 0 018.25 12H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h3.75a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v3.75A2.25 2.25 0 0118 12h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </span>
                    <span><strong class="text-slate-700">Total Reports</strong> — how many incidents citizens have recorded in the system overall.</span>
                </div>
                <div class="flex gap-2 items-start">
                    <span class="text-slate-400 mt-0.5 shrink-0" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span><strong class="text-slate-700">Peak Hour</strong> — the time of day with the most incidents; deploy more enforcers around this window.</span>
                </div>
                <div class="flex gap-2 items-start">
                    <span class="text-slate-400 mt-0.5 shrink-0" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                        </svg>
                    </span>
                    <span><strong class="text-slate-700">Busiest Day</strong> — the weekday with the highest report volume; plan heavier coverage on this day.</span>
                </div>
                <div class="flex gap-2 items-start">
                    <span class="text-slate-400 mt-0.5 shrink-0" aria-hidden="true">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span><strong class="text-slate-700">Avg Resolution</strong> — how long it takes on average to close an incident from the time it was reported.</span>
                </div>
            </div>
        </section>

        {{-- Charts Row 1: Hourly & Weekly --}}
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <div>
                        <span class="inline-flex items-center rounded-full bg-blue-50 border border-blue-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-blue-600">Incident Frequency</span>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">Reports by Hour of Day</h2>
                        <p class="mt-0.5 text-sm text-slate-500">When do incidents peak? Use this to schedule enforcer shifts and traffic patrols.</p>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V11m8 8V5m8 14v-7" />
                        </svg>
                    </span>
                </div>
                <div class="mt-5">
                    <canvas id="hourChart" height="130"></canvas>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <div>
                        <span class="inline-flex items-center rounded-full bg-rose-50 border border-rose-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-rose-600">Weekly Pattern</span>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">Reports by Day of Week</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Which days carry the highest risk? Allocate resources and plan ahead accordingly.</p>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                        </svg>
                    </span>
                </div>
                <div class="mt-5">
                    <canvas id="dayChart" height="130"></canvas>
                </div>
            </div>

        </section>

        {{-- Charts Row 2: Type & Status --}}
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <div>
                        <span class="inline-flex items-center rounded-full bg-violet-50 border border-violet-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-violet-600">Incident Breakdown</span>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">Reports by Type</h2>
                        <p class="mt-0.5 text-sm text-slate-500">What types of incidents are most common? Use this to identify training and resource priorities.</p>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-5 flex justify-center">
                    <canvas id="typeChart" height="200" style="max-height:260px"></canvas>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <div>
                        <span class="inline-flex items-center rounded-full bg-teal-50 border border-teal-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-teal-600">Resolution Pipeline</span>
                        <h2 class="mt-2 text-lg font-bold text-slate-900">Reports by Status</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Track how reports progress — from pending to resolved. A large backlog may signal resource gaps.</p>
                    </div>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-600" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </span>
                </div>
                <div class="mt-5 flex justify-center">
                    <canvas id="statusChart" height="200" style="max-height:260px"></canvas>
                </div>
            </div>

        </section>

        {{-- Risk Insight Banner --}}
        <section class="rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-teal-50 p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700" aria-hidden="true">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-1">Key Risk Insight</p>
                    <p class="text-base font-bold text-emerald-900">
                        Most reported incident:
                        <span class="capitalize">{{ ucwords(str_replace('_', ' ', $mostCommonType)) }}</span>
                    </p>
                    <p class="mt-2 text-sm text-emerald-800 leading-relaxed">
                        The highest volume of reports occurs at
                        <strong>{{ str_pad($peakHour, 2, '0', STR_PAD_LEFT) }}:00</strong>
                        on
                        <strong>{{ ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$peakDay] }}s</strong>.
                        @if($avgResolution)
                            The team is resolving incidents in an average of <strong>{{ number_format($avgResolution, 1) }} hours</strong>.
                        @endif
                    </p>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="rounded-xl bg-white border border-emerald-100 px-4 py-3 text-sm">
                            <p class="font-semibold text-emerald-800 flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                                Recommended Action
                            </p>
                            <p class="mt-0.5 text-emerald-700 text-xs">Pre-position enforcers at high-risk spots before <strong>{{ str_pad($peakHour, 2, '0', STR_PAD_LEFT) }}:00</strong>.</p>
                        </div>
                        <div class="rounded-xl bg-white border border-emerald-100 px-4 py-3 text-sm">
                            <p class="font-semibold text-emerald-800 flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                                </svg>
                                High-Risk Day
                            </p>
                            <p class="mt-0.5 text-emerald-700 text-xs">Increase patrols every <strong>{{ ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$peakDay] }}</strong> during peak windows.</p>
                        </div>
                        <div class="rounded-xl bg-white border border-emerald-100 px-4 py-3 text-sm">
                            <p class="font-semibold text-emerald-800 flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                                Top Incident Type
                            </p>
                            <p class="mt-0.5 text-emerald-700 text-xs">Focus training/resources on: <strong class="capitalize">{{ ucwords(str_replace('_', ' ', $mostCommonType)) }}</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const hourLabels  = @json($hourLabels);
                const hourData    = @json($hourData);
                const dayLabels   = @json($dayLabels);
                const dayData     = @json($dayData);
                const typeLabels  = @json($typeBreakdown->keys()->map(fn($k) => ucwords(str_replace('_', ' ', $k))));
                const typeData    = @json($typeBreakdown->values());
                const statusLabels = @json($statusFunnel->keys()->map(fn($k) => ucwords(str_replace('_', ' ', $k))));
                const statusData  = @json($statusFunnel->values());

                const peakHour = {{ $peakHour }};
                const peakDay  = {{ $peakDay }};

                // Shared tooltip style
                const tooltipDefaults = {
                    backgroundColor: '#1e293b',
                    titleColor: '#f8fafc',
                    bodyColor: '#cbd5e1',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                };

                // Bar colours: highlight peak hour in amber, rest in blue
                const hourColors = hourData.map((_, i) =>
                    i === peakHour ? 'rgba(245,158,11,0.9)' : 'rgba(59,130,246,0.6)'
                );

                // Bar colours: highlight peak day in rose, rest in slate-blue
                const dayColors = dayData.map((_, i) =>
                    i === peakDay ? 'rgba(239,68,68,0.9)' : 'rgba(100,116,139,0.5)'
                );

                const palette = ['#3b82f6','#f59e0b','#ef4444','#10b981','#8b5cf6','#06b6d4','#f97316','#84cc16'];

                // Hour Chart
                new Chart(document.getElementById('hourChart'), {
                    type: 'bar',
                    data: {
                        labels: hourLabels,
                        datasets: [{
                            label: 'Reports',
                            data: hourData,
                            backgroundColor: hourColors,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                ...tooltipDefaults,
                                callbacks: {
                                    title: ctx => ctx[0].label,
                                    label: ctx => `${ctx.raw} report${ctx.raw !== 1 ? 's' : ''}${ctx.dataIndex === peakHour ? ' · Peak hour' : ''}`,
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                        }
                    }
                });

                // Day Chart
                new Chart(document.getElementById('dayChart'), {
                    type: 'bar',
                    data: {
                        labels: dayLabels,
                        datasets: [{
                            label: 'Reports',
                            data: dayData,
                            backgroundColor: dayColors,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                ...tooltipDefaults,
                                callbacks: {
                                    title: ctx => ctx[0].label,
                                    label: ctx => `${ctx.raw} report${ctx.raw !== 1 ? 's' : ''}${ctx.dataIndex === peakDay ? ' · Busiest day' : ''}`,
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });

                // Type Chart
                new Chart(document.getElementById('typeChart'), {
                    type: 'doughnut',
                    data: {
                        labels: typeLabels,
                        datasets: [{
                            data: typeData,
                            backgroundColor: palette,
                            hoverOffset: 8,
                            borderWidth: 2,
                            borderColor: '#fff',
                        }]
                    },
                    options: {
                        cutout: '60%',
                        plugins: {
                            legend: { position: 'bottom', labels: { padding: 14, font: { size: 12 } } },
                            tooltip: {
                                ...tooltipDefaults,
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${ctx.raw} reports (${Math.round(ctx.parsed / typeData.reduce((a,b)=>a+b,0) * 100)}%)`,
                                }
                            }
                        }
                    }
                });

                // Status Chart
                new Chart(document.getElementById('statusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusData,
                            backgroundColor: ['#f59e0b','#3b82f6','#8b5cf6','#06b6d4','#10b981','#ef4444'],
                            hoverOffset: 8,
                            borderWidth: 2,
                            borderColor: '#fff',
                        }]
                    },
                    options: {
                        cutout: '60%',
                        plugins: {
                            legend: { position: 'bottom', labels: { padding: 14, font: { size: 12 } } },
                            tooltip: {
                                ...tooltipDefaults,
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${ctx.raw} reports (${Math.round(ctx.parsed / statusData.reduce((a,b)=>a+b,0) * 100)}%)`,
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-app-nav>
