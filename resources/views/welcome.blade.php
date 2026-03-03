<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<<<<<<< HEAD
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
=======

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Minglanilla Traffic System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="w-full bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-700 rounded flex items-center justify-center text-white font-bold">
                    LP
                </div>
                <div>
                    <div class="font-bold text-blue-700">LIHOK PADULONG</div>
                    <div class="text-xs text-red-600 font-semibold">MINGLANILLA TRAFFIC COMMAND</div>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8">
                <a href="#" class="hover:text-blue-700 font-medium">Home</a>
                <a href="#core-features" class="hover:text-blue-700 font-medium">Features</a>
                <a href="#impact" class="hover:text-blue-700 font-medium">Impact</a>
            </nav>

            @auth
                <a href="{{ url('/dashboard') }}"
                    class="bg-blue-700 text-white px-4 py-2 rounded font-semibold hover:bg-blue-800 transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="bg-blue-700 text-white px-4 py-2 rounded font-semibold hover:bg-blue-800 transition">
                    Login
                </a>
            @endauth
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative py-24 bg-gradient-to-r from-blue-800 to-blue-900 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                        Smart Traffic Management for
                        <span class="text-yellow-400">Minglanilla</span>
                    </h1>

                    <p class="text-lg text-blue-100 mb-8">
                        Digitally report incidents, monitor traffic conditions, and improve response
                        through real-time reporting and analytics.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <button id="openReportBtn"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition">
                            Report an Incident
                        </button>
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-white text-blue-900 font-bold py-3 px-8 rounded-lg shadow-lg transition hover:bg-gray-100">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="bg-white text-blue-900 font-bold py-3 px-8 rounded-lg shadow-lg transition hover:bg-gray-100">
                                Join as Citizen
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-center gap-6">
                    <img src="{{ asset('images/second_logo-removebg-preview.png') }}"
                        class="w-56 object-contain drop-shadow-xl">
                    <img src="{{ asset('images/first_logo-removebg-preview.png') }}"
                        class="w-56 object-contain drop-shadow-xl">
                </div>

            </div>
        </div>
    </section>
    <!-- Traffic Map Section -->
    <section class="py-16 bg-gray-50 z-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Live Incident Map</h2>
                <p class="text-gray-600">View recent traffic incidents and reports across Minglanilla</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div id="public-map" class="w-full h-[500px]"></div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initPublicMap('public-map');
        });
    </script>
    <!-- CORE FEATURES -->
    <section id="core-features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-900 mb-12">
                Core Features
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 text-center">
                    <div
                        class="w-16 h-16 bg-blue-700 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        🚦
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-2">Real-Time Monitoring</h3>
                    <p class="text-gray-700">
                        Monitor traffic conditions across Minglanilla with live updates.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 text-center">
                    <div
                        class="w-16 h-16 bg-yellow-500 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        📊
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-2">Traffic Analytics</h3>
                    <p class="text-gray-700">
                        Gain data-driven insights to improve traffic planning and response.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-8 text-center">
                    <div
                        class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        🔔
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-2">Instant Alerts</h3>
                    <p class="text-gray-700">
                        Receive alerts about road hazards, congestion, and incidents.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- IMPACT SECTION -->
    <section id="impact" class="py-20 bg-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-12">
                Our Impact
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <div>
                    <div class="text-4xl font-bold text-red-600 mb-2">2,500+</div>
                    <p class="text-gray-700">Reports Submitted</p>
                </div>

                <div>
                    <div class="text-4xl font-bold text-blue-700 mb-2">45%</div>
                    <p class="text-gray-700">Faster Response</p>
                </div>

                <div>
                    <div class="text-4xl font-bold text-yellow-500 mb-2">98%</div>
                    <p class="text-gray-700">User Satisfaction</p>
                </div>

                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">24/7</div>
                    <p class="text-gray-700">System Availability</p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-blue-900 text-white text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-8">
            Building a Safer Minglanilla Together
        </h2>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold py-3 px-8 rounded-lg transition">
                    Join as Citizen
                </a>
                <a href="{{ route('login') }}"
                    class="bg-white hover:bg-gray-100 text-blue-900 font-bold py-3 px-8 rounded-lg transition">
                    Officer Access
                </a>
            @endauth
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 py-8 text-center sticky top-[100vh]">
        <p class="text-sm">
            © 2026 Minglanilla Traffic Management and Simulation System. All rights reserved.
        </p>
    </footer>


    <!-- REPORT MODAL -->
    <div id="reportModal"
        class="fixed inset-0 bg-black bg-opacity-50 opacity-0 invisible transition-opacity duration-300 z-50 flex items-center justify-center">

        <div id="reportModalContent" class="bg-white w-full max-w-3xl rounded-lg shadow-xl relative 
               h-[700px] overflow-y-auto
               transform scale-95 transition-all duration-300">

            <button id="closeReportBtn"
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-2xl font-bold">
                &times;
            </button>

            <div class="p-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-6">
                    Report Traffic Incident
                </h2>

                <x-report-form action="{{ route('report.store') }}" />
            </div>
        </div>
    </div>

    @if(session('success'))
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

            <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-8 text-center transform scale-95 opacity-0 transition-all duration-300"
                id="successModalContent">

                <div class="text-green-600 text-4xl mb-4">✓</div>

                <h2 class="text-xl font-bold text-gray-800 mb-2">
                    Success!
                </h2>

                <p class="text-gray-600 mb-6">
                    {{ session('success') }}
                </p>

                <button id="closeSuccessModal"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition">
                    Close
                </button>
            </div>
        </div>
    @endif
</body>

</html>