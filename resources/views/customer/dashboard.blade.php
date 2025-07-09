<x-layouts.app>
    <div class="min-h-screen bg-gray-50">
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Dashboard Customer</h1>
                            <p class="mt-1 text-sm text-gray-600">Selamat datang, {{ $user->name }}</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Reservasi</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $reservations->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Reservasi Aktif</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $reservations->whereIn('status', ['APPLICATION', 'CONFIRMED'])->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Menunggu Konfirmasi</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $reservations->where('status', 'APPLICATION')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Reservasi Saya</h3>
                            <a href="{{ route('customer.reservations.create') }}" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus mr-2"></i>
                                Buat Reservasi
                            </a>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @forelse($reservations->take(5) as $reservation)
                                <div class="p-6 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    @if($reservation->status == 'CONFIRMED')
                                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                                    @elseif($reservation->status == 'APPLICATION')
                                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                                    @else
                                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">
                                                        {{ $reservation->datetime->format('d M Y, H:i') }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $reservation->notes ?? 'Tidak ada catatan' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($reservation->status == 'CONFIRMED') bg-green-100 text-green-800
                                                @elseif($reservation->status == 'APPLICATION') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                @if($reservation->status == 'CONFIRMED')
                                                    Dikonfirmasi
                                                @elseif($reservation->status == 'APPLICATION')
                                                    Menunggu
                                                @else
                                                    Ditolak
                                                @endif
                                            </span>
                                            
                                            @if($reservation->status == 'APPLICATION')
                                                <button 
                                                    onclick="cancelReservation({{ $reservation->id }})"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Batalkan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center">
                                    <div class="text-gray-400 mb-4">
                                        <i class="fas fa-calendar-times text-4xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada reservasi</h3>
                                    <p class="text-gray-500 mb-4">Anda belum memiliki reservasi apapun.</p>
                                    <a href="{{ route('customer.reservations.create') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        <i class="fas fa-plus mr-2"></i>
                                        Buat Reservasi Pertama
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        
                        @if($reservations->count() > 5)
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <a href="{{ route('customer.reservations.index') }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat semua reservasi ({{ $reservations->count() }}) →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Profil Saya</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            @if($customer)
                                <div class="space-y-2 text-sm">
                                    @if($customer->phone)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-phone text-gray-400"></i>
                                            <span>{{ $customer->phone }}</span>
                                        </div>
                                    @endif
                                    @if($customer->address)
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                            <span>{{ $customer->address }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('customer.profile.edit') }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Edit Profil →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('customer.reservations.create') }}" 
                                   class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-150">
                                    <div class="p-2 rounded-full bg-blue-100">
                                        <i class="fas fa-plus text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Buat Reservasi</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('customer.reservations.index') }}" 
                                   class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition duration-150">
                                    <div class="p-2 rounded-full bg-green-100">
                                        <i class="fas fa-list text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Lihat Reservasi</p>
                                    </div>
                                </a>
                                
                                <a href="{{ route('contact.create') }}" 
                                   class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-150">
                                    <div class="p-2 rounded-full bg-yellow-100">
                                        <i class="fas fa-envelope text-yellow-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Hubungi Kami</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if($reservations->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($reservations->take(3) as $reservation)
                                        <div class="flex items-start space-x-3">
                                            <div class="p-1 rounded-full 
                                                @if($reservation->status == 'CONFIRMED') bg-green-100 
                                                @elseif($reservation->status == 'APPLICATION') bg-yellow-100 
                                                @else bg-red-100 
                                                @endif mt-1">
                                                <i class="fas fa-calendar 
                                                    @if($reservation->status == 'CONFIRMED') text-green-600 
                                                    @elseif($reservation->status == 'APPLICATION') text-yellow-600 
                                                    @else text-red-600 
                                                    @endif text-xs"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm text-gray-900">
                                                    Reservasi {{ $reservation->datetime->format('d M Y, H:i') }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $reservation->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">
                                    Belum ada aktivitas
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden" style="z-index: 50;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Batalkan Reservasi
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin membatalkan reservasi ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            onclick="confirmCancel()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Batalkan
                    </button>
                    <button type="button" 
                            onclick="closeCancelModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let reservationToCancel = null;
        
        function cancelReservation(reservationId) {
            reservationToCancel = reservationId;
            document.getElementById('cancelModal').classList.remove('hidden');
        }
        
        function closeCancelModal() {
            reservationToCancel = null;
            document.getElementById('cancelModal').classList.add('hidden');
        }
        
        function confirmCancel() {
            if (reservationToCancel) {
                fetch(`/reservations/${reservationToCancel}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal membatalkan reservasi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membatalkan reservasi');
                });
            }
            closeCancelModal();
        }
        
        
        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    </script>
</x-layouts.app>