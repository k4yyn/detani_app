@extends('layouts.admin')

@section('content')


<div>
    <!-- Main Content Container -->
    <div class="max-w-9x1 mx-auto px-4 sm:px-2 lg:px-6 py-2">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div class="space-y-2">
                <h1 class="text-3xl sm:text-4xl font-bold text-green-900">
                    Dashboard Admin
                </h1>
                <p class="text-gray-600 text-sm sm:text-base">Ringkasan transaksi dan penjualan hari ini</p>
            </div>
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white border border-green-200 shadow-sm">
                <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                <i class="far fa-calendar-alt text-orange-500"></i>
                <span class="font-medium text-green-800">{{ now()->isoFormat('D MMMM Y') }}</span>
            </div>
        </div>

        <hr class="w-full h-px bg-green-200 border-0 mb-10">

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Transaksi Card -->
            <div class="p-5 rounded-xl bg-white border border-green-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-orange-500 uppercase tracking-wider mb-2">Total Transaksi</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-green-900">{{ $totalTransaksiHariIni }}</h3>
                            @if($kenaikan['transaksi'] > 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-green-100">
                                <i class="fas fa-arrow-up text-green-700 text-xs"></i>
                                <span class="text-xs font-semibold text-green-700">{{ round($kenaikan['transaksi'], 1) }}%</span>
                            </div>
                            @elseif($kenaikan['transaksi'] < 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-red-100">
                                <i class="fas fa-arrow-down text-red-600 text-xs"></i>
                                <span class="text-xs font-semibold text-red-600">{{ abs(round($kenaikan['transaksi'], 1)) }}%</span>
                            </div>
                            @else
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-100">
                                <i class="fas fa-equals text-yellow-600 text-xs"></i>
                                <span class="text-xs font-semibold text-yellow-600">0%</span>
                            </div>
                            @endif
                        </div>
                        <p class="text-gray-500 text-xs mt-2">dari kemarin</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-receipt text-green-700"></i>
                    </div>
                </div>
            </div>
            
            <!-- Pendapatan Card -->
            <div class="p-5 rounded-xl bg-white border border-green-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-orange-500 uppercase tracking-wider mb-2">Pendapatan</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-green-900">@currency($pendapatanHariIni)</h3>
                            @if($kenaikan['pendapatan'] > 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-green-100">
                                <i class="fas fa-arrow-up text-green-700 text-xs"></i>
                                <span class="text-xs font-semibold text-green-700">{{ round($kenaikan['pendapatan'], 1) }}%</span>
                            </div>
                            @elseif($kenaikan['pendapatan'] < 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-red-100">
                                <i class="fas fa-arrow-down text-red-600 text-xs"></i>
                                <span class="text-xs font-semibold text-red-600">{{ abs(round($kenaikan['pendapatan'], 1)) }}%</span>
                            </div>
                            @else
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-100">
                                <i class="fas fa-equals text-yellow-600 text-xs"></i>
                                <span class="text-xs font-semibold text-yellow-600">0%</span>
                            </div>
                            @endif
                        </div>
                        <p class="text-gray-500 text-xs mt-2">dari kemarin</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-coins text-orange-500"></i>
                    </div>
                </div>
            </div>
            
            <!-- Produk Terjual Card -->
            <div class="p-5 rounded-xl bg-white border border-green-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-orange-500 uppercase tracking-wider mb-2">Produk Terjual</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-green-900">{{ $produkTerjualHariIni }}</h3>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-100">
                                <i class="fas fa-arrow-up text-yellow-600 text-xs"></i>
                                <span class="text-xs font-semibold text-yellow-600">5%</span>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">dari kemarin</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-shopping-basket text-blue-500"></i>
                    </div>
                </div>
            </div>
            
            <!-- Rata-rata Transaksi Card -->
            <div class="p-5 rounded-xl bg-white border border-green-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-orange-500 uppercase tracking-wider mb-2">Rata Transaksi</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-green-900">@currency($rataTransaksiHariIni)</h3>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-green-100">
                                <i class="fas fa-equals text-green-700 text-xs"></i>
                                <span class="text-xs font-semibold text-green-700">Stabil</span>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">konsisten</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-yellow-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Transaksi Hari Ini -->
            <div class="lg:col-span-2">
                <div class="rounded-xl bg-white border border-green-200 shadow-sm overflow-hidden">
                    <!-- Header -->
                    <div class="border-b border-green-200 p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="font-bold text-lg text-green-900">Transaksi Hari Ini</h3>
                            <p class="text-gray-600 text-sm">Daftar transaksi terbaru</p>
                        </div>
                        <a href="{{ route('admin.reports.daily') }}" class="px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition-colors duration-300 text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-filter text-xs"></i>
                            <span>Lihat Laporan</span>
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="py-3 px-4 text-left font-semibold text-gray-700 uppercase tracking-wider text-xs">ID Transaksi</th>
                                    <th class="py-3 px-4 text-left font-semibold text-gray-700 uppercase tracking-wider text-xs">Waktu</th>
                                    <th class="py-3 px-4 text-left font-semibold text-gray-700 uppercase tracking-wider text-xs">Total</th>
                                    <th class="py-3 px-4 text-left font-semibold text-gray-700 uppercase tracking-wider text-xs">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-green-100">
                                @forelse($transaksiTerbaru as $transaksi)
                                <tr class="hover:bg-green-50 transition-colors duration-200">
                                    <td class="py-3 px-4 font-medium text-green-900 text-sm">#{{ $transaksi->kode_transaksi }}</td>
                                    <td class="py-3 px-4 text-gray-600 text-sm">
                                        <span class="text-xs">{{ $transaksi->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-green-900 text-sm">@currency($transaksi->total_harga)</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            {{$transaksi->status_pembayaran ?? '-'}}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500 text-sm">
                                        Belum ada transaksi hari ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                
                    <!-- Footer -->
                    <div class="border-t border-green-200 p-4 text-center">
                        <a href="{{ route('admin.reports.daily') }}" class="px-4 py-2 rounded-lg font-medium text-blue-700 hover:text-blue-800 transition-colors duration-300 text-sm flex items-center justify-center gap-2 mx-auto">
                            <span>Lihat Semua Transaksi</span>
                            <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Produk Terlaris -->
            <div class="space-y-6">
                <div class="rounded-xl bg-white border border-green-200 shadow-sm overflow-hidden">
                    <!-- Header -->
                    <div class="border-b border-green-200 p-5">
                        <h3 class="font-bold text-lg text-green-900">Produk Terlaris</h3>
                        <p class="text-gray-600 text-sm">Hari ini</p>
                    </div>
                    <!-- Product List -->
                    <div class="p-4 space-y-3">
                        @forelse($produkTerlaris as $produk)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-green-50 hover:bg-green-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-box text-green-700"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-green-900 text-sm">{{ $produk->name }}</p>
                                    <p class="text-gray-600 text-xs">{{ $produk->sold }} terjual</p>
                                </div>
                            </div>
                            <span class="font-semibold text-green-900 text-sm">@currency($produk->revenue)</span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500 text-sm">
                            Belum ada produk terjual hari ini
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection