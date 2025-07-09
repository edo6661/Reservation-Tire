<x-layouts.app>
    <div class="min-h-screen bg-gray-50">
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-900">Detail User</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Informasi User
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Detail informasi pengguna sistem
                                </p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">ID User</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->id }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                                        <dd class="mt-1">
                                            @if($user->role == 'admin')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-shield-alt mr-1"></i>
                                                    Admin
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Customer
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                                        <dd class="mt-1">
                                            @if($user->email_verified_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Not Verified
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Aksi
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Tindakan yang dapat dilakukan
                                </p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <div class="space-y-3">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-edit mr-2"></i>
                                        Edit User
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" 
                                          class="w-full"
                                          x-data="{ showConfirm: false }">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                @click="showConfirm = true"
                                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <i class="fas fa-trash mr-2"></i>
                                            Hapus User
                                        </button>
                                        
                                        <div x-show="showConfirm" 
                                             x-transition:enter="ease-out duration-300"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="ease-in duration-200"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             class="fixed inset-0 z-50 overflow-y-auto" 
                                             style="display: none;">
                                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                
                                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                    Konfirmasi Hapus
                                                                </h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-gray-500">
                                                                        Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>? 
                                                                        Tindakan ini tidak dapat dibatalkan.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <button type="submit" 
                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Ya, Hapus
                                                        </button>
                                                        <button type="button" 
                                                                @click="showConfirm = false"
                                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->role == 'customer' && $user->customer)
                <div class="mt-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Informasi Customer
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Detail informasi sebagai customer
                            </p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Customer ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->customer->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->customer->phone ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->customer->address ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Reservasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->customer->reservations->count() ?? 0 }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                @endif

                @if($user->role == 'customer' && $user->customer && $user->customer->reservations->count() > 0)
                <div class="mt-6">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Reservasi Terbaru
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                5 reservasi terbaru dari customer ini
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal & Waktu
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Dibuat
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($user->customer->reservations->take(5) as $reservation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $reservation->datetime->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($reservation->status == 'confirmed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Confirmed
                                                    </span>
                                                @elseif($reservation->status == 'application')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Application
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="fas fa-times-circle mr-1"></i>
                                                        Rejected
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $reservation->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>