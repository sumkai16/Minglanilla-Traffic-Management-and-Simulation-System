<x-app-nav title="User Management" page-title="User Management" page-eyebrow="System Administration">
    <x-slot:actions>
        <button type="button" @click="$dispatch('open-admin-user-create')"
            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                    d="M10 5.75a.75.75 0 01.75.75v2.75h2.75a.75.75 0 010 1.5h-2.75v2.75a.75.75 0 01-1.5 0v-2.75H6.5a.75.75 0 010-1.5h2.75V6.5A.75.75 0 0110 5.75z" />
            </svg>
            Add User
        </button>
    </x-slot:actions>

    <div class="min-h-0 bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100"
        x-data="{ showCreateModal: {{ $errors->any() ? 'true' : 'false' }} }"
        @open-admin-user-create.window="showCreateModal = true"
        @keydown.escape.window="showCreateModal = false">
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
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-blue-700/70">Total Users</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">{{ $users->count() }}</div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center">
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
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-blue-700/70">Admins</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">
                                    {{ $users->where('role', 'admin')->count() }}
                                </div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 2a.75.75 0 01.39.11l6 3.6a.75.75 0 01.36.64v4.58a7.5 7.5 0 01-6.9 7.48.75.75 0 01-.17 0A7.5 7.5 0 013.25 10.93V6.35a.75.75 0 01.36-.64l6-3.6A.75.75 0 0110 2zm3.03 7.28a.75.75 0 10-1.06-1.06L9.5 10.69 8.03 9.22a.75.75 0 10-1.06 1.06l2 2a.75.75 0 001.06 0l3-3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-blue-700/70">Head MITCOM</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">
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
                        class="bg-white rounded-2xl shadow-sm border border-blue-100 p-5 hover:-translate-y-0.5 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-blue-700/70">Enforcers</div>
                                <div class="text-3xl font-semibold text-slate-900 mt-3">
                                    {{ $users->where('role', 'enforcer')->count() }}
                                </div>
                            </div>
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M9.664 2.318a.75.75 0 01.672 0l6.5 3.25a.75.75 0 01.414.671V10c0 4.01-3.185 7.39-7.25 7.79A8.03 8.03 0 012.75 10V6.239a.75.75 0 01.414-.671l6.5-3.25zM10 6a.75.75 0 01.75.75v2.5h1.5a.75.75 0 010 1.5h-1.5v2.5a.75.75 0 01-1.5 0v-2.5h-1.5a.75.75 0 010-1.5h1.5v-2.5A.75.75 0 0110 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div
                    class="bg-white shadow-sm rounded-2xl border border-blue-100 overflow-hidden border-t-4 border-t-blue-600">
                    <div
                        class="px-6 py-5 border-b border-blue-100 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">All Users</h2>
                            <p class="text-sm text-blue-700/70">Search and filter accounts, then edit roles or remove
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
                                <input id="userSearch" type="text" placeholder="Search name or email"
                                    class="w-full rounded-xl border border-blue-100 bg-white pl-9 pr-9 py-2 text-sm text-slate-900 placeholder:text-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <button type="button" id="clearSearch"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                                    aria-label="Clear search">
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
                                <button type="button" data-role-filter="all"
                                    class="role-filter px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition bg-blue-700 text-white ring-blue-700">
                                    All
                                </button>
                                <button type="button" data-role-filter="admin"
                                    class="role-filter px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition bg-white text-slate-700 ring-slate-200 hover:bg-slate-50">
                                    Admin
                                </button>
                                <button type="button" data-role-filter="head-mitcom"
                                    class="role-filter px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition bg-white text-slate-700 ring-slate-200 hover:bg-slate-50">
                                    Head MITCOM
                                </button>
                                <button type="button" data-role-filter="enforcer"
                                    class="role-filter px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition bg-white text-slate-700 ring-slate-200 hover:bg-slate-50">
                                    Enforcer
                                </button>
                                <button type="button" data-role-filter="user"
                                    class="role-filter px-3 py-1.5 rounded-full text-xs font-semibold ring-1 ring-inset transition bg-white text-slate-700 ring-slate-200 hover:bg-slate-50">
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
                            <tbody id="usersTable" class="bg-white divide-y divide-slate-100">
                                @forelse($users as $user)
                                    <tr data-role="{{ $user->role }}"
                                        data-search="{{ strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->email) }}"
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
                                        <td class="px-6 py-4 text-sm text-gray-500 align-middle">
                                            <span class="inline-flex items-center gap-2">
                                                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M2 6.5A2.5 2.5 0 014.5 4h11A2.5 2.5 0 0118 6.5v7A2.5 2.5 0 0115.5 16h-11A2.5 2.5 0 012 13.5v-7z" />
                                                    <path fill-rule="evenodd"
                                                        d="M3.06 6.62a.75.75 0 01.99-.32l5.43 2.72a1.25 1.25 0 001.1 0l5.43-2.72a.75.75 0 11.67 1.34l-5.43 2.72a2.75 2.75 0 01-2.46 0L3.38 7.96a.75.75 0 01-.32-.99z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="truncate">{{ $user->email }}</span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full ring-1 ring-inset bg-blue-50 text-blue-800 ring-blue-200">
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

        <div x-cloak x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center px-4 py-8">
                <div x-show="showCreateModal" x-transition.opacity class="absolute inset-0 bg-slate-950/55 backdrop-blur-sm"></div>

                <div x-show="showCreateModal" x-transition
                    class="relative w-full max-w-3xl overflow-hidden rounded-[2rem] border border-blue-100 bg-white shadow-2xl">
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-700 via-cyan-500 to-slate-800"></div>

                    <div class="relative px-6 py-6 sm:px-8 border-b border-slate-200 bg-gradient-to-r from-blue-50 via-white to-cyan-50">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-blue-700 font-semibold">Admin Action</p>
                                <h2 class="text-2xl font-bold text-slate-900 mt-2">Add New User</h2>
                                <p class="text-sm text-slate-500 mt-1">Create a new account for administrators, Head MITCOM, enforcers, or citizens.</p>
                            </div>
                            <button type="button" @click="showCreateModal = false"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition"
                                aria-label="Close add user modal">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 sm:p-8">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <p class="font-semibold">Please review the form and correct the highlighted fields.</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    placeholder="Enter first name"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 @error('first_name') border-red-500 @enderror">
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    placeholder="Enter last name"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 @error('last_name') border-red-500 @enderror">
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter email address"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select name="role"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 @error('role') border-red-500 @enderror">
                                    <option value="">Select a role</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="head-mitcom" {{ old('role') === 'head-mitcom' ? 'selected' : '' }}>Head MITCOM</option>
                                    <option value="enforcer" {{ old('role') === 'enforcer' ? 'selected' : '' }}>Enforcer</option>
                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Citizen</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="rounded-2xl border border-blue-100 bg-blue-50/60 px-4 py-4">
                                <p class="text-sm font-semibold text-slate-900">Quick Notes</p>
                                <p class="text-xs text-slate-600 mt-2">New accounts are automatically marked as verified and can sign in right away after creation.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" placeholder="Minimum 8 characters"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" placeholder="Re-enter password"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                            <button type="button" @click="showCreateModal = false"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M10 5.75a.75.75 0 01.75.75v2.75h2.75a.75.75 0 010 1.5h-2.75v2.75a.75.75 0 01-1.5 0v-2.75H6.5a.75.75 0 010-1.5h2.75V6.5A.75.75 0 0110 5.75z" />
                                </svg>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tableBody = document.getElementById('usersTable');
                const searchInput = document.getElementById('userSearch');
                const clearSearch = document.getElementById('clearSearch');
                const roleButtons = Array.from(document.querySelectorAll('.role-filter'));
                let activeRole = 'all';

                const applyFilters = () => {
                    const q = (searchInput?.value || '').trim().toLowerCase();
                    const rows = tableBody ? Array.from(tableBody.querySelectorAll('tr[data-role]')) : [];
                    rows.forEach((row) => {
                        const role = row.dataset.role || '';
                        const search = row.dataset.search || '';
                        const roleOk = activeRole === 'all' || role === activeRole;
                        const searchOk = !q || search.includes(q);
                        row.classList.toggle('hidden', !(roleOk && searchOk));
                    });
                };

                roleButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        activeRole = btn.dataset.roleFilter || 'all';
                        roleButtons.forEach((b) => {
                            b.classList.remove('bg-blue-700', 'text-white', 'ring-blue-700');
                            b.classList.add('bg-white', 'text-slate-700', 'ring-slate-200', 'hover:bg-slate-50');
                        });
                        btn.classList.remove('bg-white', 'text-slate-700', 'ring-slate-200', 'hover:bg-slate-50');
                        btn.classList.add('bg-blue-700', 'text-white', 'ring-blue-700');
                        applyFilters();
                    });
                });

                if (searchInput) {
                    searchInput.addEventListener('input', applyFilters);
                }
                if (clearSearch) {
                    clearSearch.addEventListener('click', () => {
                        if (searchInput) searchInput.value = '';
                        applyFilters();
                    });
                }

                applyFilters();
            });
        </script>
    </div>
</x-app-nav>
