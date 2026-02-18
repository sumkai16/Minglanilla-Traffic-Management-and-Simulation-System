<form method="POST" action="{{ route('report.store') }}" enctype="multipart/form-data" class="p-8">
    @csrf

    @guest
        <!-- Guest Reporter Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="reporter_name" class="block text-blue-900 font-semibold text-sm mb-2">Reporter Name <span
                        class="text-red-600">*</span></label>
                <input type="text" id="reporter_name" name="reporter_name" value="{{ old('reporter_name') }}"
                    placeholder="Full name"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('reporter_name') border-red-500 @enderror"
                    required>
                @error('reporter_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reporter_phone" class="block text-blue-900 font-semibold text-sm mb-2">Contact Number <span
                        class="text-red-600">*</span></label>
                <input type="tel" id="reporter_phone" name="reporter_phone" value="{{ old('reporter_phone') }}"
                    placeholder="0921 225 1234"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('reporter_phone') border-red-500 @enderror"
                    required>
                @error('reporter_phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="reporter_email" class="block text-blue-900 font-semibold text-sm mb-2">Email Address <span
                    class="text-red-600">*</span></label>
            <input type="email" id="reporter_email" name="reporter_email" value="{{ old('reporter_email') }}"
                placeholder="your.email@example.com"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('reporter_email') border-red-500 @enderror"
                required>
            <p class="mt-1 text-xs text-gray-600">Note: You can only submit one report as a guest. Please login to submit
                more.</p>
            @error('reporter_email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endguest

    <!-- Incident Type & Location -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="issue_type" class="block text-blue-900 font-semibold text-sm mb-2">Incident Type <span
                    class="text-red-600">*</span></label>
            <select id="issue_type" name="issue_type"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white transition @error('issue_type') border-red-500 @enderror"
                required>
                <option value="">Select incident type</option>
                <option value="traffic_signal_problem" {{ old('issue_type') == 'traffic_signal_problem' ? 'selected' : '' }}>Traffic Signal Problem</option>
                <option value="road_damage" {{ old('issue_type') == 'road_damage' ? 'selected' : '' }}>Road Damage /
                    Hazard</option>
                <option value="illegal_parking" {{ old('issue_type') == 'illegal_parking' ? 'selected' : '' }}>Illegal
                    Parking</option>
                <option value="traffic_obstruction" {{ old('issue_type') == 'traffic_obstruction' ? 'selected' : '' }}>
                    Traffic Obstruction</option>
                <option value="accident" {{ old('issue_type') == 'accident' ? 'selected' : '' }}>Accident / Incident
                </option>
                <option value="traffic_violation" {{ old('issue_type') == 'traffic_violation' ? 'selected' : '' }}>Traffic
                    Violation</option>
                <option value="reckless_driving" {{ old('issue_type') == 'reckless_driving' ? 'selected' : '' }}>Reckless
                    Driving</option>
                <option value="public_safety" {{ old('issue_type') == 'public_safety' ? 'selected' : '' }}>Public Safety
                    Concern</option>
                <option value="infrastructure" {{ old('issue_type') == 'infrastructure' ? 'selected' : '' }}>
                    Infrastructure Issue</option>
            </select>
            @error('issue_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="location" class="block text-blue-900 font-semibold text-sm mb-2">Location / Barangay <span
                    class="text-red-600">*</span></label>
            <input type="text" id="location" name="location" value="{{ old('location') }}"
                placeholder="e.g. Poblacion Ward, Main Street"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('location') border-red-500 @enderror"
                required>
            @error('location')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Description & Image Upload -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="description" class="block text-blue-900 font-semibold text-sm mb-2">Brief Description <span
                    class="text-red-600">*</span></label>
            <textarea id="description" name="description" rows="6"
                placeholder="Provide more details about the incident: vehicles involved, exact location, severity, etc."
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition @error('description') border-red-500 @enderror"
                required>{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-blue-900 font-semibold text-sm mb-2">
                Upload Image (Optional)
            </label>

            <div class="relative">
                <input type="file" id="image" name="image" accept="image/*" class="hidden">

                <label for="image"
                    class="flex flex-col items-center justify-center w-full h-[184px] border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition text-center"
                    id="uploadLabel">

                    <div id="uploadPlaceholder">
                        <svg class="w-10 h-10 text-gray-400 mb-2 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <p class="text-gray-600 text-sm font-medium">Click to upload image</p>
                        <p class="text-gray-500 text-xs mt-1">PNG, JPG up to 5MB</p>
                    </div>

                    <img id="imagePreview" class="hidden max-h-[160px] rounded-lg shadow-md object-contain" />
                </label>
            </div>

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Coordinates (hidden for now) -->
    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', '10.2833') }}">
    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', '123.7972') }}">

    <!-- Disclaimer -->
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            <p class="text-sm text-gray-700">By submitting you confirm that the information provided is accurate.
                Providing false reports is punishable by law under municipal ordinances.</p>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex items-center justify-center gap-4">
        <a href="{{ url('/') }}" class="px-6 py-3 text-gray-700 font-semibold hover:text-gray-900 transition">
            Cancel
        </a>
        <button type="submit"
            class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 px-10 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
            Submit Report
        </button>
    </div>
</form>