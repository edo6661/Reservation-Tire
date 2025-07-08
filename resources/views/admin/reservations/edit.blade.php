{{-- resources/views/admin/reservations/edit.blade.php --}}
<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <a href="{{ route('admin.reservations.show', $reservation->id) }}" 
                       class="mr-4 text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Reservasi</h1>
                        <p class="mt-2 text-sm text-gray-600">Edit reservasi #{{ $reservation->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-md p-6" x-data="reservationForm()">
                <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Service Selection -->
                    <div class="mb-6">
                        <label for="service" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tools mr-2"></i>Layanan
                        </label>
                        <select name="service" id="service" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih layanan...</option>
                            <option value="Installation of tires purchased at our store" {{ old('service', $reservation->service->value) === 'Installation of tires purchased at our store' ? 'selected' : '' }}>
                                Installation of tires purchased at our store
                            </option>
                            <option value="Replacement and installation of tires brought in (tires shipped directly to our store)" {{ old('service', $reservation->service->value) === 'Replacement and installation of tires brought in (tires shipped directly to our store)' ? 'selected' : '' }}>
                                Replacement and installation of tires brought in (tires shipped directly to our store)
                            </option>
                            <option value="Oil change" {{ old('service', $reservation->service->value) === 'Oil change' ? 'selected' : '' }}>
                                Oil change
                            </option>
                            <option value="Tire storage and tire replacement at our store" {{ old('service', $reservation->service->value) === 'Tire storage and tire replacement at our store' ? 'selected' : '' }}>
                                Tire storage and tire replacement at our store
                            </option>
                            <option value="Change tires by bringing your own (removal and removal of season tires, etc.)" {{ old('service', $reservation->service->value) === 'Change tires by bringing your own (removal and removal of season tires, etc.)' ? 'selected' : '' }}>
                                Change tires by bringing your own (removal and removal of season tires, etc.)
                            </option>
                        </select>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2"></i>Tanggal
                            </label>
                            <input type="date" name="date" id="date" 
                                   x-model="selectedDate"
                                   @change="checkSlots()"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('date', $reservation->datetime->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-2"></i>Waktu
                            </label>
                            <select name="time" id="time" 
                                    x-model="selectedTime"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih waktu...</option>
                                <option value="{{ $reservation->datetime->format('H:i') }}" selected>{{ $reservation->datetime->format('H:i') }}</option>
                                <template x-for="slot in availableSlots" :key="slot">
                                    <option :value="slot" x-text="slot"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden datetime field -->
                    <input type="hidden" name="datetime" :value="selectedDate + ' ' + selectedTime">

                    <!-- Customer Contact -->
                    <div class="mb-6">
                        <label for="customer_contact" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2"></i>Kontak Pelanggan
                        </label>
                        <input type="text" name="customer_contact" id="customer_contact" 
                               value="{{ old('customer_contact', $reservation->customer_contact) }}"
                               placeholder="Nomor telepon atau email pelanggan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Coupon Code -->
                    <div class="mb-6">
                        <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-ticket-alt mr-2"></i>Kode Kupon (Opsional)
                        </label>
                        <input type="text" name="coupon_code" id="coupon_code" 
                               value="{{ old('coupon_code', $reservation->coupon_code) }}"
                               placeholder="Masukkan kode kupon"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Simple Questionnaire -->
                    <div class="mb-6">
                        <label for="simple_questionnaire" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-clipboard-question mr-2"></i>Kuesioner Sederhana (Opsional)
                        </label>
                        <textarea name="simple_questionnaire" id="simple_questionnaire" rows="4" 
                                  placeholder="Informasi tambahan dari pelanggan..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('simple_questionnaire', $reservation->simple_questionnaire) }}</textarea>
                    </div>

                    <!-- Management Notes -->
                    <div class="mb-6">
                        <label for="management_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-2"></i>Catatan Manajemen (Opsional)
                        </label>
                        <textarea name="management_notes" id="management_notes" rows="4" 
                                  placeholder="Catatan internal untuk manajemen..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('management_notes', $reservation->management_notes) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag mr-2"></i>Status
                        </label>
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="application" {{ old('status', $reservation->status->value) === 'application' ? 'selected' : '' }}>
                                Menunggu Konfirmasi
                            </option>
                            <option value="confirmed" {{ old('status', $reservation->status->value) === 'confirmed' ? 'selected' : '' }}>
                                Dikonfirmasi
                            </option>
                            <option value="rejected" {{ old('status', $reservation->status->value) === 'rejected' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.reservations.show', $reservation->id) }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function reservationForm() {
            return {
                selectedDate: '{{ $reservation->datetime->format('Y-m-d') }}',
                selectedTime: '{{ $reservation->datetime->format('H:i') }}',
                availableSlots: [],
                
                async checkSlots() {
                    if (!this.selectedDate) {
                        this.availableSlots = [];
                        return;
                    }
                    
                    try {
                        const response = await window.axios.get(`/admin/availability/slots/${this.selectedDate}`);
                        this.availableSlots = response.data.slots.filter(slot => slot !== '{{ $reservation->datetime->format('H:i') }}');
                    } catch (error) {
                        console.error('Error fetching slots:', error);
                        this.availableSlots = [];
                    }
                }
            }
        }
    </script>
</x-layouts.app>