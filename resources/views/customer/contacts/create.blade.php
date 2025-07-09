<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Hubungi Kami</h1>
                        <p class="mt-2 text-gray-600">Kirim pesan, pertanyaan, atau saran Anda kepada kami</p>
                    </div>
                    @auth
                        <a href="{{ route('customer.contacts.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Pesan
                        </a>
                    @endauth
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-red-800">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Formulir Kontak</h2>
                    <p class="text-sm text-gray-600 mt-1">Isi formulir di bawah ini untuk mengirim pesan kepada kami</p>
                </div>
                
                <div class="px-6 py-4">
                    <form method="POST" action="{{ auth()->check() ? route('customer.contacts.store') : route('contact.store') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="sender" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Anda <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="sender" 
                                   name="sender" 
                                   value="{{ old('sender', auth()->user()->email ?? '') }}"
                                   {{ auth()->check() ? 'readonly' : '' }}
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('sender') border-red-500 @enderror {{ auth()->check() ? 'bg-gray-50' : '' }}"
                                   placeholder="masukkan.email@domain.com">
                            @error('sender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Pesan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Masukkan judul pesan Anda">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="text" class="block text-sm font-medium text-gray-700 mb-2">
                                Isi Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="text" 
                                      name="text" 
                                      rows="8"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('text') border-red-500 @enderror"
                                      placeholder="Tulis pesan, pertanyaan, atau saran Anda di sini...">{{ old('text') }}</textarea>
                            @error('text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end space-x-3">
                            @auth
                                <a href="{{ route('customer.contacts.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Batal
                                </a>
                            @endauth
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Kontak</h3>
                </div>
                
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Email</h4>
                            <p class="text-sm text-gray-600">info@example.com</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Telepon</h4>
                            <p class="text-sm text-gray-600">+62 21 1234 5678</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Alamat</h4>
                            <p class="text-sm text-gray-600">Jakarta, Indonesia</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Jam Operasional</h4>
                            <p class="text-sm text-gray-600">Senin - Jumat: 08:00 - 17:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>