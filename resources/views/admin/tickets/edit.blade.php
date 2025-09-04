@extends('layouts.admin')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.tickets.index') }}" 
               class="mr-4 p-2 text-gray-600 hover:text-gray-800 transition duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-green-800">
                    <span class="text-green-700">✏️</span> Edit Stok Tiket
                </h1>
                <p class="text-gray-600 mt-1">Tambah stok tiket untuk {{ $stock->month }} {{ $stock->year }}</p>
            </div>
        </div>
    </div>

    <!-- Current Data Info - Moved to top -->
    <div class="max-w-2xl mx-auto mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-700 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-2">Informasi Stok Saat Ini:</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <span class="font-medium">Stok Awal:</span>
                            <span class="ml-1 px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                                {{ number_format($stock->initial_stock) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Terjual:</span>
                            <span class="ml-1 px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">
                                {{ number_format($stock->totalSold()) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Sisa:</span>
                            <span class="ml-1 px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                {{ number_format($stock->remainingStock()) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Persentase Terjual:</span>
                            <span class="ml-1 px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs">
                                {{ $stock->initial_stock > 0 ? round(($stock->totalSold() / $stock->initial_stock) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gray-100 border-b border-gray-300">
                <h2 class="text-lg font-semibold text-green-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Stok Tiket
                </h2>
            </div>
            
            <form action="{{ route('admin.tickets.update', $stock->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Bulan Field (Read Only) -->
                <div class="space-y-2">
                    <label for="month" class="block text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bulan
                    </label>
                    <input 
                        type="text" 
                        id="month"
                        name="month" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
                        value="{{ $stock->month }}" 
                        readonly
                    >
                    <p class="text-xs text-gray-500">Bulan tidak dapat diubah</p>
                </div>

                <!-- Tahun Field (Read Only) -->
                <div class="space-y-2">
                    <label for="year" class="block text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Tahun
                    </label>
                    <input 
                        type="number" 
                        id="year"
                        name="year" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed"
                        value="{{ $stock->year }}" 
                        readonly
                    >
                    <p class="text-xs text-gray-500">Tahun tidak dapat diubah</p>
                </div>

                <!-- Stok Tambahan Field -->
                <div class="space-y-2">
                    <label for="additional_stock" class="block text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Stok Tambahan <span class="text-red-700">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="additional_stock"
                        name="additional_stock" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-green-700 transition duration-200"
                        placeholder="Masukkan jumlah stok yang akan ditambahkan..."
                        value="{{ old('additional_stock') }}" 
                        required
                        min="1"
                    >
                    <p class="text-xs text-gray-500">Jumlah tiket yang akan ditambahkan ke stok yang sudah ada</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-300">
                    <a 
                        href="{{ route('admin.tickets.index') }}" 
                        class="flex-1 sm:flex-none bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg shadow-sm transition duration-200 flex items-center justify-center order-2 sm:order-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 sm:flex-none bg-green-800 hover:bg-green-900 text-white font-medium py-3 px-6 rounded-lg shadow-sm transition duration-200 flex items-center justify-center order-1 sm:order-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Stok
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Warning Card -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-700 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <div class="text-sm text-yellow-800">
                    <p class="font-medium mb-1">Perhatian:</p>
                    <ul class="space-y-1">
                        <li>• Stok yang ditambahkan akan ditambahkan ke stok yang sudah ada</li>
                        <li>• Stok baru akan langsung terlihat di halaman data tiket</li>
                        <li>• Pastikan jumlah stok yang ditambahkan sudah benar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection