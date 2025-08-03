@extends('layouts.user')

@section('content')
<div class="min-h-screen py-8">
<div class="container mx-auto px-4 max-w-7xl">

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl border border-amber-100 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
            <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center gap-3">
                <svg class="w-10 h-10 transform transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Data Barang
            </h1>
            <p class="text-amber-100 mt-2">Lihat data barang di sini</p>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-2xl shadow-xl border border-amber-100 p-6 mb-8 flex flex-col lg:flex-row gap-4 justify-between">
        <form action="{{ route('user.data.index') }}" method="GET" class="flex-grow max-w-xl">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, kode, lokasi..."
                    class="w-full pl-10 pr-4 py-2 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                >
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-amber-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-amber-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-amber-500 to-orange-500">
                        <th class="px-4 py-2 text-white text-sm">No</th>
                        <th class="px-4 py-2 text-white text-sm">Kode</th>
                        <th class="px-4 py-2 text-white text-sm">Nama</th>
                        <th class="px-4 py-2 text-white text-sm">Stok</th>
                        <th class="px-4 py-2 text-white text-sm">Harga Jual</th>
                        <th class="px-4 py-2 text-white text-sm">Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100">
                    @forelse ($data as $item)
                    <tr class="hover:bg-amber-50">
                        <td class="px-4 py-2 text-sm">{{ $loop->iteration + ($data->perPage() * ($data->currentPage() - 1)) }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded bg-amber-100 text-amber-700 text-xs font-semibold">{{ $item->codetrx }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $item->nama_barang }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($item->stok > 30) bg-green-100 text-green-700
                                @elseif($item->stok > 5) bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700
                                @endif">{{ $item->stok }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm">{{ $item->lokasi_penyimpanan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data barang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($data->hasPages())
    <div class="mt-6">
        {{ $data->withQueryString()->links() }}
    </div>
    @endif
</div>
</div>

<style>
.pagination {
    @apply flex gap-1 justify-center mt-4;
}
.pagination .page-link {
    @apply px-3 py-1 text-sm bg-white border border-amber-200 rounded hover:bg-amber-50;
}
.pagination .page-item.active .page-link {
    @apply bg-gradient-to-r from-amber-500 to-orange-500 text-white;
}
.pagination .page-item.disabled .page-link {
    @apply text-gray-400 bg-gray-50;
}
</style>
@endsection
