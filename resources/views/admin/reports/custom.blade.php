@extends('layouts.admin')

@section('title', 'Laporan Kustom')
@section('header', 'Laporan Kustom')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-calendar-range mr-2"></i> Laporan Kustom 
            ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})
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
                <p class="text-sm text-gray-500">Rata-rata per Hari</p>
                <h3 class="text-2xl font-bold">
                    @php
                        $days = $startDate->diffInDays($endDate) + 1;
                    @endphp
                    @if($days > 0)
                        Rp {{ number_format($total / $days, 0, ',', '.') }}
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
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Invoice</th>
                    <th class="py-3 px-4 text-left">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transaksis as $transaksi)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $transaksi->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                            {{ $transaksi->invoice }}
                        </span>
                    </td>
                    <td class="py-3 px-4">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500">
                        Tidak ada data transaksi pada periode ini
                    </td>
                </tr>
                @endforelse
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