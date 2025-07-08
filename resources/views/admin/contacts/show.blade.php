{{-- resources/views/admin/contacts/show.blade.php --}}
<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Pesan</h1>
                        <p class="mt-2 text-gray-600">Lihat dan balas pesan dari pelanggan</p>
                    </div>
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
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

            <!-- Contact Message -->
            <div class="bg-white shadow rounded-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $contact->title }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $contact->situation === 'answered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $contact->situation === 'answered' ? 'Sudah Dijawab' : 'Belum Dijawab' }}
                        </span>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pengirim</label>
                            <p class="text-sm text-gray-900">{{ $contact->sender }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <p class="text-sm text-gray-900">{{ $contact->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->text }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answer Section -->
            @if($contact->situation === 'answered')
                <!-- Show Answer -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Jawaban</h3>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Jawaban</label>
                            <p class="text-gray-900">{{ $contact->answer_title }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Isi Jawaban</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->answer_text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Answer Form -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Balas Pesan</h3>
                    </div>
                    
                    <div class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.contacts.answer', $contact->id) }}">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="answer_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Jawaban <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="answer_title" 
                                       name="answer_title" 
                                       value="{{ old('answer_title') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('answer_title') border-red-500 @enderror"
                                       placeholder="Masukkan judul jawaban">
                                @error('answer_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="answer_text" class="block text-sm font-medium text-gray-700 mb-2">
                                    Isi Jawaban <span class="text-red-500">*</span>
                                </label>
                                <textarea id="answer_text" 
                                          name="answer_text" 
                                          rows="8"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('answer_text') border-red-500 @enderror"
                                          placeholder="Tulis jawaban Anda di sini...">{{ old('answer_text') }}</textarea>
                                @error('answer_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-end space-x-3">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Kirim Jawaban
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Delete Button -->
            <div class="mt-8 flex justify-end">
                <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                      onsubmit="return confirm('Yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.')" 
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>