@php
    $typeLabels = [
        'traffic_advisory' => 'Traffic Advisory',
        'road_closure' => 'Road Closure',
        'emergency' => 'Emergency',
        'system_notice' => 'System Notice',
    ];

    $typeIcons = [
        'traffic_advisory' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>',
        'road_closure' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>',
        'emergency' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>',
        'system_notice' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>',
    ];
@endphp

@php
    $pageTitle = request('type') === 'traffic_advisory' ? 'Traffic Advisories' : 'Announcements';
@endphp
<x-app-nav :title="$pageTitle" :page-title="$pageTitle" :page-eyebrow="ucfirst($prefix) . ' Portal'">
    <x-slot:actions>
        @if(auth()->user()->role === 'user')
            <a href="{{ route('user.reports.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Report Incident
            </a>
        @elseif(auth()->user()->role === 'enforcer')
            <a href="{{ route('enforcer.reports.index') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                My Reports
            </a>
        @endif
    </x-slot:actions>

    <main class="py-10 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-60 bg-gradient-to-b from-blue-100/70 via-blue-50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Urgent Announcement Banner --}}
            @if($urgentAnnouncement)
                <section class="mb-10 relative overflow-hidden rounded-[2.5rem] border-2 border-rose-200 bg-white p-1 shadow-2xl shadow-rose-500/10">
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-rose-100/50 blur-3xl"></div>
                    <div class="absolute -left-20 -bottom-20 h-64 w-64 rounded-full bg-amber-100/50 blur-3xl"></div>
                    
                    <div class="relative flex flex-col lg:flex-row overflow-hidden rounded-[2.25rem]">
                        @if($urgentAnnouncement->image)
                            <div class="lg:w-[28rem] shrink-0 relative overflow-hidden group">
                                <img src="{{ asset('storage/' . $urgentAnnouncement->image) }}"
                                    alt="{{ $urgentAnnouncement->title }}"
                                    class="h-64 w-full object-cover lg:h-full transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-600/20 to-transparent mix-blend-overlay"></div>
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col justify-center p-8 lg:p-12">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-2 rounded-full bg-rose-600 px-4 py-1.5 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-rose-200">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-300 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                    </span>
                                    Live Alert
                                </span>
                                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">
                                    {{ $typeLabels[$urgentAnnouncement->type] ?? 'Emergency' }}
                                </span>
                            </div>
                            
                            <h2 class="mt-6 text-3xl lg:text-4xl font-black text-slate-900 leading-tight">
                                {{ $urgentAnnouncement->title }}
                            </h2>
                            <p class="mt-4 text-lg leading-relaxed text-slate-600 lg:pr-10">
                                {{ $urgentAnnouncement->content }}
                            </p>
                            <a href="{{ route($prefix . '.announcements.show', $urgentAnnouncement->id) }}"
                               class="mt-6 inline-flex items-center gap-2 rounded-full bg-rose-600 px-5 py-2.5 text-sm font-bold text-white shadow-md hover:bg-rose-700 transition">
                                View Details
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                            </a>

                            <div class="mt-8 flex flex-wrap items-center gap-6 border-t border-slate-100 pt-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-rose-50 flex items-center justify-center text-rose-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Published</p>
                                        <p class="text-sm font-bold text-slate-700">{{ $urgentAnnouncement->published_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Authorized By</p>
                                        <p class="text-sm font-bold text-slate-700">{{ $urgentAnnouncement->author?->first_name }} {{ $urgentAnnouncement->author?->last_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <div class="mb-12">
                <div class="flex flex-col gap-10 pb-10 border-b border-slate-200/60">
                    <div class="max-w-3xl">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="h-1 w-10 rounded-full bg-blue-600"></span>
                            <span class="text-[11px] font-black uppercase tracking-[0.25em] text-blue-600 leading-none">Official Portal Updates</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.05]">
                            {{ request('type') === 'traffic_advisory' ? 'Traffic Advisories' : 'Public Updates' }}
                        </h1>
                        <p class="mt-6 text-xl text-slate-500 leading-relaxed font-medium">
                            Official {{ request('type') === 'traffic_advisory' ? 'road notifications and traffic management alerts' : 'system announcements and community updates' }} for the municipality of Minglanilla.
                        </p>
                    </div>

                    <div class="flex flex-col md:flex-row items-center gap-4 w-full">
                        <form action="{{ route($prefix . '.announcements.index') }}" method="GET" class="relative group flex-1 max-w-md">
                            @if(request('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search official updates..." 
                                   class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm group-hover:border-slate-300">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-500">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </form>

                        <div class="w-full md:w-auto relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/50 p-1 shadow-inner">
                            <nav class="flex items-center gap-1 overflow-x-auto no-scrollbar scroll-smooth">
                                <a href="{{ route($prefix . '.announcements.index', ['search' => request('search')]) }}" 
                                    class="shrink-0 rounded-xl px-5 py-2.5 text-[10px] font-black uppercase tracking-wider transition-all {{ !request('type') ? 'bg-white text-blue-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-800' }}">
                                    All Updates
                                </a>
                                @foreach($typeLabels as $value => $label)
                                    <a href="{{ route($prefix . '.announcements.index', ['type' => $value, 'search' => request('search')]) }}" 
                                        class="shrink-0 rounded-xl px-5 py-2.5 text-[10px] font-black uppercase tracking-wider transition-all {{ request('type') === $value ? 'bg-white text-blue-600 shadow-sm border border-slate-200' : 'text-slate-500 hover:text-slate-800' }}">
                                        {{ str_replace(' Traffic Advisory', '', $label) }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Announcements Feed --}}
            @if($announcements->count())
                <div class="space-y-6">
                    @foreach($announcements as $announcement)
                        <article class="group relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-2 transition-all duration-300 hover:border-blue-300 hover:shadow-2xl hover:shadow-blue-500/10">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-6 p-4">
                                {{-- Media Content --}}
                                @if($announcement->image)
                                    <div class="relative h-48 w-full shrink-0 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 lg:h-56 lg:w-72 xl:w-80">
                                        <img src="{{ asset('storage/' . $announcement->image) }}"
                                            alt="{{ $announcement->title }}"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl"></div>
                                    </div>
                                @else
                                    <div class="relative h-48 w-full shrink-0 overflow-hidden rounded-2xl border border-slate-100 bg-gradient-to-br from-slate-50 to-slate-100 lg:h-56 lg:w-72 xl:w-80 flex items-center justify-center">
                                        <div class="text-slate-300">
                                            {!! $typeIcons[$announcement->type] ?? '' !!}
                                        </div>
                                    </div>
                                @endif

                                {{-- Textual Content --}}
                                <div class="flex flex-1 flex-col min-w-0">
                                    <div class="flex flex-wrap items-center gap-3 mb-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest text-blue-700 ring-1 ring-blue-200">
                                            {!! $typeIcons[$announcement->type] ?? '' !!}
                                            {{ $typeLabels[$announcement->type] ?? 'Announcement' }}
                                        </span>
                                        <span class="rounded-full px-3.5 py-1.5 text-[10px] font-black uppercase tracking-widest ring-1
                                            {{ $announcement->priority === 'urgent' ? 'bg-rose-50 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-50 text-amber-700 ring-amber-200' : 'bg-slate-50 text-slate-600 ring-slate-200') }}">
                                            {{ $announcement->priority }}
                                        </span>
                                        <span class="ml-auto text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                            {{ $announcement->published_at?->format('F d, Y') }}
                                        </span>
                                    </div>

                                    <h2 class="text-2xl font-black text-slate-900 group-hover:text-blue-600 transition-colors duration-200">
                                        {{ $announcement->title }}
                                    </h2>
                                    <p class="mt-3 text-base leading-relaxed text-slate-600 line-clamp-2">
                                        {{ $announcement->content }}
                                        
                                    </p>
                                        <a href="{{ isset($announcement->is_advisory) && $announcement->is_advisory 
                                                ? route($prefix . '.advisories.show', str_replace('advisory-', '', $announcement->id)) 
                                                : route($prefix . '.announcements.show', $announcement->id) }}"
                                            class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                                            View Details
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                            </svg>
                                        </a>
                                    <div class="mt-6 flex flex-wrap items-center gap-y-2 gap-x-6 border-t border-slate-50 pt-5 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                                        <div class="flex items-center gap-2.5">
                                            <div class="h-7 w-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-black">
                                                {{ substr($announcement->author?->first_name ?? 'M', 0, 1) }}
                                            </div>
                                            <span class="text-slate-600">{{ $announcement->author?->first_name }} {{ $announcement->author?->last_name }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <span>{{ $announcement->published_at?->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $announcements->links() }}
                </div>
            @else
                <div class="mt-12 overflow-hidden rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-white px-6 py-24 text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-50 text-slate-300">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                        </svg>
                    </div>
                    <h2 class="mt-8 text-2xl font-black text-slate-900">No updates found</h2>
                    <p class="mt-4 text-slate-500">There are no announcements matching your current filter.</p>
                    <a href="{{ route($prefix . '.announcements.index') }}" class="mt-8 inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700">
                        Clear all filters
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </main>

    <x-toast />
</x-app-nav>
