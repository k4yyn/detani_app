@extends('layouts.admin')

@section('title', 'Laporan Tahunan')
@section('header', 'Laporan Tahunan')

@section('content')
@php
    $selectedYear = request('tahun', now()->year);
@endphp

<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-calendar mr-2"></i> Laporan Tahunan ({{ $selectedYear }})
            </h2>
                 <p> <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke menu laporan</a> </p>
            <form method="GET" action="{{ route('admin.reports.yearly') }}">
                <select id="selectYear" name="tahun" onchange="this.form.submit()">
                    @for ($i = 2020; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </form>
        </div>

        <div class="flex space-x-2">
             <button id="exportExcel" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
        </div>
    </div>

    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <h3 class="text-2xl font-bold">{{ $transaksis->count() }}</h3>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <h3 class="text-2xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Rata-rata per Bulan</p>
                <h3 class="text-2xl font-bold">
                    @if($transaksis->count() > 0)
                        Rp {{ number_format($total / 12, 0, ',', '.') }}
                    @else
                        Rp 0
                    @endif
                </h3>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="transactionTable" class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Bulan</th>
                    <th class="py-3 px-4 text-left">Jumlah Transaksi</th>
                    <th class="py-3 px-4 text-left">Total Pendapatan</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
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
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F') }}</td>
                        <td class="py-3 px-4">{{ $data['count'] }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.reports.monthly', ['month' => $selectedYear . '-' . $month]) }}" class="text-blue-500 hover:underline">Detail</a>
                        </td>

                    </tr>
                @endfor
            </tbody>
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="3" class="py-3 px-4 text-right">Total</td>
                    <td class="py-3 px-4">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="bg-white rounded-xl shadow p-6 mt-8">
    <h3 class="text-lg font-semibold mb-4">Grafik Pendapatan Tahun {{ $tahun }}</h3>
    <canvas id="yearlyChart" height="100"></canvas>
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
    const min = Math.min(...monthlyChart);

    // Tentukan warna setiap bar berdasarkan nilai
    const backgroundColors = monthlyChart.map(value => {
        if (value === max && value !== min) return 'rgba(75, 192, 192, 0.7)'; // hijau terang (bulan tertinggi)
        if (value === min && value !== max) return 'rgba(255, 99, 132, 0.7)'; // merah terang (bulan terendah)
        return 'rgba(54, 162, 235, 0.7)'; // biru default
    });
    const borderColors = monthlyChart.map(value => {
        if (value === max && value !== min) return 'rgba(75, 192, 192, 1)';
        if (value === min && value !== max) return 'rgba(255, 99, 132, 1)';
        return 'rgba(54, 162, 235, 1)';
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
                borderWidth: 1,
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            return ` ${value}`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Grafik Total Pendapatan Bulanan',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

</script>
@endpush
