<x-app-nav title="Traffic Advisories" page-title="Traffic Advisories" page-eyebrow="Command Center">
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Head MITCOM</p>
                <h1 class="text-2xl font-bold text-slate-900">Traffic Advisories</h1>
            </div>
            <a href="{{ route('head-mitcom.advisories.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                + New Advisory
            </a>
        </div>

        {{-- List --}}
        @if($advisories->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center text-slate-400">
                No advisories yet. Create one to get started.
            </div>
        @else
            <div class="space-y-3">
                @foreach($advisories as $advisory)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span @class([
                                    'text-xs font-semibold px-2.5 py-0.5 rounded-full',
                                    'bg-green-100 text-green-700' => $advisory->status === 'published',
                                    'bg-yellow-100 text-yellow-700' => $advisory->status === 'draft',
                                    'bg-slate-100 text-slate-500' => $advisory->status === 'archived',
                                ])>
                                    {{ ucfirst($advisory->status) }}
                                </span>
                            </div>
                            <p class="font-semibold text-slate-800 truncate">{{ $advisory->title }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                {{ $advisory->start_date->format('M d, Y') }} — {{ $advisory->end_date->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <a href="{{ route('head-mitcom.advisories.show', $advisory) }}"
                                class="text-xs font-semibold text-blue-600 hover:underline">View</a>
                            <a href="{{ route('head-mitcom.advisories.edit', $advisory) }}"
                                class="text-xs font-semibold text-slate-500 hover:underline">Edit</a>

                            @if($advisory->status === 'draft')
                                <form action="{{ route('head-mitcom.advisories.publish', $advisory) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-semibold text-green-600 hover:underline">Publish</button>
                                </form>
                            @elseif($advisory->status === 'published')
                                <form action="{{ route('head-mitcom.advisories.unpublish', $advisory) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-semibold text-yellow-600 hover:underline">Unpublish</button>
                                </form>
                                <form action="{{ route('head-mitcom.advisories.archive', $advisory) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs font-semibold text-slate-400 hover:underline">Archive</button>
                                </form>
                            @endif

                            <form action="{{ route('head-mitcom.advisories.destroy', $advisory) }}" method="POST"
                                onsubmit="return confirm('Delete this advisory?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>

    <x-toast />
</x-app-nav>