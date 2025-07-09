<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Pesan</h1>
                        <p class="mt-2 text-gray-600">Lihat pesan yang telah Anda kirim</p>
                    </div>
                    <a href="{{ route('customer.contacts.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Pesan
                    </a>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $contact->title }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $contact->situation === 'answered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $contact->situation === 'answered' ? 'Sudah Dijawab' : 'Menunggu Jawaban' }}
                        </span>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Pengirim</label>
                            <p class="text-sm text-gray-900">{{ $contact->sender }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kirim</label>
                            <p class="text-sm text-gray-900">{{ $contact->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Anda</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->text }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($contact->situation === 'answered')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <i class="fas fa-reply text-green-600 mr-2"></i>
                            <h3 class="text-lg font-medium text-gray-900">Balasan dari Tim Kami</h3>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Balasan</label>
                            <p class="text-lg font-medium text-gray-900">{{ $contact->answer_title }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Isi Balasan</label>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->answer_text }}</p>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            Dijawab pada {{ $contact->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 text-center">
                        <i class="fas fa-hourglass-half text-yellow-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Menunggu Balasan</h3>
                        <p class="text-gray-600">Pesan Anda sedang diproses. Tim kami akan segera membalas pesan Anda.</p>
                    </div>
                </div>
            @endif

            <div class="mt-8 flex justify-center">
                <a href="{{ route('customer.contacts.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Kirim Pesan Baru
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>