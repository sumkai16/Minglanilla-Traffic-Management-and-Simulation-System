<x-app-nav title="Submit Report" page-title="Submit Report" page-eyebrow="Public Reporting">
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.initReportMapPicker === 'function') {
                    initReportMapPicker();
                }
            });
        </script>
    @endpush
</x-app-nav>
