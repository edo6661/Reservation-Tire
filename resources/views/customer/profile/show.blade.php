<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Profil Saya
                    </h1>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-8">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-3xl text-green-600"></i>
                            </div>
                            <div class="ml-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <p class="text-gray-600 mt-1">
                                    <i class="fas fa-users mr-1 text-green-500"></i>
                                    Customer
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('customer.profile.edit') }}" 
                               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Profil
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>
                                    Nama Lengkap
                                </label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Email
                                </label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2"></i>
                                    Nomor Telepon
                                </label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 font-medium">
                                        {{ $customer?->phone_number ?? 'Belum diisi' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-tag mr-2"></i>
                                    Role
                                </label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $user->role->value }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Tanggal Bergabung
                                </label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 font-medium">{{ $user->created_at->format('d F Y') }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Total Reservasi
                                </label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-gray-900 font-medium">
                                        {{ $customer?->reservations->count() ?? 0 }} reservasi
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($customer && $customer->reservations->count() > 0)
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-history mr-2"></i>
                                Reservasi Terbaru
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-3">
                                    @foreach($customer->reservations->take(3) as $reservation)
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                                <div>
                                                    <p class="font-medium text-gray-900">
                                                        Reservasi #{{ $reservation->id }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $reservation->created_at->format('d F Y, H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <span class="text-sm text-gray-500">
                                                {{ $reservation->status ?? 'Pending' }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                                @if($customer->reservations->count() > 3)
                                    <div class="mt-3 text-center">
                                        <a href="#" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                            Lihat semua reservasi
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-red-600 mb-4">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Zona Bahaya
                        </h3>
                        <div class="bg-red-50 rounded-lg p-4">
                            <p class="text-red-800 mb-4">
                                Menghapus akun akan menghapus semua data yang terkait dengan akun ini secara permanen, termasuk riwayat reservasi.
                            </p>
                            <form method="POST" action="{{ route('customer.profile.destroy') }}" 
                                  x-data="{ showConfirm: false }">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        @click="showConfirm = true"
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus Akun
                                </button>

                                <div x-show="showConfirm" 
                                     x-cloak
                                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                            Konfirmasi Penghapusan
                                        </h3>
                                        <p class="text-gray-600 mb-6">
                                            Apakah Anda yakin ingin menghapus akun ini? Semua data reservasi Anda akan hilang dan tindakan ini tidak dapat dibatalkan.
                                        </p>
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" 
                                                    @click="showConfirm = false"
                                                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                                                Batal
                                            </button>
                                            <button type="submit" 
                                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                                                Hapus Akun
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>