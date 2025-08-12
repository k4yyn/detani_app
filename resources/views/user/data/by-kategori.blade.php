@extends('layouts.user')

@section('content')
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center group">
                            <svg class="w-10 h-10 mr-4 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="relative">
                                {{ ucfirst($kategori) }}
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white/30 transition-all duration-300 group-hover:w-full"></span>
                            </span>
                        </h1>
                        <p class="text-amber-100 mt-2 text-lg">Daftar produk kategori {{ $kategori }}</p>
                    </div>
                    <div class="hidden lg:flex items-center space-x-4">
                        <div class="bg-white/20 rounded-lg p-3">
                            <span class="text-white font-semibold text-lg">{{ $data->count() }} Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <a href="{{ route('user.data.index') }}"
                   class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>

                <form action="{{ route('user.data.by-kategori', $kategori) }}" method="GET" class="flex-grow max-w-2xl w-full">
                    <div class="flex items-center gap-3">
                        <div class="relative flex-grow">
                            @if(request('search'))
                            <a href="{{ route('user.data.by-kategori', $kategori) }}"
                               class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 z-10 transition-colors"
                               title="Hapus pencarian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                            @else
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 text-amber-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            @endif
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari dalam kategori {{ $kategori }}..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300"
                            />
                        </div>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 overflow-hidden">
            @if($data->count() > 0)
                <div class="divide-y divide-amber-100">
                    @foreach ($data as $item)
                        <div class="flex flex-col md:flex-row md:items-center justify-between px-6 py-5 hover:bg-amber-50 transition">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-amber-400 to-orange-400 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-lg">{{ $item->nama_barang }}</div>
                                    <div class="text-sm text-gray-500">Kode: {{ $item->codetrx }}</div>
                                    @if($item->deskripsi)
                                        <div class="text-sm text-gray-600 mt-1">{{ Str::limit($item->deskripsi, 100) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-8 text-sm">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-700">Stok:</span>
                                    <span class="inline-block px-3 py-1 rounded-full text-center
                                        @if($item->stok > 30) bg-green-100 text-green-800
                                        @elseif($item->stok > 5) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        {{ $item->stok }} unit
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-700">Harga Pokok:</span>
                                    <span class="text-gray-600">Rp {{ number_format($item->harga_pokok, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-700">Harga Jual:</span>
                                    <span class="text-green-600 font-semibold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-700">Lokasi:</span>
                                    <span class="text-gray-600">{{ $item->lokasi_penyimpanan }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        @if(request('search'))
                            Tidak ada hasil pencarian
                        @else
                            Belum ada produk di kategori {{ $kategori }}
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-4">
                        @if(request('search'))
                            Coba kata kunci yang berbeda atau hapus filter pencarian
                        @else
                            Tambahkan produk pertama untuk kategori ini
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('user.data.by-kategori', $kategori) }}" 
                           class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hapus Filter
                        </a>
                    @else
                    @endif
                </div>
            @endif
        </div>

        <!-- Summary Card - IMPROVED RESPONSIVE LAYOUT -->
        @if($data->count() > 0)
        <div class="mt-8">
            <!-- Mobile: 1 column, SM: 2 columns, MD: 2 columns, LG+: 4 columns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Card 1: Total Produk -->
                <div class="bg-white rounded-xl shadow-lg border border-amber-100 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Produk</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $data->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Stok -->
                <div class="bg-white rounded-xl shadow-lg border border-green-100 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Stok</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ number_format($data->sum('stok')) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Nilai Stok -->
                <div class="bg-white rounded-xl shadow-lg border border-yellow-100 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Nilai Stok</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                                Rp {{ number_format($data->sum(function($item) { return $item->stok * $item->harga_pokok; }), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Rata-rata Harga -->
                <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-4 sm:p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Rata-rata Harga</p>
                            <p class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                                Rp {{ number_format($data->avg('harga_jual'), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection