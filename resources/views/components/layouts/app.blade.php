<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin - Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-100">
        <div class="flex min-h-screen" x-data="{ sidebarOpen: true }">
            <div class="bg-white shadow-lg fixed h-full z-30 transition-all duration-300 ease-in-out" 
                 :class="sidebarOpen ? 'w-64' : 'w-16'">
                <div class="flex items-center justify-between h-16 px-4 bg-blue-600 text-white">
                    <div class="flex items-center" :class="{ 'justify-center': !sidebarOpen }">
                        <span class="text-lg font-semibold transition-opacity duration-300" 
                              x-show="sidebarOpen" 
                              x-transition:enter="transition-opacity duration-300 delay-100"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              x-transition:leave="transition-opacity duration-300"
                              x-transition:leave-start="opacity-100"
                              x-transition:leave-end="opacity-0">Admin Panel</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="hover:bg-blue-500 p-1 rounded">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <nav class="mt-8" :class="sidebarOpen ? 'px-4' : 'px-2'">
                    <div class="space-y-2">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}"
                           :class="sidebarOpen ? 'px-4' : 'px-2 justify-center'"
                           :title="!sidebarOpen ? 'Dashboard' : ''">
                            <i class="fas fa-tachometer-alt" :class="sidebarOpen ? 'mr-3' : 'text-lg'"></i>
                            <span x-show="sidebarOpen"
                                  x-transition:enter="transition-opacity duration-300 delay-100"
                                  x-transition:enter-start="opacity-0"
                                  x-transition:enter-end="opacity-100"
                                  x-transition:leave="transition-opacity duration-200"
                                  x-transition:leave-start="opacity-100"
                                  x-transition:leave-end="opacity-0">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}"
                           :class="sidebarOpen ? 'px-4' : 'px-2 justify-center'"
                           :title="!sidebarOpen ? 'Manage Users' : ''">
                            <i class="fas fa-users" :class="sidebarOpen ? 'mr-3' : 'text-lg'"></i>
                            <span x-show="sidebarOpen">Manage Users</span>
                        </a>

                        <a href="{{ route('admin.reservations.index') }}" 
                           class="flex items-center py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ request()->routeIs('admin.reservations.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}"
                           :class="sidebarOpen ? 'px-4' : 'px-2 justify-center'"
                           :title="!sidebarOpen ? 'Manage Reservations' : ''">
                            <i class="fas fa-calendar-alt" :class="sidebarOpen ? 'mr-3' : 'text-lg'"></i>
                            <span x-show="sidebarOpen">Manage Reservations</span>
                        </a>

                        <a href="{{ route('admin.contacts.index') }}" 
                           class="flex items-center py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200 {{ request()->routeIs('admin.contacts.*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : '' }}"
                           :class="sidebarOpen ? 'px-4' : 'px-2 justify-center'"
                           :title="!sidebarOpen ? 'Manage Contacts' : ''">
                            <i class="fas fa-envelope" :class="sidebarOpen ? 'mr-3' : 'text-lg'"></i>
                            <span x-show="sidebarOpen">Manage Contacts</span>
                        </a>

                        <hr class="my-4 border-gray-200" x-show="sidebarOpen">

                        <a href="#" 
                           class="flex items-center py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200"
                           :class="sidebarOpen ? 'px-4' : 'px-2 justify-center'"
                           :title="!sidebarOpen ? 'Reports' : ''">
                            <i class="fas fa-chart-bar" :class="sidebarOpen ? 'mr-3' : 'text-lg'"></i>
                            <span x-show="sidebarOpen">Reports</span>
                        </a>

                        <a href="#" 
                           class="flex items-center py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200"
                           :class="sidebarOpen ? 'px-4' : 'px-2 justify-center'"
                           :title="!sidebarOpen ? 'Settings' : ''">
                            <i class="fas fa-cogs" :class="sidebarOpen ? 'mr-3' : 'text-lg'"></i>
                            <span x-show="sidebarOpen">Settings</span>
                        </a>
                    </div>
                </nav>

                <div class="absolute bottom-0 w-full border-t border-gray-200 transition-all duration-300"
                     :class="sidebarOpen ? 'p-4' : 'p-2'">
                    <div class="flex items-center" :class="{ 'justify-center': !sidebarOpen }">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="ml-3 flex-1" x-show="sidebarOpen">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="relative" x-data="{ open: false }" x-show="sidebarOpen">
                            <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute bottom-full right-0 mb-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('admin.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-edit mr-2"></i>Edit Profile
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-16'">
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between h-16">
                            <div class="flex-1 ml-4">
                                <h1 class="text-2xl font-semibold text-gray-900">
                                    Dashboard
                                </h1>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile sidebar and overlay -->
        <div class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-20" 
             x-data="{ showMobile: false }" 
             x-show="showMobile" 
             @toggle-mobile-sidebar.window="showMobile = !showMobile" 
             @click="showMobile = false"></div>

        <div class="lg:hidden fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-xl transform -translate-x-full transition-transform duration-300" 
             x-data="{ showMobile: false }" 
             x-show="showMobile" 
             @toggle-mobile-sidebar.window="showMobile = !showMobile" 
             :class="{ 'translate-x-0': showMobile }">
            <div class="flex items-center justify-between h-16 px-4 bg-blue-600 text-white">
                <div class="flex items-center">
                    <i class="fas fa-cog mr-2"></i>
                    <span class="text-lg font-semibold">Admin Panel</span>
                </div>
                <button @click="showMobile = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="mt-8 px-4">
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-users mr-3"></i>
                        <span>Manage Users</span>
                    </a>
                    <a href="{{ route('admin.reservations.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        <span>Manage Reservations</span>
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>Manage Contacts</span>
                    </a>
                    <hr class="my-4 border-gray-200">
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-chart-bar mr-3"></i>
                        <span>Reports</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-cogs mr-3"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>
        </div>
    </body>
</html>
