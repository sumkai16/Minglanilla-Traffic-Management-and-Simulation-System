<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

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
                        <img src="{{ asset('images/first_logo-removebg-preview.png') }}" alt="Minglanilla Shield Logo"
                            class="h-20 w-20 object-contain">
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold tracking-wide text-blue-100">LIHOK PADULONG</p>
                    <p class="text-xs uppercase tracking-widest text-red-200">Minglanilla Traffic Command</p>
                    <h1 class="text-3xl font-semibold text-white">Report Management</h1>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/30 text-white text-sm hover:bg-white/10 transition">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M11.78 4.22a.75.75 0 010 1.06L7.56 9.5H16a.75.75 0 010 1.5H7.56l4.22 4.22a.75.75 0 11-1.06 1.06l-5.5-5.5a.75.75 0 010-1.06l5.5-5.5a.75.75 0 011.06 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Dashboard
                </a>
                <div class="flex items-center gap-3 rounded-full bg-white/10 border border-white/15 px-4 py-2">
                    <span class="text-white text-sm whitespace-nowrap">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-500/90 text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-red-500 transition">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.5 3.25A2.25 2.25 0 005.25 5.5v9A2.25 2.25 0 007.5 16.75h3a.75.75 0 000-1.5h-3a.75.75 0 01-.75-.75v-9a.75.75 0 01.75-.75h3a.75.75 0 000-1.5h-3z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M11.72 6.22a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9.5a.75.75 0 010-1.5h3.94l-1.72-1.72a.75.75 0 010-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

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