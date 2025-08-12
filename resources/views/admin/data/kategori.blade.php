@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 md:py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg border border-blue-100 mb-6 md:mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-4 sm:px-6 md:px-8 py-4 md:py-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white flex items-center group">
                            <svg class="w-6 h-6 sm:w-8 md:w-10 h-8 md:h-10 mr-2 sm:mr-3 md:mr-4 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="relative">
                                <span class="block sm:hidden">Kategori Barang</span>
                                <span class="hidden sm:block">Manajemen Kategori Barang</span>
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white/30 transition-all duration-300 group-hover:w-full"></span>
                            </span>
                        </h1>
                        <p class="text-blue-100 mt-1 sm:mt-2 text-sm sm:text-base md:text-lg">
                            <span class="hidden sm:inline">Kelola kategori barang/jasa dengan mudah dan efisien</span>
                            <span class="sm:hidden">Kelola kategori barang</span>
                        </p>
                    </div>
                    <div class="hidden lg:flex items-center space-x-4">
                        <div class="bg-white/20 rounded-lg p-2 md:p-3">
                            <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg border border-blue-100 p-4 sm:p-5 md:p-6 mb-6 md:mb-8">
            <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:gap-4 md:items-center md:justify-between">
                <!-- Back Button -->
                <div class="w-full md:w-auto order-1 md:order-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg md:rounded-xl text-sm sm:text-base text-gray-700 font-medium sm:font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Add Button -->
                <div class="w-full md:w-auto order-2 md:order-3">
                    <a href="{{ route('admin.data.create') }}"
                       class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-medium sm:font-semibold text-sm sm:text-base rounded-lg md:rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 group">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="hidden sm:inline">Tambah Data</span>
                        <span class="sm:hidden">Tambah</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- List Kategori -->
        <div class="space-y-3 sm:space-y-4">
            @forelse ($kategoris as $kategori)
                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg border border-blue-100 overflow-hidden hover:shadow-xl transition-all duration-200">
                    <a href="{{ route('admin.data.by-kategori', $kategori->kategori) }}" class="block">
                        <div class="p-4 sm:p-5 md:p-6 hover:bg-blue-50 transition-colors">
                            <div class="flex items-center justify-between space-x-3 sm:space-x-4">
                                <!-- Category Info -->
                                <div class="flex items-center space-x-3 sm:space-x-4 flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-lg md:rounded-xl flex items-center justify-center">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 capitalize truncate">{{ $kategori->kategori }}</h3>
                                        <p class="text-xs sm:text-sm text-gray-500">{{ $kategori->jumlah_produk }} produk</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-1 sm:space-x-2 md:space-x-3 flex-shrink-0">            
                                    <!-- Delete Button -->
                                     <form action="{{ route('admin.data.destroy-kategori', $kategori->kategori) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 sm:p-2 text-red-600 hover:bg-red-100 rounded-md sm:rounded-lg transition-colors touch-manipulation" title="Hapus">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    
                                    <!-- Chevron Icon -->
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="bg-white rounded-xl md:rounded-2xl shadow-lg border border-blue-100 p-8 sm:p-10 md:p-12 text-center">
                    <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-1 sm:mb-2">Belum ada kategori</h3>
                    <p class="text-sm sm:text-base text-gray-500">Tambahkan produk pertama Anda untuk membuat kategori</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection