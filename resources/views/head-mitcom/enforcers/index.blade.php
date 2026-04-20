<x-app-nav title="Enforcers - MITCOM Head" page-title="Enforcers" page-eyebrow="Command Center">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Enforcers</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $enforcers->total() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Active Assignments</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">
                    {{ $enforcers->sum('assigned_reports_count') }}
                </p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Unassigned Reports</p>
                <p class="text-3xl font-bold text-yellow-500 mt-1">
                    {{ \App\Models\Report::where('status', 'verified')->count() }}
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">All Enforcers</h2>
                        <p class="text-xs text-slate-500 mt-1">Search, filter, and sort enforcers by name, email, or assignment status</p>
                    </div>
                    <span class="text-sm text-slate-400 font-medium px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                        {{ $enforcers->total() }} total
                    </span>
                </div>

                {{-- Filter Bar --}}
                <form method="GET" action="{{ route('head-mitcom.enforcers.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div class="relative md:col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..."
                            class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400">
                    </div>

                    <div>
                        <select name="assignment"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="all">All Assignments</option>
                            <option value="has_assignments" @selected(request('assignment') === 'has_assignments')>Has Assignments</option>
                            <option value="no_assignments" @selected(request('assignment') === 'no_assignments')>No Assignments</option>
                        </select>
                    </div>

                    <div>
                        <select name="sort"
                            class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                            <option value="created_at" @selected(request('sort', 'created_at') === 'created_at')>Sort: Newest First</option>
                            <option value="first_name" @selected(request('sort') === 'first_name')>Sort: Name (A-Z)</option>
                            <option value="assigned_reports_count" @selected(request('sort') === 'assigned_reports_count')>Sort: Most Assignments</option>
                        </select>
                        <input type="hidden" name="dir" value="{{ request('sort') === 'first_name' ? 'asc' : (request('sort') === 'assigned_reports_count' ? 'desc' : 'desc') }}">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm">
                            Apply
                        </button>
                        @if(request()->anyFilled(['search', 'assignment', 'sort']))
                            <a href="{{ route('head-mitcom.enforcers.index') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50 transition" title="Clear Filters">
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
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Name</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Email</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Assigned Reports</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Joined</th>
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($enforcers as $enforcer)
                                            <tr class="hover:bg-slate-50 transition">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        @if($enforcer->profile_image)
                                                            <img src="{{ asset('storage/' . $enforcer->profile_image) }}" alt="{{ $enforcer->first_name }}" class="h-9 w-9 rounded-full object-cover shrink-0 ring-2 ring-blue-50">
                                                        @else
                                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-700 to-slate-900 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                                                {{ strtoupper(substr($enforcer->first_name, 0, 1)) }}{{ strtoupper(substr($enforcer->last_name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <p class="font-semibold text-slate-900">
                                                                {{ $enforcer->first_name }} {{ $enforcer->last_name }}
                                                            </p>
                                                            <p class="text-xs text-slate-400">Enforcer</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-slate-500">{{ $enforcer->email }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                                        {{ $enforcer->assigned_reports_count > 0
                            ? 'bg-purple-100 text-purple-700'
                            : 'bg-slate-100 text-slate-400' }}">
                                                        {{ $enforcer->assigned_reports_count }} assigned
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-slate-400 text-xs">
                                                    {{ $enforcer->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('head-mitcom.enforcers.show', $enforcer) }}"
                                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition">
                                                            View
                                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('head-mitcom.enforcer-stations.create', ['enforcer_id' => $enforcer->id]) }}"
                                                            class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-900 font-semibold text-xs border border-emerald-200 hover:border-emerald-400 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition">
                                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 15.012 17 12.343 17 9A7 7 0 103 9c0 3.343 1.698 6.012 3.354 7.385a13.31 13.31 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Deploy
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-300 text-sm">
                                    No enforcers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $enforcers->links() }}
            </div>
        </div>
    </main>

    <x-toast />
</x-app-nav>