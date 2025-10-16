{{-- resources/views/user/stock-kantin/laporan.blade.php --}}
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Laporan Stock Kantin 1</span>
                        </h1>
                        <p class="text-green-50 mt-1.5 text-sm sm:text-base">Rekap aktivitas stock harian</p>
                    </div>
                    <a href="{{ route('user.stock-kantin.dashboard') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg transition-colors text-sm font-medium whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Date Filter & Summary -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-5 lg:p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-end gap-5">
                <!-- Date Filter -->
                <div class="flex-1">
                    <form action="{{ route('user.stock-kantin.laporan') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Laporan</label>
                            <input type="date" name="tanggal" value="{{ $tanggal }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition-all duration-200 hover:shadow-md font-medium text-sm">
                                Tampilkan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Summary -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    <div class="text-center p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                        <div class="text-xl sm:text-2xl font-bold text-blue-700">{{ $summary['total_verifikasi'] }}</div>
                        <div class="text-xs font-medium text-blue-600 mt-1">Verifikasi</div>
                    </div>
                    <div class="text-center p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-lg border border-green-200">
                        <div class="text-xl sm:text-2xl font-bold text-green-700">{{ $summary['total_match'] }}</div>
                        <div class="text-xs font-medium text-green-600 mt-1">Match</div>
                    </div>
                    <div class="text-center p-3 bg-gradient-to-br from-red-50 to-red-100 rounded-lg border border-red-200">
                        <div class="text-xl sm:text-2xl font-bold text-red-700">{{ $summary['total_selisih'] }}</div>
                        <div class="text-xs font-medium text-red-600 mt-1">Selisih</div>
                    </div>
                    <div class="text-center p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                        <div class="text-xl sm:text-2xl font-bold text-purple-700">{{ $summary['total_transfer'] }}</div>
                        <div class="text-xs font-medium text-purple-600 mt-1">Transfer</div>
                    </div>
                    <div class="text-center p-3 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg border border-orange-200 col-span-2 sm:col-span-1">
                        <div class="text-xl sm:text-2xl font-bold text-orange-700">{{ $summary['total_penjualan'] }}</div>
                        <div class="text-xs font-medium text-orange-600 mt-1">Terjual</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">
            <!-- Verifikasi Stock -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="px-4 sm:px-5 py-3.5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-green-100">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span>Hasil Verifikasi Stock</span>
                    </h2>
                </div>

                @if($verifikasi->count() > 0)
                    <div class="divide-y divide-gray-200 max-h-[400px] overflow-y-auto">
                        @foreach($verifikasi as $v)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $v->data->nama_barang }}</h4>
                                    <div class="grid grid-cols-3 gap-2 sm:gap-3 mt-2.5">
                                        <div class="text-center p-2 bg-blue-50 rounded-lg">
                                            <span class="block text-xs text-blue-600 font-medium mb-0.5">Sistem</span>
                                            <span class="block font-bold text-blue-800">{{ $v->stock_sistem }}</span>
                                        </div>
                                        <div class="text-center p-2 bg-purple-50 rounded-lg">
                                            <span class="block text-xs text-purple-600 font-medium mb-0.5">Fisik</span>
                                            <span class="block font-bold text-purple-800">{{ $v->stock_fisik }}</span>
                                        </div>
                                        <div class="text-center p-2 {{ $v->selisih == 0 ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                                            <span class="block text-xs {{ $v->selisih == 0 ? 'text-green-600' : 'text-red-600' }} font-medium mb-0.5">Selisih</span>
                                            <span class="block font-bold {{ $v->selisih == 0 ? 'text-green-800' : 'text-red-800' }}">
                                                {{ $v->selisih > 0 ? '+' : '' }}{{ $v->selisih }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($v->keterangan)
                                        <p class="text-xs sm:text-sm text-gray-600 mt-2 line-clamp-2">{{ $v->keterangan }}</p>
                                    @endif
                                </div>
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                    {{ $v->status == 'match' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $v->status == 'match' ? '✓ Match' : '✗ Selisih' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Verifikasi Summary -->
                    <div class="bg-gray-50 px-4 sm:px-5 py-3 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 text-sm">
                            <span class="text-gray-600">
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                    {{ $summary['total_match'] }} match
                                </span>
                                <span class="mx-2">•</span>
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></span>
                                    {{ $summary['total_selisih'] }} selisih
                                </span>
                            </span>
                            <span class="font-semibold text-gray-900">
                                Total: {{ $summary['total_verifikasi'] }} barang
                            </span>
                        </div>
                    </div>
                @else
                    <div class="p-8 sm:p-12 text-center">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">Belum ada verifikasi stock</p>
                    </div>
                @endif
            </div>

            <!-- Riwayat Transfer -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="px-4 sm:px-5 py-3.5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <span>Riwayat Transfer</span>
                    </h2>
                </div>

                @if($transfer->count() > 0)
                    <div class="divide-y divide-gray-200 max-h-[400px] overflow-y-auto">
                        @foreach($transfer as $t)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $t->data->nama_barang }}</h4>
                                    <div class="flex flex-wrap items-center gap-3 mt-2 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-800 rounded-lg font-semibold">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ $t->jumlah }} unit
                                        </span>
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $t->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500 mt-2 bg-blue-50 px-2.5 py-1 rounded inline-flex">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                        Gudang → Kantin 1
                                    </div>
                                    @if($t->keterangan)
                                        <p class="text-xs sm:text-sm text-gray-600 mt-2 line-clamp-2">{{ $t->keterangan }}</p>
                                    @endif
                                </div>
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 whitespace-nowrap">
                                    ✓ Selesai
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Transfer Summary -->
                    <div class="bg-gray-50 px-4 sm:px-5 py-3 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 text-sm">
                            <span class="text-gray-600">
                                {{ $summary['total_transfer'] }} transfer hari ini
                            </span>
                            <span class="font-semibold text-gray-900">
                                Total: {{ $summary['total_barang_transfer'] }} unit
                            </span>
                        </div>
                    </div>
                @else
                    <div class="p-8 sm:p-12 text-center">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">Belum ada transfer hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stock Malam Section -->
        @if(count($stockMalam) > 0)
        <div class="mt-6 bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="px-4 sm:px-5 py-3.5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <div>
                        <span>Stock Malam (Otomatis)</span>
                        <p class="text-xs font-normal text-purple-600 mt-0.5">Stock Pagi - Penjualan Hari Ini</p>
                    </div>
                </h2>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($stockMalam as $item)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="mb-3">
                        <h4 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $item['barang']->nama_barang }}</h4>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="text-center p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                            <div class="text-xs text-blue-600 font-medium mb-1">Stock Pagi</div>
                            <div class="font-bold text-blue-800 text-lg sm:text-xl">{{ $item['stock_pagi'] }}</div>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-red-50 to-red-100 rounded-lg border border-red-200">
                            <div class="text-xs text-red-600 font-medium mb-1">Terjual</div>
                            <div class="font-bold text-red-800 text-lg sm:text-xl">-{{ $item['terjual'] }}</div>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-lg border border-green-200">
                            <div class="text-xs text-green-600 font-medium mb-1">Stock Akhir</div>
                            <div class="font-bold text-green-800 text-lg sm:text-xl">{{ $item['stock_akhir'] }}</div>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                            <div class="text-xs text-gray-600 font-medium mb-1">Status</div>
                            <div class="font-bold text-base {{ $item['verifikasi']->status == 'match' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item['verifikasi']->status == 'match' ? '✓ Match' : '✗ Selisih' }}
                            </div>
                        </div>
                    </div>
                    @if($item['terjual'] > 0)
                    <div class="mt-2.5 text-xs text-gray-600 bg-orange-50 px-3 py-1.5 rounded-lg inline-flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        {{ $item['terjual'] }} unit terjual hari ini
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Stock Malam Summary -->
            <div class="bg-gray-50 px-4 sm:px-5 py-3 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 text-sm">
                    <span class="text-gray-600">
                        {{ count($stockMalam) }} barang • {{ $summary['total_penjualan'] }} unit terjual
                    </span>
                    <span class="font-semibold text-gray-900">
                        Stock Akhir: {{ array_sum(array_column($stockMalam, 'stock_akhir')) }} unit
                    </span>
                </div>
            </div>
        </div>

        <!-- Status Message -->
        <div class="mt-5 p-4 rounded-lg border
            @if($summary['total_selisih'] == 0) bg-gradient-to-r from-green-50 to-green-100 border-green-200
            @else bg-gradient-to-r from-orange-50 to-orange-100 border-orange-200 @endif">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if($summary['total_selisih'] == 0)
                    <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    @else
                    <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="ml-3 flex-1">
                    <span class="text-sm sm:text-base {{ $summary['total_selisih'] == 0 ? 'text-green-800' : 'text-orange-800' }} font-medium">
                        @if($summary['total_selisih'] == 0)
                            Semua stock match! 
                            @if($summary['total_penjualan'] > 0)
                            {{ $summary['total_penjualan'] }} unit terjual hari ini.
                            @endif
                            Operasional berjalan lancar.
                        @else
                            Ada {{ $summary['total_selisih'] }} barang dengan selisih stock. 
                            @if($summary['total_penjualan'] > 0)
                            {{ $summary['total_penjualan'] }} unit terjual hari ini.
                            @endif
                            Perlu pengecekan lebih lanjut.
                        @endif
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection