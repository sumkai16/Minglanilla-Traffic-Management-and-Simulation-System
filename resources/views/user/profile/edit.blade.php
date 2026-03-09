<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <x-app-nav pageTitle="My Profile" />

        <main class="py-10 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-blue-100/70 via-blue-50 to-transparent"></div>
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                @if(session('success') || session('status'))
                    <div
                        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-lg mb-6 shadow-sm -mt-4 relative z-10">
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

                <div class="relative">
                    <div
                        class="absolute inset-0 -z-10 rounded-[2.5rem] bg-gradient-to-br from-blue-50/90 via-white to-blue-50/40 border border-blue-100/70">
                    </div>
                    <div class="absolute -z-10 -left-8 top-8 h-24 w-24 rounded-full bg-blue-200/35 blur-3xl"></div>
                    <div class="absolute -z-10 -right-8 bottom-8 h-24 w-24 rounded-full bg-cyan-200/35 blur-3xl"></div>
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-4 sm:p-6 lg:p-8">

                    <!-- Profile Card -->
                    <div class="lg:col-span-4 flex flex-col items-center space-y-4 pt-10">
                        <div class="w-full max-w-sm bg-white shadow-sm rounded-3xl border border-blue-100 overflow-hidden relative z-10">
                            <div class="relative px-6 pt-6 pb-5 bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900">
                                <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-white/10 blur-2xl"></div>
                                <div class="absolute -left-10 -bottom-10 h-28 w-28 rounded-full bg-cyan-400/20 blur-2xl"></div>
                                <div class="relative flex items-center gap-4">
                                    <div
                                        class="h-16 w-16 rounded-2xl bg-white/10 border border-white/20 text-white flex items-center justify-center text-2xl font-bold">
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.3em] text-blue-100">Citizen Account</p>
                                        <h2 class="text-xl font-bold text-white">{{ $user->first_name }} {{ $user->last_name }}</h2>
                                        <p class="text-sm text-blue-100/80 mt-1">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-6 space-y-4">
                                <div class="flex items-center justify-between rounded-2xl border border-blue-100 bg-blue-50/60 px-4 py-3">
                                    <div>
                                        <p class="text-xs uppercase tracking-widest text-slate-500">Member Since</p>
                                        <p class="text-sm font-semibold text-slate-900 mt-1">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="h-10 w-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M10 2.5a3.5 3.5 0 00-3.5 3.5v1H5a2.5 2.5 0 00-2.5 2.5v5A2.5 2.5 0 005 17h10a2.5 2.5 0 002.5-2.5v-5A2.5 2.5 0 0015 7h-1.5V6A3.5 3.5 0 0010 2.5zM8 6a2 2 0 114 0v1H8V6z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div class="rounded-xl border border-slate-200 px-4 py-3">
                                        <p class="text-xs uppercase tracking-widest text-slate-500">Role</p>
                                        <p class="font-semibold text-slate-900 mt-1">Citizen</p>
                                    </div>
                                    <div class="rounded-xl border border-slate-200 px-4 py-3">
                                        <p class="text-xs uppercase tracking-widest text-slate-500">Status</p>
                                        <p class="font-semibold text-emerald-600 mt-1">Active</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full max-w-sm bg-white shadow-sm rounded-2xl border border-blue-100 p-5">
                            <h3 class="text-sm font-semibold text-slate-900">Account Tips</h3>
                            <p class="text-xs text-slate-500 mt-1">Keep your details updated for faster assistance.</p>
                            <div class="mt-4 space-y-3 text-sm text-slate-600">
                                <div class="flex items-start gap-3">
                                    <span class="mt-1 h-2 w-2 rounded-full bg-blue-500"></span>
                                    <span>Use an email you check regularly for alerts.</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="mt-1 h-2 w-2 rounded-full bg-blue-500"></span>
                                    <span>Update your password periodically to stay secure.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Forms -->
                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <!-- Edit Profile Form -->
                        <div
                            class="bg-white shadow-sm rounded-2xl border border-blue-100 overflow-hidden lg:mt-0">
                            <div class="px-6 py-8 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white min-h-[96px] flex flex-col justify-center">
                                <h3 class="text-lg font-semibold text-slate-900">Profile Information</h3>
                                <p class="text-sm text-slate-500 mt-1">Update your account details</p>
                            </div>

                            <form method="POST" action="{{ route('profile.update') }}" class="p-8 space-y-8">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="first_name"
                                        class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" id="first_name"
                                        value="{{ old('first_name', $user->first_name) }}"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
                                        required>
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name"
                                        class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" id="last_name"
                                        value="{{ old('last_name', $user->last_name) }}"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
                                        required>
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                        required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">We will use this for account updates.</p>
                                </div>

                                <div class="flex">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition shadow">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Form -->
                        <div class="bg-white shadow-sm rounded-2xl border border-blue-100 overflow-hidden">
                            <div class="px-6 py-5 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-white min-h-[96px] flex flex-col justify-center">
                                <h3 class="text-lg font-semibold text-slate-900">Change Password</h3>
                                <p class="text-sm text-slate-500 mt-1">Update your password to keep your account secure
                                </p>
                            </div>

                            <form method="POST" action="{{ route('profile.updatePassword') }}" class="p-8 space-y-8">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-slate-700 mb-2">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                                        required>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New
                                        Password</label>
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                        required>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Must be at least 8 characters</p>
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-slate-700 mb-2">Confirm New
                                        Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full px-4 py-3.5 text-base border border-slate-200 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                </div>

                                <div class="flex">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-xl transition shadow">
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>
