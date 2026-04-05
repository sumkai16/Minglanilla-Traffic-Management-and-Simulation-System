@props([
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard',
    'pageEyebrow' => 'Operations',
    'pageDescription' => null,
])

<x-app-nav :title="$title" :page-title="$pageTitle" :page-eyebrow="$pageEyebrow" :page-description="$pageDescription">
    @isset($actions)
        <x-slot:actions>{{ $actions }}</x-slot:actions>
    @endisset

    <main class="px-4 py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    @isset($scripts)
        @push('scripts')
            {{ $scripts }}
        @endpush
    @endisset
</x-app-nav>
