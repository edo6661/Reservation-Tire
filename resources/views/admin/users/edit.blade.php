<x-layouts.app>
    <div class="min-h-screen bg-gray-50">
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Edit User</h1>
                            <p class="mt-1 text-sm text-gray-600">Edit informasi user {{ $user->name }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.users.show', $user->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-150">
                                <i class="fas fa-eye mr-2"></i>
                                Detail
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-150">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span class="text-green-800">{{ session('success') }}</span>
                        <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                        <div class="text-red-800">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Edit Informasi User</h2>
                </div>
                
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="Masukkan email"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            <button type="button" 
                                    x-data="{ show: false }"
                                    @click="show = !show; $refs.password.type = show ? 'text' : 'password'"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Konfirmasi password baru">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" 
                                name="role"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role', $user->role->value) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ old('role', $user->role->value) == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mr-2 mt-0.5"></i>
                            <div class="text-sm text-blue-800">
                                <p><strong>Informasi:</strong></p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>User ini terdaftar pada {{ $user->created_at->format('d M Y H:i') }}</li>
                                    <li>Update terakhir pada {{ $user->updated_at->format('d M Y H:i') }}</li>
                                    @if($user->customer)
                                        <li>User ini memiliki {{ $user->customer->reservations->count() }} reservasi</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.users.show', $user->id) }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            <i class="fas fa-save mr-2"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>