<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Advisories — Minglanilla</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-50 min-h-screen">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-8 px-6 shadow">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold tracking-tight">Minglanilla Traffic Advisories</h1>
            <p class="text-blue-100 text-sm mt-1">Official traffic updates from the Municipality of Minglanilla</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-6 py-10">

        @if($advisories->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-10 text-center">
                <p class="text-slate-500">No active traffic advisories at this time.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($advisories as $advisory)
                    <a href="{{ route('advisories.show', $advisory) }}"
                        class="block bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:border-blue-400 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-800">{{ $advisory->title }}</h2>
                                <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ $advisory->description }}</p>
                                <p class="text-slate-400 text-xs mt-3">
                                    {{ \Carbon\Carbon::parse($advisory->start_date)->format('M d, Y') }}
                                    @if($advisory->end_date)
                                        — {{ \Carbon\Carbon::parse($advisory->end_date)->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                            <span class="shrink-0 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                Published
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>

</body>

</html>