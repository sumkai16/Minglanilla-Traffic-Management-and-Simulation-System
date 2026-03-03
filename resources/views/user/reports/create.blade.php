<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen">

        <x-app-nav pageTitle="Submit Report" />

        <main class="py-8 relative">
            <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden -mt-4 relative z-10">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-xl font-bold text-slate-900">Report Traffic Incident</h2>
                        <p class="text-sm text-slate-500 mt-1">Provide details about the incident you witnessed</p>
                    </div>

                    <x-report-form action="{{ route('user.reports.store') }}" />
                </div>

            </div>
        </main>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the map picker for the report form
        if (typeof window.initReportMapPicker === 'function') {
            initReportMapPicker();
        }
    });
</script>

</html>