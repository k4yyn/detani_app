@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header Section -->
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

        <!-- Action Buttons & Search Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-indigo-100 p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Tombol Kembali -->
                <a href="{{ route('admin.dashboard') }}"
                   class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>

                <!-- Form Pencarian -->
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

                <!-- Tombol Tambah -->
                <a href="{{ route('admin.data.create') }}"
                   class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Data
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-500 to-blue-500">
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">No</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">Kode Barang</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">Nama Barang</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">Harga Pokok</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">Harga Jual</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-left tracking-wider">Lokasi</th>
                            <th class="px-6 py-4 text-white text-sm font-bold text-center tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-100">
                        @forelse ($data as $item)
                        <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50 transition-all duration-200 group">
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                {{ $loop->iteration + ($data->perPage() * ($data->currentPage() - 1)) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-blue-800 border border-indigo-200">
                                    {{ $item->codetrx }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-indigo-400 to-blue-400 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $item->nama_barang }}</div>
                                        @if($item->kategori)
                                        <div class="text-xs text-indigo-600">{{ $item->kategori }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    @if($item->stok > 30) bg-green-100 text-green-800 border border-green-200
                                    @elseif($item->stok > 5) bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @else bg-red-100 text-red-800 border border-red-200
                                    @endif">
                                    {{ $item->stok }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                Rp {{ number_format($item->harga_pokok, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $item->lokasi_penyimpanan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('admin.data.edit', $item->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white rounded-lg transition-all duration-200 transform hover:scale-110 group"
                                       title="Edit Data">
                                        <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.data.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('⚠️ Yakin ingin menghapus data barang \'{{ $item->nama_barang }}\'?\n\nData yang dihapus tidak dapat dikembalikan!')"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-200 transform hover:scale-110 group"
                                                title="Hapus Data">
                                            <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-20 h-20 bg-gradient-to-r from-indigo-100 to-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Belum Ada Data Barang</h3>
                                        <p class="text-gray-500 mb-4">Tambahkan data barang pertama untuk memulai inventaris</p>
                                        <a href="{{ route('admin.data.create') }}"
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Tambah Data Pertama
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($data->hasPages())
        <div class="mt-8 bg-white rounded-2xl shadow-xl border border-amber-100 p-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
                </div>
                <div class="pagination-wrapper">
                    {{ $data->withQueryString()->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.pagination-wrapper .pagination {
    @apply flex items-center space-x-1;
}

.pagination-wrapper .page-link {
    @apply px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-amber-50 hover:border-amber-300 hover:text-amber-600 transition-all duration-200;
}

.pagination-wrapper .page-item.active .page-link {
    @apply bg-gradient-to-r from-amber-500 to-orange-500 text-white border-amber-500 hover:from-amber-600 hover:to-orange-600;
}

.pagination-wrapper .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed hover:bg-white hover:border-gray-300 hover:text-gray-400;
}
</style>
@endsection
