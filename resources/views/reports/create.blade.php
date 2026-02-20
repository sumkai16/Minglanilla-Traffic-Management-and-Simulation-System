<x-guest-layout>


<div id="reportCard"
     class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] 
     transition-all duration-500 ease-out p-10 border border-gray-100">

    <!-- Logo & Title -->
    <div class="flex items-center gap-4 mb-8">  
        <img src="{{ asset('images/logo-login.png') }}" 
             alt="Logo" 
             class="w-14 h-14 rounded-lg object-contain">

        <div>
            <p class="text-xl font-black text-blue-900 tracking-wide">
                Lihok Padulong
            </p>
            <p class="text-sm font-extrabold text-red-600 -mt-1 tracking-wide">
                MITCOM MINGLANILLA
            </p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="py-16 bg-orange-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded">
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden border-t-8 border-red-600">
                <x-report-form />

            </div>
        </div>

    </form>

</div>

<!-- Animations + Submit Behavior -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const card = document.getElementById('reportCard');

    // Fade in effect
    card.classList.add('opacity-0', 'translate-y-4');

    setTimeout(() => {
        card.classList.remove('opacity-0', 'translate-y-4');
        card.classList.add('opacity-100', 'translate-y-0');
    }, 100);

    // Submit loading state
    const form = document.getElementById('reportForm');
    const button = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function () {
        button.disabled = true;
        btnText.classList.add('invisible');
        spinner.classList.remove('hidden');
    });
});
</script>

</x-guest-layout>