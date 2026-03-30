<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Detail</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
<div class="min-h-screen">
    <x-app-nav pageTitle="Report Detail" />
    <main class="py-8 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <a href="{{ route('enforcer.reports.index') }}"
               class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 mb-4">
                ← Back to Reports
            </a>

            <!-- Report Info -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-4 -mt-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">{{ $report->title ?? $report->issue_type }}</h2>
                    <span @class([
                        'text-xs font-semibold px-3 py-1 rounded-full',
                        'bg-yellow-100 text-yellow-700' => $report->status === 'assigned',
                        'bg-blue-100 text-blue-700' => $report->status === 'for_verification',
                        'bg-green-100 text-green-700' => $report->status === 'resolved',
                    ])>
                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                    </span>
                </div>
                <dl class="space-y-2 text-sm">
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Issue Type</dt>
                        <dd class="text-slate-800 font-medium">{{ $report->issue_type }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Location</dt>
                        <dd class="text-slate-800">{{ $report->location }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Description</dt>
                        <dd class="text-slate-800">{{ $report->description }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-500 w-32">Assigned</dt>
                        <dd class="text-slate-800">{{ $report->assigned_at ? \Carbon\Carbon::parse($report->assigned_at)->format('M d, Y h:i A') : '—' }}</dd>
                    </div>
                </dl>

                @if($report->image_path)
                    <div class="mt-4">
                        <p class="text-xs text-slate-500 mb-2">Incident Photo</p>
                        <img src="{{ Storage::url($report->image_path) }}" class="rounded-xl max-h-64 object-cover">
                    </div>
                @endif
            </div>

            <!-- Action Section -->
            @if($report->status === 'assigned')
                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-800 mb-1">Submit Proof of Resolution</h3>
                    <p class="text-sm text-slate-500 mb-4">Upload a photo proving the issue has been resolved. Head MITCOM will verify it.</p>
                    <form action="{{ route('enforcer.reports.proof', $report) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Proof Photo <span class="text-red-500">*</span></label>
                            <input type="file" name="proof_image" accept="image/*"
                                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('proof_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition">
                            Submit for Verification
                        </button>
                    </form>
                </div>

            @elseif($report->status === 'for_verification')
                <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6 text-center">
                    <p class="text-blue-700 font-semibold">Proof Submitted</p>
                    <p class="text-blue-600 text-sm mt-1">Awaiting Head MITCOM verification.</p>
                    @if($report->proof_image)
                        <img src="{{ Storage::url($report->proof_image) }}" class="rounded-xl max-h-48 object-cover mx-auto mt-4">
                    @endif
                </div>

            @elseif($report->status === 'resolved')
                <div class="bg-green-50 rounded-2xl border border-green-200 p-6 text-center">
                    <p class="text-green-700 font-semibold">✓ Report Resolved</p>
                    <p class="text-green-600 text-sm mt-1">Verified by Head MITCOM on {{ \Carbon\Carbon::parse($report->resolved_at)->format('M d, Y') }}.</p>
                    @if($report->proof_image)
                        <img src="{{ Storage::url($report->proof_image) }}" class="rounded-xl max-h-48 object-cover mx-auto mt-4">
                    @endif
                </div>
            @endif

        </div>
    </main>
</div>
<x-toast />
</body>
</html>