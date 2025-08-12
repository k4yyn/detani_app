@extends('layouts.admin')

@section('title', 'Laporan Tahunan')
@section('header', 'Laporan Tahunan')

@section('content')
@php
    $selectedYear = request('tahun', now()->year);
@endphp

<div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-calendar mr-2"></i> 
                <span>Laporan Tahunan</span>
                <span class="ml-2 text-blue-600">({{ $selectedYear }})</span>
            </h2>
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <a href="{{ route('admin.reports.index') }}" 
                   class="text-blue-600 hover:text-blue-800 hover:underline transition-colors text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke menu laporan
                </a>
                
                <form method="GET" action="{{ route('admin.reports.yearly') }}" class="flex items-center">
                    <label for="selectYear" class="text-sm font-medium text-gray-700 mr-2 whitespace-nowrap">Tahun:</label>
                    <select id="selectYear" 
                            name="tahun" 
                            onchange="this.form.submit()"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @for ($i = 2020; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>

        <div class="flex justify-end">
            <button id="exportExcel" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center shadow-md hover:shadow-lg">
                <i class="fas fa-file-excel mr-2"></i> 
                <span class="hidden sm:inline">Export</span> Excel
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                        <h3 class="text-3xl font-bold mt-1">{{ number_format($transaksis->count()) }}</h3>
                    </div>
                    <div class="bg-blue-400 bg-opacity-30 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-xl shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Pendapatan</p>
                        <h3 class="text-2xl lg:text-3xl font-bold mt-1">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-green-400 bg-opacity-30 p-3 rounded-full">
                        <i class="fas fa-money-bill-wave text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-md sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Rata-rata per Bulan</p>
                        <h3 class="text-2xl lg:text-3xl font-bold mt-1">
                            @if($transaksis->count() > 0)
                                Rp {{ number_format($total / 12, 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        </h3>
                    </div>
                    <div class="bg-purple-400 bg-opacity-30 p-3 rounded-full">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Grafik Pendapatan Tahun {{ $tahun }}
            </h3>
        </div>
        <div class="relative" style="height: 400px;">
            <canvas id="yearlyChart"></canvas>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-table mr-2 text-blue-600"></i>
                Detail Bulanan
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table id="transactionTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Bulan
                        </th>
                        <th class="py-4 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Jumlah Transaksi
                        </th>
                        <th class="py-4 px-6 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Total Pendapatan
                        </th>
                        <th class="py-4 px-6 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $monthlyData = $transaksis->groupBy(function($item) {
                            return $item->created_at->format('Y-m');
                        })->map(function($group) {
                            return [
                                'count' => $group->count(),
                                'total' => $group->sum('total_harga')
                            ];
                        });
                    @endphp

                    @for($i = 1; $i <= 12; $i++)
                        @php
                            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $yearMonth = $selectedYear . '-' . $month;
                            $data = $monthlyData[$yearMonth] ?? ['count' => 0, 'total' => 0];
                            $monthName = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F');
                            $monthNameId = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->locale('id')->format('F');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-blue-600 font-semibold text-sm">{{ $i }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $monthNameId }}</div>
                                        <div class="text-xs text-gray-500">{{ $selectedYear }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ number_format($data['count']) }}</div>
                                <div class="text-xs text-gray-500">transaksi</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($data['total'], 0, ',', '.') }}
                                </div>
                                @if($data['total'] > 0)
                                    <div class="text-xs text-gray-500">
                                        Rata-rata: Rp {{ number_format($data['count'] > 0 ? $data['total'] / $data['count'] : 0, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                @if($data['count'] > 0)
                                    <a href="{{ route('admin.reports.monthly', ['month' => $selectedYear . '-' . $month]) }}" 
                                       class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        <i class="fas fa-minus mr-1"></i>
                                        Tidak ada data
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="2" class="py-4 px-6 text-right text-sm font-bold text-gray-900">
                            <i class="fas fa-calculator mr-2"></i>Total Keseluruhan:
                        </td>
                        <td class="py-4 px-6 text-sm font-bold text-gray-900">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.getElementById('selectYear').addEventListener('change', function () {
        const selectedYear = this.value;
        const baseUrl = window.location.origin + window.location.pathname;
        window.location.href = baseUrl + '?tahun=' + selectedYear;
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('exportExcel').addEventListener('click', function () {
            const table = document.getElementById('transactionTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan" });

            // Nama file berdasarkan tahun yang dipilih
            const month = @json(\Carbon\Carbon::parse($selectedYear)->format('Y_m'));
            const timestamp = new Date().toISOString().slice(0,19).replace(/[-T:]/g, "");
            const filename = `Laporan_Tahunan_{{ $selectedYear }}_${timestamp}.xlsx`;

            XLSX.writeFile(wb, filename);
        });
    });
    
    const ctx = document.getElementById('yearlyChart').getContext('2d');
    const monthlyChart = @json($monthlyChart);
    const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Cari nilai maksimum dan minimum
    const max = Math.max(...monthlyChart);
    const min = Math.min(...monthlyChart.filter(val => val > 0)); // Exclude zero values for min

    // Tentukan warna setiap bar berdasarkan nilai
    const backgroundColors = monthlyChart.map(value => {
        if (value === 0) return 'rgba(156, 163, 175, 0.7)'; // abu-abu untuk data kosong
        if (value === max && value !== min) return 'rgba(34, 197, 94, 0.7)'; // hijau terang (bulan tertinggi)
        if (value === min && value !== max && value > 0) return 'rgba(239, 68, 68, 0.7)'; // merah terang (bulan terendah)
        return 'rgba(59, 130, 246, 0.7)'; // biru default
    });
    
    const borderColors = monthlyChart.map(value => {
        if (value === 0) return 'rgba(156, 163, 175, 1)';
        if (value === max && value !== min) return 'rgba(34, 197, 94, 1)';
        if (value === min && value !== max && value > 0) return 'rgba(239, 68, 68, 1)';
        return 'rgba(59, 130, 246, 1)';
    });

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Total Pendapatan',
                data: monthlyChart,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return `Bulan ${context[0].label}`;
                        },
                        label: function(context) {
                            let value = context.raw.toLocaleString('id-ID', { 
                                style: 'currency', 
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                            return `Pendapatan: ${value}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            weight: 500
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        },
                        font: {
                            size: 11
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
@endpush