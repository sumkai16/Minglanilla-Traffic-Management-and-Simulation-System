<x-app-layout>
    <x-slot name="header">
        <div class="bg-blue-900">
            <header class="relative">
                <div class="max-w-7xl mx-auto p-5 lg:px-8">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <div
                                    class="h-17 w-17 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/second_logo-removebg-preview.png') }}"
                                        alt="Minglanilla Official Seal" class="h-20 w-20 object-contain">
                                </div>
                                <div
                                    class="-ml-3 h-17 w-17 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/first_logo-removebg-preview.png') }}"
                                        alt="Minglanilla Shield Logo" class="h-20 w-20 object-contain">
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold tracking-wide text-blue-100">LIHOK PADULONG</p>
                                <p class="text-xs uppercase tracking-widest text-red-200">Minglanilla Traffic Command
                                </p>
                                <h1 class="text-3xl font-semibold text-white">{{ $pageTitle ?? 'Dashboard' }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Welcome to your dashboard, {{ auth()->user()->first_name }}!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>