@extends('layouts.admin')

@section('title', 'Laporan Bulanan')
@section('header', 'Laporan Bulanan')

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

            <button id="toggleFilter" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 px-3 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:shadow-sm">
                <i class="fas fa-filter text-gray-700"></i>
            </button>
        </div>

        <div class="flex-1 flex flex-col items-center text-center mt-4 md:mt-0 md:order-2">
            <h2 class="text-xl md:text-2xl font-bold text-white mb-1">
                Laporan Transaksi Bulanan
            </h2>
            @if($selectedMonth)
                <span class="text-sm text-gray-300">
                    Bulan {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
                </span>
            @endif
        </div>

        <div class="flex-shrink-0 mt-4 md:mt-0 md:order-3">
            <button id="exportExcel"
                    class="bg-orange-100 hover:bg-orange-200 border border-orange-300 px-4 py-2.5 text-orange-700 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-200 hover:shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                Export Excel
            </button>
        </div>
    </div>
</div>

<form id="filterForm" method="GET" action="{{ route('admin.reports.monthly') }}" class="flex flex-col sm:flex-row items-center gap-2 mt-4 hidden">
    <label for="month" class="font-semibold whitespace-nowrap text-gray-800">Pilih Bulan:</label>
    <input type="month" name="month" id="month" value="{{ $selectedMonth }}" 
           class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-emerald-600 focus:border-transparent">
    <button type="submit" class="bg-emerald-700 text-white px-4 py-2 rounded hover:bg-emerald-800 transition whitespace-nowrap">
        Tampilkan
    </button>
</form>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-green-200">
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
                        <th scope="col" class="px-3 md:px-6 py-3 md:py-4 text-left text-xs md:text-sm font-semibold text-white uppercase tracking-wider">
                            Jenis
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
                    @php
                        $groupOrder = ['owner', 'karyawan', 'lainnya', 'pelanggan'];
                        $groupLabels = [
                            'owner' => 'Transaksi Owner',
                            'karyawan' => 'Transaksi Karyawan', 
                            'lainnya' => 'Transaksi Lainnya',
                            'pelanggan' => 'Transaksi Pelanggan'
                        ];
                        $groupColors = [
                            'owner' => 'bg-green-50 border-green-200',
                            'karyawan' => 'bg-purple-50 border-purple-200',
                            'lainnya' => 'bg-orange-50 border-orange-200', 
                            'pelanggan' => 'bg-blue-50 border-blue-200'
                        ];
                        $groupIcons = [
                            'owner' => 'fas fa-crown text-green-600',
                            'karyawan' => 'fas fa-user-tie text-purple-600',
                            'lainnya' => 'fas fa-ellipsis-h text-orange-600',
                            'pelanggan' => 'fas fa-users text-blue-600'
                        ];
                    @endphp

                    @forelse($groupOrder as $group)
                        @if(isset($groupedTransaksis[$group]) && $groupedTransaksis[$group]->count() > 0)
                            <!-- GROUP HEADER -->
                            <tr class="{{ $groupColors[$group] }} border-t-4 border-l-4 border-r-4">
                                <td colspan="7" class="px-4 py-3">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div class="flex items-center">
                                            <i class="{{ $groupIcons[$group] }} mr-3 text-lg"></i>
                                            <span class="text-lg font-bold text-gray-800">{{ $groupLabels[$group] }}</span>
                                            <span class="ml-3 px-2 py-1 text-xs font-medium bg-white rounded-full border">
                                                {{ $groupedTransaksis[$group]->count() }} transaksi
                                            </span>
                                        </div>
                                        <div class="text-sm font-semibold text-gray-700">
                                            Total Group: Rp {{ number_format($groupedTransaksis[$group]->sum('total_harga'), 0, ',', '.') }}
                                        </div>
                                    </div>
                                </td>
                            </tr>

                                    <!-- DATA PER GROUP -->
                                    @foreach($groupedTransaksis[$group] as $t)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-l-4 border-r-4 
                                        {{ $loop->last ? 'border-b-4' : '' }} 
                                        {{ $group == 'owner' ? 'border-green-200' : '' }}
                                        {{ $group == 'karyawan' ? 'border-purple-200' : '' }}
                                        {{ $group == 'lainnya' ? 'border-orange-200' : '' }}
                                        {{ $group == 'pelanggan' ? 'border-blue-200' : '' }}">
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
                                     <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $badgeColors = [
                                                    'pelanggan' => 'bg-blue-100 text-blue-800',
                                                    'owner' => 'bg-green-100 text-green-800',
                                                    'karyawan' => 'bg-purple-100 text-purple-800',
                                                    'lainnya' => 'bg-orange-100 text-orange-800'
                                                ];
                                                $color = $badgeColors[$t->jenis_transaksi] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <div class="flex flex-col gap-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                    {{ ucfirst($t->jenis_transaksi) }}
                                                </span>
                                                @if($t->jenis_transaksi === 'lainnya' && $t->pelaku_transaksi)
                                                    <span class="text-xs text-orange-600 font-medium">
                                                        <i class="fas fa-user-circle mr-1"></i>
                                                        {{ $t->pelaku_transaksi }}
                                                    </span>
                                                @endif
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
                            @endforeach
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
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
                    @php
                        $tableTotal = $transaksis->sum('total_harga');
                    @endphp
                    <tr class="border-t-2 border-green-700">
                        <td class="px-2 md:px-3 py-4 md:py-6 text-right font-bold text-green-900 text-xs md:text-sm align-middle" colspan="2">
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
                        <td class="px-2 md:px-3 py-4 md:py-6 font-bold text-sm md:text-base text-green-900 align-middle text-left" colspan="3">
                            <div class="bg-blue-100 rounded-lg px-2 py-1 inline-block text-blue-700 text-xs md:text-sm">
                                Rp {{ number_format($tableTotal, 0, ',', '.') }}
                            </div>
                        </td>
                    </tr>
                    <tr class="bg-green-50">
                        <td colspan="4" class="px-2 md:px-3 py-4 md:py-6 text-right font-bold text-green-900 text-xs md:text-sm align-middle">
                            Rata-rata transaksi:
                        </td>
                        <td colspan="3" class="px-2 md:px-3 py-4 md:py-6 font-bold text-sm md:text-base text-green-900 align-middle">
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
            const table = document.getElementById('transactionTable');
            const tableClone = table.cloneNode(true);
            const tfoot = tableClone.querySelector('tfoot');
            if (tfoot) {
                tfoot.remove();
            }
            const wb = XLSX.utils.table_to_book(tableClone, { sheet: "Laporan" });
            const month = @json(\Carbon\Carbon::parse($selectedMonth)->format('Y_m'));
            const timestamp = new Date().toISOString().slice(0, 19).replace(/[-T:]/g, "");
            const filename = `Laporan_Bulanan_${month}_${timestamp}.xlsx`;
            XLSX.writeFile(wb, filename);
        });

        // Event listener for toggling the filter form
        document.getElementById('toggleFilter').addEventListener('click', function() {
            const filterForm = document.getElementById('filterForm');
            filterForm.classList.toggle('hidden');
        });
    });
</script>
@endpush