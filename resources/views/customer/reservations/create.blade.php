<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('customer.reservations.index') }}" 
                       class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Buat Reservasi</h1>
                        <p class="text-gray-600 mt-1">Isi form untuk membuat reservasi layanan</p>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white shadow-sm rounded-lg p-6"
                 x-data="reservationForm()">
                <form method="POST" action="{{ route('customer.reservations.store') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Service Selection -->
                        <div>
                            <label for="service" class="block text-sm font-medium text-gray-700 mb-2">
                                Layanan <span class="text-red-500">*</span>
                            </label>
                            <select id="service" name="service" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Pilih layanan...</option>
                                @foreach(App\Enums\ServiceType::cases() as $service)
                                    <option value="{{ $service->value }}" 
                                            {{ old('service') == $service->value ? 'selected' : '' }}>
                                        {{ $service->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date and Time -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="date" name="date" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       value="{{ old('date') }}"
                                       min="{{ date('Y-m-d') }}"
                                       x-model="selectedDate"
                                       @change="loadAvailableSlots"
                                       required>
                            </div>
                            
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Waktu <span class="text-red-500">*</span>
                                </label>
                                <select id="time" name="time" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        x-model="selectedTime"
                                        :disabled="!selectedDate"
                                        required>
                                    <option value="">Pilih waktu...</option>
                                    <template x-for="slot in availableSlots" :key="slot">
                                        <option :value="slot" x-text="slot"></option>
                                    </template>
                                </select>
                                <p class="text-sm text-gray-500 mt-1" x-show="!selectedDate">
                                    Pilih tanggal terlebih dahulu untuk melihat slot waktu yang tersedia
                                </p>
                            </div>
                        </div>

                        <!-- Customer Contact -->
                        <div>
                            <label for="customer_contact" class="block text-sm font-medium text-gray-700 mb-2">
                                Kontak <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="customer_contact" name="customer_contact" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('customer_contact') }}"
                                   placeholder="Nomor telepon atau email"
                                   required>
                        </div>

                        <!-- Coupon Code -->
                        <div>
                            <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Kupon (Opsional)
                            </label>
                            <input type="text" id="coupon_code" name="coupon_code" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('coupon_code') }}"
                                   placeholder="Masukkan kode kupon jika ada">
                        </div>

                        <!-- Simple Questionnaire -->
                        <div>
                            <label for="simple_questionnaire" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Tambahan (Opsional)
                            </label>
                            <textarea id="simple_questionnaire" name="simple_questionnaire" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Berikan informasi tambahan tentang kendaraan atau layanan yang dibutuhkan">{{ old('simple_questionnaire') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('customer.reservations.index') }}" 
                               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200"
                                    :disabled="loading">
                                <span x-show="!loading">Buat Reservasi</span>
                                <span x-show="loading" class="flex items-center">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Memproses...
                                </span>
                            </button>
                        </div>
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
                loading: false,

                async loadAvailableSlots() {
                    if (!this.selectedDate) {
                        this.availableSlots = [];
                        return;
                    }

                    this.loading = true;
                    this.selectedTime = '';
                    
                    try {
                        const response = await axios.get(`/customer/availability/slots/${this.selectedDate}`);
                        this.availableSlots = response.data.slots;
                    } catch (error) {
                        console.error('Error loading available slots:', error);
                        this.availableSlots = [];
                    } finally {
                        this.loading = false;
                    }
                },

                init() {
                    
                    this.$watch('selectedDate', () => {
                        this.updateDatetime();
                    });
                    
                    this.$watch('selectedTime', () => {
                        this.updateDatetime();
                    });
                },

                updateDatetime() {
                    if (this.selectedDate && this.selectedTime) {
                        const datetime = `${this.selectedDate} ${this.selectedTime}`;
                        const datetimeInput = document.createElement('input');
                        datetimeInput.type = 'hidden';
                        datetimeInput.name = 'datetime';
                        datetimeInput.value = datetime;
                        
                        
                        const existingInput = document.querySelector('input[name="datetime"]');
                        if (existingInput) {
                            existingInput.remove();
                        }
                        
                        
                        document.querySelector('form').appendChild(datetimeInput);
                    }
                }
            }
        }
    </script>
</x-layouts.app>