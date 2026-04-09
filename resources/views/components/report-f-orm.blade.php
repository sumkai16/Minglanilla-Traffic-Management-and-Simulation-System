@props(['action' => '', 'showReporterFields' => false])

<div x-data="{ 
    showDuplicateModal: false, 
    showCancelModal: false, 
    duplicateInfo: null, 
    confirmedDuplicate: false,
    
    async handleSubmit() {
        const form = this.$refs.reportForm;
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Only check for duplicates if we haven't already confirmed this is a desired duplicate
        if (!this.confirmedDuplicate) {
            try {
                const response = await fetch('{{ route('reports.check-duplicate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        issue_type: document.getElementById('issue_type').value,
                        latitude: document.getElementById('latitude').value,
                        longitude: document.getElementById('longitude').value
                    })
                });
                const data = await response.json();
                
                if (data.found) {
                    this.duplicateInfo = data;
                    this.showDuplicateModal = true;
                    return;
                }
            } catch (error) {
                console.error('Duplicate check failed:', error);
            }
        }

        this.submitForm();
    },

    submitForm() {
        const btn = document.getElementById('submitReportBtn');
        const text = document.getElementById('submitText');
        const loading = document.getElementById('submitLoading');
        
        if (btn && text && loading) {
            btn.disabled = true;
            text.classList.add('hidden');
            loading.classList.remove('hidden');
        }
        this.$refs.reportForm.submit();
    }
}" @keydown.escape.window="showCancelModal = false; showDuplicateModal = false">
    <form x-ref="reportForm" method="POST" action="{{ $action ?: route('report.store') }}" enctype="multipart/form-data"
        class="p-8 bg-white/90 backdrop-blur rounded-3xl border border-blue-100 shadow-[0_20px_50px_rgba(12,38,88,0.15)]">
    @csrf
    ...

    @if(!Auth::check() || $showReporterFields)
        <!-- Guest Reporter Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="reporter_name" class="block text-blue-900 font-semibold text-sm mb-2">Reporter Name <span
                        class="text-red-600">*</span></label>
                <input type="text" id="reporter_name" name="reporter_name" value="{{ old('reporter_name') }}"
                    placeholder="Full name"
                    class="w-full px-4 py-3 border border-blue-100 rounded-xl bg-slate-50/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('reporter_name') border-red-500 @enderror"
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
                    class="w-full px-4 py-3 border border-blue-100 rounded-xl bg-slate-50/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('reporter_phone') border-red-500 @enderror"
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
                class="w-full px-4 py-3 border border-blue-100 rounded-xl bg-slate-50/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('reporter_email') border-red-500 @enderror"
                required>
            <p class="mt-1 text-xs text-blue-700/70">Note: You can only submit one report as a guest. Please login to submit
                more.</p>
            @error('reporter_email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <!-- Incident Type & Location -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label for="issue_type" class="block text-blue-900 font-semibold text-sm mb-2">Incident Type <span
                    class="text-red-600">*</span></label>
            <select id="issue_type" name="issue_type"
                class="w-full px-4 py-3 border border-blue-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50/60 transition @error('issue_type') border-red-500 @enderror"
                required>
                <option value="">Select incident type</option>
                <option value="traffic_signal_problem" {{ old('issue_type') == 'traffic_signal_problem' ? 'selected' : '' }}>Traffic Signal Problem</option>
                <option value="road_damage" {{ old('issue_type') == 'road_damage' ? 'selected' : '' }}>Road Damage /
                    Hazard</option>
                <option value="traffic_obstruction" {{ old('issue_type') == 'traffic_obstruction' ? 'selected' : '' }}>
                    Traffic Obstruction</option>
                <option value="accident" {{ old('issue_type') == 'accident' ? 'selected' : '' }}>Accident / Incident
                </option>
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
                class="w-full px-4 py-3 border border-blue-100 rounded-xl bg-slate-50/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('location') border-red-500 @enderror"
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
                class="w-full px-4 py-3 border border-blue-100 rounded-xl bg-slate-50/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition @error('description') border-red-500 @enderror"
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
                    class="flex flex-col items-center justify-center w-full h-[184px] border-2 border-dashed border-blue-200 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50/70 transition text-center"
                    id="uploadLabel">

                    <div id="uploadPlaceholder">
                        <svg class="w-10 h-10 text-blue-300 mb-2 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <p class="text-blue-800 text-sm font-medium">Click to upload image</p>
                        <p class="text-blue-700/70 text-xs mt-1">PNG, JPG up to 5MB</p>
                    </div>

                    <img id="imagePreview" class="hidden max-h-[160px] rounded-lg shadow-md object-contain" />
                </label>
            </div>

            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Map Picker -->
    <div class="mb-6">
        <label class="block text-blue-900 font-semibold text-sm mb-2">Click on the Map to Mark Incident Location <span
                class="text-red-600">*</span></label>
        <div id="map-picker" class="w-full h-[400px] border border-blue-200 rounded-2xl shadow-inner"></div>
        <p class="text-xs text-blue-700/70 mt-2">Click anywhere on the map to pinpoint the exact location of the incident.
        </p>
    </div>

    <!-- Hidden coordinate inputs -->
    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', '10.2833') }}">
    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', '123.7972') }}">
    <!-- Disclaimer -->
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-6">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            <p class="text-sm text-blue-800/80">By submitting you confirm that the information provided is accurate.
                Providing false reports is punishable by law under municipal ordinances.</p>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex items-center justify-center gap-4">
        <button type="button" @click="showCancelModal = true"
            class="px-6 py-3 text-blue-700/80 font-semibold hover:text-blue-900 transition cursor-pointer">
            Cancel
        </button>
        <button type="button" id="submitReportBtn" @click="handleSubmit()"
            class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold py-3 px-10 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
            <span id="submitText">Submit Report</span>
            <span id="submitLoading" class="hidden inline-flex items-center">
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Submitting...
            </span>
        </button>

        <!-- Cancel Confirmation Modal -->
        <div x-show="showCancelModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[9999] flex items-center justify-center px-4"
            style="display: none;"
            @keydown.escape.window="showCancelModal = false">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showCancelModal = false"></div>

            <!-- Modal Content -->
            <div x-show="showCancelModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                class="relative w-full max-w-md bg-gradient-to-br from-[#0c1e3a] to-[#132d5e] rounded-2xl shadow-2xl border border-blue-500/20 overflow-hidden">

                <!-- Decorative top glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-40 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent rounded-full"></div>

                <div class="p-8 text-center">
                    <!-- Warning Icon -->
                    <div class="mx-auto w-16 h-16 rounded-full bg-amber-500/15 border border-amber-400/30 flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-white mb-2">Cancel Report?</h3>

                    <!-- Message -->
                    <p class="text-blue-200/70 text-sm leading-relaxed mb-8">
                        Are you sure you want to cancel this report? All the information you've entered will be lost and cannot be recovered.
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" @click="showCancelModal = false"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-blue-200 bg-white/5 border border-blue-400/20 hover:bg-white/10 hover:border-blue-400/40 transition-all duration-200 cursor-pointer">
                            Go Back
                        </button>
                        <a href="{{ url('/') }}"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-lg shadow-red-500/25 hover:shadow-red-500/40 transition-all duration-200 transform hover:-translate-y-0.5">
                            Yes, Cancel Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Duplicate Confirmation Modal -->
        <div x-show="showDuplicateModal" 
            class="fixed inset-0 z-[9999] flex items-center justify-center px-4"
            x-cloak
            style="display: none;">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDuplicateModal = false"></div>
            
            <!-- Modal Content -->
            <div x-show="showDuplicateModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md bg-white rounded-[2rem] shadow-2xl border border-blue-100 overflow-hidden">
                
                <div class="p-8 text-center">
                    <!-- Warning icon -->
                    <div class="mx-auto w-20 h-20 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Duplicate Incident?</h3>
                    <p class="text-slate-600 leading-relaxed mb-8">
                        There's already an existing Report Incident on this location reported <span x-text="duplicateInfo?.created_at" class="font-bold text-blue-600"></span>.
                        <br><br>
                        Are you sure you still want to report it?
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" @click="showDuplicateModal = false"
                            class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-colors">
                            No, Cancel
                        </button>
                        <button type="button" @click="confirmedDuplicate = true; submitForm()"
                            class="flex-1 px-6 py-3.5 rounded-2xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                            Yes, Report Anyway
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
