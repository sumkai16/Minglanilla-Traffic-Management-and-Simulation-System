<x-app-nav title="User Management" page-title="User Management" page-eyebrow="System Administration">
    <x-slot:actions>
        <button type="button" @click="$dispatch('open-admin-user-create')"
            class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/15">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.75v12.5m6.25-6.25H5.75" />
            </svg>
            Add User
        </button>
    </x-slot:actions>

    <div x-data="{ showCreateModal: {{ $errors->any() ? 'true' : 'false' }} }"
        @open-admin-user-create.window="showCreateModal = true"
        @keydown.escape.window="showCreateModal = false">

        <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm">
                    <strong class="font-semibold">Success:</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm">
                    <strong class="font-semibold">Error:</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total Users</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Admins</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['admin'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Head MITCOM</p>
                    <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $stats['head_mitcom'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition cursor-default">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Enforcers</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['enforcer'] }}</p>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">All Users</h2>
                            <p class="text-xs text-slate-500 mt-1">Search and filter accounts, manage roles and access</p>
                        </div>
                        <span class="text-sm text-slate-400 font-medium px-3 py-1 bg-slate-50 rounded-full border border-slate-100">
                            {{ $users->total() }} total
                        </span>
                    </div>

                    {{-- Filter Bar --}}
                    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
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
                            <select name="role"
                                class="w-full py-2 text-sm border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-slate-600">
                                <option value="all">All Roles</option>
                                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                                <option value="head-mitcom" @selected(request('role') === 'head-mitcom')>Head MITCOM</option>
                                <option value="enforcer" @selected(request('role') === 'enforcer')>Enforcer</option>
                                <option value="user" @selected(request('role') === 'user')>Citizen</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-4 rounded-xl transition text-sm">
                                Apply
                            </button>
                            @if(request()->anyFilled(['search', 'role']))
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50 transition" title="Clear Filters">
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
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">#</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Name</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Email</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Role</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Joined</th>
                                <th class="text-left px-6 py-3 font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">#{{ $user->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-700 to-slate-900 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($user->first_name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </p>
                                                @if($user->id === auth()->id())
                                                    <p class="text-xs text-slate-400">(You)</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span @class([
                                            'px-2.5 py-1 rounded-full text-xs font-semibold',
                                            'bg-purple-100 text-purple-700' => $user->role === 'admin',
                                            'bg-yellow-100 text-yellow-700' => $user->role === 'head-mitcom',
                                            'bg-green-100 text-green-700' => $user->role === 'enforcer',
                                            'bg-blue-100 text-blue-700' => $user->role === 'user',
                                        ])>
                                            {{ ucfirst(str_replace('-', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 text-xs">
                                        {{ $user->created_at->format('M d, Y') }}<br>
                                        <span class="text-slate-300">{{ $user->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs border border-blue-200 hover:border-blue-400 px-3 py-1.5 rounded-lg transition">
                                                Edit
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                    onsubmit="return confirm('Delete {{ $user->first_name }} {{ $user->last_name }}? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 font-semibold text-xs border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-slate-300 text-sm">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            </div>
        </main>

        {{-- Create User Modal --}}
        <div x-cloak x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center px-4 py-8">
                <div x-show="showCreateModal" x-transition.opacity class="absolute inset-0 bg-slate-950/55 backdrop-blur-sm"></div>

                <div x-show="showCreateModal" x-transition
                    class="relative w-full max-w-3xl overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl">
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
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.75v12.5m6.25-6.25H5.75" />
                                </svg>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-nav>
