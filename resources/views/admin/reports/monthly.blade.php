@extends('layouts.admin')

@section('title', 'Laporan Bulanan')
@section('header', 'Laporan Bulanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">>
        <form method="GET" action="{{ route('admin.reports.monthly') }}" class="mb-4">
            <label for="month" class="font-semibold">Pilih Bulan:</label>
            <input type="month" name="month" id="month" value="{{ $selectedMonth }}" class="border border-gray-300 rounded px-2 py-1">
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded ml-2">Tampilkan</button>
        </form>

        @if($selectedMonth)
            <h2 class="text-lg font-semibold mb-2">Transaksi Bulan {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}</h2>
        @endif
        <p> <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke menu laporan</a> </p>
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
                <p class="text-sm text-gray-500">Rata-rata per Transaksi</p>
                <h3 class="text-2xl font-bold">
                    @if($transaksis->count() > 0)
                        Rp {{ number_format($total / $transaksis->count(), 0, ',', '.') }}
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
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Invoice</th>
                    <th class="py-3 px-4 text-left">Kasir</th>
                    <th class="py-3 px-4 text-left">Total</th>
                    <th class="py-3 px-4 text left">Metode</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
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
                    <td class="py-3 px-4">{{ $transaksi->user->name ?? '_'}}</td>
                    <td class="py-3 px-4">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td class="px-3 py-4">{{ ucfirst($t->metode_pembayaran ?? 'Tunai') }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('admin.transaksi.struk', $transaksi->id) }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1 text-sm bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6m1-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z" />
                                    </svg>
                                    Lihat Struk
                                </a>
                            </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500">
                        Tidak ada data transaksi bulan ini
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="3" class="py-3 px-5 text-right">Total</td>
                    <td colspan="3" class="py-3 px-5">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('exportExcel').addEventListener('click', function () {
            const table = document.getElementById('transactionTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan" });

            // Nama file berdasarkan bulan yang dipilih
            const month = @json(\Carbon\Carbon::parse($selectedMonth)->format('Y_m'));
            const timestamp = new Date().toISOString().slice(0,19).replace(/[-T:]/g, "");
            const filename = `Laporan_Bulanan_${month}_${timestamp}.xlsx`;

            XLSX.writeFile(wb, filename);
        });
    });
</script>
@endpush