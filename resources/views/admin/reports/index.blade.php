@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6 animate-fadeIn">
    @php
        $totalPendapatan = $total ?? 0;
        $totalTransaksi = $transaksis->count();
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
    @endphp

    <!-- Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start mb-8">
        <div class="mb-6 lg:mb-0">
            <h1 class="text-2xl font-semibold text-gray-800 mb-2">Laporan Transaksi</h1>
            <p class="text-gray-600">Ringkasan data transaksi bisnis</p>
        </div>

        <div class="flex gap-3">
            <button id="exportExcel" class="bg-green-50 hover:bg-green-100 border border-green-200 px-4 py-2 text-green-700 rounded-lg text-sm font-medium flex items-center transition-colors">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
            <button id="exportPDF" class="bg-red-50 hover:bg-red-100 border border-red-200 px-4 py-2 text-red-700 rounded-lg text-sm font-medium flex items-center transition-colors">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </button>
        </div>
    </div>

    <!-- Filter Info -->
    @if(request('start_date') && request('end_date'))
        <div class="text-sm text-gray-600 mb-4">
            Menampilkan data dari <strong>{{ request('start_date') }}</strong> sampai <strong>{{ request('end_date') }}</strong>
        </div>
    @elseif(request('filter'))
        <div class="text-sm text-gray-600 mb-4">
            Menampilkan data filter: <strong>{{ ucfirst(request('filter')) }}</strong>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-8">
        <h3 class="text-lg font-medium text-black mb-4">Filter Laporan</h3>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-black mb-2">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 rounded-lg border border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-black mb-2">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 rounded-lg border border-gray-300">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium">
                    <i class="fas fa-search mr-2"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-summary-card title="Total Transaksi" value="{{ number_format($totalTransaksi) }}" icon="fas fa-receipt" color="blue" desc="Transaksi tercatat" />
        <x-summary-card title="Total Pendapatan" value="Rp {{ number_format($totalPendapatan, 0, ',', '.') }}" icon="fas fa-coins" color="green" desc="Revenue terkumpul" />
        <x-summary-card title="Rata-rata Transaksi" value="Rp {{ number_format($rataRata, 0, ',', '.') }}" icon="fas fa-chart-line" color="purple" desc="Per transaksi" />
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="bg-indigo-50 border-b border-indigo-200 px-6 py-4">
            <h3 class="text-lg font-medium text-black">Detail Transaksi</h3>
        </div>

        <div class="overflow-x-auto">
            <table id="transactionTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase">Kasir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-indigo-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-blue-600">{{ $transaksi->kode_transaksi }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $transaksi->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $transaksi->details->sum('qty') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Tidak ada transaksi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($transaksis instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4 px-4">
            {{ $transaksis->withQueryString()->links() }}
        </div>
    @endif

    <!-- Footer -->
    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 bg-slate-50 border border-slate-200 rounded-lg p-4 mt-6">
        <div class="flex items-center mb-2 md:mb-0">
            <i class="fas fa-info-circle mr-2 text-slate-500"></i>
            <span>Data diperbarui secara real-time</span>
        </div>
        <div class="flex items-center">
            <i class="fas fa-clock mr-2 text-slate-500"></i>
            <span>Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB</span>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
    }

    thead th.sticky {
        position: sticky;
        top: 0;
        background-color: #eef2ff;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('exportPDF').addEventListener('click', function () {
            const btn = this;
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Membuat PDF...';
            btn.disabled = true;

            const element = document.querySelector('.bg-white.rounded-lg.shadow-sm');

            html2canvas(element, {
                scale: 2,
                useCORS: true,
                scrollY: -window.scrollY
            }).then(canvas => {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 210;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let position = 0;

                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                pdf.save('Laporan_Transaksi_{{ \Carbon\Carbon::now()->format("Ymd_His") }}.pdf');
                btn.innerHTML = original;
                btn.disabled = false;
            }).catch(err => {
                console.error(err);
                alert('Gagal membuat PDF');
                btn.innerHTML = original;
                btn.disabled = false;
            });
        });

        document.getElementById('exportExcel').addEventListener('click', function () {
            const table = document.getElementById('transactionTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Laporan" });
            XLSX.writeFile(wb, 'Laporan_Transaksi_{{ \Carbon\Carbon::now()->format("Ymd_His") }}.xlsx');
        });
    });
</script>
@endpush
