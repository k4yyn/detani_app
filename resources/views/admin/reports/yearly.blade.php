@extends('layouts.admin')

@section('title', 'Laporan Tahunan')
@section('header', 'Laporan Tahunan')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-calendar mr-2"></i> Laporan Tahunan ({{ now()->format('Y') }})
        </h2>
        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
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
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Bulan</th>
                    <th class="py-3 px-4 text-left">Jumlah Transaksi</th>
                    <th class="py-3 px-4 text-left">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $monthlyData = $transaksis->groupBy(function($item) {
                        return $item->created_at->format('Y-m');
                    })->map(function($group) {
                        return [
                            'count' => $group->count(),
                            'total' => $group->sum('total')
                        ];
                    });
                @endphp

                @for($i = 1; $i <= 12; $i++)
                    @php
                        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $yearMonth = now()->format('Y') . '-' . $month;
                        $data = $monthlyData[$yearMonth] ?? ['count' => 0, 'total' => 0];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F') }}</td>
                        <td class="py-3 px-4">{{ $data['count'] }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                    </tr>
                @endfor
            </tbody>
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="2" class="py-3 px-4 text-right">Total</td>
                    <td class="py-3 px-4">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection