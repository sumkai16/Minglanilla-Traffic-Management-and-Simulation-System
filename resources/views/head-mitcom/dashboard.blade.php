<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head MITCOM Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <x-app-nav pageTitle="Head MITCOM Dashboard" />

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Welcome Card -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6 mb-6 -mt-4 relative z-10">
                    <h2 class="text-lg font-semibold text-slate-900">Welcome, {{ auth()->user()->first_name }}!</h2>
                    <p class="text-slate-600 text-sm mt-1">coming soon...</p>
                </div>

                <!-- Content goes here -->
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                    <p class="text-slate-700">coming soon...</p>
                </div>

            </div>
        </main>
    </div>
</body>

</html>