<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">

        <x-app-nav pageTitle="My Dashboard">
            <a href="{{ route('user.profile.edit') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 transition">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6z" />
                    <path fill-rule="evenodd"
                        d="M2 16.5A4.5 4.5 0 016.5 12h7a4.5 4.5 0 014.5 4.5.75.75 0 01-.75.75H2.75A.75.75 0 012 16.5z"
                        clip-rule="evenodd" />
                </svg>
                My Profile
            </a>
            <a href="{{ route('user.announcements.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 transition">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 2.75a3.75 3.75 0 00-3.75 3.75v1.046c0 .535-.133 1.062-.387 1.532l-.581 1.076A1.75 1.75 0 006.822 13h6.356a1.75 1.75 0 001.54-2.841l-.581-1.076a3.234 3.234 0 01-.387-1.532V6.5A3.75 3.75 0 0010 2.75zM8.25 14.5a1.75 1.75 0 103.5 0h-3.5z"
                        clip-rule="evenodd" />
                </svg>
                Announcements
            </a>
            <a href="{{ route('user.reports.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white text-sm font-semibold hover:bg-blue-400 transition">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10 5.75a.75.75 0 01.75.75v2.75h2.75a.75.75 0 010 1.5h-2.75v2.75a.75.75 0 01-1.5 0v-2.75H6.5a.75.75 0 010-1.5h2.75V6.5A.75.75 0 0110 5.75z" />
                </svg>
                Report Incident

            </a>

        </x-app-nav>

        <main class="py-10 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-60 bg-gradient-to-b from-blue-100/70 via-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Welcome Card -->
                <div
                    class="relative overflow-hidden bg-white shadow-sm rounded-3xl border border-blue-100 p-7 mb-6 -mt-6">
                    <div class="absolute -right-14 -top-12 h-40 w-40 rounded-full bg-blue-500/10 blur-2xl"></div>
                    <div class="absolute -left-10 -bottom-12 h-36 w-36 rounded-full bg-cyan-400/10 blur-2xl"></div>
                    <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                Citizen Dashboard
                            </div>
                            <h2 class="mt-3 text-2xl md:text-3xl font-bold text-slate-900">
                                Welcome Citizen!
                            </h2>
                            <p class="text-slate-600 text-sm mt-2 max-w-xl">
                                Track your incident reports, follow their progress, and stay updated with real-time traffic
                                activity.
                            </p>
                        </div>
                        <div
                            class="flex items-center gap-6 rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white px-5 py-4 shadow-sm">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Total Reports</div>
                                <div class="text-4xl font-bold text-blue-600 mt-2">{{ $reports->total() }}</div>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow">
                                <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M3.75 5.5A1.75 1.75 0 015.5 3.75h6.086c.464 0 .91.184 1.237.513l3.664 3.664c.329.327.513.773.513 1.237V14.5a1.75 1.75 0 01-1.75 1.75H5.5A1.75 1.75 0 013.75 14.5v-9z" />
                                    <path
                                        d="M12.25 3.75V7a.75.75 0 00.75.75h3.25" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                @if($urgentAnnouncement)
                    <section
                        class="relative overflow-hidden rounded-[1.75rem] border border-rose-200 bg-gradient-to-r from-rose-50 via-white to-amber-50 p-6 mb-6 shadow-sm">
                        <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-rose-300/20 blur-2xl"></div>
                        <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <div class="inline-flex items-center gap-2 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                    Urgent Announcement
                                </div>
                                <h3 class="mt-3 text-2xl font-bold text-slate-900">{{ $urgentAnnouncement->title }}</h3>
                                <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">{{ $urgentAnnouncement->content }}</p>
                            </div>
                            <div class="rounded-2xl border border-rose-200 bg-white/90 px-5 py-4 text-sm text-slate-600 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-widest text-rose-600">Published</p>
                                <p class="mt-2 font-semibold text-slate-900">{{ $urgentAnnouncement->published_at?->format('M d, Y h:i A') }}</p>
                                <a href="{{ route('user.announcements.index') }}"
                                    class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                                    View all announcements
                                </a>
                            </div>
                        </div>
                    </section>
                @endif

                <section class="bg-white shadow-sm rounded-3xl border border-blue-100 p-6 mb-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Announcement Dashboard</p>
                            <h3 class="mt-2 text-2xl font-bold text-slate-900">Latest community updates</h3>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                                Stay informed about traffic advisories, emergencies, and road updates published by Head MITCOM.
                            </p>
                        </div>
                        <a href="{{ route('user.announcements.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                            View all announcements
                        </a>
                    </div>

                    @if($latestAnnouncements->count())
                        <div class="mt-6 grid gap-4 md:grid-cols-3">
                            @foreach($latestAnnouncements as $announcement)
                                <article class="rounded-[1.5rem] border p-5 shadow-sm {{ $announcement->priority === 'urgent' ? 'border-rose-200 bg-rose-50/60' : 'border-slate-200 bg-slate-50/60' }}">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $announcement->priority === 'urgent' ? 'bg-rose-100 text-rose-700 ring-rose-200' : ($announcement->priority === 'important' ? 'bg-amber-100 text-amber-700 ring-amber-200' : 'bg-blue-50 text-blue-700 ring-blue-200') }}">
                                            {{ ucfirst($announcement->priority) }}
                                        </span>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">
                                            {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $announcement->type)) }}
                                        </span>
                                    </div>
                                    <h4 class="mt-4 text-lg font-bold text-slate-900">{{ $announcement->title }}</h4>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">
                                        {{ \Illuminate\Support\Str::limit($announcement->content, 140) }}
                                    </p>
                                    <p class="mt-4 text-xs text-slate-400">
                                        Published {{ $announcement->published_at?->diffForHumans() }}
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                            <p class="font-semibold text-slate-700">No announcements published yet</p>
                            <p class="mt-2 text-sm text-slate-500">Public updates from Head MITCOM will appear here once available.</p>
                        </div>
                    @endif
                </section>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div
                        class="group bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Pending</div>
                                <div class="text-3xl font-semibold text-yellow-600 mt-3">{{ $pendingCount }}</div>
                                <p class="text-xs text-slate-400 mt-2">Awaiting validation</p>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-200 flex items-center justify-center group-hover:scale-105 transition">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="group bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Verified</div>
                                <div class="text-3xl font-semibold text-blue-600 mt-3">{{ $verifiedCount }}</div>
                                <p class="text-xs text-slate-400 mt-2">Confirmed by team</p>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center group-hover:scale-105 transition">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="group bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Resolved</div>
                                <div class="text-3xl font-semibold text-green-600 mt-3">{{ $resolvedCount }}</div>
                                <p class="text-xs text-slate-400 mt-2">Closed successfully</p>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-green-50 text-green-700 ring-1 ring-inset ring-green-200 flex items-center justify-center group-hover:scale-105 transition">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session('success'))
                    <div
                        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-lg mb-6 shadow-sm animate-fade-in">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <strong class="font-semibold">Success!</strong>
                                <span class="block text-sm mt-0.5">{{ session('success') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Reports Table -->
                <div
                    class="bg-white shadow-sm rounded-2xl border border-blue-100 overflow-hidden border-t-4 border-t-blue-600">
                    <div class="px-6 py-5 border-b border-blue-100">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">My Reports</h2>
                                <p class="text-sm text-blue-700/70 mt-1">View all your submitted incident reports</p>
                            </div>
                            <form method="GET" action="{{ route('user.dashboard') }}"
                                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Issue Type</label>
                                    <select name="issue_type"
                                        class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200">
                                        <option value="">All issues</option>
                                        @foreach($issueTypes as $type)
                                            <option value="{{ $type['value'] }}" @selected($issueType === $type['value'])>
                                                {{ $type['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Report Status</label>
                                    <select name="status"
                                        class="rounded-lg border border-slate-200 bg-white px-7 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200">
                                        <option value="">All statuses</option>
                                        @foreach($statusOptions as $option)
                                            <option value="{{ $option['value'] }}" @selected($status === $option['value'])>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Order</label>
                                    <select name="sort"
                                        class="rounded-lg border border-slate-200 bg-white px-7 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200">
                                        <option value="latest" @selected($sort === 'latest')>Latest </option>
                                        <option value="oldest" @selected($sort === 'oldest')>Oldest </option>
                                    </select>
                                </div>
                                <div class="flex gap-2 pt-1 sm:pt-6">
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-7 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                                        Apply
                                    </button>
                                    <a href="{{ route('user.dashboard') }}"
                                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-slate-300 hover:text-slate-800 transition">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Issue Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Location</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Submitted</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($reports as $report)
                                    <tr class="hover:bg-slate-50/70 transition cursor-pointer"
                                        onclick="window.location='{{ route('user.reports.show', $report) }}'">
                                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $report->id }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ Str::limit($report->location, 40) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full ring-1 ring-inset
                                                                                                            @if($report->status === 'pending') bg-yellow-50 text-yellow-800 ring-yellow-200
                                                                                                            @elseif($report->status === 'verified') bg-blue-50 text-blue-800 ring-blue-200
                                                                                                            @elseif($report->status === 'assigned') bg-purple-50 text-purple-800 ring-purple-200
                                                                                                            @elseif($report->status === 'resolved') bg-green-50 text-green-800 ring-green-200
                                                                                                            @elseif($report->status === 'rejected') bg-red-50 text-red-800 ring-red-200
                                                                                                            @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $report->created_at->format('M d, Y') }}
                                            <br>
                                            <span
                                                class="text-xs text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-slate-400 mb-2">
                                                <svg class="h-12 w-12 mx-auto" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">No reports yet</p>
                                            <p class="text-sm text-slate-400 mt-1">Submit your first incident report to get
                                                started</p>
                                            <a href="{{ route('user.reports.create') }}"
                                                class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                Report Incident
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($reports->hasPages())
                        <div class="px-6 py-4 border-t border-blue-100">
                            {{ $reports->links() }}
                        </div>
                    @endif
                </div>

                <!-- Live Map -->
                <div class="relative overflow-hidden bg-white shadow-xl rounded-2xl p-6 mt-6 border border-blue-100">
                    <div class="absolute inset-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_top_left,rgba(59,130,246,0.25),transparent_55%),radial-gradient(circle_at_bottom_right,rgba(14,165,233,0.2),transparent_55%)]"></div>
                    <div class="relative">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900">Live Traffic Map</h3>
                                <p class="text-sm text-blue-700/80">Browse live incidents around Minglanilla</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 border border-blue-100">
                                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                    Verified
                                </span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-yellow-50 px-3 py-1 border border-yellow-100">
                                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                    Pending
                                </span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1 border border-green-100">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    Resolved
                                </span>
                            </div>
                        </div>

                        <div class="relative overflow-hidden rounded-2xl border border-slate-200 shadow-inner">
                            <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-blue-500/10 via-transparent to-cyan-500/10"></div>
                            <div id="user-map" class="w-full h-[420px]"></div>
                            <div class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700 shadow">
                                Live Map
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('user-map')) {
                initPublicMap('user-map');
            }
        });
    </script>
</body>

</html>
