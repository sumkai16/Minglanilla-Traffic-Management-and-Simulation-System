<x-dashboard-shell title="Audit Log" page-title="Audit Log"
    page-eyebrow="System Administration"
    page-description="A chronological record of all system actions performed across reports, advisories, and announcements.">

    <x-slot:actions>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            ← Back to Dashboard
        </a>
    </x-slot:actions>

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Filters --}}
        <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Filters</p>
           <form method="GET" action="{{ route('admin.audit-log') }}" class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4" x-data id="filter-form">
                <div>
                    <label class="text-xs font-semibold text-slate-500">Event Type</label>
                    <select name="event" @change="$el.form.submit()"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">All Events</option>
                        <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500">Subject</label>
                   <select name="subject" @change="$el.form.submit()"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">All Subjects</option>
                        <option value="Report" {{ request('subject') === 'Report' ? 'selected' : '' }}>Report</option>
                        <option value="Announcement" {{ request('subject') === 'Announcement' ? 'selected' : '' }}>Announcement</option>
                        <option value="TrafficAdvisory" {{ request('subject') === 'TrafficAdvisory' ? 'selected' : '' }}>Traffic Advisory</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500">Performed By</label>
                    <input type="text" name="causer" value="{{ request('causer') }}"
                    placeholder="Search by name..."
                    x-data="{ timeout: null }"
                    @input="clearTimeout(timeout); timeout = setTimeout(() => $el.form.submit(), 500)"
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500">Date From</label>
                   <input type="date" name="date_from" value="{{ request('date_from') }}" @change="$el.form.submit()"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500">Date To</label>
                   <input type="date" name="date_to" value="{{ request('date_to') }}" @change="$el.form.submit()"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>
                <div class="flex items-end gap-2 sm:col-span-2 xl:col-span-3">
                   
                    @if(request()->anyFilled(['event', 'subject', 'causer', 'date_from', 'date_to']))
                        <a href="{{ route('admin.audit-log') }}"
                            class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </section>

        {{-- Log Table --}}
        <section class="rounded-[2rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Activity Trail</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-950">System-wide actions</h3>
                </div>
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-600">
                    {{ $logs->total() }} {{ Str::plural('entry', $logs->total()) }}
                </span>
            </div>

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
                            'created' => 'bg-emerald-100 text-emerald-700',
                            'updated' => 'bg-blue-100 text-blue-700',
                            'deleted' => 'bg-rose-100 text-rose-700',
                        ];
                        $eventColor = $colors[$log->event] ?? 'bg-slate-100 text-slate-600';
                        $initials = $causer
                            ? strtoupper(substr($causer->first_name ?? 'S', 0, 1) . substr($causer->last_name ?? '', 0, 1))
                            : 'SY';
                        $attributes = $log->properties->get('attributes') ?? [];
                    @endphp
                    <div class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white text-xs font-bold">
                            {{ $initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-semibold text-slate-900">
                                    {{ $causer ? $causer->first_name . ' ' . $causer->last_name : 'System' }}
                                </span>
                                @if($causer)
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-500 uppercase tracking-wide">
                                        {{ $causer->role }}
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
                        <p class="text-sm font-semibold text-slate-500">No activity recorded yet.</p>
                        <p class="mt-1 text-xs text-slate-400">Actions on reports, advisories, and announcements will appear here.</p>
                    </div>
                @endforelse
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </section>
    </div>
</x-dashboard-shell>