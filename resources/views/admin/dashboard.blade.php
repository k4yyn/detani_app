@extends('layouts.admin')

@section('content')
<!-- Main Container with Subtle Background -->
<div class="min-h-screen bg-slate-50">
    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div class="space-y-2">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-800">
                    Dashboard Admin
                </h1>
                <p class="text-slate-500 text-sm sm:text-base">Ringkasan transaksi dan penjualan hari ini</p>
            </div>
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white border border-slate-200 shadow-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                <i class="far fa-calendar-alt text-slate-400"></i>
                <span class="font-medium text-slate-700">{{ now()->isoFormat('D MMMM Y') }}</span>
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Transaksi Card -->
            <div class="p-5 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Transaksi</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $totalTransaksiHariIni }}</h3>
                            @if($kenaikan['transaksi'] > 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100">
                                <i class="fas fa-arrow-up text-emerald-600 text-xs"></i>
                                <span class="text-xs font-semibold text-emerald-600">{{ round($kenaikan['transaksi'], 1) }}%</span>
                            </div>
                            @elseif($kenaikan['transaksi'] < 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-red-100">
                                <i class="fas fa-arrow-down text-red-600 text-xs"></i>
                                <span class="text-xs font-semibold text-red-600">{{ abs(round($kenaikan['transaksi'], 1)) }}%</span>
                            </div>
                            @else
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-blue-100">
                                <i class="fas fa-equals text-blue-600 text-xs"></i>
                                <span class="text-xs font-semibold text-blue-600">0%</span>
                            </div>
                            @endif
                        </div>
                        <p class="text-slate-500 text-xs mt-2">dari kemarin</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-receipt text-purple-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- Pendapatan Card -->
            <div class="p-5 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pendapatan</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800">@currency($pendapatanHariIni)</h3>
                            @if($kenaikan['pendapatan'] > 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100">
                                <i class="fas fa-arrow-up text-emerald-600 text-xs"></i>
                                <span class="text-xs font-semibold text-emerald-600">{{ round($kenaikan['pendapatan'], 1) }}%</span>
                            </div>
                            @elseif($kenaikan['pendapatan'] < 0)
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-red-100">
                                <i class="fas fa-arrow-down text-red-600 text-xs"></i>
                                <span class="text-xs font-semibold text-red-600">{{ abs(round($kenaikan['pendapatan'], 1)) }}%</span>
                            </div>
                            @else
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-blue-100">
                                <i class="fas fa-equals text-blue-600 text-xs"></i>
                                <span class="text-xs font-semibold text-blue-600">0%</span>
                            </div>
                            @endif
                        </div>
                        <p class="text-slate-500 text-xs mt-2">dari kemarin</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-coins text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- Produk Terjual Card -->
            <div class="p-5 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Produk Terjual</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $produkTerjualHariIni }}</h3>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-blue-100">
                                <i class="fas fa-arrow-up text-blue-600 text-xs"></i>
                                <span class="text-xs font-semibold text-blue-600">5%</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-xs mt-2">dari kemarin</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-shopping-basket text-green-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- Rata-rata Transaksi Card -->
            <div class="p-5 rounded-xl bg-white border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Rata Transaksi</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl sm:text-3xl font-bold text-slate-800">@currency($rataTransaksiHariIni)</h3>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full bg-purple-100">
                                <i class="fas fa-equals text-purple-600 text-xs"></i>
                                <span class="text-xs font-semibold text-purple-600">Stabil</span>
                            </div>
                        </div>
                        <p class="text-slate-500 text-xs mt-2">konsisten</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-amber-600"></i>
                    </div>
                </div>
            </div>
        </div>

            <!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Transaksi Hari Ini -->
    <div class="lg:col-span-2">
        <div class="rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="border-b border-slate-200 p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="font-bold text-lg text-slate-800">Transaksi Hari Ini</h3>
                    <p class="text-slate-500 text-sm">Daftar transaksi terbaru</p>
                </div>
                <a href="{{ route('admin.reports.daily') }}" class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors duration-300 text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-filter text-xs"></i>
                    <span>Lihat Laporan</span>
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold text-slate-600 uppercase tracking-wider text-xs">ID Transaksi</th>
                            <th class="py-3 px-4 text-left font-semibold text-slate-600 uppercase tracking-wider text-xs">Waktu</th>
                            <th class="py-3 px-4 text-left font-semibold text-slate-600 uppercase tracking-wider text-xs">Total</th>
                            <th class="py-3 px-4 text-left font-semibold text-slate-600 uppercase tracking-wider text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($transaksiTerbaru as $transaksi)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="py-3 px-4 font-medium text-slate-800 text-sm">#{{ $transaksi->kode_transaksi }}</td>
                            <td class="py-3 px-4 text-slate-600 text-sm">
                                {{ \Carbon\Carbon::parse($transaksi->created_at)->format('H:i') }} WIB
                            </td>
                            <td class="py-3 px-4 font-medium text-slate-800 text-sm">
                                @currency($transaksi->total_harga)
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-500 text-sm">
                                Belum ada transaksi hari ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        
                    <!-- Footer -->
                    <div class="border-t border-slate-200 p-4 text-center">
                        <a href="{{ route('admin.reports.daily') }}" class="px-4 py-2 rounded-lg font-medium text-purple-600 hover:text-purple-800 transition-colors duration-300 text-sm flex items-center justify-center gap-2 mx-auto">
                            <span>Lihat Semua Transaksi</span>
                            <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Produk Terlaris -->
            <div class="space-y-6">
                <div class="rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    <!-- Header -->
                    <div class="border-b border-slate-200 p-5">
                        <h3 class="font-bold text-lg text-slate-800">Produk Terlaris</h3>
                        <p class="text-slate-500 text-sm">Hari ini</p>
                    </div>
                    <!-- Product List -->
                    <div class="p-4 space-y-3">
                        @forelse($produkTerlaris as $produk)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-box text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 text-sm">{{ $produk->name }}</p>
                                    <p class="text-slate-500 text-xs">{{ $produk->sold }} terjual</p>
                                </div>
                            </div>
                            <span class="font-semibold text-slate-800 text-sm">@currency($produk->revenue)</span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-slate-500 text-sm">
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