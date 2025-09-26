<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#166534"> <!-- Green-800 -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<title>@yield('title', 'Kasir DeTani')</title>

<!-- Tailwind -->
@vite('resources/css/app.css')

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

@stack('styles')
</head>

<body class="bg-gray-100 font-sans text-gray-800 h-full antialiased">
<div x-data="{ showSidebar: false }" class="flex flex-col min-h-full">

<!-- HEADER -->
<header class="bg-green-800 text-white shadow sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Menu & Logo -->
            <div class="flex items-center">
                <!-- Desktop only: Show hamburger for sidebar -->
                <button @click="showSidebar = true" class="hidden md:inline-flex items-center justify-center p-2 rounded-md text-white hover:text-green-100 hover:bg-green-700 focus:outline-none transition">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <div class="flex items-center ml-0 md:ml-4 space-x-2">
                    <i class="fas fa-store text-xl"></i>
                    <h1 class="text-lg font-semibold hidden sm:inline">Kasir DeTani</h1>
                </div>
            </div>

            <!-- Date & User -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center bg-green-50 px-3 py-1 rounded-lg text-green-800 shadow">
                    <i class="far fa-calendar-alt mr-2 text-green-600"></i>
                    <span class="text-sm font-medium">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="flex items-center text-white group relative">
                    <div class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full bg-green-700 flex items-center justify-center text-white font-medium">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:inline text-sm">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded shadow py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- SIDEBAR (Desktop Only) -->
<div class="fixed inset-0 z-40 md:block hidden" x-show="showSidebar" x-cloak>
    <div class="absolute inset-0 bg-black/50" @click="showSidebar = false"></div>
    <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl transform transition-all duration-300" 
         x-show="showSidebar" 
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="-translate-x-full" 
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-4 py-4 bg-green-800 text-white">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-store text-lg"></i>
                    <span class="text-lg font-semibold">Kasir DeTani</span>
                </div>
                <button @click="showSidebar = false" class="text-green-100 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ url('user/transaksi') }}" 
                   class="{{ request()->is('user/transaksi*') ? 'bg-green-50 text-green-800' : 'text-gray-700 hover:bg-gray-100 hover:text-green-800' }} block px-4 py-3 rounded-lg transition">
                    <i class="fas fa-shopping-cart mr-3"></i> Transaksi
                </a>
                <a href="{{ route('user.data.index') }}" 
                   class="{{ request()->is('user.data.index*') ? 'bg-green-50 text-green-800' : 'text-gray-700 hover:bg-gray-100 hover:text-green-800' }} block px-4 py-3 rounded-lg transition">
                    <i class="fas fa-box mr-3"></i> Data Barang
                </a>
                <a href="{{ route('user.nota.notaHarian') }}" 
                    class="{{ request()->is('user/nota.nota-harian*') ? 'bg-green-50 text-green-800' : 'text-gray-700 hover:bg-gray-100 hover:text-green-800' }} block px-4 py-3 rounded-lg transition">
                    <i class="fas fa-receipt mr-3"></i> Nota Harian
                </a>
                <a href="{{ route('user.tickets.create') }}" 
                    class="{{ request()->is('user/tickets/create') ? 'bg-green-50 text-green-800' : 'text-gray-700 hover:bg-gray-100 hover:text-green-800' }} block px-4 py-3 rounded-lg transition">
                    <i class="fas fa-ticket-alt mr-3"></i> Penjualan Tiket
                </a>
            </nav>

            <div class="px-4 py-4 border-t">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MAIN -->
<main class="flex-1 transition-all duration-200 pb-16 md:pb-0" :class="{ 'blur-sm': showSidebar }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @hasSection('page-title')
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title')</h1>
            @hasSection('page-description')
                <p class="text-sm text-gray-600 mt-1">@yield('page-description')</p>
            @endif
        </div>
        @endif

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            @yield('content')
        </div>
    </div>
</main>

<!-- MOBILE BOTTOM NAVIGATION -->
<nav class="fixed bottom-0 inset-x-0 bg-white border-t shadow md:hidden z-20">
    <div class="flex justify-around">
        <a href="{{ url('user/transaksi') }}" 
           class="{{ request()->is('user/transaksi*') ? 'text-green-800 bg-green-50 bottom-nav-active' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 transition-all duration-200 flex-1">
            <i class="fas fa-shopping-cart text-lg mb-1"></i>
            <span class="text-xs font-medium">Transaksi</span>
        </a>
        <a href="{{ route('user.data.index') }}" 
           class="{{ request()->is('data*') ? 'text-green-800 bg-green-50 bottom-nav-active' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 transition-all duration-200 flex-1">
            <i class="fas fa-box text-lg mb-1"></i>
            <span class="text-xs font-medium">Barang</span>
        </a>
        <a href="{{ route('user.nota.notaHarian') }}" 
           class="{{ request()->is('user/nota/nota-harian*') ? 'text-green-800 bg-green-50 bottom-nav-active' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 transition-all duration-200 flex-1">
            <i class="fas fa-receipt text-lg mb-1"></i>
            <span class="text-xs font-medium">Nota</span>
        </a>
        <a href="{{ route('user.tickets.create') }}" 
           class="{{ request()->is('user/tickets/*') ? 'text-green-800 bg-green-50 bottom-nav-active' : 'text-gray-500' }} flex flex-col items-center justify-center p-3 transition-all duration-200 flex-1">
            <i class="fas fa-ticket-alt text-lg mb-1"></i>
            <span class="text-xs font-medium">Tiket</span>
        </a>
    </div>
</nav>
</div>

<style>
[x-cloak] { display: none !important; }
button, a { transition: all 0.2s ease; touch-action: manipulation; }
button:active, a:active { transform: scale(0.98); }

/* Enhanced mobile bottom nav styling */
@media (max-width: 768px) {
    .bottom-nav-active {
        position: relative;
    }
    .bottom-nav-active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background: #166534; /* Green-800 */
        border-radius: 0 0 2px 2px;
    }
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