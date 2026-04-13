@php
    $typeLabels = [
        'traffic_advisory' => 'Traffic Advisory',
        'road_closure' => 'Road Closure',
        'emergency' => 'Emergency',
        'system_notice' => 'System Notice',
    ];
@endphp

<x-app-nav title="Announcements - MITCOM Head" page-title="Announcement Center" page-eyebrow="Command Center">
    <x-slot:actions>
        <button onclick="document.getElementById('createAnnouncementModal').classList.remove('hidden'); setTimeout(() => { document.getElementById('createAnnouncementModal').querySelector('[data-modal-backdrop]').classList.add('opacity-100'); document.getElementById('createAnnouncementModal').querySelector('[data-modal-content]').classList.remove('scale-95', 'opacity-0'); document.getElementById('createAnnouncementModal').querySelector('[data-modal-content]').classList.add('scale-100', 'opacity-100'); }, 10);"
            class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Create Announcement
        </button>
    </x-slot:actions>

    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <div class="space-y-6">
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

                                        @if($announcement->image)
                                            <div class="mt-3 overflow-hidden rounded-xl border border-slate-200">
                                                <img src="{{ asset('storage/' . $announcement->image) }}"
                                                    alt="{{ $announcement->title }}"
                                                    class="w-full max-h-52 object-cover">
                                            </div>
                                        @endif

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
                        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-bold text-slate-900">No announcements yet</h3>
                        <p class="mt-2 text-sm text-slate-500">Click the "Create Announcement" button above to publish your first citizen-facing announcement.</p>
                    </div>
                @endif

                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
    </main>

    {{-- Create Announcement Modal --}}
    <div id="createAnnouncementModal" class="fixed inset-0 z-50 hidden" x-data="{ preview: null }">
        {{-- Backdrop --}}
        <div data-modal-backdrop
            class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"
            onclick="closeCreateModal()"></div>

        {{-- Modal Content --}}
        <div class="flex min-h-full items-center justify-center p-4">
            <div data-modal-content
                class="relative w-full max-w-2xl transform rounded-[1.75rem] border border-slate-200 bg-white shadow-2xl transition-all duration-300 scale-95 opacity-0">

                {{-- Header --}}
                <div class="border-b border-slate-200 px-6 py-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Create Announcement</p>
                        <h2 class="mt-1 text-xl font-bold text-slate-900">Publish citizen updates</h2>
                    </div>
                    <button onclick="closeCreateModal()"
                        class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="max-h-[calc(100vh-12rem)] overflow-y-auto px-6 py-6">
                    <p class="text-sm leading-6 text-slate-500 mb-6">
                        Share traffic advisories, road closures, emergency notices, and service updates with citizens.
                    </p>

                    <form method="POST" action="{{ route('head-mitcom.announcements.store') }}" enctype="multipart/form-data" class="space-y-4" id="createAnnouncementForm">
                        @csrf

                        <div>
                            <label for="modal_title" class="text-sm font-semibold text-slate-700">Title</label>
                            <input id="modal_title" name="title" type="text" value="{{ old('title') }}"
                                class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                placeholder="Enter a clear announcement title" required>
                            @error('title')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="modal_content" class="text-sm font-semibold text-slate-700">Message</label>
                            <textarea id="modal_content" name="content" rows="5"
                                class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                placeholder="Write the full announcement message for citizens..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Attach Image (Optional)</label>
                            <div class="mt-2 relative">
                                <input type="file" id="modal_announcement_image" name="image" accept="image/*" class="hidden"
                                    @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }">

                                <label for="modal_announcement_image"
                                    class="flex flex-col items-center justify-center w-full rounded-xl border-2 border-dashed border-slate-300 cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all duration-200 overflow-hidden"
                                    :class="preview ? 'p-0' : 'py-8'">

                                    <template x-if="!preview">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                                            </svg>
                                            <p class="text-sm font-medium text-slate-600">Click to upload an image</p>
                                            <p class="text-xs text-slate-400 mt-1">PNG, JPG, GIF, WebP up to 5MB</p>
                                        </div>
                                    </template>

                                    <template x-if="preview">
                                        <img :src="preview" class="w-full max-h-48 object-cover rounded-xl">
                                    </template>
                                </label>

                                <button type="button" x-show="preview" @click="preview = null; document.getElementById('modal_announcement_image').value = '';"
                                    class="absolute top-2 right-2 rounded-full bg-slate-900/60 p-1.5 text-white hover:bg-slate-900/80 transition"
                                    title="Remove image">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @error('image')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="modal_type" class="text-sm font-semibold text-slate-700">Type</label>
                                <select id="modal_type" name="type"
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
                                <label for="modal_priority" class="text-sm font-semibold text-slate-700">Priority</label>
                                <select id="modal_priority" name="priority"
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
                    </form>
                </div>

                {{-- Footer --}}
                <div class="border-t border-slate-200 px-6 py-4 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" onclick="closeCreateModal()"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </button>
                    <button type="submit" form="createAnnouncementForm"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Save announcement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeCreateModal() {
            const modal = document.getElementById('createAnnouncementModal');
            const backdrop = modal.querySelector('[data-modal-backdrop]');
            const content = modal.querySelector('[data-modal-content]');

            backdrop.classList.remove('opacity-100');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Auto-open modal if there are validation errors
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('createAnnouncementModal').classList.remove('hidden');
                setTimeout(() => {
                    const modal = document.getElementById('createAnnouncementModal');
                    modal.querySelector('[data-modal-backdrop]').classList.add('opacity-100');
                    modal.querySelector('[data-modal-content]').classList.remove('scale-95', 'opacity-0');
                    modal.querySelector('[data-modal-content]').classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        @endif
    </script>

    <x-toast />
</x-app-nav>
