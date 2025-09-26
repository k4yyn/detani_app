<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#166534">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <title>@yield('title', 'De Tani Waterpark')</title>

    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    @stack('styles')
</head>

<style>
    body {
    font-family: "Montserrat", sans-serif;
}
    div{
    font-family: "Montserrat", sans-serif;
    }
    nav{
    font-family: "Montserrat", sans-serif;
    }
</style>

<body class="bg-white font-sans text-gray-800 h-full antialiased">
    <div x-data="{ showSidebar: false }" class="flex flex-col min-h-full">
        <header class="bg-transparent backdrop-blur-md shadow-xs sticky top-0 z-30 border-b border-gray-200">
            <div class="px-4 sm:px-4 lg:px-6">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <button @click="showSidebar = true" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-green-800 hover:bg-gray-100 focus:outline-none transition-all duration-200">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <div class="flex-shrink-0 flex items-center ml-4">
                            <img class="h-14 w-auto -mt-2" src="{{ asset('asset/image/logo-detani.png') }}" alt="Amaliah Logo">
                            <span class="ml-2 text-lg font-medium text-gray-800 hidden sm:inline">Admin DeTani</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center bg-green-100 px-3 py-1 rounded-lg text-green-800">
                            <i class="far fa-calendar-alt mr-2 text-green-700"></i>
                            <span class="text-sm font-medium">{{ now()->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 group relative">
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-800 font-medium">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:inline text-sm">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="fixed inset-0 z-40 overflow-hidden" x-show="showSidebar" x-cloak>
            <div
                class="absolute inset-0 bg-gray-900/60 backdrop-blur-md"
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

            <div
                class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-xl transform transition-transform duration-500 ease-in-out rounded-br-xl rounded-tr-2xl"
                x-show="showSidebar"
                x-transition:enter="transition ease-in-out duration-500"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-400"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                x-cloak
            >
                <div class="flex flex-col h-full bg-white shadow-xl rounded-tr-3xl rounded-br-3xl transition-transform duration-300 ease-in-out">

    <div class="flex items-center justify-between px-6 py-5 bg-green-900 text-white rounded-tr-xl">
        <div class="flex items-center">
            <img class="h-14 w-auto -mt-2" src="{{ asset('asset/image/logo-detani.png') }}" alt="Detani Logo">
            <div class="ml-3">
                <h2 class="text-xl font-bold tracking-tight">Admin Panel</h2>
            </div>
        </div>
        <button @click="showSidebar = false" class="text-green-200 hover:text-white transition-colors duration-200 focus:outline-none">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
        <a href="{{ url('admin/dashboard') }}"
           class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl mx-2 transition-all duration-300 ease-in-out cursor-pointer 
           {{ request()->is('admin/dashboard*') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
            <div class="w-8 h-8 rounded-full mr-4 flex items-center justify-center transition-all duration-300 ease-in-out transform
                        {{ request()->is('admin/dashboard*') ? 'bg-green-100 text-green-600 scale-110' : 'bg-gray-100 text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 group-hover:scale-110' }}">
                <i class="fas fa-home"></i>
            </div>
            <span class="flex-1">Dashboard</span>
            <div class="w-2 h-2 rounded-full bg-green-600 transition-opacity duration-200 {{ request()->is('admin/dashboard*') ? 'opacity-100' : 'opacity-0' }}"></div>
        </a>

        <a href="{{ url('admin/data') }}"
           class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl mx-2 transition-all duration-300 ease-in-out cursor-pointer 
           {{ request()->is('admin/data*') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
            <div class="w-8 h-8 rounded-full mr-4 flex items-center justify-center transition-all duration-300 ease-in-out transform
                        {{ request()->is('admin/data*') ? 'bg-green-100 text-green-600 scale-110' : 'bg-gray-100 text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 group-hover:scale-110' }}">
                <i class="fas fa-box"></i>
            </div>
            <span class="flex-1">Data Barang</span>
            <div class="w-2 h-2 rounded-full bg-green-600 transition-opacity duration-200 {{ request()->is('admin/data*') ? 'opacity-100' : 'opacity-0' }}"></div>
        </a>

        <a href="{{ url('admin/reports') }}"
           class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl mx-2 transition-all duration-300 ease-in-out cursor-pointer 
           {{ request()->is('admin/reports*') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
            <div class="w-8 h-8 rounded-full mr-4 flex items-center justify-center transition-all duration-300 ease-in-out transform
                        {{ request()->is('admin/reports*') ? 'bg-green-100 text-green-600 scale-110' : 'bg-gray-100 text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 group-hover:scale-110' }}">
                <i class="fas fa-chart-line"></i>
            </div>
            <span class="flex-1">Laporan</span>
            <div class="w-2 h-2 rounded-full bg-green-600 transition-opacity duration-200 {{ request()->is('admin/reports*') ? 'opacity-100' : 'opacity-0' }}"></div>
        </a>

        <div x-data="{ open: {{ request()->is('admin/tickets*') ? 'true' : 'false' }} }">
    <button @click="open = !open"
            class="group relative w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl mx-2 transition-all duration-300 ease-in-out 
            {{ request()->is('admin/tickets*') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
        <div class="w-8 h-8 rounded-full mr-4 flex items-center justify-center transition-all duration-300 ease-in-out transform
                    {{ request()->is('admin/tickets*') ? 'bg-green-100 text-green-600 scale-110' : 'bg-gray-100 text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 group-hover:scale-110' }}">
            <i class="fas fa-ticket-alt"></i>
        </div>
        <span class="flex-1 text-left">Ticketing</span>
        <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs ml-2 transform transition-transform duration-200"></i>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-y-0" x-transition:enter-end="opacity-100 transform scale-y-100" class="mt-2 space-y-1 origin-top">
        <a href="{{ url('admin/tickets') }}"
           class="flex items-center justify-between pl-16 pr-4 py-2 text-sm rounded-lg mx-2 transition-all duration-200
           {{ request()->is('admin/tickets') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
            <span class="flex-1 text-left">Data Ticketing</span>
            <div class="w-2 h-2 rounded-full bg-green-600 transition-opacity duration-200 {{ request()->is('admin/tickets') ? 'opacity-100' : 'opacity-0' }}"></div>
        </a>
        <a href="{{ route('admin.tickets.reports.index') }}"
           class="flex items-center justify-between pl-16 pr-4 py-2 text-sm rounded-lg mx-2 transition-all duration-200
           {{ request()->is('admin/tickets/reports*') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
            <span class="flex-1 text-left">Laporan Ticketing</span>
            <div class="w-2 h-2 rounded-full bg-green-600 transition-opacity duration-200 {{ request()->is('admin/tickets/reports*') ? 'opacity-100' : 'opacity-0' }}"></div>
        </a>
    </div>
</div>

        <a href="{{ url('admin/approval') }}"
           class="group relative flex items-center px-4 py-3 text-sm font-medium rounded-xl mx-2 transition-all duration-300 ease-in-out cursor-pointer 
           {{ request()->is('admin/approval*') ? 'bg-green-50 text-green-900 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-900' }}">
            <div class="w-8 h-8 rounded-full mr-4 flex items-center justify-center transition-all duration-300 ease-in-out transform
                        {{ request()->is('admin/approval*') ? 'bg-green-100 text-green-600 scale-110' : 'bg-gray-100 text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 group-hover:scale-110' }}">
                <i class="fas fa-lock"></i>
            </div>
            <span class="flex-1">Izin Akses</span>
            <div class="w-2 h-2 rounded-full bg-green-600 transition-opacity duration-200 {{ request()->is('admin/approval*') ? 'opacity-100' : 'opacity-0' }}"></div>
        </a>
    </nav>

    <div class="px-5 py-4 border-t border-gray-200">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-green-800 hover:bg-green-100 transition-colors duration-200">
                <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>
                Keluar
            </button>
        </form>
    </div>
</div>
            </div>
        </div>

        <main class="flex-1 transition-all duration-200 animate-fade-in" :class="{ 'blur-sm': showSidebar }">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="">
                    @hasSection('page-title')
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-semibold text-green-800 flex items-center">
                                    @yield('page-title')
                                </h1>
                                @hasSection('page-description')
                                    <p class="mt-1 text-sm text-red-700">
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
                {{-- FLASH MESSAGE --}}
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 animate-fade-in">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300 animate-fade-in">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    </div>
                @endif
                <div class="bg-white rounded-lg p-2">
                    @yield('content')
                </div>
            </div>
        </main>
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
<script>
console.log('🚀 Script loaded');
if ("serviceWorker" in navigator) {
  console.log('✅ Service Worker supported');
  window.addEventListener("load", () => {
    console.log('🔄 Registering Service Worker...');
    navigator.serviceWorker
      .register("/service-worker.js")  // Pakai path absolut
      .then(reg => {
        console.log("✅ Service Worker registered successfully");
        console.log("📍 Scope:", reg.scope);
        console.log("📦 Registration:", reg);
      })
      .catch(err => {
        console.error("❌ Service Worker registration failed:");
        console.error(err);
      });
  });
} else {
  console.error("❌ Service Worker not supported");
}
</script>
</body>
</html>