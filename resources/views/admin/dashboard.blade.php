<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <x-app-nav pageTitle="Admin Dashboard" />
        <!-- Header -->


        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Welcome -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Welcome, {{ auth()->user()->first_name }}!</h2>
                    <p class="text-gray-600 text-sm mt-1">Minglanilla Traffic Management System - Admin Panel</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 ">
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</div>
                        <div class="text-sm text-gray-500 mt-1">Total Users</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $adminCount }}</div>
                        <div class="text-sm text-gray-500 mt-1">Admins</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $headMitcomCount }}</div>
                        <div class="text-sm text-gray-500 mt-1">Head MITCOM</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $enforcerCount }}</div>
                        <div class="text-sm text-gray-500 mt-1">Enforcers</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.users.index') }}"
                            class="block p-4 border border-gray-300 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                            <div class="font-medium text-gray-900">👥 Manage Users</div>
                            <div class="text-sm text-gray-500 mt-1">Add, edit, or remove users</div>
                        </a>
                        <a href="{{ route('admin.reports.index') }}"
                            class="block p-4 border border-gray-300 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                            <div class="font-medium text-gray-900">📋 Traffic Reports</div>
                            <div class="text-sm text-gray-500 mt-1">View all traffic reports</div>
                        </a>
                        <a href="{{ route('admin.map') }}"
                            class="block p-4 border border-slate-200 rounded-xl hover:border-blue-500 hover:shadow-md hover:-translate-y-0.5 transition group">
                            <div class="flex items-center gap-3 mb-2">
                                <div
                                    class="h-10 w-10 rounded-lg bg-slate-900/5 group-hover:bg-blue-50 flex items-center justify-center transition">
                                    <svg class="h-5 w-5 text-slate-700 group-hover:text-blue-700" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8 1a.75.75 0 01.75.75V6h4.5V1.75a.75.75 0 011.5 0V6h1.25A2.75 2.75 0 0118.75 8.75v8.5A2.75 2.75 0 0116 20.25H4A2.75 2.75 0 011.25 17.25v-8.5A2.75 2.75 0 014 6h1.25V1.75A.75.75 0 018 1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="font-semibold text-slate-900">Live Traffic Map</div>
                            </div>
                            <div class="text-sm text-slate-500">View all incidents on interactive map</div>
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>