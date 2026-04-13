<x-app-nav title="Audit Log" page-title="Audit Log" page-eyebrow="System Administration">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalLogs = $logs->total();
                $createdCount = \Spatie\Activitylog\Models\Activity::where('event', 'created')->count();
                $updatedCount = \Spatie\Activitylog\Models\Activity::where('event', 'updated')->count();
                $deletedCount = \Spatie\Activitylog\Models\Activity::where('event', 'deleted')->count();
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Entries</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalLogs }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Created</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $createdCount }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Updated</p>
                <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $updatedCount }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Deleted</p>
                <p class="text-3xl font-bold text-red-500 mt-1">{{ $deletedCount }}</p>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Activity Trail</h2>
                        <p class="text-xs text-slate-500 mt-1">Chronological record of all system actions across reports, advisories, and announcements</p>
                    </div>
                    <span class="text-sm text-slate-400 font-medium px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                        {{ $logs->total() }} {{ Str::plural('entry', $logs->total()) }}
                    </span>
                </div>

                {{-- Filter Bar --}}
                <form method="GET" action="{{ route('admin.audit-log') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
                    <div class="relative md:col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="causer" value="{{ request('causer') }}" placeholder="Search by user name..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400">
                    </div>

                    <div>
                        <select name="event"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="">All Events</option>
                            <option value="created" @selected(request('event') === 'created')>Created</option>
                            <option value="updated" @selected(request('event') === 'updated')>Updated</option>
                            <option value="deleted" @selected(request('event') === 'deleted')>Deleted</option>
                        </select>
                    </div>

                    <div>
                        <select name="subject"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="">All Subjects</option>
                            <option value="Report" @selected(request('subject') === 'Report')>Report</option>
                            <option value="Announcement" @selected(request('subject') === 'Announcement')>Announcement</option>
                            <option value="TrafficAdvisory" @selected(request('subject') === 'TrafficAdvisory')>Traffic Advisory</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600"
                            placeholder="From" title="Date from">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm">
                            Apply
                        </button>
                        @if(request()->anyFilled(['event', 'subject', 'causer', 'date_from', 'date_to']))
                            <a href="{{ route('admin.audit-log') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50 transition" title="Clear Filters">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    {{-- Hidden date_to preserves the value if already set --}}
                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                </form>
            </div>

            {{-- Activity List --}}
            <div class="divide-y divide-slate-100">
                @forelse($logs as $log)
                    @php
                        $causer = $log->causer;
                        $subjectType = $log->subject_type
                            ? class_basename($log->subject_type)
                            : 'System';
                        $subjectLabel = match($subjectType) {
                            'TrafficAdvisory' => 'Advisory',
                            default => $subjectType,
                        };
                        $colors = [
                            'created' => 'bg-green-100 text-green-700',
                            'updated' => 'bg-blue-100 text-blue-700',
                            'deleted' => 'bg-red-100 text-red-700',
                        ];
                        $eventColor = $colors[$log->event] ?? 'bg-slate-100 text-slate-600';
                        $initials = $causer
                            ? strtoupper(substr($causer->first_name ?? 'S', 0, 1) . substr($causer->last_name ?? '', 0, 1))
                            : 'SY';
                        $attributes = $log->properties->get('attributes') ?? [];
                    @endphp
                    <div class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-700 to-slate-900 text-white text-xs font-bold">
                            {{ $initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-semibold text-slate-900">
                                    {{ $causer ? $causer->first_name . ' ' . $causer->last_name : 'System' }}
                                </span>
                                @if($causer)
                                    <span @class([
                                        'px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide',
                                        'bg-purple-100 text-purple-700' => $causer->role === 'admin',
                                        'bg-yellow-100 text-yellow-700' => $causer->role === 'head-mitcom',
                                        'bg-green-100 text-green-700' => $causer->role === 'enforcer',
                                        'bg-blue-100 text-blue-700' => $causer->role === 'user',
                                    ])>
                                        {{ str_replace('-', ' ', $causer->role) }}
                                    </span>
                                @endif
                                <span class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide {{ $eventColor }}">
                                    {{ $log->event ?? 'action' }}
                                </span>
                                <span class="text-xs text-slate-400">on</span>
                                <span class="text-xs font-semibold text-slate-600">{{ $subjectLabel }}</span>
                            </div>
                            <p class="mt-0.5 text-xs text-slate-500">{{ $log->description }}</p>
                            @if(!empty($attributes))
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($attributes as $key => $value)
                                        @php
                                            $displayValue = $value;
                                            if ($key === 'assigned_to' && isset($enforcers[$value])) {
                                                $e = $enforcers[$value];
                                                $displayValue = $e->first_name . ' ' . $e->last_name;
                                            }
                                        @endphp
                                        <span class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] text-slate-600">
                                            {{ $key }}: {{ is_array($displayValue) ? json_encode($displayValue) : $displayValue }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0 text-right">
                            <p class="text-xs text-slate-400">{{ $log->created_at->diffForHumans() }}</p>
                            <p class="mt-0.5 text-[10px] text-slate-300">{{ $log->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <p class="text-sm text-slate-300">No activity recorded yet.</p>
                        <p class="mt-1 text-xs text-slate-300">Actions on reports, advisories, and announcements will appear here.</p>
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        </div>
    </main>
</x-app-nav>