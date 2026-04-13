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

<x-app-nav title="Announcements" page-title="Announcements" page-eyebrow="Citizen Portal">
    <x-slot:actions>
        <a href="{{ route('user.reports.create') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Report Incident
        </a>
    </x-slot:actions>

    <main class="py-10 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-60 bg-gradient-to-b from-blue-100/70 via-blue-50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Urgent Announcement Banner --}}
            @if($urgentAnnouncement)
                <section class="mb-8 overflow-hidden rounded-[1.75rem] border border-rose-200 bg-gradient-to-r from-rose-50 via-white to-amber-50 shadow-md">
                    <div class="flex flex-col lg:flex-row">
                        @if($urgentAnnouncement->image)
                            <div class="lg:w-80 shrink-0">
                                <img src="{{ asset('storage/' . $urgentAnnouncement->image) }}"
                                    alt="{{ $urgentAnnouncement->title }}"
                                    class="h-48 w-full object-cover lg:h-full">
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col gap-5 p-6 lg:flex-row lg:items-center lg:justify-between">
                            <div class="min-w-0">
                                <div class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                    <svg class="h-3.5 w-3.5 animate-pulse" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                                    Urgent Announcement
                                </div>
                                <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $urgentAnnouncement->title }}</h2>
                                <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">{{ $urgentAnnouncement->content }}</p>
                            </div>
                            <div class="shrink-0 rounded-2xl border border-rose-200 bg-white/90 p-4 text-sm text-slate-600 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-widest text-rose-600">{{ $typeLabels[$urgentAnnouncement->type] ?? 'Announcement' }}</p>
                                <p class="mt-2 font-semibold text-slate-900">Published {{ $urgentAnnouncement->published_at?->format('M d, Y h:i A') }}</p>
                                <p class="mt-1 text-xs text-slate-500">By {{ $urgentAnnouncement->author?->first_name }} {{ $urgentAnnouncement->author?->last_name }}</p>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- Main Announcements Section --}}
            <section class="rounded-[1.75rem] border border-blue-100 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-200 px-6 py-5 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Public Announcements</h1>
                        <p class="mt-1 text-sm text-slate-500">Stay updated with traffic advisories, closures, emergency notices, and service announcements.</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                        <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                        </svg>
                        <span>{{ $announcements->total() }} {{ Str::plural('announcement', $announcements->total()) }}</span>
                    </div>
                </div>

                @if($announcements->count())
                    <div class="grid gap-5 px-6 py-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($announcements as $announcement)
                            <article class="group flex flex-col rounded-2xl border overflow-hidden transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5
                                {{ $announcement->priority === 'urgent' ? 'border-rose-200 bg-rose-50/40' : ($announcement->priority === 'important' ? 'border-amber-200 bg-amber-50/30' : 'border-slate-200 bg-white') }}">

                                {{-- Image --}}
                                @if($announcement->image)
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $announcement->image) }}"
                                            alt="{{ $announcement->title }}"
                                            class="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                    </div>
                                @else
                                    {{-- Decorative header when no image --}}
                                    <div class="h-2 w-full {{ $announcement->priority === 'urgent' ? 'bg-gradient-to-r from-rose-400 to-rose-500' : ($announcement->priority === 'important' ? 'bg-gradient-to-r from-amber-400 to-amber-500' : 'bg-gradient-to-r from-blue-400 to-blue-600') }}"></div>
                                @endif

                                {{-- Content --}}
                                <div class="flex flex-1 flex-col p-5">
                                    {{-- Badges --}}
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                                            {!! $typeIcons[$announcement->type] ?? '' !!}
                                            {{ $typeLabels[$announcement->type] ?? 'Announcement' }}
                                        </span>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1
                                            {{ $announcement->priority === 'urgent' ? 'bg-rose-100 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-100 text-amber-700 ring-amber-200' : 'bg-slate-100 text-slate-600 ring-slate-200') }}">
                                            {{ ucfirst($announcement->priority) }}
                                        </span>
                                    </div>

                                    {{-- Title & Body --}}
                                    <h2 class="mt-3 text-lg font-bold text-slate-900 leading-snug">{{ $announcement->title }}</h2>
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit($announcement->content, 180) }}</p>

                                    {{-- Footer --}}
                                    <div class="mt-4 flex items-center gap-3 border-t pt-4 text-xs text-slate-400
                                        {{ $announcement->priority === 'urgent' ? 'border-rose-200' : ($announcement->priority === 'important' ? 'border-amber-200' : 'border-slate-200') }}">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            <span>{{ $announcement->published_at?->format('M d, Y') }}</span>
                                        </div>
                                        <span class="text-slate-300">·</span>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            <span>{{ $announcement->author?->first_name }} {{ $announcement->author?->last_name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $announcements->links() }}
                    </div>
                @else
                    <div class="px-6 py-20 text-center">
                        <svg class="mx-auto h-14 w-14 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
                        </svg>
                        <h2 class="mt-4 text-lg font-bold text-slate-900">No announcements available yet</h2>
                        <p class="mt-2 text-sm text-slate-500">Once Head MITCOM publishes updates, they will appear here.</p>
                    </div>
                @endif
            </section>
        </div>
    </main>

    <x-toast />
</x-app-nav>
