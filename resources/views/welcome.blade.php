<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">
        <!-- Header/Navigation -->
        <header class="w-full bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-700 rounded flex items-center justify-center text-white font-bold">LP</div>
                        <div>
                            <div class="font-bold text-blue-700">LIHOK PADULONG</div>
                            <div class="text-xs text-red-600 font-semibold">MINGLANILLA TRAFFIC COMMAND</div>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                 <nav class="hidden md:flex items-center gap-8">
    <a href="#" class="nav-link" id="home-link">Home</a>
    <a href="#report-incident" class="nav-link" id="report-link">Report</a>
    <a href="#core-features" class="nav-link" id="features-link">Features</a>
</nav>

                    <!-- Login Button -->
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-700 text-white px-4 py-2 rounded font-semibold hover:bg-blue-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-700 text-white px-4 py-2 rounded font-semibold hover:bg-blue-800">Login</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative w-full py-20 md:py-32 bg-gradient-to-r from-blue-700 to-blue-900 text-white overflow-hidden">
            <!-- Background overlay -->
            <div class="absolute inset-0 bg-black/30 z-0"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <!-- Left side content -->
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">
                            Traffic Management and Simulation System for <span class="text-yellow-400">Minglanilla</span>
                        </h1>
                        <p class="text-lg md:text-xl text-gray-100 mb-8">Improving Traffic Flow Through Digital Innovation</p>
                        <a href="#report-incident" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition">
                            Report an Incident
                        </a>
                    </div>

                    <!-- Right side - Official Seal and Shield Logo -->
                    <div class="hidden md:flex flex-col gap-6 justify-center items-center">
                        <!-- Official Seal -->
                        <img src="{{ asset('images/second_logo-removebg-preview.png') }}" alt="Minglanilla Official Seal" class="w-64 h-64 object-contain drop-shadow-lg">
                        
                        <!-- Shield Logo -->
                        <img src="{{ asset('images/first_logo-removebg-preview.png') }}" alt="Minglanilla Shield Logo" class="w-64 h-80 object-contain drop-shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <!-- Incident Reporting Form Section -->
        <section id="report-incident" class="py-16 md:py-24 bg-orange-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-900 mb-4">Urgent Incident Reporting</h2>
                <p class="text-center text-gray-700 mb-12">Submit real-time reports directly to MTCOM. Your data helps dispatch traffic officers and notify commuters within minutes.</p>

                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-8 border-red-600">
                    <form class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Reporter Name -->
                            <div>
                                <label class="block text-blue-900 font-semibold text-sm mb-2">Reporter Name</label>
                                <input type="text" placeholder="Full name" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                            </div>

                            <!-- Contact Number -->
                            <div>
                                <label class="block text-blue-900 font-semibold text-sm mb-2">Contact Number</label>
                                <input type="tel" placeholder="0921 225 1234" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Incident Type -->
                            <div>
                                <label class="block text-blue-900 font-semibold text-sm mb-2">Incident Type</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 bg-white" required>
                                    <option>Select incident type</option>
                                    <option>Traffic Accident</option>
                                    <option>Road Obstruction</option>
                                    <option>Traffic Light Issue</option>
                                    <option>Hazardous Condition</option>
                                </select>
                            </div>

                            <!-- Location/Barangay -->
                            <div>
                                <label class="block text-blue-900 font-semibold text-sm mb-2">Location / Barangay</label>
                                <input type="text" placeholder="Location details" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Brief Description -->
                            <div>
                                <label class="block text-blue-900 font-semibold text-sm mb-2">Brief Description</label>
                                <textarea placeholder="Provide more details about the incident or issue with vehicles involved, location of incident, etc." rows="4" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500 resize-none"></textarea>
                            </div>

                            <!-- Upload Image -->
                            <div>
                                <label class="block text-blue-900 font-semibold text-sm mb-2">Upload Image</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 cursor-pointer transition">
                                    <input type="file" accept="image/*" class="hidden" id="image-upload">
                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <p class="text-gray-600 text-sm">Click to upload image</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6">
                            <p class="text-sm text-gray-700">By submitting you confirm that the information provided is accurate. Providing false reports is punishable by law under municipal ordinances.</p>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg transition">
                                Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Core Features Section -->
        <section class="py-16 md:py-24 bg-white" id="core-features">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-900 mb-12">Core Features</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-blue-50 rounded-lg p-8 text-center" id="feature-1">
                        <div class="w-16 h-16 bg-blue-700 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-blue-900 mb-2">Real-Time Monitoring</h3>
                        <p class="text-gray-700">Monitor traffic conditions across Minglanilla with live updates and instant incident notifications.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-yellow-50 rounded-lg p-8 text-center" id="feature-2">
                        <div class="w-16 h-16 bg-yellow-500 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-blue-900 mb-2">Traffic Analytics</h3>
                        <p class="text-gray-700">Get detailed insights and reports on traffic patterns to improve future planning and response.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-red-50 rounded-lg p-8 text-center" id="feature-3">
                        <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-blue-900 mb-2">Instant Alerts</h3>
                        <p class="text-gray-700">Receive immediate notifications about road hazards, accidents, and traffic congestion alerts.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics/Impact Section -->
       <section class="py-16 md:py-24 bg-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-900 mb-12">
            Our Impact
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <div id="impact-reports" class="impact-card text-center">
                <div class="text-4xl font-bold text-red-600 mb-2">2,500+</div>
                <p class="text-gray-700">Reports Submitted</p>
            </div>

            <div id="impact-response" class="impact-card text-center">
                <div class="text-4xl font-bold text-blue-700 mb-2">45%</div>
                <p class="text-gray-700">Faster Response Time</p>
            </div>

            <div id="impact-satisfaction" class="impact-card text-center">
                <div class="text-4xl font-bold text-yellow-500 mb-2">98%</div>
                <p class="text-gray-700">User Satisfaction</p>
            </div>

            <div id="impact-availability" class="impact-card text-center">
                <div class="text-4xl font-bold text-green-600 mb-2">24/7</div>
                <p class="text-gray-700">System Available</p>
            </div>

        </div>
    </div>
</section>

        <!-- CTA Section -->
        <section class="py-16 md:py-20 bg-blue-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl md:text-4xl font-bold mb-8">Building a Safer, Faster Minglanilla Together</h2>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-3 px-8 rounded-lg transition">Join as Citizen</a>
                            <a href="{{ route('login') }}" class="bg-white hover:bg-gray-100 text-blue-900 font-bold py-3 px-8 rounded-lg transition">Officer Access</a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-300 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm">© 2026 Minglanilla Traffic Management and Simulation System. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>