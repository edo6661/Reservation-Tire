{{-- resources/views/admin/dashboard.blade.php --}}
<x-layouts.app>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Dashboard Admin</h1>
                            <p class="mt-1 text-sm text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users.index') }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Lihat semua users →
                        </a>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-user-friends text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Customers</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalCustomers }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" 
                           class="text-sm text-green-600 hover:text-green-800 font-medium">
                            Lihat semua customers →
                        </a>
                    </div>
                </div>

                <!-- Total Reservations -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <i class="fas fa-calendar-alt text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Reservations</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalReservations }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" 
                           class="text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                            Lihat semua reservations →
                        </a>
                    </div>
                </div>

                <!-- Unanswered Contacts -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100">
                            <i class="fas fa-envelope text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Kontak Belum Dijawab</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $unansweredContacts }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" 
                           class="text-sm text-red-600 hover:text-red-800 font-medium">
                            Lihat semua kontak →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Quick Actions Card -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.create') }}" 
                               class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-150">
                                <div class="p-2 rounded-full bg-blue-100">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Tambah User</p>
                                    <p class="text-xs text-gray-500">Buat user baru</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-150">
                                <div class="p-2 rounded-full bg-green-100">
                                    <i class="fas fa-users text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Kelola Users</p>
                                    <p class="text-xs text-gray-500">Lihat semua users</p>
                                </div>
                            </a>
                            
                            <a href="#" 
                               class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-150">
                                <div class="p-2 rounded-full bg-yellow-100">
                                    <i class="fas fa-calendar-check text-yellow-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Kelola Reservasi</p>
                                    <p class="text-xs text-gray-500">Lihat reservasi</p>
                                </div>
                            </a>
                            
                            <a href="#" 
                               class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition duration-150">
                                <div class="p-2 rounded-full bg-red-100">
                                    <i class="fas fa-envelope-open text-red-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Jawab Kontak</p>
                                    <p class="text-xs text-gray-500">Balas pesan</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="p-1 rounded-full bg-blue-100 mt-1">
                                    <i class="fas fa-user-plus text-blue-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-900">User baru terdaftar</p>
                                    <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="p-1 rounded-full bg-green-100 mt-1">
                                    <i class="fas fa-calendar-check text-green-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-900">Reservasi baru dikonfirmasi</p>
                                    <p class="text-xs text-gray-500">4 jam yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="p-1 rounded-full bg-yellow-100 mt-1">
                                    <i class="fas fa-envelope text-yellow-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-900">Pesan kontak baru diterima</p>
                                    <p class="text-xs text-gray-500">6 jam yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="p-1 rounded-full bg-red-100 mt-1">
                                    <i class="fas fa-times-circle text-red-600 text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-900">Reservasi dibatalkan</p>
                                    <p class="text-xs text-gray-500">8 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat semua aktivitas →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>