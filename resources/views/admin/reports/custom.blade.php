@extends('layouts.admin')

@section('title', 'Laporan Kustom')
@section('header', 'Laporan Kustom')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-xl font-bold text-green-800">
            <i class="fas fa-calendar-range mr-2"></i> Laporan Kustom 
            ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})
        </h2>
        <div>
            <button class="px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-900 transition shadow-sm hover:shadow-md">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
        </div>
    </div>

    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-green-800">{{ $transaksis->count() }}</h3>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-green-800">Rp {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Rata-rata per Hari</p>
                <h3 class="text-2xl font-bold text-green-800">
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
        <table class="min-w-full bg-white rounded-lg overflow-hidden border border-gray-200">
            <thead class="bg-green-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-medium">Tanggal</th>
                    <th class="py-3 px-4 text-left text-sm font-medium">Invoice</th>
                    <th class="py-3 px-4 text-left text-sm font-medium">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @forelse($transaksis as $transaksi)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-900">{{ $transaksi->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                            {{ $transaksi->invoice }}
                        </span>
                    </td>
                    <td class="py-3 px-4 font-semibold text-green-800">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak ada data transaksi pada periode ini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-100 font-bold border-t border-gray-300">
                <tr>
                    <td colspan="2" class="py-3 px-4 text-right text-gray-900">Total</td>
                    <td class="py-3 px-4 text-green-800">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection