<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Reservasi</h1>
                        <p class="mt-2 text-sm text-gray-600">Ubah detail reservasi Anda</p>
                    </div>
                    <a href="{{ route('customer.reservations.show', $reservation->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Terjadi kesalahan:</p>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('customer.reservations.update', $reservation->id) }}" method="POST" 
                      x-data="reservationForm()" x-init="init()">
                    @csrf
                    @method('PUT')

                    <div class="px-4 py-5 sm:px-6 bg-blue-50 border-b border-blue-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Informasi Reservasi
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            ID Reservasi: #{{ $reservation->id }}
                        </p>
                    </div>

                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="service" class="block text-sm font-medium text-gray-700">
                                    Layanan <span class="text-red-500">*</span>
                                </label>
                                <select name="service" id="service" required
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Pilih layanan...</option>
                                    @foreach(App\Enums\ServiceType::cases() as $serviceType)
                                        <option value="{{ $serviceType->value }}" 
                                                {{ old('service', $reservation->service->value) === $serviceType->value ? 'selected' : '' }}>
                                            {{ $serviceType->value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">
                                        Tanggal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="date" id="date" required
                                           value="{{ old('date', $reservation->datetime->format('Y-m-d')) }}"
                                           x-model="selectedDate" 
                                           x-on:change="fetchAvailableSlots()"
                                           min="{{ date('Y-m-d') }}"
                                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="time" class="block text-sm font-medium text-gray-700">
                                        Waktu <span class="text-red-500">*</span>
                                    </label>
                                    <select name="time" id="time" required
                                            x-model="selectedTime"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">Pilih waktu...</option>
                                        <template x-for="slot in availableSlots" :key="slot">
                                            <option :value="slot" x-text="slot"></option>
                                        </template>
                                    </select>
                                    <div x-show="loading" class="mt-2 text-sm text-gray-500">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Memuat waktu yang tersedia...
                                    </div>
                                    @error('time')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="customer_contact" class="block text-sm font-medium text-gray-700">
                                    Kontak Customer <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_contact" id="customer_contact" required
                                       value="{{ old('customer_contact', $reservation->customer_contact) }}"
                                       placeholder="Nomor telepon atau email"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('customer_contact')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="coupon_code" class="block text-sm font-medium text-gray-700">
                                    Kode Kupon (Opsional)
                                </label>
                                <input type="text" name="coupon_code" id="coupon_code"
                                       value="{{ old('coupon_code', $reservation->coupon_code) }}"
                                       placeholder="Masukkan kode kupon jika ada"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('coupon_code')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="simple_questionnaire" class="block text-sm font-medium text-gray-700">
                                    Kuesioner Sederhana (Opsional)
                                </label>
                                <textarea name="simple_questionnaire" id="simple_questionnaire" rows="4"
                                          placeholder="Ceritakan detail tentang kendaraan Anda atau layanan yang dibutuhkan..."
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('simple_questionnaire', $reservation->simple_questionnaire) }}</textarea>
                                @error('simple_questionnaire')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <input type="hidden" name="datetime" x-model="datetimeValue">
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-gray-500">
                                    <span class="text-red-500">*</span> Wajib diisi
                                </p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('customer.reservations.show', $reservation->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function reservationForm() {
            return {
                selectedDate: '{{ old('date', $reservation->datetime->format('Y-m-d')) }}',
                selectedTime: '{{ old('time', $reservation->datetime->format('H:i')) }}',
                availableSlots: [],
                loading: false,
                datetimeValue: '{{ old('datetime', $reservation->datetime->format('Y-m-d H:i:s')) }}',

                init() {
                    this.fetchAvailableSlots();
                    this.$watch('selectedDate', () => this.updateDatetime());
                    this.$watch('selectedTime', () => this.updateDatetime());
                },

                updateDatetime() {
                    if (this.selectedDate && this.selectedTime) {
                        this.datetimeValue = this.selectedDate + ' ' + this.selectedTime + ':00';
                    }
                },

                async fetchAvailableSlots() {
                    if (!this.selectedDate) return;
                    
                    this.loading = true;
                    try {
                        const response = await axios.get(`/customer/availability/slots/${this.selectedDate}`);
                        this.availableSlots = response.data.slots;
                        
                        
                        if (this.selectedTime && !this.availableSlots.includes(this.selectedTime)) {
                            this.availableSlots.push(this.selectedTime);
                        }
                    } catch (error) {
                        console.error('Error fetching available slots:', error);
                        this.availableSlots = [];
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-layouts.app>