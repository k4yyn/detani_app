@extends('layouts.admin')

@section('title', 'Laporan Mingguan')
@section('header', 'Laporan Transaksi Mingguan')

@section('content')
     <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start mb-8">
        <div class="mb-6 lg:mb-0">
        <h2 class="text-lg font-bold mb-4">Laporan Transaksi Minggu Ini</h2>
        <p> <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke menu laporan</a> </p>
        </div>
             <div class="flex gap-3">
                <button id="exportExcel" class="bg-green-50 hover:bg-green-100 border border-green-200 px-4 py-2 text-green-700 rounded-lg text-sm font-medium flex items-center transition-colors">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </button>
            </div>
        </div>

    <table class="w-full text-sm bg-white border shadow">
        <thead class="bg-amber-800 text-white">
            <tr>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Invoice</th>
                <th class="px-4 py-4 border">Kasir</th>
                <th class="px-4 py-2 border">Total</th>
                <th class="px-4 py-2 border">Metode</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($transaksis as $t)
                @php $total += $t->total_harga; @endphp
                <tr class="text-center hover:bg-amber-50">
                    <td class="border px-4 py-2">{{ $t->created_at->format('d M Y') }}</td>
                    <td class="border px-4 py-2">{{ $t->invoice ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $t->user->name ?? '-'}}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($t->metode_pembayaran ?? 'Tunai') }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.transaksi.struk', $t->id) }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1 text-sm bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6m1-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z" />
                                    </svg>
                                    Lihat Struk
                                </a>
                    </td>    
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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportExcel').addEventListener('click', function () {
        const table = document.querySelector('table'); // Ambil tabel pertama
        const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan Mingguan" });
        XLSX.writeFile(wb, "laporan_mingguan.xlsx");
    });
</script>
@endpush