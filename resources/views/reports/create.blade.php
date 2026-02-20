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

    <!-- Page Heading -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-blue-900 tracking-wide">
            Submit an Incident Report
        </h2>
        <p class="text-sm text-gray-600 mt-2">
            Provide accurate details to help traffic officers respond quickly.
        </p>
    </div>

    <!-- Form -->
    <form method="POST"
          action="{{ route('report.store') }}"
          enctype="multipart/form-data"
          class="space-y-5"
          id="reportForm">
        @csrf

        @guest
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text"
                   name="reporter_name"
                   placeholder="Reporter Name"
                   value="{{ old('reporter_name') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
                   focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
                   transition-all duration-200 ease-in-out"
                   required>

            <input type="tel"
                   name="reporter_phone"
                   placeholder="Contact Number"
                   value="{{ old('reporter_phone') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
                   focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
                   transition-all duration-200 ease-in-out"
                   required>
        </div>

        <input type="email"
               name="reporter_email"
               placeholder="Email Address"
               value="{{ old('reporter_email') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
               focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
               transition-all duration-200 ease-in-out"
               required>
        @endguest

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <select name="issue_type"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
                    focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
                    transition-all duration-200 ease-in-out"
                    required>
                <option value="">Select Incident Type</option>
                <option value="traffic_signal_problem">Traffic Signal Problem</option>
                <option value="road_damage">Road Damage / Hazard</option>
                <option value="illegal_parking">Illegal Parking</option>
                <option value="traffic_obstruction">Traffic Obstruction</option>
                <option value="accident">Accident / Incident</option>
                <option value="traffic_violation">Traffic Violation</option>
                <option value="reckless_driving">Reckless Driving</option>
                <option value="public_safety">Public Safety Concern</option>
                <option value="infrastructure">Infrastructure Issue</option>
            </select>

            <input type="text"
                   name="location"
                   placeholder="Location / Barangay"
                   value="{{ old('location') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
                   focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
                   transition-all duration-200 ease-in-out"
                   required>
        </div>

        <textarea name="description"
                  rows="4"
                  placeholder="Brief Description"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
                  focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
                  transition-all duration-200 ease-in-out"
                  required>{{ old('description') }}</textarea>

        <!-- Image Upload -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-blue-900">
                Add Image <span class="text-gray-500 font-normal">(Optional)</span>
            </label>

            <input type="file"
                   name="image"
                   accept="image/*"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 
                   focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-700 
                   transition-all duration-200 ease-in-out">

            <p class="text-xs text-gray-500">
                Upload a photo to provide additional evidence. Supported formats: JPG, PNG.
            </p>
        </div>

        <!-- Submit + Cancel -->
        <div class="flex flex-col items-center pt-6 space-y-4">

            <button id="submitBtn"
                type="submit"
                class="relative w-full md:w-1/2 bg-blue-900 hover:bg-blue-800 
                active:scale-95 hover:scale-105 transform transition-all duration-200 
                ease-in-out text-white px-10 py-3 rounded-xl font-semibold 
                shadow-lg hover:shadow-2xl disabled:opacity-70 disabled:cursor-not-allowed">

                <span id="btnText">Submit Report</span>

                <!-- Spinner -->
                <span id="spinner" class="hidden absolute inset-0 flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75"
                              fill="currentColor"
                              d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </span>
            </button>

            <a href="{{ url('/') }}"
               class="text-blue-900 font-semibold text-sm hover:underline transition">
                Cancel
            </a>

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