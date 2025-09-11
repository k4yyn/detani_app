@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="bg-gradient-to-r from-green-700 to-green-800 p-6 rounded-t-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h1 class="text-2xl font-bold text-white">
                    Nota Harian
                    <span class="block sm:inline text-lg font-medium text-green-100 mt-1 sm:mt-0 sm:ml-2">
                        {{ now()->format('d M Y') }}
                    </span>
                </h1>
                <a href="{{ route('user.nota.notaHarian.cetak') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Nota Harian
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($transaksi->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-lg text-gray-500 font-medium">Tidak ada transaksi hari ini</p>
                <p class="text-sm text-gray-400 mt-1">Transaksi yang dilakukan akan muncul di sini</p>
            </div>
        @else
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-50 border-b border-green-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Transaksi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($transaksi as $t)
                        <tr class="hover:bg-green-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $t->kode_transaksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $t->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('user.transaksi.struk', $t->id) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6m1-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z" />
                                    </svg>
                                    Lihat Struk
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden p-4 space-y-4">
                @foreach($transaksi as $t)
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                {{ $t->kode_transaksi }}
                            </span>
                            <p class="text-sm text-gray-500">Transaksi #{{ $loop->iteration }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $t->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold text-green-600">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="{{ route('user.transaksi.struk', $t->id) }}" target="_blank"
                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6m1-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z" />
                            </svg>
                            Struk
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary Footer (if there are transactions) -->
            <div class="bg-green-50 px-6 py-4 border-t border-green-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600">
                    <span>Total {{ $transaksi->count() }} transaksi hari ini</span>
                    <span class="font-medium mt-1 sm:mt-0">
                        Total: <span class="text-green-600 font-semibold">Rp {{ number_format($transaksi->sum('total_harga'), 0, ',', '.') }}</span>
                    </span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection