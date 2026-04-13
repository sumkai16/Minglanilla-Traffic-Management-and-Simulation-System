<x-app-nav title="Enforcer Stations - MITCOM Head" page-title="Enforcer Station Assignments" page-eyebrow="Command Center">
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-medium ring-1 ring-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stats row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Assignments</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stations->total() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Active</p>
                <p class="text-3xl font-bold text-emerald-700 mt-1">{{ $activeCount }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-rose-100 shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">Expired</p>
                <p class="text-3xl font-bold text-rose-600 mt-1">{{ $expiredCount }}</p>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-5 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Station Assignments</h2>
                    <p class="mt-1 text-sm text-slate-500">Manage where each enforcer is stationed and their assignment period.</p>
                </div>
                <a href="{{ route('head-mitcom.enforcer-stations.create') }}"
                   class="inline-flex items-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                    + Assign Station
                </a>
            </div>

            {{-- Filter bar --}}
            <div class="border-b border-slate-200 bg-white px-6 py-4">
                <form method="GET" action="{{ route('head-mitcom.enforcer-stations.index') }}">
                    <div class="flex flex-wrap items-center gap-3">

                        {{-- Search --}}
                        <div class="relative flex-1 min-w-[180px]">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search station or enforcer..."
                                class="w-full rounded-xl border border-slate-300 bg-white pl-9 pr-4 py-2.5 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        </div>

                        {{-- Status --}}
                        <select name="status"
                            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">All Statuses</option>
                            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="expired"  {{ request('status') === 'expired'  ? 'selected' : '' }}>Expired</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        {{-- Enforcer --}}
                        <select name="enforcer_id"
                            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">All Enforcers</option>
                            @foreach($enforcers as $enforcer)
                                <option value="{{ $enforcer->id }}" {{ request('enforcer_id') == $enforcer->id ? 'selected' : '' }}>
                                    {{ $enforcer->first_name }} {{ $enforcer->last_name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Sort --}}
                        <select name="sort"
                            class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="latest"   {{ request('sort', 'latest') === 'latest'   ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest"   {{ request('sort') === 'oldest'   ? 'selected' : '' }}>Oldest First</option>
                            <option value="expires"  {{ request('sort') === 'expires'  ? 'selected' : '' }}>Expiring Soon</option>
                            <option value="enforcer" {{ request('sort') === 'enforcer' ? 'selected' : '' }}>Enforcer Name</option>
                        </select>

                        {{-- Apply --}}
                        <button type="submit"
                            class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Apply
                        </button>

                        {{-- Clear --}}
                        @if(request()->hasAny(['search', 'status', 'enforcer_id', 'sort']))
                            <a href="{{ route('head-mitcom.enforcer-stations.index') }}"
                            class="text-xs font-semibold text-rose-500 hover:text-rose-700 transition">
                                × Clear
                            </a>
                        @endif

                    </div>
                </form>
            </div>
            @if($stations->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Enforcer</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Station</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Period</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Status</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Notes</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($stations as $station)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-700 to-slate-900 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($station->enforcer->first_name, 0, 1)) }}{{ strtoupper(substr($station->enforcer->last_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $station->enforcer->first_name }} {{ $station->enforcer->last_name }}</p>
                                                <p class="text-xs text-slate-400">Enforcer</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800">{{ $station->label }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $station->latitude }}, {{ $station->longitude }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-xs">
                                        <p>{{ $station->assigned_at->format('M d, Y') }}</p>
                                        <p class="text-slate-400">to {{ $station->expires_at->format('M d, Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($station->is_active && !$station->isExpired())
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                        @elseif($station->isExpired())
                                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-rose-200">Expired</span>
                                        @else
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500 italic max-w-[180px] truncate">
                                        {{ $station->notes ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('head-mitcom.enforcer-stations.show', $station) }}"
                                               class="inline-flex items-center rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                                View
                                            </a>
                                            <a href="{{ route('head-mitcom.enforcer-stations.edit', $station) }}"
                                               class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-white">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('head-mitcom.enforcer-stations.destroy', $station) }}"
                                                  onsubmit="return confirm('Remove this station assignment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <h3 class="text-lg font-bold text-slate-900">No station assignments found</h3>
                    <p class="mt-2 text-sm text-slate-500">Try adjusting your filters or assign a new station.</p>
                </div>
            @endif

            @if($stations->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $stations->links() }}
                </div>
            @endif
        </div>
    </main>

    <x-toast />
</x-app-nav>