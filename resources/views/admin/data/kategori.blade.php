@extends('layouts.admin')

@section('content')
<div>
    <div class="max-w-9x1 mx-auto px-4 sm:px-2 lg:px-6 py-2">
        
        <!-- Header -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-200 mb-6 md:mb-8 overflow-hidden">
            <div class="bg-green-800 px-4 sm:px-6 md:px-8 py-4 md:py-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-2xl font-semibold text-white flex items-center group">
                            <svg class="w-6 h-6 sm:w-8 md:w-10 h-8 md:h-10 mr-2 sm:mr-3 md:mr-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="relative">
                                <span class="block sm:hidden">Kategori Barang</span>
                                <span class="hidden sm:block">Manajemen Kategori Barang</span>
                                <span class=""></span>
                            </span>
                        </h1>
                        <p class="text-gray-300 mt-1 sm:mt-2 text-sm sm:text-base md:text-md">
                            <span class="hidden sm:inline">Kelola kategori barang/jasa dengan mudah dan efisien</span>
                            <span class="sm:hidden">Kelola kategori barang</span>
                        </p>
                    </div>
                
                        <a href="{{ route('admin.data.create') }}"
                       class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-green-700 hover:bg-green-900 text-white font-medium sm:font-semibold text-sm sm:text-base rounded-lg md:rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 group">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="hidden sm:inline">Tambah Data</span>
                        <span class="sm:hidden">Tambah Data</span>
                    </a>
    
                </div>
            </div>
        </div> 

        <!-- List Kategori -->
        <div class="space-y-3 sm:space-y-4">
            @forelse ($kategoris as $kategori)
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-200">
                    <a href="{{ route('admin.data.by-kategori', $kategori->kategori) }}" class="block">
                        <div class="p-4 sm:p-5 md:p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between space-x-3 sm:space-x-4">
                                <!-- Category Info -->
                                <div class="flex items-center space-x-3 sm:space-x-4 flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-green-800 rounded-lg md:rounded-xl flex items-center justify-center">
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
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-10 md:p-12 text-center">
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