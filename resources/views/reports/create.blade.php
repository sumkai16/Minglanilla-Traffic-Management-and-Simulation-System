<x-guest-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Urgent Incident Reporting</h1>
            <p class="text-blue-100 text-lg">Submit real-time reports directly to MTCOM. Your data helps dispatch
                traffic officers and notify commuters within minutes.</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="py-16 bg-orange-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded">
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden border-t-8 border-red-600">
                <x-report-form />

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Only init public map if it exists (landing page)
            if (document.getElementById('public-map')) {
                initPublicMap('public-map');
            }

            // Initialize map picker for report form
            if (document.getElementById('map-picker')) {
                initReportMapPicker();
            }
        });
    </script>
</x-guest-layout>