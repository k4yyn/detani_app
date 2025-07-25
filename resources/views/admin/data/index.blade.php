@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl border border-indigo-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-500 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center group">
                            <svg class="w-10 h-10 mr-4 transform transition-transform duration-300 group-hover:rotate-12" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="relative">
                                Daftar Barang
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white/30 transition-all duration-300 group-hover:w-full"></span>
                            </span>
                        </h1>
                        <p class="text-indigo-100 mt-2 text-lg">Kelola inventaris barang dengan mudah dan efisien</p>
                    </div>
                    <div class="hidden lg:flex items-center space-x-4">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-2xl shadow-xl border border-indigo-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <a href="{{ route('admin.dashboard') }}"
                   class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>

                <form action="{{ route('admin.data.index') }}" method="GET" class="flex-grow max-w-2xl w-full">
                    <div class="flex items-center gap-3">
                        <div class="relative flex-grow">
                            @if(request('search'))
                            <a href="{{ route('admin.data.index') }}"
                               class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 z-10 transition-colors"
                               title="Hapus pencarian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                            @else
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            @endif
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari berdasarkan nama, kode, atau lokasi..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-indigo-300"
                            />
                        </div>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.data.create') }}"
                   class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Data
                </a>
            </div>
        </div>

        <!-- Daftar Barang Berdasarkan Kategori -->
        <div class="space-y-10">
            @forelse ($groupedData as $kategori => $items)
                <div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
                    <div class="bg-indigo-50 border-b border-indigo-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-indigo-700">{{ $kategori }}</h2>
                    </div>
                    <div class="divide-y divide-indigo-100">
                        @foreach ($items as $item)
                            <div class="flex flex-col md:flex-row md:items-center justify-between px-6 py-4 hover:bg-indigo-50 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-indigo-400 to-blue-400 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $item->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">Kode: {{ $item->codetrx }}</div>
                                    </div>
                                </div>
                                <div class="mt-2 md:mt-0 flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-6 text-sm">
                                    <div>
                                        <span class="font-medium">Stok:</span>
                                        <span class="inline-block px-3 py-1 rounded-full
                                            @if($item->stok > 30) bg-green-100 text-green-800
                                            @elseif($item->stok > 5) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ $item->stok }} unit
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Harga Jual:</span>
                                        <span class="text-gray-800">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Lokasi:</span>
                                        <span class="text-gray-700">{{ $item->lokasi_penyimpanan }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 flex space-x-2">
                                    <a href="{{ route('admin.data.edit', $item->id) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white rounded-lg transition transform hover:scale-105"
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
                                            class="inline-flex items-center justify-center w-9 h-9 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition transform hover:scale-105"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-500">Tidak ada data barang ditemukan.</div>
            @endforelse
        </div>

    </div>
</div>
@endsection
