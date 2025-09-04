@extends('layouts.admin')

@section('title', 'Laporan Bulanan')
@section('header', 'Laporan Bulanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-6">
        <!-- Form Filter -->
        <div class="flex-1">
            <form method="GET" action="{{ route('admin.reports.monthly') }}" class="flex flex-col sm:flex-row gap-2">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <label for="month" class="font-semibold whitespace-nowrap text-gray-800">Pilih Bulan:</label>
                    <input type="month" name="month" id="month" value="{{ $selectedMonth }}" 
                           class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-emerald-600 focus:border-transparent">
                    <button type="submit" class="bg-emerald-700 text-white px-4 py-2 rounded hover:bg-emerald-800 transition whitespace-nowrap">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Navigation & Export -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="order-2 sm:order-1">
                <a href="{{ route('admin.reports.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 rounded-lg text-sm font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Menu Laporan
                </a>
            </div>
            <button id="exportExcel" class="order-1 sm:order-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition inline-flex items-center border border-orange-600">
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
    
    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-green-200">
        <!-- Responsive Table Container -->
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <table id="transactionTable" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-green-800">
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
                        @php $tableTotal = 0; @endphp
                        @forelse ($transaksis as $t)
                            @php $tableTotal += $t->total_harga; @endphp
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="font-medium">{{ $t->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 md:hidden">{{ $t->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-blue-600 font-mono">
                                    {{ $t->invoice ?? '-' }}
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm text-gray-900">
                                  <div class="flex items-center">
                                    <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-xs text-gray-600"></i>
                                    </div>
                                    {{ $t->user->name ?? '_'}}
                                    </div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm font-semibold text-green-900 text-right">
                                    <div class="text-sm md:text-base">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-center">
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
                                <td colspan="6" class="px-6 py-12 text-center">
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
                    <tfoot class="bg-green-50">
    <tr class="border-t-2 border-green-700">
        <td class="px-2 md:px-3 py-4 md:py-6 text-right font-bold text-green-900 text-xs md:text-sm align-middle">
            Total Transaksi:
        </td>
        <td class="px-2 md:px-3 py-4 md:py-6 font-bold text-sm md:text-base text-green-900 align-middle">
            <div class="bg-green-100 rounded-lg px-2 py-1 inline-block text-green-700 text-xs md:text-sm">
                {{ $transaksis->count() }}
            </div>
        </td>
        <td class="px-2 md:px-3 py-4 md:py-6 text-right font-bold text-green-900 text-xs md:text-sm align-middle">
            Total Bulan Ini:
        </td>
        <td class="px-2 md:px-3 py-4 md:py-6 font-bold text-sm md:text-base text-green-900 align-middle text-left">
            <div class="bg-blue-100 rounded-lg px-2 py-1 inline-block text-blue-700 text-xs md:text-sm">
                Rp {{ number_format($tableTotal, 0, ',', '.') }}
            </div>
        </td>
        <td class="px-2 md:px-3 py-4 md:py-6 text-right font-bold text-green-900 text-xs md:text-sm align-middle">
            Rata-rata transaksi:
        </td>
        <td class="px-2 md:px-3 py-4 md:py-6 font-bold text-sm md:text-base text-green-900 align-middle">
            <div class="bg-purple-100 rounded-lg px-2 py-1 inline-block text-purple-700 text-xs md:text-sm">
                @if($transaksis->count() > 0)
                    Rp {{ number_format($tableTotal / $transaksis->count(), 0, ',', '.') }}
                @else
                    Rp 0
                @endif
            </div>
        </td>
    </tr>
</tfoot>
                </table>
            </div>
        </div>
        
        <!-- Mobile scroll indicator -->
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