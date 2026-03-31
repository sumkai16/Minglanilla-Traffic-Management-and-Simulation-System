<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement - MITCOM Head</title>
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

    <x-app-nav pageTitle="Edit Announcement">
        <a href="{{ route('head-mitcom.announcements.index') }}"
            class="inline-flex items-center gap-2 rounded-full border border-white/30 px-4 py-2 text-sm text-white transition hover:-translate-y-0.5 hover:bg-white/10">
            Back to Announcements
        </a>
    </x-app-nav>

    <main class="max-w-4xl mx-auto px-4 lg:px-8 py-8">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Announcement Editor</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">{{ $announcement->title }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">Update the message, adjust the priority, or change whether it is published.</p>

            <form method="POST" action="{{ route('head-mitcom.announcements.update', $announcement) }}" class="mt-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="text-sm font-semibold text-slate-700">Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $announcement->title) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        required>
                    @error('title')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="text-sm font-semibold text-slate-700">Message</label>
                    <textarea id="content" name="content" rows="7"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        required>{{ old('content', $announcement->content) }}</textarea>
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
                                <option value="{{ $value }}" @selected(old('type', $announcement->type) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="text-sm font-semibold text-slate-700">Priority</label>
                        <select id="priority" name="priority"
                            class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required>
                            <option value="normal" @selected(old('priority', $announcement->priority) === 'normal')>Normal</option>
                            <option value="important" @selected(old('priority', $announcement->priority) === 'important')>Important</option>
                            <option value="urgent" @selected(old('priority', $announcement->priority) === 'urgent')>Urgent</option>
                        </select>
                    </div>
                </div>

                <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <input type="checkbox" name="publish_now" value="1" @checked(old('publish_now', $announcement->is_published))
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>
                        <span class="block text-sm font-semibold text-slate-800">Keep this announcement published</span>
                        <span class="mt-1 block text-xs text-slate-500">Uncheck this to save it as a draft and remove it from the citizen side.</span>
                    </span>
                </label>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Save changes
                    </button>
                    <a href="{{ route('head-mitcom.announcements.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>

    <x-toast />
</body>

</html>
