<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<x-app-nav pageTitle="View Report" />

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Report Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Report Details</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Issue Type</label>
                            <p class="mt-1 text-lg text-gray-900">
                                {{ ucwords(str_replace('_', ' ', $report->issue_type)) }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Description</label>
                            <p class="mt-1 text-gray-900">{{ $report->description }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Location</label>
                            <p class="mt-1 text-gray-900">{{ $report->location }}</p>
                            <p class="mt-1 text-sm text-gray-500">
                                Coordinates: {{ $report->latitude }}, {{ $report->longitude }}
                            </p>
                        </div>

                        @if($report->image_path)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Photo Evidence</label>
                                <img src="{{ Storage::url($report->image_path) }}" alt="Report evidence"
                                    class="rounded-lg shadow-md max-w-md">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Location on Map</h2>
                    <div id="report-map" class="w-full h-[400px] rounded-lg border-2 border-gray-200"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Status</h2>

                    <div class="mb-4">
                        <span class="px-3 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                @if($report->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($report->status === 'verified') bg-blue-100 text-blue-800
                                @elseif($report->status === 'assigned') bg-purple-100 text-purple-800
                                @elseif($report->status === 'resolved') bg-green-100 text-green-800
                                @elseif($report->status === 'rejected') bg-red-100 text-red-800
                                @endif">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('admin.reports.updateStatus', $report) }}">
                        @csrf
                        @method('PATCH')

                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Change
                            Status</label>
                        <select name="status" id="status"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-4">
                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="verified" {{ $report->status === 'verified' ? 'selected' : '' }}>Verified
                            </option>
                            <option value="assigned" {{ $report->status === 'assigned' ? 'selected' : '' }}>Assigned
                            </option>
                            <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved
                            </option>
                            <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>

                        <button type="submit"
                            class="w-full bg-blue-900 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Reporter Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Reporter Information</h2>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Name</label>
                            <p class="mt-1 text-gray-900">
                                @if($report->user)
                                    {{ $report->user->first_name }} {{ $report->user->last_name }}
                                @else
                                    {{ $report->reporter_name ?? 'Guest' }}
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-gray-900">
                                @if($report->user)
                                    {{ $report->user->email }}
                                @else
                                    {{ $report->reporter_email ?? 'N/A' }}
                                @endif
                            </p>
                        </div>

                        @if($report->reporter_phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone</label>
                                <p class="mt-1 text-gray-900">{{ $report->reporter_phone }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Submitted</label>
                            <p class="mt-1 text-gray-900">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                            <p class="text-sm text-gray-500">{{ $report->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @if($report->verified_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="mt-1 text-gray-900">{{ $report->verified_at->format('M d, Y h:i A') }}</p>
                        <p class="text-sm text-gray-500">{{ $report->verified_at->diffForHumans() }}</p>
                    </div>
                @endif
                @if($report->verified_by)
                    <!-- Verification Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Verification Info</h2>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Verified By</label>
                                <p class="mt-1 text-gray-900">{{ $report->verifier->first_name }}
                                    {{ $report->verifier->last_name }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Verified At</label>
                                <p class="mt-1 text-gray-900">{{ $report->verified_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize map centered on report location
        const map = L.map('report-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        // Add marker at report location
        L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
            .addTo(map)
            .bindPopup(`
                    <div class="p-2">
                        <h3 class="font-bold">{{ ucwords(str_replace('_', ' ', $report->issue_type)) }}</h3>
                        <p class="text-sm">{{ $report->location }}</p>
                    </div>
                `).openPopup();
    });
</script>