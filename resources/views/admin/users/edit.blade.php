<x-app-nav title="Edit User" page-title="Edit User" page-eyebrow="System Administration">
    <x-slot:actions>
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-white/15">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" />
            </svg>
            Back to Users
        </a>
    </x-slot:actions>

    <main class="py-10 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-blue-100/80 via-slate-50 to-transparent"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="space-y-6">
                <section class="relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(59,130,246,0.14),transparent_42%),radial-gradient(circle_at_bottom_right,rgba(6,182,212,0.12),transparent_38%)] pointer-events-none"></div>
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-700 via-cyan-500 to-slate-800"></div>
                    <div class="relative px-6 py-8 sm:px-8">
                        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-5">
                                @if($user->profile_image)
                                    <div class="h-20 w-20 shrink-0 rounded-3xl overflow-hidden shadow-lg border-2 border-white ring-4 ring-blue-50/50">
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="h-20 w-20 shrink-0 rounded-3xl bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900 text-white flex items-center justify-center text-3xl font-black shadow-lg border-2 border-white ring-4 ring-blue-50/50">
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-xs uppercase tracking-[0.3em] text-blue-700">{{ ucfirst($user->role) }} Account</p>
                                    <h2 class="text-2xl font-bold text-slate-900 mt-2">{{ $user->first_name }} {{ $user->last_name }}</h2>
                                    <p class="text-sm text-slate-500 mt-1">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 sm:min-w-[320px]">
                                <div class="rounded-2xl border border-slate-200 bg-white/80 px-4 py-4">
                                    <p class="text-xs uppercase tracking-widest text-slate-400">Role</p>
                                    <p class="text-sm font-semibold text-slate-900 mt-2">{{ ucfirst(str_replace('-', ' ', $user->role)) }}</p>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-white/80 px-4 py-4 col-span-1">
                                    <p class="text-xs uppercase tracking-widest text-slate-400">Joined</p>
                                    <p class="text-sm font-semibold text-slate-900 mt-2">{{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                    <div class="px-6 py-6 sm:px-8 border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-blue-50">
                        <p class="text-xs uppercase tracking-[0.25em] text-blue-700 font-semibold">Admin Editor</p>
                        <h3 class="text-xl font-bold text-slate-900 mt-2">Update User Details</h3>
                        <p class="text-sm text-slate-500 mt-1">Modify account access, personal information, or profile image.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="p-6 sm:p-8">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <p class="font-semibold">Please review the form and correct the highlighted fields.</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="profile_image" class="block text-sm font-medium text-slate-700 mb-2">Profile Image (Optional)</label>
                                <input type="file" name="profile_image" id="profile_image" accept="image/*"
                                    class="w-full text-base text-slate-600 file:mr-4 file:py-3.5 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:border-blue-500 p-1.5 @error('profile_image') border-red-500 @enderror">
                                @error('profile_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
                                    required>
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="last_name"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
                                    required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Role <span class="text-red-500">*</span></label>
                                <select name="role" id="role"
                                    class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror"
                                    required>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="head-mitcom" {{ old('role', $user->role) === 'head-mitcom' ? 'selected' : '' }}>Head MITCOM</option>
                                    <option value="enforcer" {{ old('role', $user->role) === 'enforcer' ? 'selected' : '' }}>Enforcer</option>
                                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Citizen</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2 mt-4 pt-6 border-t border-slate-100">
                                <h4 class="text-sm font-semibold text-slate-900 mb-4">Update Password <span class="text-xs font-normal text-slate-500 ml-2">(leave blank to keep current)</span></h4>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                                <input type="password" name="password" id="password" placeholder="Leave blank to keep current password"
                                    class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Leave blank to keep current password"
                                    class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                            <a href="{{ route('admin.users.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25zM12 14.25v-2.812m0 2.812l-4.5 2.25V3.75z" />
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
</x-app-nav>