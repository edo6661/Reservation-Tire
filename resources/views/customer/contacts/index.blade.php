{{-- resources/views/customer/contacts/index.blade.php --}}
<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Pesan Saya</h1>
                        <p class="mt-2 text-gray-600">Lihat semua pesan yang sudah Anda kirim</p>
                    </div>
                    <a href="{{ route('customer.contacts.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Kirim Pesan Baru
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

            <!-- Contacts List -->
            @if($contacts->count() > 0)
                <div class="bg-white shadow overflow-hidden rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        @foreach($contacts as $contact)
                            <li class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $contact->title }}</h3>
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $contact->situation === 'answered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $contact->situation === 'answered' ? 'Sudah Dijawab' : 'Menunggu Jawaban' }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-800">{{ Str::limit($contact->text, 150) }}</p>
                                        <div class="mt-3 flex items-center text-xs text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <span>Dikirim {{ $contact->created_at->diffForHumans() }}</span>
                                            @if($contact->situation === 'answered')
                                                <span class="ml-4">
                                                    <i class="fas fa-reply mr-1"></i>
                                                    Ada balasan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('customer.contacts.show', $contact->id) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-envelope text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pesan</h3>
                    <p class="text-gray-600 mb-6">Anda belum pernah mengirim pesan kepada kami.</p>
                    <a href="{{ route('customer.contacts.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Kirim Pesan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>