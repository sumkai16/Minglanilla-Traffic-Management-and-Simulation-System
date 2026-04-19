<x-app-nav title="Live Traffic Map" page-title="Live Traffic Map" page-eyebrow="System Administration">
    <main class="py-8 relative">
        <div class="absolute inset-x-0 top-0 -z-10 h-56 bg-gradient-to-b from-blue-50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="-mt-4">
                <x-incident-map 
                    mapId="admin-map" 
                    heightClass="h-[calc(100vh-280px)] min-h-[600px]" 
                />
            </div>

        </div>
    </main>
</x-app-nav>