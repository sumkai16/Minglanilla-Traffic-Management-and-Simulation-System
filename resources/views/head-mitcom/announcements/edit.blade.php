@php
    $typeLabels = [
        'traffic_advisory' => 'Traffic Advisory',
        'road_closure' => 'Road Closure',
        'emergency' => 'Emergency',
        'system_notice' => 'System Notice',
    ];
@endphp

<x-app-nav title="Edit Announcement - MITCOM Head" page-title="Edit Announcement" page-eyebrow="Command Center">
    <x-slot:actions>
        <a href="{{ route('head-mitcom.announcements.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            Back to Announcements
        </a>
    </x-slot:actions>

    <main class="max-w-4xl mx-auto px-4 lg:px-8 py-8">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Announcement Editor</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">{{ $announcement->title }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">Update the message, adjust the priority, or change whether it is published.</p>

            <form method="POST" action="{{ route('head-mitcom.announcements.update', $announcement) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
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

                {{-- Image Upload / Edit --}}
                <div>
                    <label class="text-sm font-semibold text-slate-700">Image</label>

                    @if($announcement->image)
                        <div id="current-image-wrapper" class="mt-2 rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-start gap-4">
                                <img src="{{ asset('storage/' . $announcement->image) }}" alt="Current image"
                                    class="h-32 w-32 rounded-xl object-cover border border-slate-200 shadow-sm">
                                <div class="flex flex-col gap-2">
                                    <p class="text-sm text-slate-600">Current image attached to this announcement.</p>
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="remove_image" value="1" id="remove-image-checkbox"
                                            class="h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                        <span class="text-sm font-medium text-rose-600">Remove this image</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-3" id="image-upload-wrapper">
                        <label for="image"
                            class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-6 text-center transition hover:border-blue-400 hover:bg-blue-50/50">
                            <svg class="mb-2 h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                            </svg>
                            <span class="text-sm font-semibold text-slate-600" id="image-label">
                                {{ $announcement->image ? 'Upload a new image to replace' : 'Click to upload an image' }}
                            </span>
                            <span class="mt-1 text-xs text-slate-400">PNG, JPG, GIF, WEBP up to 5MB</span>
                        </label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="hidden"
                            onchange="document.getElementById('image-label').textContent = this.files[0] ? this.files[0].name : '{{ $announcement->image ? 'Upload a new image to replace' : 'Click to upload an image' }}'">
                    </div>

                    @error('image')
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
</x-app-nav>
