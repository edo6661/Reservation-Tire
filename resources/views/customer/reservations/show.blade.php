<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Reservasi</h1>
                        <p class="mt-2 text-sm text-gray-600">Informasi lengkap reservasi Anda</p>
                    </div>
                    <a href="{{ route('customer.reservations.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                @foreach($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reservation Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Status Banner -->
                <div class="px-4 py-5 sm:px-6 {{ $reservation->status->value === 'confirmed' ? 'bg-green-50' : ($reservation->status->value === 'rejected' ? 'bg-red-50' : 'bg-yellow-50') }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Status Reservasi
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                ID Reservasi: #{{ $reservation->id }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $reservation->status->value === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($reservation->status->value === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                <i class="fas fa-circle mr-2 text-xs"></i>
                                {{ ucfirst($reservation->status->value) }}
                            </span>
                            @if($reservation->canBeCancelled())
                                <form action="{{ route('customer.reservations.cancel', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')"
                                            class="inline-flex items-center px-3 py-1 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100">
                                        <i class="fas fa-times mr-1"></i>
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Layanan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $reservation->service->value }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                    {{ $reservation->datetime->format('d F Y') }}
                                </div>
                                <div class="flex items-center mt-1">
                                    <i class="fas fa-clock mr-2 text-blue-500"></i>
                                    {{ $reservation->datetime->format('H:i') }} WIB
                                </div>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Kontak Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $reservation->customer_contact }}
                            </dd>
                        </div>
                        @if($reservation->coupon_code)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Kode Kupon</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $reservation->coupon_code }}
                                    </span>
                                </dd>
                            </div>
                        @endif
                        @if($reservation->simple_questionnaire)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Kuesioner Sederhana</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="whitespace-pre-wrap">{{ $reservation->simple_questionnaire }}</div>
                                </dd>
                            </div>
                        @endif
                        @if($reservation->management_notes)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Catatan Manajemen</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                        <div class="whitespace-pre-wrap">{{ $reservation->management_notes }}</div>
                                    </div>
                                </dd>
                            </div>
                        @endif
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $reservation->created_at->format('d F Y H:i') }} WIB
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <div class="flex justify-between">
                        <div>
                            @if($reservation->status->value === 'application')
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-hourglass-half mr-2"></i>
                                    Menunggu Konfirmasi
                                </span>
                            @elseif($reservation->status->value === 'confirmed')
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Reservasi Dikonfirmasi
                                </span>
                            @elseif($reservation->status->value === 'rejected')
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Reservasi Ditolak
                                </span>
                            @endif
                        </div>
                        <div class="flex space-x-3">
                            @if($reservation->status->value === 'application')
                                <a href="{{ route('customer.reservations.edit', $reservation->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Reservasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>