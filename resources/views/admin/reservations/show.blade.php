<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('admin.reservations.index') }}" 
                           class="mr-4 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Detail Reservasi</h1>
                            <p class="mt-2 text-sm text-gray-600">Informasi lengkap reservasi #{{ $reservation->id }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        @if($reservation->status->value === 'application')
                            <form method="POST" action="{{ route('admin.reservations.confirm', $reservation->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center"
                                        onclick="return confirm('Yakin ingin mengkonfirmasi reservasi ini?')">
                                    <i class="fas fa-check mr-2"></i>
                                    Konfirmasi
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reservations.reject', $reservation->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center"
                                        onclick="return confirm('Yakin ingin menolak reservasi ini?')">
                                    <i class="fas fa-times mr-2"></i>
                                    Tolak
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-calendar-alt mr-2"></i>Informasi Reservasi
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID Reservasi</label>
                                <p class="text-gray-900">#{{ $reservation->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                @switch($reservation->status->value)
                                    @case('application')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu Konfirmasi
                                        </span>
                                        @break
                                    @case('confirmed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Dikonfirmasi
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i>
                                            Ditolak
                                        </span>
                                        @break
                                @endswitch
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu</label>
                                <p class="text-gray-900">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $reservation->datetime->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                                <p class="text-gray-900">{{ $reservation->service->value }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kontak Pelanggan</label>
                                <p class="text-gray-900">
                                    <i class="fas fa-phone mr-2"></i>
                                    {{ $reservation->customer_contact }}
                                </p>
                            </div>
                            @if($reservation->coupon_code)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Kupon</label>
                                    <p class="text-gray-900">
                                        <i class="fas fa-ticket-alt mr-2"></i>
                                        {{ $reservation->coupon_code }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($reservation->simple_questionnaire)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                <i class="fas fa-clipboard-question mr-2"></i>Kuesioner Pelanggan
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $reservation->simple_questionnaire }}</p>
                            </div>
                        </div>
                    @endif

                    @if($reservation->management_notes)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                <i class="fas fa-sticky-note mr-2"></i>Catatan Manajemen
                            </h2>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $reservation->management_notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-user mr-2"></i>Informasi Pelanggan
                        </h2>
                        
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $reservation->customer->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $reservation->customer->user->email }}</p>
                            </div>
                        </div>
                        
                        @if($reservation->customer->phone_number)
                            <div class="mb-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <p class="text-gray-900">{{ $reservation->customer->phone_number }}</p>
                            </div>
                        @endif
                        
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bergabung Sejak</label>
                            <p class="text-gray-900">{{ $reservation->customer->user->created_at->format('d M Y') }}</p>
                        </div>
                        
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Reservasi</label>
                            <p class="text-gray-900">{{ $reservation->customer->reservations->count() }} reservasi</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-history mr-2"></i>Timeline
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Reservasi dibuat</p>
                                    <p class="text-sm text-gray-500">{{ $reservation->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($reservation->status->value !== 'application')
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 {{ $reservation->status->value === 'confirmed' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                        <i class="fas {{ $reservation->status->value === 'confirmed' ? 'fa-check text-green-600' : 'fa-times text-red-600' }} text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            Status diubah menjadi {{ $reservation->status->value === 'confirmed' ? 'Dikonfirmasi' : 'Ditolak' }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $reservation->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>