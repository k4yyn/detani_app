@extends('layouts.admin')

@section('title', 'Laporan Harian')
@section('header', 'Laporan Harian')

@section('content')
    <h2 class="text-lg font-bold mb-4">Laporan Transaksi Hari Ini</h2>

    <table class="w-full border text-sm">
        <thead>
            <tr class="bg-amber-700 text-white">
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Invoice</th>
                <th class="border px-4 py-2">Total</th>
                <th class="border px-4 py-2">Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $t)
                <tr class="text-center">
                    <td class="border px-2 py-1">{{ $t->created_at->format('d M Y') }}</td>
                    <td class="border px-2 py-1">{{ $t->invoice ?? '-' }}</td>
                    <td class="border px-2 py-1">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="border px-2 py-1">{{ ucfirst($t->metode_pembayaran ?? 'Tunai') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">Tidak ada transaksi hari ini.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
