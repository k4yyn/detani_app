@extends('layouts.admin')

@section('title', 'Laporan Kustom')
@section('header', 'Laporan Kustom')

@section('content')
<div class="bg-green-900 rounded-xl shadow-sm border border-green-200 p-6 mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 md:order-1">
            <a href="{{ route('admin.reports.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg text-sm font-medium transition-colors duration-200 mb-3 sm:mb-0">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="flex-1 flex flex-col items-center text-center mt-4 md:mt-0 md:order-2">
            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">
                Laporan Custom
            </h2>
            <span class="text-sm text-gray-300">
                ({{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }})
            </span>
        </div>

        <div class="flex-shrink-0 mt-4 md:mt-0 md:order-3">
            <button id="exportExcel"
                    class="w-full sm:w-auto px-4 py-2.5 bg-orange-100 hover:bg-orange-200 text-orange-700 border border-orange-300 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                Export Excel
            </button>
        </div>
    </div>
</div>

<div class="mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-blue-100 text-blue-800 p-6 rounded-xl border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-700 text-sm font-medium">Total Transaksi</p>
                    <h3 class="text-3xl font-bold mt-1">{{ number_format($transaksis->count()) }}</h3>
                </div>
                <div class="bg-blue-200 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-green-100 text-green-800 p-6 rounded-xl border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-700 text-sm font-medium">Total Pendapatan</p>
                    <h3 class="text-2xl lg:text-3xl font-bold mt-1">Rp {{ number_format($total, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-100 text-purple-800 p-6 rounded-xl border border-purple-200 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-700 text-sm font-medium">Rata-rata per Hari</p>
                    <h3 class="text-2xl lg:text-3xl font-bold mt-1">
                        @php
                            $days = $startDate->diffInDays($endDate) + 1;
                        @endphp
                        @if($days > 0 && $total > 0)
                            Rp {{ number_format($total / $days, 0, ',', '.') }}
                        @else
                            Rp 0
                        @endif
                    </h3>
                </div>
                <div class="bg-purple-200 p-3 rounded-full">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-green-200">
    <div class="px-6 py-4 bg-green-50 border-b border-green-200">
        <h3 class="text-lg font-semibold text-green-900 flex items-center">
            <i class="fas fa-table mr-2 text-green-700"></i>
            Detail Transaksi
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table id="customReportTable" class="min-w-full divide-y divide-gray-300">
            <thead class="bg-green-800">
                <tr>
                    <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Invoice
                    </th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Total
                    </th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Metode
                    </th>
                    <th class="py-4 px-6 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transaksis as $t)
                    <tr class="hover:bg-green-50 transition-colors duration-200">
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ $t->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500 md:hidden">{{ $t->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-blue-600 font-mono">
                            {{ $t->invoice ?? '-' }}
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm font-semibold text-green-900">
                            <div class="text-sm md:text-base">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                             <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                {{ strtolower($t->metode_pembayaran ?? 'tunai') === 'tunai' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($t->metode_pembayaran ?? 'Tunai') }}
                            </span>
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-center">
                            <a href="{{ route('admin.transaksi.struk', $t->id) }}" target="_blank"
                                class="inline-flex items-center px-2 md:px-3 py-1 md:py-2 text-xs md:text-sm bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors shadow-sm">
                                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="hidden sm:inline">Lihat Struk</span>
                                <span class="sm:hidden">Struk</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-medium text-gray-500 mb-1">Tidak ada transaksi pada periode ini</p>
                                <p class="text-sm text-gray-400">Silakan ubah rentang tanggal untuk melihat data</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-green-50">
                <tr>
                    <td colspan="2" class="py-4 px-6 text-right text-sm font-bold text-gray-900">
                        Total Keseluruhan:
                    </td>
                    <td class="py-4 px-6 text-sm font-bold text-green-900">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="md:hidden bg-green-100 px-4 py-2 text-center">
        <p class="text-xs text-green-800">
            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Geser ke kiri/kanan untuk melihat lebih banyak kolom
            <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener for exporting to Excel
        document.getElementById('exportExcel').addEventListener('click', function () {
            const table = document.getElementById('customReportTable');
            const tableClone = table.cloneNode(true);
            const tfoot = tableClone.querySelector('tfoot');

            if (tfoot) {
                // Ensure the footer for export is clean
                const totalRow = tfoot.querySelector('tr');
                if (totalRow) {
                    // Remove the last two empty cells from the cloned footer
                    totalRow.removeChild(totalRow.lastElementChild);
                    totalRow.removeChild(totalRow.lastElementChild);
                    // Set correct colspan for the "Total" cell
                    totalRow.children[0].setAttribute('colspan', '3');
                }
            }

            // Check if there is data to export
            const tbody = tableClone.querySelector('tbody');
            if (!tbody || tbody.children.length === 0 || (tbody.children.length === 1 && tbody.children[0].querySelector('td').getAttribute('colspan') === '5')) {
                alert('Tidak ada data yang dapat diekspor.');
                return;
            }

            // Remove the 'Aksi' column from the cloned table
            const headerCells = tableClone.querySelectorAll('th');
            const actionHeaderIndex = Array.from(headerCells).findIndex(th => th.textContent.trim() === 'Aksi');
            if (actionHeaderIndex !== -1) {
                tableClone.querySelectorAll('tr').forEach(row => {
                    if (row.children[actionHeaderIndex]) {
                        row.removeChild(row.children[actionHeaderIndex]);
                    }
                });
            }

            // Remove 'Metode' column because it's messy in Excel
            const methodHeaderIndex = Array.from(headerCells).findIndex(th => th.textContent.trim() === 'Metode');
            if (methodHeaderIndex !== -1) {
                tableClone.querySelectorAll('tr').forEach(row => {
                    if (row.children[methodHeaderIndex]) {
                        row.removeChild(row.children[methodHeaderIndex]);
                    }
                });
            }

            const wb = XLSX.utils.table_to_book(tableClone, { sheet: "Laporan Kustom" });
            const startDate = "{{ $startDate->format('Y-m-d') }}";
            const endDate = "{{ $endDate->format('Y-m-d') }}";
            const filename = `Laporan_Kustom_${startDate}_to_${endDate}.xlsx`;
            XLSX.writeFile(wb, filename);
        });
    });
</script>
@endpush