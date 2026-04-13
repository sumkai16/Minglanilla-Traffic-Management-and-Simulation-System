<x-app-nav title="Traffic Advisories" page-title="Traffic Advisories" page-eyebrow="Command Center">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Published</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['published'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Draft</p>
                <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $stats['draft'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Archived</p>
                <p class="text-3xl font-bold text-slate-400 mt-1">{{ $stats['archived'] }}</p>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">All Advisories</h2>
                        <p class="text-xs text-slate-500 mt-1">Search, filter, and manage traffic advisories</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-400 font-medium px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                            {{ $advisories->total() }} total
                        </span>
                        <a href="{{ route('head-mitcom.advisories.create') }}"
                            class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm shadow-sm">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.75v12.5m6.25-6.25H5.75" />
                            </svg>
                            New Advisory
                        </a>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <form method="GET" action="{{ route('head-mitcom.advisories.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div class="relative md:col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search advisory title..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400">
                    </div>

                    <div>
                        <select name="status"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="all">All Statuses</option>
                            <option value="published" @selected(request('status') === 'published')>Published</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                            <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                        </select>
                    </div>

                    <div>
                        <select name="sort"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="created_at" @selected(request('sort', 'created_at') === 'created_at')>Sort: Newest First</option>
                            <option value="title" @selected(request('sort') === 'title')>Sort: Title (A-Z)</option>
                            <option value="start_date" @selected(request('sort') === 'start_date')>Sort: Start Date</option>
                        </select>
                        <input type="hidden" name="dir" value="{{ request('sort') === 'title' ? 'asc' : 'desc' }}">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm">
                            Apply
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'sort']))
                            <a href="{{ route('head-mitcom.advisories.index') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50 transition" title="Clear Filters">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Title</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Status</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Date Range</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Created</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($advisories as $advisory)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-900 truncate max-w-[280px]">{{ $advisory->title }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span @class([
                                        'px-2.5 py-1 rounded-full text-xs font-semibold',
                                        'bg-green-100 text-green-700' => $advisory->status === 'published',
                                        'bg-yellow-100 text-yellow-700' => $advisory->status === 'draft',
                                        'bg-slate-100 text-slate-500' => $advisory->status === 'archived',
                                    ])>
                                        {{ ucfirst($advisory->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs">
                                    {{ $advisory->start_date->format('M d, Y') }} — {{ $advisory->end_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-xs">
                                    {{ $advisory->created_at->format('M d, Y') }}<br>
                                    <span class="text-slate-300">{{ $advisory->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('head-mitcom.advisories.show', $advisory) }}"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition">
                                            View
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('head-mitcom.advisories.edit', $advisory) }}"
                                            class="inline-flex items-center gap-1 text-slate-500 hover:text-slate-700 font-semibold text-xs border border-slate-200 hover:border-slate-400 px-3 py-1.5 rounded-lg transition">
                                            Edit
                                        </a>

                                        @if($advisory->status === 'draft')
                                            <form action="{{ route('head-mitcom.advisories.publish', $advisory) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-semibold text-xs border border-green-200 hover:border-green-400 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition">
                                                    Publish
                                                </button>
                                            </form>
                                        @elseif($advisory->status === 'published')
                                            <form action="{{ route('head-mitcom.advisories.unpublish', $advisory) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 text-yellow-600 hover:text-yellow-800 font-semibold text-xs border border-yellow-200 hover:border-yellow-400 px-3 py-1.5 rounded-lg transition">
                                                    Unpublish
                                                </button>
                                            </form>
                                            <form action="{{ route('head-mitcom.advisories.archive', $advisory) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 text-slate-400 hover:text-slate-600 font-semibold text-xs border border-slate-200 hover:border-slate-400 px-3 py-1.5 rounded-lg transition">
                                                    Archive
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('head-mitcom.advisories.destroy', $advisory) }}" method="POST"
                                            onsubmit="return confirm('Delete this advisory?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 font-semibold text-xs border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-300 text-sm">
                                    No advisories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $advisories->links() }}
            </div>
        </div>
    </main>

    <x-toast />
</x-app-nav>