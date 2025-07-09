<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Kontak</h1>
                <p class="mt-2 text-gray-600">Kelola pesan dan pertanyaan dari pelanggan</p>
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

            <div x-data="{ activeTab: 'unanswered' }" class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="activeTab = 'unanswered'" 
                                :class="activeTab === 'unanswered' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            <i class="fas fa-clock mr-2"></i>
                            Belum Dijawab ({{ $unansweredContacts->total() }})
                        </button>
                        <button @click="activeTab = 'all'" 
                                :class="activeTab === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            <i class="fas fa-envelope mr-2"></i>
                            Semua Pesan ({{ $contacts->total() }})
                        </button>
                    </nav>
                </div>

                <div x-show="activeTab === 'unanswered'" class="mt-6">
                    @if($unansweredContacts->count() > 0)
                        <div class="bg-white shadow overflow-hidden rounded-lg">
                            <ul class="divide-y divide-gray-200">
                                @foreach($unansweredContacts as $contact)
                                    <li class="px-6 py-4 hover:bg-gray-50">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <h3 class="text-lg font-medium text-gray-900">{{ $contact->title }}</h3>
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Belum Dijawab
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-600">Dari: {{ $contact->sender }}</p>
                                                <p class="mt-2 text-sm text-gray-800">{{ Str::limit($contact->text, 150) }}</p>
                                                <p class="mt-2 text-xs text-gray-500">{{ $contact->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex space-x-2 ml-4">
                                                <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Lihat
                                                </a>
                                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                                      onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="mt-6">
                            {{ $unansweredContacts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Pesan Belum Dijawab</h3>
                            <p class="text-gray-600">Semua pesan sudah dijawab.</p>
                        </div>
                    @endif
                </div>

                <div x-show="activeTab === 'all'" class="mt-6">
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
                                                        {{ $contact->situation === App\Enums\ContactSituation::ANSWERED ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $contact->situation === App\Enums\ContactSituation::ANSWERED ? 'Sudah Dijawab' : 'Belum Dijawab' }}
                                                    </span>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-600">Dari: {{ $contact->sender }}</p>
                                                <p class="mt-2 text-sm text-gray-800">{{ Str::limit($contact->text, 150) }}</p>
                                                <p class="mt-2 text-xs text-gray-500">{{ $contact->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex space-x-2 ml-4">
                                                <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    Lihat
                                                </a>
                                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                                      onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="mt-6">
                            {{ $contacts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Pesan</h3>
                            <p class="text-gray-600">Belum ada pesan masuk.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>