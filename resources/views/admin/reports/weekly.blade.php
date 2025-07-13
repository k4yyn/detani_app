@extends('layouts.admin')

@section('title', 'Laporan Mingguan')
@section('header', 'Laporan Transaksi Mingguan')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke menu laporan</a>
    </div>

    <table class="w-full text-sm bg-white border shadow">
        <thead class="bg-amber-800 text-white">
            <tr>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Invoice</th>
                <th class="px-4 py-2 border">Total</th>
                <th class="px-4 py-2 border">Metode</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($transaksis as $t)
                @php $total += $t->total; @endphp
                <tr class="text-center hover:bg-amber-50">
                    <td class="border px-4 py-2">{{ $t->created_at->format('d M Y') }}</td>
                    <td class="border px-4 py-2">{{ $t->invoice ?? '-' }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($t->metode_pembayaran ?? 'Tunai') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">Tidak ada data.</td></tr>
            @endforelse
            <tr class="bg-gray-100 font-semibold">
                <td colspan="2" class="text-right px-4 py-2">Total</td>
                <td colspan="2" class="px-4 py-2">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
@endsection
