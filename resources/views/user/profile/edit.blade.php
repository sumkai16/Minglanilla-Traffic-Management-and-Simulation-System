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

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Profile Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 -mt-4 relative z-10">
                            <div class="text-center">
                                <div
                                    class="h-24 w-24 rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                                    {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                </div>
                                <h2 class="text-xl font-bold text-slate-900">{{ $user->first_name }}
                                    {{ $user->last_name }}</h2>
                                <p class="text-sm text-slate-500 mt-1">{{ $user->email }}</p>
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <div class="text-xs text-slate-500">Member since</div>
                                    <div class="text-sm font-medium text-slate-900 mt-1">
                                        {{ $user->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Forms -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Edit Profile Form -->
                        <div
                            class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden -mt-4 lg:mt-0">
                            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Profile Information</h3>
                                <p class="text-sm text-slate-500 mt-1">Update your account details</p>
                            </div>

                            <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-6">
                                @csrf
                                @method('PATCH')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="first_name"
                                            class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                                        <input type="text" name="first_name" id="first_name"
                                            value="{{ old('first_name', $user->first_name) }}"
                                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
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
                                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
                                            required>
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                        required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Form -->
                        <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                                <h3 class="text-lg font-semibold text-slate-900">Change Password</h3>
                                <p class="text-sm text-slate-500 mt-1">Update your password to keep your account secure
                                </p>
                            </div>

                            <form method="POST" action="{{ route('profile.updatePassword') }}" class="p-6 space-y-6">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-slate-700 mb-2">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                                        required>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New
                                        Password</label>
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
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
                                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-6 rounded-lg transition">
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>