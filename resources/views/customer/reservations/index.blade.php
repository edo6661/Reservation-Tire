<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Reservasi Saya</h1>
                        <p class="text-gray-600 mt-1">Kelola reservasi layanan Anda</p>
                    </div>
                    <a href="{{ route('customer.reservations.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Buat Reservasi</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                @if($reservations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Layanan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal & Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kontak
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reservations as $reservation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reservation->service->value }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $reservation->datetime->format('d M Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $reservation->datetime->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($reservation->status)
                                                @case(App\Enums\ReservationStatus::APPLICATION)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Menunggu
                                                    </span>
                                                    @break
                                                @case(App\Enums\ReservationStatus::CONFIRMED)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Dikonfirmasi
                                                    </span>
                                                    @break
                                                @case(App\Enums\ReservationStatus::REJECTED)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Ditolak
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $reservation->customer_contact }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('customer.reservations.show', $reservation->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($reservation->status === App\Enums\ReservationStatus::APPLICATION)
                                                    <a href="{{ route('customer.reservations.edit', $reservation->id) }}" 
                                                       class="text-green-600 hover:text-green-900 transition-colors duration-200">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($reservation->canBeCancelled())
                                                    <form method="POST" action="{{ route('customer.reservations.cancel', $reservation->id) }}" 
                                                          class="inline-block"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada reservasi</h3>
                        <p class="text-gray-500 mb-6">Anda belum membuat reservasi apapun.</p>
                        <a href="{{ route('customer.reservations.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200">
                            Buat Reservasi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>