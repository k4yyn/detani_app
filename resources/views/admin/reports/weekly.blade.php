@extends('layouts.admin')

@section('title', 'Laporan Mingguan')
@section('header', 'Laporan Transaksi Mingguan')

@section('content')
    <!-- Header Section -->
    <div class="bg-green-900 rounded-xl shadow-sm border border-green-200 p-6 mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <div class="flex-shrink-0 order-2 md:order-1 w-full md:w-auto">
            <a href="{{ route('admin.reports.index') }}"
                class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg text-sm font-medium transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="flex-1 flex flex-col items-center text-center order-1 md:order-2">
            <h2 class="text-xl md:text-2xl font-bold text-white">Laporan Transaksi Minggu Ini</h2>
            <span class="text-sm text-gray-300 mt-1">{{ now()->format('d F Y') }}</span>
        </div>

        <div class="flex-shrink-0 order-3 md:order-3 w-full md:w-auto mt-4 md:mt-0">
            <button id="exportExcel"
                    class="bg-orange-100 hover:bg-orange-200 border border-orange-300 px-4 py-2.5 text-orange-700 rounded-lg text-sm font-medium flex items-center justify-center w-full transition-all duration-200 hover:shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                Export Excel
            </button>
        </div>
    </div>
</div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-green-200">
        <!-- Responsive Table Container -->
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-300">
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
                        @php $total = 0; @endphp
                        @forelse ($transaksis as $t)
                            @php $total += $t->total_harga; @endphp
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
                                    {{ $t->user->name ?? '-'}}
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
                                        <p class="text-lg font-medium text-gray-500 mb-1">Tidak ada transaksi minggu ini</p>
                                        <p class="text-sm text-gray-400">Belum ada data transaksi untuk ditampilkan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-green-50">
                        <tr class="border-t-2 border-green-700">
                            <td colspan="3" class="px-3 md:px-6 py-4 md:py-6 text-right font-bold text-green-900 text-sm md:text-lg">
                                Total Minggu Ini:
                            </td>
                            <td colspan="3" class="px-3 md:px-6 py-4 md:py-6 font-bold text-lg md:text-xl text-green-900">
                                <div class="bg-blue-100 rounded-lg px-3 py-2 inline-block text-blue-700">
                                    Rp {{ number_format($total, 0, ',', '.') }}
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
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportExcel').addEventListener('click', function () {
        const table = document.querySelector('table'); // Ambil tabel pertama
        const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan Mingguan" });
        XLSX.writeFile(wb, "laporan_mingguan_{{ date('Y-m-d') }}.xlsx");
    });
</script>
@endpush