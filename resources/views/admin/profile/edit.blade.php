<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            <i class="fas fa-edit mr-2 text-green-600"></i>
                            Edit Profil
                        </h1>
                        <a href="{{ route('admin.profile.show') }}" 
                           class="text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
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

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2 mt-1"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800 mb-2">Terjadi kesalahan:</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg">
                <div class="px-6 py-8">
                    <div class="flex items-center mb-8">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-3xl text-green-600"></i>
                        </div>
                        <div class="ml-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-600 mt-1">
                                <i class="fas fa-users mr-1 text-green-500"></i>
                                Admin
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.profile.update') }}" 
                          x-data="{ showPassword: false, passwordConfirmation: '' }">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2"></i>
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 @error('name') border-red-500 @enderror"
                                           required>
                                    @error('name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-2"></i>
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 @error('email') border-red-500 @enderror"
                                           required>
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                        <i class="fas fa-lock mr-2 text-blue-600"></i>
                                        Ubah Password
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-4">
                                        Kosongkan jika tidak ingin mengubah password.
                                    </p>

                                    <div class="space-y-4">
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-key mr-2"></i>
                                                Password Baru
                                            </label>
                                            <div class="relative">
                                                <input :type="showPassword ? 'text' : 'password'" 
                                                       id="password" 
                                                       name="password" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 @error('password') border-red-500 @enderror pr-10"
                                                       minlength="8"
                                                       placeholder="Minimal 8 karakter">
                                                <button type="button" 
                                                        @click="showPassword = !showPassword"
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-key mr-2"></i>
                                                Konfirmasi Password
                                            </label>
                                            <input type="password" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   x-model="passwordConfirmation"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                                   placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                        <i class="fas fa-info-circle mr-2 text-gray-600"></i>
                                        Informasi Akun
                                    </h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600">Role:</span>
                                            <span class="font-medium text-green-600">{{ $user->role->value }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600">Bergabung:</span>
                                            <span class="font-medium">{{ $user->created_at->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-8 pt-8 border-t border-gray-200">
                            <a href="{{ route('admin.profile.show') }}" 
                               class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-red-600 mb-4">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Zona Bahaya
                        </h3>
                        <div class="bg-red-50 rounded-lg p-4">
                            <p class="text-red-800 mb-4">
                                Menghapus akun akan menghapus semua data yang terkait dengan akun ini secara permanen, termasuk riwayat reservasi.
                            </p>
                            <form method="POST" action="{{ route('admin.profile.destroy') }}" 
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
                                                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-2200">
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