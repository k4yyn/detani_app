@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-4 lg:py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 lg:mb-8 overflow-hidden">
            <div class="bg-green-800 px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white flex items-center group">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 mr-3 sm:mr-4 transform transition-transform duration-300 group-hover:rotate-12 flex-shrink-0" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="relative break-words">
                                {{ ucfirst($kategori) }}
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white/30 transition-all duration-300 group-hover:w-full"></span>
                            </span>
                        </h1>
                        <p class="text-blue-100 mt-2 text-base sm:text-lg">Daftar produk kategori {{ $kategori }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-white/20 rounded-lg px-3 py-2 sm:p-3">
                            <span class="text-white font-semibold text-sm sm:text-lg">{{ $data->count() }} Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-6 lg:mb-8">
            <div class="flex flex-col space-y-4 lg:space-y-0 lg:flex-row lg:gap-4 lg:items-center lg:justify-between">
                <!-- Back Button -->
                <div class="order-1 lg:order-1">
                    <a href="{{ route('admin.data.index') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="whitespace-nowrap">Kembali</span>
                    </a>
                </div>

                <!-- Search Form -->
                <div class="order-3 lg:order-2 flex-1 lg:max-w-2xl">
                    <form action="{{ route('admin.data.by-kategori', $kategori) }}" method="GET" class="w-full">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <div class="relative flex-1">
                                @if(request('search'))
                                <button type="button"
                                    onclick="window.location.href='{{ route('admin.data.by-kategori', $kategori) }}'"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-700 z-10 transition-colors"
                                    title="Hapus pencarian"
                                    aria-label="Hapus pencarian">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                </button>
                                @else
                                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-600 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                @endif
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari dalam kategori {{ $kategori }}..."
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400 text-sm sm:text-base"
                                />
                            </div>
                            <button
                                type="submit"
                                class="px-4 sm:px-6 py-3 bg-green-800 hover:bg-green-900 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 whitespace-nowrap"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="hidden sm:inline">Cari</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Add Button -->
                <div class="order-2 lg:order-3">
                    <a href="{{ route('admin.data.create') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-green-800 hover:bg-green-900 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="whitespace-nowrap">Tambah Data</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Product List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 lg:mb-8">
            @if($data->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach ($data as $item)
                        <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors">
                            <!-- Mobile Layout -->
                            <div class="block lg:hidden space-y-4">
                                <!-- Product Header -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-green-800 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-bold text-gray-900 text-lg break-words">{{ $item->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">Kode: {{ $item->codetrx }}</div>
                                        @if($item->deskripsi)
                                            <div class="text-sm text-gray-600 mt-1 break-words">{{ Str::limit($item->deskripsi, 100) }}</div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Product Details Grid -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Stok</span>
                                        <span class="block px-2 py-1 rounded-full text-xs text-center font-medium
                                            @if($item->stok > 30) bg-green-100 text-green-800
                                            @elseif($item->stok > 5) bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ $item->stok }} unit
                                        </span>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Lokasi</span>
                                        <span class="block text-sm text-gray-600 break-words">{{ $item->lokasi_penyimpanan }}</span>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Harga Pokok</span>
                                        <span class="block text-sm text-gray-600">Rp {{ number_format($item->harga_pokok, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Harga Jual</span>
                                        <span class="block text-sm text-green-800 font-semibold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-2 pt-2">
                                    <a href="{{ route('admin.data.edit', $item->id) }}"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition transform hover:scale-105"
                                        title="Edit">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.data.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $item->nama_barang }}?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-700 hover:bg-red-800 text-white text-sm font-medium rounded-lg transition transform hover:scale-105"
                                            title="Hapus">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Desktop Layout -->
                            <div class="hidden lg:flex lg:items-center lg:justify-between">
                                <div class="flex items-center space-x-4 flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-12 h-12 bg-green-800 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-gray-900 text-lg truncate">{{ $item->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">Kode: {{ $item->codetrx }}</div>
                                        @if($item->deskripsi)
                                            <div class="text-sm text-gray-600 mt-1 truncate">{{ Str::limit($item->deskripsi, 100) }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-6 xl:space-x-8 text-sm flex-shrink-0">
                                    <div class="text-center">
                                        <div class="font-medium text-gray-700 text-xs uppercase tracking-wide mb-1">Stok</div>
                                        <span class="inline-block px-3 py-1 rounded-full text-center font-medium
                                            @if($item->stok > 30) bg-green-100 text-green-800
                                            @elseif($item->stok > 5) bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ $item->stok }} unit
                                        </span>
                                    </div>
                                    <div class="text-center min-w-0">
                                        <div class="font-medium text-gray-700 text-xs uppercase tracking-wide mb-1">Harga Pokok</div>
                                        <div class="text-gray-600 truncate">Rp {{ number_format($item->harga_pokok, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="text-center min-w-0">
                                        <div class="font-medium text-gray-700 text-xs uppercase tracking-wide mb-1">Harga Jual</div>
                                        <div class="text-green-800 font-semibold truncate">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="text-center min-w-0 max-w-32">
                                        <div class="font-medium text-gray-700 text-xs uppercase tracking-wide mb-1">Lokasi</div>
                                        <div class="text-gray-600 text-sm truncate" title="{{ $item->lokasi_penyimpanan }}">{{ $item->lokasi_penyimpanan }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2 ml-6">
                                    <a href="{{ route('admin.data.edit', $item->id) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition transform hover:scale-105"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.data.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $item->nama_barang }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-10 h-10 bg-red-700 hover:bg-red-800 text-white rounded-lg transition transform hover:scale-105"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 sm:p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2-2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
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
                        <a href="{{ route('admin.data.by-kategori', $kategori) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-800 hover:bg-green-900 text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hapus Filter
                        </a>
                    @else
                        <a href="{{ route('admin.data.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-800 hover:bg-green-900 text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Produk
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Summary Cards -->
        @if($data->count() > 0)
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-red-700 truncate">Total Produk</p>
                        <p class="text-xl sm:text-2xl font-bold text-green-800">{{ $data->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-red-700 truncate">Total Stok</p>
                        <p class="text-xl sm:text-2xl font-bold text-green-800">{{ $data->sum('stok') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-red-700 truncate">Nilai Stok</p>
                        <p class="text-sm sm:text-2xl font-bold text-green-800 truncate" title="Rp {{ number_format($data->sum(function($item) { return $item->stok * $item->harga_pokok; }), 0, ',', '.') }}">
                            Rp {{ number_format($data->sum(function($item) { return $item->stok * $item->harga_pokok; }), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-red-700 truncate">Rata-rata Harga</p>
                        <p class="text-sm sm:text-2xl font-bold text-green-800 truncate" title="Rp {{ number_format($data->avg('harga_jual'), 0, ',', '.') }}">
                            Rp {{ number_format($data->avg('harga_jual'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection