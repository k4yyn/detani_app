@extends('layouts.admin')

@section('title', 'Laporan Bulanan')
@section('header', 'Laporan Bulanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-4 md:p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-6">
        <!-- Form Filter -->
        <div class="flex-1">
            <form method="GET" action="{{ route('admin.reports.monthly') }}" class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <label for="month" class="font-semibold whitespace-nowrap">Pilih Bulan:</label>
                    <input type="month" name="month" id="month" value="{{ $selectedMonth }}" 
                           class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition whitespace-nowrap">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Navigation & Export -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <p class="order-2 sm:order-1">
                <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">
                    &larr; Kembali ke menu laporan
                </a>
            </p>
            <button id="exportExcel" class="order-1 sm:order-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center">
                <i class="fas fa-file-excel mr-2"></i>
                <span class="hidden sm:inline">Export Excel</span>
                <span class="sm:hidden">Excel</span>
            </button>
        </div>
    </div>

    <!-- Month Title -->
    @if($selectedMonth)
        <div class="mb-6">
            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                Transaksi Bulan {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
            </h2>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ $transaksis->count() }}</h3>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 mb-1">Rata-rata per Transaksi</p>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800">
                    @if($transaksis->count() > 0)
                        Rp {{ number_format($total / $transaksis->count(), 0, ',', '.') }}
                    @else
                        Rp 0
                    @endif
                </h3>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Responsive Table Container -->
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <table id="transactionTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-amber-700">
                        <tr>
                            <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                                Invoice
                            </th>
                            <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                                Kasir
                            </th>
                            <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-right text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-center text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                                Metode
                            </th>
                            <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-center text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $total = 0; @endphp
                        @forelse ($transaksis as $t)
                            @php $total += $t->total_harga; @endphp
                            <tr class="hover:bg-amber-50 transition-colors duration-150">
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="font-medium">{{ $t->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 md:hidden">{{ $t->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                    {{ $t->invoice ?? '-' }}
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $t->user->name ?? '-'}}
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                    <div class="text-sm md:text-base">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ strtolower($t->metode_pembayaran ?? 'tunai') === 'tunai' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
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
                                        <p class="text-lg font-medium text-gray-500 mb-1">Tidak ada transaksi bulan ini</p>
                                        <p class="text-sm text-gray-400">Belum ada data transaksi untuk ditampilkan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-amber-50">
                        <tr class="border-t-2 border-amber-200">
                            <td colspan="3" class="px-3 md:px-6 py-4 md:py-6 text-right font-bold text-gray-900 text-sm md:text-lg">
                                Total Bulan Ini:
                            </td>
                            <td colspan="3" class="px-3 md:px-6 py-4 md:py-6 font-bold text-lg md:text-xl text-gray-900">
                                <div class="bg-amber-200 rounded-lg px-3 py-2 inline-block">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Mobile scroll indicator -->
        <div class="md:hidden bg-gray-50 px-4 py-2 text-center">
            <p class="text-xs text-gray-500">
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
        document.getElementById('exportExcel').addEventListener('click', function () {
            // Get the table element
            const table = document.getElementById('transactionTable');
            
            // Clone the table to modify it for export
            const tableClone = table.cloneNode(true);
            
            // Remove the footer from the exported data
            const tfoot = tableClone.querySelector('tfoot');
            if (tfoot) {
                tfoot.remove();
            }
            
            // Convert table to workbook
            const wb = XLSX.utils.table_to_book(tableClone, { sheet: "Laporan" });

            // Generate filename based on selected month and current timestamp
            const month = @json(\Carbon\Carbon::parse($selectedMonth)->format('Y_m'));
            const timestamp = new Date().toISOString().slice(0,19).replace(/[-T:]/g, "");
            const filename = `Laporan_Bulanan_${month}_${timestamp}.xlsx`;

            // Export to Excel
            XLSX.writeFile(wb, filename);
        });
    });
</script>
@endpush