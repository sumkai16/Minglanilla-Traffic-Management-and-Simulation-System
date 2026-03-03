<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
    <div class="min-h-screen">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-900 to-slate-900"></div>
            <div
                class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.4),transparent_55%)]">
            </div>
            <div class="absolute inset-0 bg-black/20"></div>

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        ← Back to Dashboard
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-700 text-sm">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6">
                        <strong class="font-semibold">Success:</strong> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                        <strong class="font-semibold">Error:</strong> {{ session('error') }}
                    </div>
                @endif

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 -mt-4 relative z-10">
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Total Users</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">{{ $users->count() }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-slate-900/5 text-slate-700 ring-1 ring-inset ring-slate-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10 8a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd"
                                        d="M2 16.5A4.5 4.5 0 016.5 12h7a4.5 4.5 0 014.5 4.5.75.75 0 01-.75.75H2.75A.75.75 0 012 16.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Admins</div>
                                <div class="text-3xl font-semibold text-red-600 mt-3">
                                    {{ $users->where('role', 'admin')->count() }}
                                </div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-red-50 text-red-700 ring-1 ring-inset ring-red-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 2a.75.75 0 01.39.11l6 3.6a.75.75 0 01.36.64v4.58a7.5 7.5 0 01-6.9 7.48.75.75 0 01-.17 0A7.5 7.5 0 013.25 10.93V6.35a.75.75 0 01.36-.64l6-3.6A.75.75 0 0110 2zm3.03 7.28a.75.75 0 10-1.06-1.06L9.5 10.69 8.03 9.22a.75.75 0 10-1.06 1.06l2 2a.75.75 0 001.06 0l3-3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Head MITCOM</div>
                                <div class="text-3xl font-semibold text-blue-600 mt-3">
                                    {{ $users->where('role', 'head-mitcom')->count() }}
                                </div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 2a.75.75 0 01.62.33l1.8 2.7 3.18.66a.75.75 0 01.41 1.23l-2.2 2.55.33 3.24a.75.75 0 01-1.08.78L10 12.98l-3.06 1.6a.75.75 0 01-1.08-.78l.33-3.24-2.2-2.55a.75.75 0 01.41-1.23l3.18-.66 1.8-2.7A.75.75 0 0110 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-slate-500">Enforcers</div>
                                <div class="text-3xl font-semibold text-amber-600 mt-3">
                                    {{ $users->where('role', 'enforcer')->count() }}
                                </div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M9.664 2.318a.75.75 0 01.672 0l6.5 3.25a.75.75 0 01.414.671V10c0 4.01-3.185 7.39-7.25 7.79A8.03 8.03 0 012.75 10V6.239a.75.75 0 01.414-.671l6.5-3.25zM10 6a.75.75 0 01.75.75v2.5h1.5a.75.75 0 010 1.5h-1.5v2.5a.75.75 0 01-1.5 0v-2.5h-1.5a.75.75 0 010-1.5h1.5v-2.5A.75.75 0 0110 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- add user button-->
                <div class="flex justify-end m-2">
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-400 text-blue-950 text-sm font-semibold hover:bg-yellow-500 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M10 5.75a.75.75 0 01.75.75v2.75h2.75a.75.75 0 010 1.5h-2.75v2.75a.75.75 0 01-1.5 0v-2.75H6.5a.75.75 0 010-1.5h2.75V6.5A.75.75 0 0110 5.75z" />
                        </svg>
                        Add User
                    </a>
                </div>

                <!-- Table -->
                <div x-cloak x-data="{
                        q: '',
                        role: 'all',
                        normalize(v) { return (v ?? '').toString().toLowerCase(); },
                        matches(text) {
                            const q = this.normalize(this.q).trim();
                            if (!q) return true;
                            return this.normalize(text).includes(q);
                        },
                    }"
                    class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden border-t-4 border-t-red-600">
                    <div
                        class="px-6 py-5 border-b border-slate-200 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">All Users</h2>
                            <p class="text-sm text-slate-500">Search and filter accounts, then edit roles or remove
                                access.</p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                            <div class="relative w-full sm:w-72">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8.5 3a5.5 5.5 0 103.464 9.78l3.628 3.628a.75.75 0 101.06-1.06l-3.628-3.628A5.5 5.5 0 008.5 3zM4.5 8.5a4 4 0 118 0 4 4 0 01-8 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input x-model="q" type="text" placeholder="Search name or email"
                                    class="w-full rounded-xl border border-slate-200 bg-white pl-9 pr-9 py-2 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <button type="button" @click="q=''"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                                    :class="q.trim() ? '' : 'hidden'" aria-label="Clear search">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 01.53 1.28L12 11.06v4.69a.75.75 0 01-1.2.6l-2-1.5a.75.75 0 01-.3-.6v-3.19L2.22 5.28A.75.75 0 012 4.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Role
                                </span>
                                <button type="button" @click="role='all'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition"
                                    :class="role==='all' ? 'bg-blue-700 text-white ring-blue-700' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50'">
                                    All
                                </button>
                                <button type="button" @click="role='admin'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition"
                                    :class="role==='admin' ? 'bg-red-600 text-white ring-red-600' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50'">
                                    Admin
                                </button>
                                <button type="button" @click="role='head-mitcom'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition"
                                    :class="role==='head-mitcom' ? 'bg-blue-700 text-white ring-blue-700' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50'">
                                    Head MITCOM
                                </button>
                                <button type="button" @click="role='enforcer'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition"
                                    :class="role==='enforcer' ? 'bg-amber-500 text-white ring-amber-500' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50'">
                                    Enforcer
                                </button>
                                <button type="button" @click="role='user'"
                                    class="px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition"
                                    :class="role==='user' ? 'bg-slate-800 text-white ring-slate-800' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50'">
                                    User
                                </button>
                            </div>
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
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Joined</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($users as $user)
                                    <tr x-show="(role === 'all' || role === @json($user->role)) && matches(@json(strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->email)))"
                                        class="hover:bg-slate-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-500 align-middle">{{ $user->id }}</td>
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-9 w-9 rounded-full ring-1 ring-inset ring-slate-200 bg-slate-900/5 flex items-center justify-center text-xs font-semibold text-slate-700">
                                                    {{ strtoupper(substr($user->first_name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $user->first_name }} {{ $user->last_name }}
                                                    </div>
                                                    @if($user->id === auth()->id())
                                                        <div class="text-xs text-slate-500">(You)</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                            @if($user->role === 'admin') bg-purple-100 text-purple-800
                                                            @elseif($user->role === 'head-mitcom') bg-blue-100 text-blue-800
                                                            @elseif($user->role === 'enforcer') bg-green-100 text-green-800
                                                            @else bg-gray-100 text-gray-800
                                                            @endif">
                                                {{ ucfirst(str_replace('-', ' ', $user->role)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 align-middle">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium align-middle text-right">
                                            <div class="inline-flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200 hover:bg-blue-50 transition">
                                                    <svg class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-8.25 8.25a1 1 0 01-.391.242l-3 1.2a.75.75 0 01-.98-.98l1.2-3a1 1 0 01.242-.391l8.25-8.25z" />
                                                        <path d="M12.75 4.422l2.828 2.828" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                        onsubmit="return confirm('Delete {{ $user->first_name }} {{ $user->last_name }}? This cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-200 hover:bg-red-50 transition">
                                                            <svg class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor"
                                                                aria-hidden="true">
                                                                <path fill-rule="evenodd"
                                                                    d="M6 3.5A1.5 1.5 0 017.5 2h5A1.5 1.5 0 0114 3.5V4h3a.75.75 0 010 1.5h-.62l-.73 10.2A2.25 2.25 0 0113.41 18H6.59a2.25 2.25 0 01-2.24-2.3L3.62 5.5H3a.75.75 0 010-1.5h3v-.5zM7.5 3.5V4h5v-.5a.5.5 0 00-.5-.5h-4a.5.5 0 00-.5.5z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>