<x-app-nav title="Report Incident - MITCOM Head" page-title="Report Incident" page-eyebrow="On-Behalf Reporting">
    <main class="max-w-4xl mx-auto px-4 lg:px-8 py-12">
        <div class="mb-8 overflow-hidden rounded-[2.5rem] border border-blue-200/50 bg-white shadow-[0_20px_50px_rgba(12,38,88,0.08)]">
            <div class="relative bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 px-8 py-10 text-white overflow-hidden">
                {{-- Decorative elements --}}
                <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute -left-10 bottom-0 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl"></div>
                
                <div class="relative flex items-center gap-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 shadow-inner">
                        <svg class="h-8 w-8 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">File Official Report</h2>
                        <p class="mt-2 text-blue-100/80 text-sm max-w-xl leading-relaxed">
                            Log incidents reported by citizens via phone or walk-in. Reports filed here are automatically 
                            <span class="font-bold text-white">Verified</span> and ready for enforcement assignment.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <x-report-f-orm 
                    :action="route('head-mitcom.reports.store')" 
                    :showReporterFields="true"
                />
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
