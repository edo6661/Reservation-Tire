<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-50">
        <header class="bg-white shadow-md">
            <nav class="container">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Reservation
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-6">
                        @guest
                            <a href="{{ route('contact.create') }}" class="text-gray-700 hover:text-blue-600 transition duration-200">
                                <i class="fas fa-envelope mr-1"></i>
                                Kontak
                            </a>
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition duration-200">
                                <i class="fas fa-sign-in-alt mr-1"></i>
                                Login
                            </a>
                        @endguest

                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                        <i class="fas fa-cog mr-1"></i>
                                        Admin
                                        <i class="fas fa-chevron-down ml-1"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                        </a>
                                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-users mr-2"></i>Kelola User
                                        </a>
                                        <a href="{{ route('admin.reservations.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-calendar-alt mr-2"></i>Kelola Reservasi
                                        </a>
                                        <a href="{{ route('admin.contacts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-envelope mr-2"></i>Kelola Kontak
                                        </a>
                                    </div>
                                </div>
                            @elseif(auth()->user()->isCustomer())
                                <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-tachometer-alt mr-1"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('customer.reservations.index') }}" class="text-gray-700 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Reservasi
                                </a>
                                <a href="{{ route('customer.contacts.index') }}" class="text-gray-700 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-envelope mr-1"></i>
                                    Kontak
                                </a>
                            @endif

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-circle mr-1"></i>
                                    {{ auth()->user()->name }}
                                    <i class="fas fa-chevron-down ml-1"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i>Profil
                                        </a>
                                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit Profil
                                        </a>
                                    @else
                                        <a href="{{ route('customer.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user mr-2"></i>Profil
                                        </a>
                                        <a href="{{ route('customer.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit Profil
                                        </a>
                                    @endif
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <div class="md:hidden">
                        <button x-data @click="$dispatch('toggle-mobile-menu')" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>

                <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" class="md:hidden mt-4 border-t pt-4">
                    <div class="flex flex-col space-y-2">
                        @guest
                            <a href="{{ route('contact.create') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                <i class="fas fa-envelope mr-2"></i>Kontak
                            </a>
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                        @endguest

                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-users mr-2"></i>Kelola User
                                </a>
                                <a href="{{ route('admin.reservations.index') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-calendar-alt mr-2"></i>Kelola Reservasi
                                </a>
                                <a href="{{ route('admin.contacts.index') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-envelope mr-2"></i>Kelola Kontak
                                </a>
                                <a href="{{ route('admin.profile.show') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                            @elseif(auth()->user()->isCustomer())
                                <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <a href="{{ route('customer.reservations.index') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-calendar-alt mr-2"></i>Reservasi
                                </a>
                                <a href="{{ route('customer.contacts.index') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-envelope mr-2"></i>Kontak
                                </a>
                                <a href="{{ route('customer.profile.show') }}" class="text-gray-700 hover:text-blue-600 py-2">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                            @endif
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 py-2 w-full text-left">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        <main class="min-h-screen">
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-white">
            <div class="container">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">
                            <i class="fas fa-info-circle mr-2"></i>
                            Tentang Kami
                        </h3>
                        <p class="text-gray-400 text-sm">
                            MyApp adalah platform yang menyediakan layanan terbaik untuk kebutuhan reservasi dan kontak Anda.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">
                            <i class="fas fa-link mr-2"></i>
                            Link Cepat
                        </h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="{{ route('contact.create') }}" class="text-gray-400 hover:text-white transition duration-200">
                                    <i class="fas fa-envelope mr-1"></i>Kontak
                                </a>
                            </li>
                            @guest
                                <li>
                                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition duration-200">
                                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">
                            <i class="fas fa-concierge-bell mr-2"></i>
                            Layanan
                        </h3>
                        <ul class="space-y-2 text-sm">
                            <li class="text-gray-400">
                                <i class="fas fa-calendar-alt mr-1"></i>Sistem Reservasi
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">
                            <i class="fas fa-address-card mr-2"></i>
                            Kontak Kami
                        </h3>
                        <div class="space-y-2 text-sm text-gray-400">
                            <p>
                                <i class="fas fa-envelope mr-2"></i>
                                info@myapp.com
                            </p>
                            <p>
                                <i class="fas fa-phone mr-2"></i>
                                +62 123 456 7890
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Jakarta, Indonesia
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-700">

                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400">
                        <p>&copy; {{ date('Y') }} MyApp. All rights reserved.</p>
                    </div>
                    
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>