<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title !== '' ? $title . ' - ' : '' }}{{ config('app.name', 'Traffic Management') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-100">
    <div class="min-h-screen px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-6xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
