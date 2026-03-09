<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
        <x-app-nav pageTitle="Admin Dashboard" />

        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

              
                <div class="relative overflow-hidden bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 mb-8 border border-blue-100">
                    
                 
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-teal-500 to-indigo-500"></div>

                    <h2 class="text-2xl font-bold 
                               bg-gradient-to-r from-blue-700 to-cyan-500 
                               bg-clip-text text-transparent">
                        Welcome, {{ auth()->user()->first_name }} 👋
                    </h2>

                    <p class="text-blue-700/80 text-sm mt-2">
                        Minglanilla Traffic Management System - Admin Control Panel
                    </p>
                </div>


                <!-- Stats Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <!-- Total Users -->
                    <div class="relative bg-white rounded-lg border border-blue-100 shadow-sm p-6 text-center 
                                transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                        <div class="text-3xl font-bold text-slate-900">
                            {{ $totalUsers }}
                        </div>
                        <div class="text-xs text-blue-700/70 mt-2 uppercase tracking-widest">
                            Total Users
                        </div>
                    </div>

                    <!-- Admins -->
                    <div class="relative bg-white rounded-lg border border-blue-100 shadow-sm p-6 text-center 
                                transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                        <div class="text-3xl font-bold text-slate-900">
                            {{ $adminCount }}
                        </div>
                        <div class="text-xs text-blue-700/70 mt-2 uppercase tracking-widest">
                            Admins
                        </div>
                    </div>

                    <!-- Head MITCOM -->
                    <div class="relative bg-white rounded-lg border border-blue-100 shadow-sm p-6 text-center 
                                transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                        <div class="text-3xl font-bold text-slate-900">
                            {{ $headMitcomCount }}
                        </div>
                        <div class="text-xs text-blue-700/70 mt-2 uppercase tracking-widest">
                            Head MITCOM
                        </div>
                    </div>

                    <!-- Enforcers -->
                    <div class="relative bg-white rounded-lg border border-blue-100 shadow-sm p-6 text-center 
                                transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                        <div class="text-3xl font-bold text-slate-900">
                            {{ $enforcerCount }}
                        </div>
                        <div class="text-xs text-blue-700/70 mt-2 uppercase tracking-widest">
                            Enforcers
                        </div>
                    </div>

                </div>

                <!-- Live Map -->
                <div class="relative overflow-hidden bg-white shadow-xl rounded-2xl p-6 mb-8 border border-blue-100">
                    <div class="absolute inset-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_top_left,rgba(59,130,246,0.25),transparent_55%),radial-gradient(circle_at_bottom_right,rgba(20,184,166,0.25),transparent_55%)]"></div>
                     <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-blue-600 to-cyan-500"></div>
                    <div class="relative">
                        
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-4">
                            
                            <div>
                                <h3 class="text-xl font-semibold text-slate-900">Live Traffic Map</h3>
                                <p class="text-sm text-blue-700/80">Real-time reports across Minglanilla</p>
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
                            <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-blue-500/10 via-transparent to-teal-500/10"></div>
                            <div id="admin-map" class="w-full h-[420px]"></div>
                            <div class="absolute top-3 left-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-blue-700 shadow">
                                Live Map
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow-xl rounded-2xl p-8 border border-blue-100">
                    
                    
                    <h3 class="text-xl font-semibold text-slate-900 mb-6">
                        Quick Actions
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        

                        <!-- Manage Users -->
                        <a href="{{ route('admin.users.index') }}"
                            class="group block p-6 rounded-2xl border border-blue-100 bg-white
                                   transition-all duration-300 
                                   hover:border-blue-500 hover:shadow-xl hover:-translate-y-1">

                            <div class="text-lg font-semibold text-slate-900 group-hover:text-blue-600 transition">
                                👥 Manage Users
                            </div>

                            <div class="text-sm text-blue-700/70 mt-2">
                                Add, edit, or remove users
                            </div>
                        </a>

                        <!-- Traffic Reports -->
                        <a href="{{ route('admin.reports.index') }}"
                            class="group block p-6 rounded-2xl border border-blue-100 bg-white
                                   transition-all duration-300 
                                   hover:border-blue-500 hover:shadow-xl hover:-translate-y-1">

                            <div class="text-lg font-semibold text-slate-900 group-hover:text-blue-600 transition">
                                📋 Traffic Reports
                            </div>

                            <div class="text-sm text-blue-700/70 mt-2">
                                View all traffic reports
                            </div>
                        </a>
<<<<<<< HEAD

                        <!-- Traffic Map -->
                        <a href="#"
                            class="group block p-6 rounded-2xl border border-blue-100 bg-white
                                   transition-all duration-300 
                                   hover:border-blue-500 hover:shadow-xl hover:-translate-y-1">

                            <div class="text-lg font-semibold text-slate-900 group-hover:text-blue-600 transition">
                                🗺️ Traffic Map
                            </div>

                            <div class="text-sm text-blue-700/70 mt-2">
                                View live traffic map
                            </div>
=======
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
>>>>>>> 25cbdd0a2da1d14a0d6fd908cafac23ff6197cee
                        </a>

                    </div>

                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('admin-map')) {
                initPublicMap('admin-map');
            }
        });
    </script>

</body>

</html>
