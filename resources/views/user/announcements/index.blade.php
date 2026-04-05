@php
    $typeLabels = [
        'traffic_advisory' => 'Traffic Advisory',
        'road_closure' => 'Road Closure',
        'emergency' => 'Emergency',
        'system_notice' => 'System Notice',
    ];
@endphp

<x-app-nav title="Announcements" page-title="Announcements" page-eyebrow="Public Reporting">
    <x-slot:actions>
        <a href="{{ route('user.reports.create') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            Report Incident
        </a>
    </x-slot:actions>

    <main class="py-10 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-60 bg-gradient-to-b from-blue-100/70 via-blue-50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($urgentAnnouncement)
                <section class="mb-6 overflow-hidden rounded-[1.75rem] border border-rose-200 bg-gradient-to-r from-rose-50 via-white to-amber-50 shadow-sm">
                    <div class="flex flex-col gap-5 p-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                Urgent Announcement
                            </div>
                            <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $urgentAnnouncement->title }}</h2>
                            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">{{ $urgentAnnouncement->content }}</p>
                        </div>
                        <div class="rounded-2xl border border-rose-200 bg-white/90 p-4 text-sm text-slate-600 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-widest text-rose-600">{{ $typeLabels[$urgentAnnouncement->type] ?? 'Announcement' }}</p>
                            <p class="mt-2 font-semibold text-slate-900">Published {{ $urgentAnnouncement->published_at?->format('M d, Y h:i A') }}</p>
                            <p class="mt-1 text-xs text-slate-500">By {{ $urgentAnnouncement->author?->first_name }} {{ $urgentAnnouncement->author?->last_name }}</p>
                        </div>
                    </div>
                </section>
            @endif

            <section class="rounded-[1.75rem] border border-blue-100 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h1 class="text-2xl font-bold text-slate-900">Public Announcement Dashboard</h1>
                    <p class="mt-2 text-sm text-slate-500">Stay updated with traffic advisories, closures, emergency notices, and service announcements from Head MITCOM.</p>
                </div>

                @if($announcements->count())
                    <div class="grid gap-4 px-6 py-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($announcements as $announcement)
                            <article class="rounded-[1.5rem] border p-5 shadow-sm {{ $announcement->priority === 'urgent' ? 'border-rose-200 bg-rose-50/60' : 'border-slate-200 bg-slate-50/60' }}">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                                        {{ $typeLabels[$announcement->type] ?? 'Announcement' }}
                                    </span>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->priority === 'urgent' ? 'bg-rose-100 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-100 text-amber-700 ring-amber-200' : 'bg-slate-100 text-slate-600 ring-slate-200') }}">
                                        {{ ucfirst($announcement->priority) }}
                                    </span>
                                </div>

                                <h2 class="mt-4 text-lg font-bold text-slate-900">{{ $announcement->title }}</h2>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $announcement->content }}</p>

                                <div class="mt-5 border-t border-slate-200 pt-4 text-xs text-slate-500">
                                    <p>Published {{ $announcement->published_at?->format('M d, Y h:i A') }}</p>
                                    <p class="mt-1">Posted by {{ $announcement->author?->first_name }} {{ $announcement->author?->last_name }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $announcements->links() }}
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <h2 class="text-lg font-bold text-slate-900">No announcements available yet</h2>
                        <p class="mt-2 text-sm text-slate-500">Once Head MITCOM publishes updates, they will appear here.</p>
                    </div>
                @endif
            </section>
        </div>
    </main>

    <x-toast />
</x-app-nav>
