<x-app-nav title="Audit Log" page-title="System Activity Timeline" page-eyebrow="System Administration" page-description="A chronological record of all system modifications, access events, and data changes for security and auditing purposes.">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8" x-data="{ 
        activeLog: null, 
        showDetail: false,
        users: {{ $allUsers->keyBy('id')->toJson() }},
        openInspector(log) {
            this.activeLog = log;
            this.showDetail = true;
            document.body.style.overflow = 'hidden';
        },
        closeInspector() {
            this.showDetail = false;
            setTimeout(() => { this.activeLog = null; }, 300);
            document.body.style.overflow = 'auto';
        },
        resolveUser(id) {
            if (!id) return 'Unknown';
            let u = this.users[id];
            return u ? `${u.first_name} ${u.last_name}` : `User #${id}`;
        },
        formatDate(date) {
            if (!date) return 'N/A';
            return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }
    }">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
            @php
                $totalLogs = $logs->total();
                $createdCount = \Spatie\Activitylog\Models\Activity::where('event', 'created')->count();
                $updatedCount = \Spatie\Activitylog\Models\Activity::where('event', 'updated')->count();
                $deletedCount = \Spatie\Activitylog\Models\Activity::where('event', 'deleted')->count();
            @endphp
            
            <div class="group relative bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-default">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-80"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Total Entries</p>
                            <p class="text-4xl font-black text-slate-800 mt-2 tracking-tight">{{ number_format($totalLogs) }}</p>
                        </div>
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-2xl shadow-sm ring-1 ring-blue-100/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-default">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-green-500 opacity-80"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Records Created</p>
                            <p class="text-4xl font-black text-slate-800 mt-2 tracking-tight">{{ number_format($createdCount) }}</p>
                        </div>
                        <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-2xl shadow-sm ring-1 ring-emerald-100/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-default">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-500 opacity-80"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Data Updated</p>
                            <p class="text-4xl font-black text-slate-800 mt-2 tracking-tight">{{ number_format($updatedCount) }}</p>
                        </div>
                        <div class="p-2.5 bg-cyan-50 text-cyan-600 rounded-2xl shadow-sm ring-1 ring-cyan-100/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-default">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-rose-500 opacity-80"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Items Deleted</p>
                            <p class="text-4xl font-black text-slate-800 mt-2 tracking-tight">{{ number_format($deletedCount) }}</p>
                        </div>
                        <div class="p-2.5 bg-rose-50 text-rose-600 rounded-2xl shadow-sm ring-1 ring-rose-100/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Section --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200/80 overflow-hidden">
                
                {{-- Search & Filter Toolbar --}}
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <form method="GET" action="{{ route('admin.audit-log') }}" class="flex flex-col xl:flex-row gap-4 xl:items-center xl:justify-between">
                    <div class="flex-1 w-full xl:w-auto relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="causer" value="{{ request('causer') }}" placeholder="Search by user name or email..."
                            class="w-full pl-10 pr-4 py-2.5 text-sm border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 placeholder:text-slate-400 shadow-sm transition-all bg-white font-medium text-slate-700">
                    </div>

                    <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
                        <select name="event" class="flex-1 min-w-[140px] py-2.5 pl-4 pr-10 text-sm border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-600 bg-white shadow-sm transition-all font-medium">
                            <option value="">All Events</option>
                            @isset($events)
                                @foreach($events as $evt)
                                    <option value="{{ $evt }}" @selected(request('event') === $evt)>{{ str($evt)->title()->replace('_', ' ') }}</option>
                                @endforeach
                            @endisset
                        </select>

                        <select name="subject" class="flex-1 min-w-[140px] py-2.5 pl-4 pr-10 text-sm border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-600 bg-white shadow-sm transition-all font-medium">
                            <option value="">All Subjects</option>
                            @isset($subjects)
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj }}" @selected(request('subject') === $subj)>{{ str($subj)->headline() }}</option>
                                @endforeach
                            @endisset
                        </select>

                        <div class="flex-1 min-w-[160px] flex items-center gap-2 bg-white border border-slate-200 shadow-sm rounded-xl px-3 py-2.5 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-500 transition-all">
                             <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                             <input type="date" name="date_from" value="{{ request('date_from') }}" class="border-0 p-0 text-sm focus:ring-0 text-slate-600 w-full bg-transparent font-medium" placeholder="From date" title="Filter from date">
                        </div>
                        <input type="hidden" name="date_to" value="{{ request('date_to') }}">

                        <div class="flex items-center gap-2 sm:ml-auto">
                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors shadow-sm shadow-slate-900/10 text-sm">
                                Apply Filters
                            </button>
                            
                            @if(request()->anyFilled(['event', 'subject', 'causer', 'date_from', 'date_to']))
                                <a href="{{ route('admin.audit-log') }}" class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all" title="Clear Filters">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- Activity Timeline --}}
            <div class="px-6 py-10 relative bg-slate-50/30">
                @if($logs->count() > 0)
                    {{-- Continuous Vertical Connector Line --}}
                    <div class="absolute top-10 bottom-10 left-[4.25rem] w-0.5 bg-slate-200/70 hidden sm:block"></div>
                @endif

                @php $currentDate = null; @endphp
                @forelse($logs as $log)
                    @php
                        $logDate = $log->created_at->format('Y-m-d');
                        $displayDate = $log->created_at->isToday()
                            ? 'Today' : ($log->created_at->isYesterday()
                            ? 'Yesterday' : $log->created_at->format('F j, Y'));
                    @endphp

                    @if($currentDate !== $logDate)
                        <div class="relative flex items-center gap-4 mb-6 mt-8 first:mt-0 z-10 pl-2 sm:pl-[2.75rem]">
                            <div class="bg-white text-slate-500 text-xs font-bold px-4 py-1.5 rounded-xl border border-slate-200 shadow-sm uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                {{ $displayDate }}
                            </div>
                        </div>
                        @php $currentDate = $logDate; @endphp
                    @endif

                    @php
                        $causer = $log->causer;
                        $subjectType = $log->subject_type ? class_basename($log->subject_type) : 'System';
                        $subjectLabel = match($subjectType) {
                            'TrafficAdvisory' => 'Advisory',
                            default => $subjectType,
                        };
                        
                        if ($log->log_name === 'auth') {
                            $subjectLabel = 'Authentication';
                        }
                        
                        $eventConfig = match($log->event) {
                            'created' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200/60', 'line' => 'bg-emerald-400', 'iconBg' => 'bg-emerald-100', 'iconText' => 'text-emerald-600', 'icon' => '<path d="M12 4v16m8-8H4" />'],
                            'updated' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200/60', 'line' => 'bg-blue-400', 'iconBg' => 'bg-blue-100', 'iconText' => 'text-blue-600', 'icon' => '<path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />'],
                            'deleted' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200/60', 'line' => 'bg-rose-400', 'iconBg' => 'bg-rose-100', 'iconText' => 'text-rose-600', 'icon' => '<path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />'],
                            'login' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200/60', 'line' => 'bg-purple-400', 'iconBg' => 'bg-purple-100', 'iconText' => 'text-purple-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />'],
                            'logout' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200/60', 'line' => 'bg-slate-300', 'iconBg' => 'bg-slate-200', 'iconText' => 'text-slate-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />'],
                            'failed_login' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200/60', 'line' => 'bg-amber-400', 'iconBg' => 'bg-amber-100', 'iconText' => 'text-amber-600', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'],
                            default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'line' => 'bg-slate-400', 'iconBg' => 'bg-slate-200', 'iconText' => 'text-slate-500', 'icon' => '<path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />']
                        };

                        $initials = $causer
                            ? strtoupper(substr($causer->first_name ?? 'S', 0, 1) . substr($causer->last_name ?? '', 0, 1))
                            : 'SY';

                        $hasOld = $log->properties->has('old');
                        $hasAttributes = $log->properties->has('attributes');
                        $attributes = $log->properties->get('attributes') ?? [];
                        $old = $log->properties->get('old') ?? [];
                        if(empty($attributes) && empty($old)) $hasAttributes = false;
                        
                        $subjectUser = ($log->subject instanceof \App\Models\User) ? $log->subject : null;
                    @endphp

                    <div class="relative flex flex-col sm:flex-row gap-5 mb-8 z-10 group cursor-pointer" 
                         @click="openInspector({
                            id: '{{ $log->id }}',
                            event: '{{ $log->event }}',
                            description: '{{ $log->description }}',
                            time: '{{ $log->created_at->format('M d, Y \a\t g:i A') }}',
                            diff: '{{ $log->created_at->diffForHumans() }}',
                            causer: {
                                id: '{{ $causer->id ?? "" }}',
                                name: '{{ $causer ? $causer->first_name . " " . $causer->last_name : "System Protocol" }}',
                                email: '{{ $causer->email ?? "N/A" }}',
                                role: '{{ $causer ? str($causer->role)->headline() : "Automated" }}',
                                joinDate: '{{ $causer->created_at ?? "" }}',
                                initials: '{{ $initials }}'
                            },
                            subjectUser: {
                                exists: {{ $subjectUser ? 'true' : 'false' }},
                                id: '{{ $subjectUser->id ?? "" }}',
                                name: '{{ $subjectUser ? $subjectUser->first_name . " " . $subjectUser->last_name : "N/A" }}',
                                email: '{{ $subjectUser->email ?? "N/A" }}',
                                role: '{{ $subjectUser ? str($subjectUser->role)->headline() : "N/A" }}',
                                joinDate: '{{ $subjectUser->created_at ?? "" }}'
                            },
                            attributes: {{ json_encode($attributes) }},
                            old: {{ json_encode($old) }},
                            eventConfig: {{ json_encode($eventConfig) }}
                         })">
                        <div class="relative flex-none hidden sm:flex flex-col items-center pl-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm z-10 transition-transform group-hover:scale-105 duration-300 {{ $causer ? 'bg-[linear-gradient(135deg,rgba(30,64,175,1),rgba(29,78,216,1))] text-white border-2 border-white' : 'bg-slate-100 border-2 border-slate-200 text-slate-500' }}">
                                @if($causer)
                                    <span class="text-sm font-bold tracking-widest">{{ $initials }}</span>
                                @else
                                    <span class="text-sm font-bold tracking-widest">SY</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 min-w-0 pr-4 sm:pr-8 pl-4 sm:pl-0 pt-1 sm:pt-0">
                            <div class="bg-white border {{ $eventConfig['border'] }} rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group-hover:border-slate-300">
                                <div class="absolute top-0 left-0 bottom-0 w-1.5 {{ $eventConfig['line'] }}"></div>
                                <div class="p-5 pl-7">
                                    <div class="flex flex-col xl:flex-row xl:items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <div class="w-6 h-6 sm:hidden rounded-lg flex items-center justify-center text-[9px] font-bold {{ $causer ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                                    {{ $initials }}
                                                </div>
                                                <span class="text-[15px] font-bold text-slate-900 tracking-tight">
                                                    {{ $causer ? $causer->first_name . ' ' . $causer->last_name : 'System Protocol' }}
                                                </span>
                                                @if($causer)
                                                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">
                                                        {{ str_replace('-', ' ', $causer->role) }}
                                                    </span>
                                                @endif
                                                <svg class="w-4 h-4 text-slate-300 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                                <span class="flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $eventConfig['bg'] }} {{ $eventConfig['text'] }} border {{ $eventConfig['border'] }}">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">{!! $eventConfig['icon'] !!}</svg>
                                                    {{ $log->event }}
                                                </span>
                                                <span class="text-xs font-semibold text-slate-400 hidden sm:inline">a</span>
                                                <span class="text-[11px] font-bold text-slate-600 bg-white border border-slate-200 shadow-sm px-2.5 py-0.5 rounded-lg ml-auto sm:ml-0">{{ $subjectLabel }}</span>
                                            </div>
                                            
                                            <div class="flex items-center gap-1.5 text-[11px] font-medium text-slate-400 mb-2">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                                {{ $causer->email ?? 'no-email@system.com' }}
                                            </div>

                                            <p class="text-[14px] text-slate-600 leading-relaxed font-medium">{{ $log->description }}</p>
                                        </div>
                                        <div class="shrink-0 flex flex-row xl:flex-col items-center xl:items-end justify-between xl:justify-start gap-2 border-t xl:border-t-0 border-slate-100 pt-3 xl:pt-0 mt-2 xl:mt-0">
                                            <div class="flex items-center gap-1.5 text-slate-500 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span class="text-[11px] font-bold">{{ $log->created_at->format('g:i A') }}</span>
                                            </div>
                                            <span class="text-[11px] font-medium text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    @if($hasAttributes)
                                        <div class="mt-5 pt-5 border-t border-slate-100/80 relative">
                                            <span class="absolute -top-2.5 left-4 bg-white px-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Captured Changes</span>
                                            @if($hasOld && count($old) > 0)
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                    @foreach($attributes as $key => $newValue)
                                                        @php
                                                            $oldValue = $old[$key] ?? null;
                                                            $displayNew = $newValue;
                                                            $displayOld = $oldValue;
                                                            if (str_ends_with($key, '_id') || $key === 'assigned_to') {
                                                                if (isset($allUsers->keyBy('id')[$newValue])) {
                                                                    $u = $allUsers->keyBy('id')[$newValue];
                                                                    $displayNew = $u->first_name . ' ' . $u->last_name;
                                                                }
                                                                if ($oldValue !== null && isset($allUsers->keyBy('id')[$oldValue])) {
                                                                    $u = $allUsers->keyBy('id')[$oldValue];
                                                                    $displayOld = $u->first_name . ' ' . $u->last_name;
                                                                }
                                                            }
                                                            $formatValInLoop = function($val) {
                                                                if ($val === null || $val === 'null') return 'None';
                                                                if (is_array($val)) return json_encode($val);
                                                                if (is_string($val) && preg_match('/^\d{4}-\d{2}-\d{2}/', $val)) {
                                                                    try { return \Carbon\Carbon::parse($val)->format('M d, Y'); } catch (\Exception $e) { return $val; }
                                                                }
                                                                if ($val === true || $val === 1 || $val === '1') return 'Enabled';
                                                                if ($val === false || $val === 0 || $val === '0') return 'Disabled';
                                                                return str($val)->headline();
                                                            };
                                                            $displayNewStr = $formatValInLoop($displayNew);
                                                            $displayOldStr = ($oldValue === null) ? '&mdash;' : $formatValInLoop($displayOld);
                                                            $isChanged = (string)$displayNewStr !== (string)$displayOldStr;
                                                        @endphp
                                                        @if($isChanged)
                                                            <div class="flex flex-col p-3 bg-slate-50/50 hover:bg-slate-50 border border-slate-200/60 rounded-xl shadow-[0_1px_2px_rgba(0,0,0,0.02)] transition-colors">
                                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                                    {{ str($key)->headline() }}
                                                                </span>
                                                                <div class="flex flex-col gap-1.5 shadow-xs">
                                                                    <div class="flex items-center gap-2 text-xs">
                                                                        <span class="font-semibold text-rose-600 bg-white border-l-2 border-rose-400 px-2 py-1 rounded-r border-y border-r border-slate-200/60 flex-1 truncate line-through decoration-rose-300" title="{{ $displayOldStr }}">{!! $displayOldStr !!}</span>
                                                                    </div>
                                                                    <div class="flex items-center gap-2 text-xs">
                                                                        <span class="font-bold text-emerald-700 bg-white border-l-2 border-emerald-400 px-2 py-1 rounded-r border-y border-r border-slate-200/60 flex-1 truncate" title="{{ $displayNewStr }}">{!! $displayNewStr !!}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="flex flex-wrap gap-2 mt-1">
                                                     @foreach($attributes as $key => $value)
                                                         @php
                                                             $displayValue = $value;
                                                             if (str_ends_with($key, '_id') || $key === 'assigned_to') {
                                                                 if (isset($allUsers->keyBy('id')[$value])) {
                                                                     $u = $allUsers->keyBy('id')[$value];
                                                                     $displayValue = $u->first_name . ' ' . $u->last_name;
                                                                 }
                                                             }
                                                             $formatValSingle = function($val) {
                                                                if ($val === null || $val === 'null') return 'Empty';
                                                                if (is_array($val)) return json_encode($val);
                                                                if (is_string($val) && preg_match('/^\d{4}-\d{2}-\d{2}/', $val)) {
                                                                    try { return \Carbon\Carbon::parse($val)->format('M d, Y'); } catch (\Exception $e) { return $val; }
                                                                }
                                                                if ($val === true || $val === 1 || $val === '1') return 'Yes';
                                                                if ($val === false || $val === 0 || $val === '0') return 'No';
                                                                return str($val)->title();
                                                             };
                                                             $formattedValue = $formatValSingle($displayValue);
                                                         @endphp
                                                         <div class="inline-flex flex-col bg-slate-50 border border-slate-200/80 px-3 py-2 rounded-xl min-w-[120px]">
                                                             <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">{{ str($key)->headline() }}</span>
                                                             <span class="text-[12px] font-bold text-slate-700 truncate max-w-[300px]" title="{{ $formattedValue }}">{{ $formattedValue }}</span>
                                                         </div>
                                                     @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-24 text-center relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-white shadow-sm border border-slate-100 rounded-full flex flex-col items-center justify-center mb-5">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">No Events Found</h3>
                        <p class="text-[14px] font-medium text-slate-500 mt-2 max-w-md mx-auto">We couldn't find any activities matching your filters. Try adjusting the date range or user query.</p>
                        @if(request()->anyFilled(['event', 'subject', 'causer', 'date_from', 'date_to']))
                            <a href="{{ route('admin.audit-log') }}" class="mt-6 inline-flex justify-center items-center gap-2 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 px-6 py-2.5 rounded-xl shadow-sm transition-all focus:ring-4 focus:ring-slate-900/20">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-5 border-t border-slate-200 bg-white">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

        <div x-show="showDetail" class="fixed inset-0 z-[100] overflow-hidden" x-cloak @keydown.escape.window="closeInspector()">
            <div x-show="showDetail" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeInspector()"></div>
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div x-show="showDetail" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-2xl">
                    <div class="h-full flex flex-col bg-white shadow-2xl overflow-y-scroll border-l border-slate-200">
                        <div class="sticky top-0 z-20 px-6 py-8 bg-white/95 backdrop-blur border-b border-slate-100">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <template x-if="activeLog">
                                        <div class="w-14 h-14 rounded-3xl flex items-center justify-center shadow-lg" :class="activeLog.eventConfig.bg + ' ' + activeLog.eventConfig.text + ' ' + activeLog.eventConfig.border">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-html="activeLog.eventConfig.icon"></svg>
                                        </div>
                                    </template>
                                    <div>
                                        <h2 class="text-xl font-black text-slate-900 tracking-tight" x-text="activeLog ? 'Activity Forensic' : ''"></h2>
                                        <div class="flex items-center gap-2 mt-1">
                                            <template x-if="activeLog">
                                                <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full" :class="activeLog.eventConfig.bg + ' ' + activeLog.eventConfig.text" x-text="activeLog.event"></span>
                                            </template>
                                            <span class="text-xs font-semibold text-slate-400" x-text="activeLog ? activeLog.time : ''"></span>
                                        </div>
                                    </div>
                                </div>
                                <button @click="closeInspector()" class="p-2.5 rounded-2xl bg-slate-50 text-slate-400 hover:text-slate-900 transition-all border border-slate-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 p-6 space-y-10 pb-20">
                            {{-- Unified Identity Section --}}
                            <section>
                                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-5 flex items-center gap-3">
                                    <span>Identity Overview</span>
                                    <div class="h-px bg-slate-100 flex-1"></div>
                                </h3>
                                
                                <div class="flex flex-col gap-4">
                                    {{-- Primary Causer Identity --}}
                                    <div class="flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-[2rem] shadow-sm relative overflow-hidden group/id">
                                        <div class="absolute top-0 right-0 p-2 opacity-5">
                                            <svg class="w-16 h-16 text-slate-900" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                        </div>
                                        
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-slate-900 text-white text-xl font-black shadow-lg shadow-slate-900/20" x-text="activeLog?.causer.initials"></div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Authenticated Personnel</p>
                                            <h4 class="text-lg font-black text-slate-900 truncate" x-text="activeLog?.causer.name"></h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs font-bold text-slate-500" x-text="activeLog?.causer.email"></span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                <span class="text-[10px] font-bold text-blue-600 uppercase" x-text="activeLog?.causer.role"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <template x-if="activeLog?.subjectUser.exists && activeLog.subjectUser.id != activeLog.causer.id">
                                        <div class="flex items-center gap-4 p-5 bg-rose-50 border border-rose-100 rounded-[2rem] shadow-sm relative overflow-hidden">
                                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-rose-100 text-rose-600 text-xl font-black border border-rose-200">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-1">Affected Personnel</p>
                                                <h4 class="text-lg font-black text-slate-900 truncate" x-text="activeLog?.subjectUser.name"></h4>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-xs font-bold text-slate-500" x-text="activeLog?.subjectUser.email"></span>
                                                    <span class="w-1 h-1 rounded-full bg-rose-200"></span>
                                                    <span class="text-[10px] font-bold text-rose-600 uppercase" x-text="activeLog?.subjectUser.role"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </section>

                            {{-- Modified Structures --}}
                            <section x-show="activeLog?.attributes && Object.keys(activeLog.attributes).length > 0">
                                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-5 flex items-center gap-3">
                                    <span>System Changes</span>
                                    <div class="h-px bg-slate-100 flex-1"></div>
                                </h3>
                                <div class="space-y-4">
                                    <template x-for="(value, key) in activeLog?.attributes" :key="key">
                                        <div class="p-4 bg-white border border-slate-200 rounded-[2rem] shadow-xs">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-[11px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 border border-slate-200/50 px-3 py-1 rounded-lg" x-text="key.replace(/_/g, ' ')"></span>
                                                <span x-show="activeLog.old && activeLog.old[key]" class="text-[9px] font-bold text-rose-500 uppercase tracking-widest">Modified</span>
                                            </div>
                                            <div class="grid grid-cols-1 gap-2">
                                                <div x-show="activeLog.old && (activeLog.old[key] !== null)" class="px-4 py-2 bg-rose-50/50 rounded-xl border border-rose-100">
                                                    <p class="text-[12px] font-bold text-rose-700 opacity-60 line-through decoration-rose-300" 
                                                       x-text=" (key.endsWith('_id') || key === 'assigned_to') ? resolveUser(activeLog.old[key]) : (typeof activeLog.old[key] === 'object' ? JSON.stringify(activeLog.old[key]) : activeLog.old[key] || 'Empty')"></p>
                                                </div>
                                                <div class="px-4 py-2 bg-emerald-50/50 rounded-xl border border-emerald-100">
                                                    <p class="text-[12px] font-bold text-emerald-800" 
                                                       x-text=" (key.endsWith('_id') || key === 'assigned_to') ? resolveUser(value) : (typeof value === 'object' ? JSON.stringify(value) : value || 'Empty')"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-nav>