{{-- resources/views/user/stock-kantin/dashboard.blade.php --}}
@extends('layouts.user')

@section('content')
<div class="min-h-screen py-4 md:py-8 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-lg md:rounded-xl shadow-md border border-gray-200 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-green-700 to-green-600 px-4 sm:px-6 lg:px-8 py-5 md:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span>Dashboard Stock Kantin 1</span>
                        </h1>
                        <p class="text-green-50 mt-1.5 text-sm sm:text-base">Kelola stock kantin dengan mudah</p>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-white/20 backdrop-blur-sm text-white rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ now()->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if(\App\Models\Data::sum('stock_kantin1') == 0)
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-l-4 border-orange-500 rounded-lg p-4 sm:p-5 mb-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex items-start flex-1">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-base sm:text-lg font-semibold text-orange-900">Setup Awal Diperlukan!</h3>
                        <p class="text-orange-800 text-sm sm:text-base mt-0.5">Stock kantin 1 belum disetup. Klik tombol di bawah untuk setup otomatis.</p>
                    </div>
                </div>
                <a href="{{ route('user.stock-kantin.auto-setup') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-all duration-200 hover:shadow-md text-sm sm:text-base whitespace-nowrap">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Setup Otomatis
                </a>
            </div>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 mb-6">
            <!-- Total Barang di Kantin -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-200 p-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Barang di Kantin</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $barangKantin1->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stok Rendah -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-200 p-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Stok Rendah</p>
                        <p class="text-2xl sm:text-3xl font-bold text-orange-600 mt-1">{{ $stokRendah }}</p>
                    </div>
                </div>
            </div>

            <!-- Stok Habis -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-200 p-5 sm:p-6 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Stok Habis</p>
                        <p class="text-2xl sm:text-3xl font-bold text-red-600 mt-1">{{ $stokHabis }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5 mb-6">
            <!-- Verifikasi Stock -->
            <a href="{{ route('user.stock-kantin.verifikasi') }}" 
               class="bg-white rounded-lg shadow-sm hover:shadow-md border border-gray-200 p-4 sm:p-5 transition-all duration-200 hover:scale-105 group">
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-100 rounded-xl flex items-center justify-center mx-auto group-hover:bg-green-200 transition-colors">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mt-3">Verifikasi Stock</p>
                    <p class="text-sm sm:text-base font-semibold text-gray-900 mt-0.5">Cek Fisik</p>
                </div>
            </a>

            <!-- Transfer Stock -->
            <a href="{{ route('user.stock-kantin.transfer') }}" 
               class="bg-white rounded-lg shadow-sm hover:shadow-md border border-gray-200 p-4 sm:p-5 transition-all duration-200 hover:scale-105 group">
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto group-hover:bg-blue-200 transition-colors">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mt-3">Transfer Stock</p>
                    <p class="text-sm sm:text-base font-semibold text-gray-900 mt-0.5">Dari Gudang</p>
                </div>
            </a>

            <!-- Laporan -->
            <a href="{{ route('user.stock-kantin.laporan') }}" 
               class="bg-white rounded-lg shadow-sm hover:shadow-md border border-gray-200 p-4 sm:p-5 transition-all duration-200 hover:scale-105 group">
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-100 rounded-xl flex items-center justify-center mx-auto group-hover:bg-purple-200 transition-colors">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mt-3">Laporan</p>
                    <p class="text-sm sm:text-base font-semibold text-gray-900 mt-0.5">Harian</p>
                </div>
            </a>

            <!-- Data Barang -->
            <a href="{{ route('user.data.index') }}" 
               class="bg-white rounded-lg shadow-sm hover:shadow-md border border-gray-200 p-4 sm:p-5 transition-all duration-200 hover:scale-105 group">
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-100 rounded-xl flex items-center justify-center mx-auto group-hover:bg-gray-200 transition-colors">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600 mt-3">Data Barang</p>
                    <p class="text-sm sm:text-base font-semibold text-gray-900 mt-0.5">Lihat Semua</p>
                </div>
            </a>
        </div>

        <!-- Barang Stok Rendah Alert -->
        @if($stokRendah > 0)
        <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-l-4 border-orange-500 rounded-lg p-4 sm:p-5 mb-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex items-start flex-1">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-base sm:text-lg font-semibold text-orange-900">Stok Rendah!</h3>
                        <p class="text-orange-800 text-sm sm:text-base mt-0.5">Ada {{ $stokRendah }} barang yang stoknya hampir habis. Segera transfer dari gudang.</p>
                    </div>
                </div>
                <a href="{{ route('user.stock-kantin.transfer') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-medium transition-all duration-200 hover:shadow-md text-sm whitespace-nowrap">
                    Transfer Sekarang
                </a>
            </div>
        </div>
        @endif

        <!-- Daftar Barang di Kantin 1 -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Barang di Kantin 1</h2>
                <p class="text-sm text-gray-600 mt-0.5">Stock yang tersedia untuk penjualan</p>
            </div>
            
            @if($barangKantin1->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($barangKantin1 as $item)
                    <div class="p-4 sm:p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 text-base sm:text-lg">{{ $item->nama_barang }}</h3>
                                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1.5 text-sm text-gray-600">
                                            <span class="inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                {{ $item->codetrx }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                {{ $item->kategori }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Info & Action -->
                            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 sm:gap-4">
                                <div class="text-center min-w-[100px]">
                                    <span class="block text-xs font-medium text-gray-600 mb-1.5">Stock Kantin</span>
                                    <span class="inline-block px-3 py-1.5 rounded-lg font-semibold text-sm
                                        @if($item->stock_kantin1 > $item->min_stock_kantin1) bg-green-100 text-green-800
                                        @elseif($item->stock_kantin1 > 0) bg-orange-100 text-orange-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $item->stock_kantin1 }} unit
                                    </span>
                                </div>
                                
                                <div class="text-center min-w-[100px]">
                                    <span class="block text-xs font-medium text-gray-600 mb-1.5">Stock Gudang</span>
                                    <span class="inline-block px-3 py-1.5 bg-blue-100 text-blue-800 rounded-lg font-semibold text-sm">
                                        {{ $item->stock_gudang }} unit
                                    </span>
                                </div>

                                @if($item->stock_kantin1 <= $item->min_stock_kantin1)
                                <a href="{{ route('user.stock-kantin.transfer') }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-all duration-200 hover:shadow-md text-sm font-medium whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Stock
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 sm:p-12 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">Belum ada barang di kantin 1</h3>
                    <p class="text-gray-600 text-sm sm:text-base mb-6 max-w-md mx-auto">Transfer barang dari gudang untuk mulai penjualan</p>
                    <a href="{{ route('user.stock-kantin.transfer') }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md text-sm sm:text-base font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Transfer dari Gudang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection