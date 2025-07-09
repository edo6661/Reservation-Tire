{{-- resources/views/admin/reservations/create.blade.php --}}
<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <a href="{{ route('admin.reservations.index') }}" 
                       class="mr-4 text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Buat Reservasi Baru</h1>
                        <p class="mt-2 text-sm text-gray-600">Buat reservasi baru untuk pelanggan</p>
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
                <form method="POST" action="{{ route('admin.reservations.store') }}">
                    @csrf
                    
                    <!-- Service Selection -->
                    <div class="mb-6">
                        <label for="service" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tools mr-2"></i>Layanan
                        </label>
                        <select name="service" id="service" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih layanan...</option>
                            <option value="Installation of tires purchased at our store" {{ old('service') === 'Installation of tires purchased at our store' ? 'selected' : '' }}>
                                Installation of tires purchased at our store
                            </option>
                            <option value="Replacement and installation of tires brought in (tires shipped directly to our store)" {{ old('service') === 'Replacement and installation of tires brought in (tires shipped directly to our store)' ? 'selected' : '' }}>
                                Replacement and installation of tires brought in (tires shipped directly to our store)
                            </option>
                            <option value="Oil change" {{ old('service') === 'Oil change' ? 'selected' : '' }}>
                                Oil change
                            </option>
                            <option value="Tire storage and tire replacement at our store" {{ old('service') === 'Tire storage and tire replacement at our store' ? 'selected' : '' }}>
                                Tire storage and tire replacement at our store
                            </option>
                            <option value="Change tires by bringing your own (removal and removal of season tires, etc.)" {{ old('service') === 'Change tires by bringing your own (removal and removal of season tires, etc.)' ? 'selected' : '' }}>
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
                                   value="{{ old('date') }}"
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
                               value="{{ old('customer_contact') }}"
                               placeholder="Nomor telepon atau email pelanggan"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Customer Selection -->
                    <div class="mb-6">
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2"></i>Pelanggan (Opsional)
                        </label>
                        <select name="customer_id" id="customer_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih pelanggan...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->customer->id }}" {{ old('customer_id') == $customer->customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Pilih pelanggan yang sudah terdaftar atau biarkan kosong untuk pelanggan baru</p>
                    </div>

                    <!-- Coupon Code -->
                    <div class="mb-6">
                        <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-ticket-alt mr-2"></i>Kode Kupon (Opsional)
                        </label>
                        <input type="text" name="coupon_code" id="coupon_code" 
                               value="{{ old('coupon_code') }}"
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
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('simple_questionnaire') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.reservations.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>Buat Reservasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function reservationForm() {
            return {
                selectedDate: '',
                selectedTime: '',
                availableSlots: [],
                init() {
                    this.selectedDate = `{{ old('date', date('Y-m-d')) }}`;
                    this.checkSlots();
                },
                
                async checkSlots() {
                    if (!this.selectedDate) {
                        this.availableSlots = [];
                        return;
                    }
                    
                    try {
                        const response = await window.axios.get(`/admin/availability/slots/${this.selectedDate}`);
                        this.availableSlots = response.data.slots;
                        this.selectedTime = '';
                    } catch (error) {
                        console.error('Error fetching slots:', error);
                        this.availableSlots = [];
                    }
                }
            }
        }
    </script>
</x-layouts.app>