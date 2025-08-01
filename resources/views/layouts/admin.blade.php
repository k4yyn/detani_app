<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4f46e5"> <!-- Indigo-600 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', 'De Tani Waterpark')</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-gray-800 h-full antialiased">
    <div x-data="{ showSidebar: false }" class="flex flex-col min-h-full">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm sticky top-0 z-30 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Mobile menu button and logo -->
                    <div class="flex items-center">
                        <button @click="showSidebar = true" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none transition-all duration-200">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <div class="flex-shrink-0 flex items-center ml-4">
                            <img class="h-8 w-auto" src="{{ asset('asset/image/logo amaliah.png') }}" alt="Amaliah Logo">
                            <span class="ml-2 text-lg font-medium text-gray-800 hidden sm:inline">Admin dTani</span>
                        </div>
                    </div>

                    <!-- Date and user info -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center bg-indigo-50 px-3 py-1 rounded-lg text-indigo-700">
                            <i class="far fa-calendar-alt mr-2 text-indigo-500"></i>
                            <span class="text-sm font-medium">{{ now()->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 group relative">
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-medium">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:inline text-sm">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-1 border border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 flex items-center">
                                        <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar Navigation -->
        <div class="fixed inset-0 z-40 overflow-hidden" x-show="showSidebar" x-cloak>
            <div class="absolute inset-0 overflow-hidden">
                <!-- Background overlay -->
                <div 
                    class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm"
                    x-show="showSidebar"
                    x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in-out duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="showSidebar = false"
                    x-cloak
                ></div>
                
                <!-- Sidebar panel -->
                <div 
                    class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-xl transform transition-transform duration-500 ease-in-out"
                    x-show="showSidebar"
                    x-transition:enter="transition ease-in-out duration-500"
                    x-transition:enter-start="-translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition ease-in-out duration-400"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="-translate-x-full opacity-0"
                    x-cloak
                >
                    <div class="flex flex-col h-full">
                        <!-- Sidebar header -->
                        <div class="flex items-center justify-between px-6 py-5 bg-indigo-600 text-white">
                            <div class="flex items-center">
                                <img class="h-10 w-auto" src="{{ asset('asset/image/logo amaliah.png') }}" alt="Amaliah Logo">
                                <div class="ml-3">
                                    <h2 class="text-lg font-semibold">Admin DeTani</h2>
                                    <p class="text-sm text-indigo-100">Admin Panel</p>
                                </div>
                            </div>
                            <button @click="showSidebar = false" class="text-indigo-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <!-- Navigation -->
                        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                            <a href="{{ url('admin/dashboard') }}" 
                               class="{{ request()->is('admin/dashboard*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg mx-2 transition-all duration-200">
                                <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center {{ request()->is('admin/dashboard*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }} transition-all duration-200">
                                    <i class="fas fa-home text-sm"></i>
                                </div>
                                <span class="flex-1">Dashboard</span>
                                <div class="w-2 h-2 rounded-full bg-indigo-500 {{ request()->is('admin/dashboard*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></div>
                            </a>

                            <a href="{{ url('admin/data') }}" 
                               class="{{ request()->is('admin/data*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg mx-2 transition-all duration-200">
                                <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center {{ request()->is('admin/data*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }} transition-all duration-200">
                                    <i class="fas fa-box text-sm"></i>
                                </div>
                                <span class="flex-1">Data Barang</span>
                                <div class="w-2 h-2 rounded-full bg-indigo-500 {{ request()->is('admin/data*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></div>
                            </a>

                            <a href="{{ url('admin/reports') }}" 
                               class="{{ request()->is('admin/reports*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg mx-2 transition-all duration-200">
                                <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center {{ request()->is('admin/reports*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }} transition-all duration-200">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </div>
                                <span class="flex-1">Laporan</span>
                                <div class="w-2 h-2 rounded-full bg-indigo-500 {{ request()->is('admin/reports*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></div>
                            </a>

                            <a href="{{ url('admin/approval') }}" 
                               class="{{ request()->is('admin/approval*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg mx-2 transition-all duration-200">
                                <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center {{ request()->is('admin/approval*') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }} transition-all duration-200">
                                    <i class="fas fa-lock text-sm"></i>
                                </div>
                                <span class="flex-1">Izin Akses</span>
                                <div class="w-2 h-2 rounded-full bg-indigo-500 {{ request()->is('admin/approval*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></div>
                            </a>
                        </nav>

                        <!-- Logout -->
                        <div class="px-5 py-4 border-t border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-indigo-600 hover:bg-indigo-50 transition-all duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-200" :class="{ 'blur-sm': showSidebar }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Page title and actions -->
                <div class="mb-6">
                    @hasSection('page-title')
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                                    @yield('page-title')
                                </h1>
                                @hasSection('page-description')
                                    <p class="mt-1 text-sm text-gray-500">
                                        @yield('page-description')
                                    </p>
                                @endif
                            </div>
                            @hasSection('page-actions')
                                <div class="flex space-x-3">
                                    @yield('page-actions')
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="bg-white rounded-lg p-6 transition-all duration-200 shadow-sm hover:shadow-md border border-gray-100">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Bottom Navigation (Mobile) -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg z-20 md:hidden">
            <div class="flex justify-around">
                <a href="{{ url('admin/dashboard') }}" 
                   class="{{ request()->is('admin/dashboard*') ? 'text-indigo-600' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 text-center w-full transition-colors duration-200 group">
                    <div class="relative">
                        <i class="fas fa-home text-xl mb-1 transition-all duration-200 group-hover:scale-110"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-indigo-500 rounded-full {{ request()->is('admin/dashboard*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></span>
                    </div>
                    <span class="text-xs font-medium transition-all duration-200 group-hover:font-semibold">Dashboard</span>
                </a>

                <a href="{{ url('admin/data') }}" 
                   class="{{ request()->is('admin/data*') ? 'text-indigo-600' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 text-center w-full transition-colors duration-200 group">
                    <div class="relative">
                        <i class="fas fa-box text-xl mb-1 transition-all duration-200 group-hover:scale-110"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-indigo-500 rounded-full {{ request()->is('admin/data*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></span>
                    </div>
                    <span class="text-xs font-medium transition-all duration-200 group-hover:font-semibold">Data Barang</span>
                </a>

                <a href="{{ url('admin/reports') }}" 
                   class="{{ request()->is('admin/reports*') ? 'text-indigo-600' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 text-center w-full transition-colors duration-200 group">
                    <div class="relative">
                        <i class="fas fa-chart-line text-xl mb-1 transition-all duration-200 group-hover:scale-110"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-indigo-500 rounded-full {{ request()->is('admin/reports*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></span>
                    </div>
                    <span class="text-xs font-medium transition-all duration-200 group-hover:font-semibold">Laporan</span>
                </a>

                <a href="{{ url('admin/approval') }}" 
                   class="{{ request()->is('admin/approval*') ? 'text-indigo-600' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 text-center w-full transition-colors duration-200 group">
                    <div class="relative">
                        <i class="fas fa-lock text-xl mb-1 transition-all duration-200 group-hover:scale-110"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-indigo-500 rounded-full {{ request()->is('admin/approval*') ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-200"></span>
                    </div>
                    <span class="text-xs font-medium transition-all duration-200 group-hover:font-semibold">Izin Akses</span>
                </a>
            </div>
        </nav>
    </div>

    <style>
        [x-cloak] { display: none !important; }

        /* Smooth scroll for sidebar */
        nav::-webkit-scrollbar {
            width: 6px;
        }
        
        nav::-webkit-scrollbar-track {
            background: #f9fafb;
        }
        
        nav::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 20px;
        }

        /* For PWA install prompt */
        @media (display-mode: standalone) {
            body {
                overscroll-behavior-y: contain;
            }

            /* Hide address bar space */
            header {
                padding-top: env(safe-area-inset-top);
            }

            /* Adjust bottom nav for iOS */
            nav.fixed-bottom {
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        /* Touch feedback */
        button, a {
            transition: all 0.2s ease;
        }

        button:active, a:active {
            transform: scale(0.98);
        }

        /* Optimize for touch targets */
        button, a {
            touch-action: manipulation;
            min-height: 44px;
            min-width: 44px;
        }

        /* Subtle hover effect for cards */
        .hover-scale {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-scale:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Fade-in animation for content */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>

    @stack('scripts')
</body>
</html>