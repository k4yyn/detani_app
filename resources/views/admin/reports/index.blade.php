@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div>
    <div class="max-w-9x1 mx-auto px-4 sm:px-2 lg:px-6 py-2">
        @php
            $totalPendapatan = $totalPendapatan ?? 0;
            $totalTransaksi = $totalTransaksi ?? 0;
            $rataRata = $rataRata ?? 0;
        @endphp

        <div class="bg-green-800 px-4 sm:px-6 rounded-2xl md:px-8 py-4 md:py-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-2xl font-semibold text-white flex items-center group">
                        <svg class="h-6 w-6 mr-3 sm:w-8 md:w-10 h-8 md:h-10 mr-2 sm:mr-3 md:mr-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-4m3 4v-4m3 4v-4m3 4h1a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2h12m0 0v-4m0 4h-2m-4-4h4"/>
                        </svg>Laporan Transaksi</h1>
                    <p class="text-gray-300 text-sm sm:text-base md:text-md">Ringkasan data transaksi bisnis</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto ">
                    <button id="exportExcel" class="bg-green-100 hover:bg-green-200 border border-green-300 px-4 py-2.5 text-green-800 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:shadow-sm">
                        <i class="fas fa-file-excel mr-2 text-green-700"></i> Export Excel
                    </button>
                </div>
            </div>

            @if(request('start_date') && request('end_date'))
                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                    <i class="fas fa-calendar-alt mr-2 text-xs"></i>
                    <strong>{{ request('start_date') }}</strong> sampai <strong>{{ request('end_date') }}</strong>
                </div>
            @elseif(request('filter'))
                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-700">
                    <i class="fas fa-filter mr-2 text-xs"></i>
                    Filter: <strong class="ml-1">{{ ucfirst(request('filter')) }}</strong>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-sliders-h text-orange-500 mr-3"></i>
                <h3 class="text-lg font-semibold text-green-900">Filter Laporan</h3>
            </div>

            <form id="filterForm" method="GET" action="{{ route('admin.reports.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Jenis Laporan</label>
                        <select id="filterSelect" name="filter"
                                class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors">
                            <option value="">Pilih Jenis Laporan</option>
                            <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="custom" {{ request('filter') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    @if(request()->has('filter') || request()->has('start_date'))
                        <div class="flex flex-col sm:flex-row gap-4">
                            @php
                                $routeMap = [
                                    'harian' => 'daily',
                                    'mingguan' => 'weekly',
                                    'bulanan' => 'monthly',
                                    'tahunan' => 'yearly',
                                ];
                                $filter = request('filter');
                            @endphp

                            @if(isset($routeMap[$filter]))
                                <a href="{{ route('admin.reports.' . $routeMap[$filter]) }}"
                                   class="px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition-colors duration-300 text-sm font-medium flex items-center gap-2">
                                    <i class="fas fa-external-link-alt mr-2"></i> Lihat Laporan Lengkap
                                </a>
                            @endif
                            
                            @if(request('filter') === 'custom' && request('start_date') && request('end_date'))
                                <a href="{{ route('admin.reports.custom', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                                   class="px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition-colors duration-300 text-sm font-medium flex items-center gap-2">
                                    <i class="fas fa-external-link-alt mr-2"></i> Lihat Laporan Lengkap
                                </a>
                            @endif

                            <a href="{{ route('admin.reports.index') }}"
                               class="px-4 py-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition-colors duration-300 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-undo mr-2"></i> Reset Filter
                            </a>
                        </div>
                    @endif
                </div>

                <div id="customDateFilter"
                     style="{{ request('filter') === 'custom' ? 'display: grid' : 'display: none' }}"
                     class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4 border-t border-gray-300">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-orange-100 hover:bg-orange-200 text-orange-700 transition-colors duration-300 text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-search mr-2"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <x-summary-card title="Total Transaksi"
                                value="{{ number_format($totalTransaksi) }}"
                                icon="fas fa-receipt"
                                color="blue"
                                desc="Transaksi tercatat" />
            <x-summary-card title="Total Pendapatan"
                                value="Rp {{ number_format($totalPendapatan, 0, ',', '.') }}"
                                icon="fas fa-coins"
                                color="green"
                                desc="Revenue terkumpul" />
            <x-summary-card title="Rata-rata Transaksi"
                                value="Rp {{ number_format($rataRata, 0, ',', '.') }}"
                                icon="fas fa-chart-line"
                                color="purple"
                                desc="Per transaksi" />
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden">
            <div class="bg-green-50 border-b border-green-200 px-6 py-4">
                <div class="flex items-center">
                    <i class="fas fa-table text-orange-500 mr-3"></i>
                    <h3 class="text-lg font-semibold text-green-900">Detail Transaksi</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="transactionTable" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kode</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kasir</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Item</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Metode</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transaksis as $transaksi)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                    {{ $transaksi->kode_transaksi }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $transaksi->created_at->format('d/m/Y') }}</span>
                                       <span class="text-xs text-gray-500">{{ $transaksi->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-xs text-gray-600"></i>
                                        </div>
                                        {{ $transaksi->user->name ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        {{ $transaksi->details->sum('qty') }} item
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-bold text-green-900">
                                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $transaksi->metode_pembayaran == 'cash' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $transaksi->metode_pembayaran ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.transaksi.struk', $transaksi->id) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-1.5 text-xs bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors duration-200 hover:shadow-sm">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 16h8M8 12h8m-7 8h6m1-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z" />
                                        </svg>
                                        Struk
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada transaksi</h3>
                                        <p class="text-gray-500">Belum ada transaksi yang ditemukan untuk filter ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($transaksis instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">
                {{ $transaksis->withQueryString()->links() }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-green-200 p-4 mt-6">
            <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600 gap-3">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-600 rounded-full mr-2 animate-pulse"></div>
                    <span>Data diperbarui secara real-time</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2 text-gray-500"></i>
                    <span>Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
    }

    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    @media (max-width: 640px) {
        .min-w-full th,
        .min-w-full td {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .min-w-full th:first-child,
        .min-w-full td:first-child {
            padding-left: 1rem;
        }

        .min-w-full th:last-child,
        .min-w-full td:last-child {
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('exportExcel').addEventListener('click', function () {
            const table = document.getElementById('transactionTable');
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Laporan Transaksi");
            XLSX.writeFile(wb, "Laporan_Transaksi.xlsx");
        });

        const filterSelect = document.getElementById('filterSelect');
        const customDateFilter = document.getElementById('customDateFilter');
        const filterForm = document.getElementById('filterForm');
        
        if (filterSelect.value === 'custom') {
            customDateFilter.style.display = 'grid';
        }

        filterSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateFilter.style.display = 'grid';
            } else {
                customDateFilter.style.display = 'none';
                filterForm.submit();
            }
        });

        const buttons = document.querySelectorAll('button[type="submit"], .btn-submit');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
            });
        });
    });
</script>
@endpush