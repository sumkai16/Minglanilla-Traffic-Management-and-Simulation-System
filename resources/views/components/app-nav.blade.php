@props([
    'title' => 'Dashboard',
    'pageTitle' => null,
    'pageEyebrow' => null,
    'pageDescription' => null,
])

@php
    use App\Support\RoleNavigation;

    $pageTitle = $pageTitle ?? $title;
    $navItems = RoleNavigation::items();
    $roleLabel = RoleNavigation::roleLabel();
    $eyebrow = $pageEyebrow ?? 'Minglanilla Traffic Command';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-900"
    style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

<div x-data="{ sidebarOpen: false, sidebarCollapsed: false }" @keydown.window.escape="sidebarOpen = true"
    class="min-h-screen bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.08),transparent_24%),radial-gradient(circle_at_bottom_right,rgba(14,165,233,0.08),transparent_20%),linear-gradient(to_bottom,#f8fafc,#eef2ff)]">

    <div x-cloak x-show="sidebarOpen" x-transition.opacity
        class="fixed inset-0 z-30 bg-slate-950/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

    <x-dashboard-sidebar :nav-items="$navItems" :role-label="$roleLabel"
        class="fixed inset-y-0 left-0 z-40 flex flex-col border-r border-white/10 bg-slate-950 text-slate-100 shadow-2xl shadow-slate-950/40 transition-all duration-300 ease-out w-72 max-w-[min(18rem,100vw)]"
        x-bind:class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            sidebarCollapsed ? 'lg:w-20 lg:max-w-none' : '',
        ]" />

    <div class="min-h-screen transition-[padding] duration-300 ease-out"
        x-bind:class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-72'">

        <header class="px-4 pt-4 sm:px-6 sm:pt-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-[2rem] border border-blue-200/40 bg-[linear-gradient(135deg,rgba(30,64,175,0.96),rgba(29,78,216,0.9)_42%,rgba(15,23,42,0.96))] shadow-xl shadow-blue-900/15">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,255,255,0.18),transparent_28%),radial-gradient(circle_at_bottom_right,rgba(56,189,248,0.18),transparent_24%)]">
                </div>
                <div class="absolute -left-16 top-0 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -right-10 bottom-0 h-36 w-36 rounded-full bg-cyan-300/20 blur-3xl"></div>

                <div class="relative px-5 py-5 sm:px-6 lg:px-8 lg:py-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-start gap-3">
                            <button type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/20 bg-white/10 text-white shadow-sm transition hover:bg-white/15 lg:hidden"
                                @click="sidebarOpen = true" aria-label="Open menu">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.75 7.75h14.5M4.75 12h14.5m-14.5 4.25h14.5" />
                                </svg>
                            </button>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-blue-100/80">
                                    {{ $eyebrow }}</p>
                                <h1 class="mt-1 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                                    {{ $pageTitle }}</h1>
                                @if ($pageDescription)
                                    <p class="mt-2 max-w-3xl text-sm leading-6 text-blue-50/85">{{ $pageDescription }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            @isset($actions)
                                {{ $actions }}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{ $slot }}
    </div>
</div>

    @stack('scripts')
</body>

</html>
