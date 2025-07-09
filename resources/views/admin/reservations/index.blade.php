<x-layouts.app>
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Reservation Management</h1>
                        <p class="mt-2 text-sm text-gray-600">Manage all customer reservations</p>
                    </div>
                    <a href="{{ route('admin.reservations.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Reservation
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Service
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Time
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reservations as $reservation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reservation->customer->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $reservation->customer->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $reservation->service->value }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $reservation->datetime->format('d M Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $reservation->datetime->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($reservation->status->value)
                                            @case('application')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                                @break
                                            @case('confirmed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Confirmed
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Rejected
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->customer_contact }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.reservations.show', $reservation->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reservations.edit', $reservation->id) }}" 
                                               class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($reservation->status->value === 'application')
                                                <form method="POST" action="{{ route('admin.reservations.confirm', $reservation->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900" 
                                                            onclick="return confirm('Are you sure you want to confirm this reservation?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.reservations.reject', $reservation->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                                            onclick="return confirm('Are you sure you want to reject this reservation?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('admin.reservations.destroy', $reservation->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Are you sure you want to delete this reservation?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        <div class="flex flex-col items-center py-8">
                                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                                            <p class="text-lg font-medium text-gray-900 mb-2">No reservations yet</p>
                                            <p class="text-sm text-gray-500">Reservations will appear here once customers make a booking</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($reservations->hasPages())
                <div class="mt-6">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
