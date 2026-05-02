@php
    $roleLabel = match ($user->role) {
        'admin' => 'Administrator Account',
        'head-mitcom' => 'Head MITCOM Account',
        'enforcer' => 'Traffic Enforcer Account',
        default => 'Citizen Account',
    };

    $roleBadge = match ($user->role) {
        'admin' => 'Administrator',
        'head-mitcom' => 'Head MITCOM',
        'enforcer' => 'Traffic Enforcer',
        default => 'Citizen',
    };

    $pageTitle = $user->role === 'enforcer' ? 'Profile Management' : 'My Profile';
    $pageEyebrow = match ($user->role) {
        'admin' => 'System Administration',
        'head-mitcom' => 'Command Center',
        'enforcer' => 'Field Operations',
        default => 'Public Reporting',
    };
@endphp

<x-app-nav title="Profile Management" :page-title="$pageTitle" :page-eyebrow="$pageEyebrow">
    <main class="py-10 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-blue-100/80 via-slate-50 to-transparent"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                @if(session('success') || session('status'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl mb-6 shadow-sm -mt-4 relative z-10">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold">
                                @if(session('success'))
                                    {{ session('success') }}
                                @elseif(session('status') === 'profile-updated')
                                    {{ __('Profile updated.') }}
                                @elseif(session('status') === 'password-updated')
                                    {{ __('Password updated.') }}
                                @else
                                    {{ session('status') }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endif

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
                                        <p class="text-xs uppercase tracking-[0.3em] text-blue-700">{{ $roleLabel }}</p>
                                        <h2 class="text-2xl font-bold text-slate-900 mt-2">{{ $user->first_name }} {{ $user->last_name }}</h2>
                                        <p class="text-sm text-slate-500 mt-1">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 sm:min-w-[320px]">
                                    <div class="rounded-2xl border border-slate-200 bg-white/80 px-4 py-4">
                                        <p class="text-xs uppercase tracking-widest text-slate-400">Role</p>
                                        <p class="text-sm font-semibold text-slate-900 mt-2">{{ $roleBadge }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-white/80 px-4 py-4">
                                        <p class="text-xs uppercase tracking-widest text-slate-400">Status</p>
                                        <p class="text-sm font-semibold text-emerald-600 mt-2">Active</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-white/80 px-4 py-4 col-span-2">
                                        <p class="text-xs uppercase tracking-widest text-slate-400">Member Since</p>
                                        <p class="text-sm font-semibold text-slate-900 mt-2">{{ $user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50/60 px-5 py-4">
                                <p class="text-sm font-semibold text-slate-900">Account Overview</p>
                                <p class="text-sm text-slate-600 mt-1">
                                    Keep your account details accurate so notifications, assignments, and account recovery continue to work smoothly.
                                </p>
                            </div>
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                        <div class="px-6 py-6 sm:px-8 border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-blue-50">
                            <p class="text-xs uppercase tracking-[0.25em] text-blue-700 font-semibold">Section 02</p>
                            <h3 class="text-xl font-bold text-slate-900 mt-2">Profile Information</h3>
                            <p class="text-sm text-slate-500 mt-1">Update your personal details and primary email address.</p>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-6 sm:p-8">
                            @csrf
                            @method('PATCH')

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
                                    <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" id="first_name"
                                        value="{{ old('first_name', $user->first_name) }}"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
                                        required>
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" id="last_name"
                                        value="{{ old('last_name', $user->last_name) }}"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
                                        required>
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                        required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-slate-500">This email is used for alerts, account notices, and password recovery.</p>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-2xl transition shadow">
                                    Save Profile Information
                                </button>
                            </div>
                        </form>
                    </section>

                    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                        <div class="px-6 py-6 sm:px-8 border-b border-slate-200 bg-gradient-to-r from-slate-50 via-white to-slate-100">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-600 font-semibold">Section 03</p>
                            <h3 class="text-xl font-bold text-slate-900 mt-2">Change Password</h3>
                            <p class="text-sm text-slate-500 mt-1">Use a strong password to protect your account and assignment access.</p>
                        </div>

                        <form method="POST" action="{{ route('profile.updatePassword') }}" class="p-6 sm:p-8">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                                        required>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                        required>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-xs text-slate-500">Use at least 8 characters for better security.</p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-2xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-2xl transition shadow">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
    </main>
</x-app-nav>
