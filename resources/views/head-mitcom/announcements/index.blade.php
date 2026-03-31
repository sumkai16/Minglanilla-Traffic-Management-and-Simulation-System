<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - MITCOM Head</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">
    @php
        $typeLabels = [
            'traffic_advisory' => 'Traffic Advisory',
            'road_closure' => 'Road Closure',
            'emergency' => 'Emergency',
            'system_notice' => 'System Notice',
        ];
    @endphp

    <x-app-nav pageTitle="Announcement Center" />

    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.05fr,1.6fr]">
            <section class="space-y-6">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Create Announcement</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Publish citizen updates</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Share traffic advisories, road closures, emergency notices, and service updates with citizens.
                    </p>

                    <form method="POST" action="{{ route('head-mitcom.announcements.store') }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <label for="title" class="text-sm font-semibold text-slate-700">Title</label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}"
                                class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                placeholder="Enter a clear announcement title" required>
                            @error('title')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="text-sm font-semibold text-slate-700">Message</label>
                            <textarea id="content" name="content" rows="6"
                                class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                placeholder="Write the full announcement message for citizens..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="type" class="text-sm font-semibold text-slate-700">Type</label>
                                <select id="type" name="type"
                                    class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                    required>
                                    @foreach($typeLabels as $value => $label)
                                        <option value="{{ $value }}" @selected(old('type', 'system_notice') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="priority" class="text-sm font-semibold text-slate-700">Priority</label>
                                <select id="priority" name="priority"
                                    class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                    required>
                                    <option value="normal" @selected(old('priority', 'normal') === 'normal')>Normal</option>
                                    <option value="important" @selected(old('priority') === 'important')>Important</option>
                                    <option value="urgent" @selected(old('priority') === 'urgent')>Urgent</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <input type="checkbox" name="publish_now" value="1" @checked(old('publish_now'))
                                class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span>
                                <span class="block text-sm font-semibold text-slate-800">Publish immediately</span>
                                <span class="mt-1 block text-xs text-slate-500">If unchecked, the announcement will be saved as a draft.</span>
                            </span>
                        </label>

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Save announcement
                        </button>
                    </form>
                </div>
            </section>

            <section class="space-y-6">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalAnnouncements }}</p>
                    </div>
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Published</p>
                        <p class="mt-2 text-3xl font-bold text-blue-900">{{ $publishedAnnouncements }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Drafts</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $draftAnnouncements }}</p>
                    </div>
                    <div class="rounded-2xl border border-rose-100 bg-rose-50 p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-rose-600">Urgent</p>
                        <p class="mt-2 text-3xl font-bold text-rose-900">{{ $urgentAnnouncements }}</p>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-xl font-bold text-slate-900">Manage Announcements</h2>
                        <p class="mt-1 text-sm text-slate-500">Publish, update, or move announcements back to draft as conditions change.</p>
                    </div>

                    @if($announcements->count())
                        <div class="space-y-4 px-6 py-6">
                            @foreach($announcements as $announcement)
                                <article class="rounded-[1.5rem] border border-slate-200 bg-slate-50/80 p-5">
                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->is_published ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                                    {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                                </span>
                                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                                                    {{ $typeLabels[$announcement->type] ?? 'Announcement' }}
                                                </span>
                                                <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->priority === 'urgent' ? 'bg-rose-50 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-50 text-amber-700 ring-amber-200' : 'bg-slate-100 text-slate-600 ring-slate-200') }}">
                                                    {{ ucfirst($announcement->priority) }}
                                                </span>
                                            </div>

                                            <h3 class="mt-3 text-lg font-bold text-slate-900">{{ $announcement->title }}</h3>
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($announcement->content, 220) }}</p>

                                            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                                <span>Created by {{ $announcement->author?->first_name }} {{ $announcement->author?->last_name }}</span>
                                                <span>{{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                                                @if($announcement->published_at)
                                                    <span>Published {{ $announcement->published_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                                            <a href="{{ route('head-mitcom.announcements.edit', $announcement) }}"
                                                class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-white">
                                                Edit
                                            </a>

                                            @if($announcement->is_published)
                                                <form method="POST" action="{{ route('head-mitcom.announcements.unpublish', $announcement) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">
                                                        Move to draft
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('head-mitcom.announcements.publish', $announcement) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                                                        Publish
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-16 text-center">
                            <h3 class="text-lg font-bold text-slate-900">No announcements yet</h3>
                            <p class="mt-2 text-sm text-slate-500">Create your first citizen-facing announcement from the panel on the left.</p>
                        </div>
                    @endif

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>

    <x-toast />
</body>

</html>
