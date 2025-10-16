{{-- resources/views/user/stock-kantin/verifikasi.blade.php --}}
@extends('layouts.user')

@section('content')
<div class="min-h-screen py-4 md:py-8 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-lg md:rounded-xl shadow-md border border-gray-200 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-green-700 to-green-600 px-4 sm:px-6 lg:px-8 py-5 md:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Verifikasi Stock Kantin 1</span>
                        </h1>
                        <p class="text-green-50 mt-1.5 text-sm sm:text-base">Cek kesesuaian stock fisik dengan sistem</p>
                    </div>
                    <a href="{{ route('user.stock-kantin.dashboard') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg transition-colors text-sm font-medium whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-5 lg:p-6 mb-6">
            <form action="{{ route('user.stock-kantin.verifikasi') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Verifikasi</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition-all duration-200 hover:shadow-md font-medium text-sm">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Verifikasi Form -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            @if($barangKantin1->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($barangKantin1 as $item)
                        @php
                            $existing = $existingVerifikasi[$item->id] ?? null;
                        @endphp
                        <div class="p-4 sm:p-5 lg:p-6 hover:bg-gray-50 transition-colors verifikasi-item" data-item-id="{{ $item->id }}">
                            <div class="flex flex-col gap-4">
                                <!-- Product Info -->
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-11 h-11 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 text-base sm:text-lg">{{ $item->nama_barang }}</h3>
                                        <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5 text-xs sm:text-sm text-gray-600">
                                            <span class="inline-flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                {{ $item->codetrx }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                {{ $item->kategori }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $item->lokasi_penyimpanan }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Comparison Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                                    <!-- System Stock -->
                                    <div class="text-center">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Stock Sistem</label>
                                        <div class="px-3 py-2.5 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg text-gray-900 font-bold text-lg border border-gray-300">
                                            {{ $item->stock_kantin1 }}
                                        </div>
                                    </div>

                                    <!-- Physical Stock Input -->
                                    <div class="text-center">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Stock Fisik</label>
                                        <input type="number" 
                                               name="stock_fisik"
                                               value="{{ $existing ? $existing->stock_fisik : '' }}" 
                                               min="0"
                                               class="w-full px-3 py-2.5 border-2 border-blue-300 rounded-lg text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold text-lg stock-fisik-input"
                                               placeholder="{{ $item->stock_kantin1 }}"
                                               onchange="simpanStatus('{{ $item->id }}')">
                                    </div>

                                    <!-- Status Indicator -->
                                    <div class="text-center col-span-2 sm:col-span-1">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Status</label>
                                        <div class="px-3 py-2.5 rounded-lg font-bold text-sm cursor-pointer hover:scale-105 transition-transform status-indicator
                                            @if($existing)
                                                {{ $existing->status == 'match' ? 'bg-green-100 text-green-800 border-2 border-green-300' : 'bg-red-100 text-red-800 border-2 border-red-300' }}
                                            @else
                                                bg-gray-100 text-gray-800 border-2 border-gray-300
                                            @endif"
                                            data-item-id="{{ $item->id }}"
                                            onclick="simpanStatus('{{ $item->id }}')">
                                            
                                            @if($existing)
                                                {{ $existing->status == 'match' ? '✅ Match' : '❌ Selisih' }}
                                            @else
                                                <span class="status-text">✅ Match</span> 
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="text-center col-span-2 lg:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-600 mb-2">Keterangan</label>
                                        <input type="text" 
                                               name="keterangan"
                                               value="{{ $existing ? $existing->keterangan : '' }}"
                                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow text-sm keterangan-input"
                                               placeholder="Catatan (opsional)">
                                    </div>
                                </div>

                                <!-- Auto-save indicator -->
                                <div class="text-right">
                                    <div class="save-status inline-flex items-center text-sm" data-item-id="{{ $item->id }}">
                                        @if($existing)
                                            <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="text-green-600 font-medium">Tersimpan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-5 lg:px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm">
                        <span class="text-gray-600 font-medium">
                            <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Total {{ $barangKantin1->count() }} barang di kantin 1
                        </span>
                        <span class="text-gray-900 font-bold">
                            <svg class="w-4 h-4 inline mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span id="saved-count">{{ $existingVerifikasi->count() }}</span> dari {{ $barangKantin1->count() }} tersimpan
                        </span>
                    </div>
                </div>

            @else
                <div class="p-8 sm:p-12 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Belum ada barang di kantin 1</h3>
                    <p class="text-sm text-gray-500 mb-6">Transfer barang dari gudang terlebih dahulu</p>
                    <a href="{{ route('user.stock-kantin.transfer') }}" 
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 hover:shadow-md text-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Transfer dari Gudang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-save when input changes
    document.querySelectorAll('.stock-fisik-input, .keterangan-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.closest('.verifikasi-item').dataset.itemId;
            saveVerifikasi(itemId);
        });
    });

    // Auto-update status when physical stock changes
    document.querySelectorAll('.stock-fisik-input').forEach(input => {
        input.addEventListener('input', function() {
            updateStatusIndicator(this);
        });
    });

    // NEW: Function to save when status is clicked
    window.simpanStatus = function(itemId) {
        saveVerifikasi(itemId);
    }

    function updateStatusIndicator(inputElement) {
        const itemElement = inputElement.closest('.verifikasi-item');
        const systemStock = parseInt(itemElement.querySelector('.from-gray-100').textContent.trim());
        const physicalStock = inputElement.value ? parseInt(inputElement.value) : systemStock;
        
        const statusIndicator = itemElement.querySelector('.status-indicator');
        
        // HANYA UPDATE VISUAL, TIDAK UBAH NILAI
        if (physicalStock === systemStock) {
            statusIndicator.className = 'px-3 py-2.5 rounded-lg font-bold text-sm cursor-pointer hover:scale-105 transition-transform status-indicator bg-green-100 text-green-800 border-2 border-green-300';
            statusIndicator.innerHTML = '✅ Match';
        } else {
            statusIndicator.className = 'px-3 py-2.5 rounded-lg font-bold text-sm cursor-pointer hover:scale-105 transition-transform status-indicator bg-red-100 text-red-800 border-2 border-red-300';
            statusIndicator.innerHTML = '❌ Selisih';
        }
    }

    function saveVerifikasi(itemId) {
        const itemElement = document.querySelector(`.verifikasi-item[data-item-id="${itemId}"]`);
        const formData = new FormData();
        
        const systemStock = parseInt(itemElement.querySelector('.from-gray-100').textContent.trim());
        const physicalStockInput = itemElement.querySelector('.stock-fisik-input');
        const physicalStock = physicalStockInput.value ? parseInt(physicalStockInput.value) : systemStock;
        
        // Tentukan status berdasarkan perbandingan stok
        const status = physicalStock === systemStock ? 'match' : 'selisih';
        
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('data_id', itemId);
        formData.append('tanggal', '{{ $tanggal }}');
        formData.append('stock_fisik', physicalStock);
        formData.append('keterangan', itemElement.querySelector('.keterangan-input').value);
        formData.append('status', status);

        const statusElement = itemElement.querySelector('.save-status');
        statusElement.innerHTML = `
            <svg class="animate-spin w-4 h-4 mr-1 text-blue-600 inline" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-blue-600 font-medium">Menyimpan...</span>
        `;

        fetch('{{ route("user.stock-kantin.simpan-verifikasi") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusElement.innerHTML = `
                    <svg class="w-4 h-4 mr-1 text-green-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-green-600 font-medium">Tersimpan</span>
                `;
                updateSavedCount();
                
                // Update visual status setelah save
                updateStatusIndicator(physicalStockInput);
            } else {
                statusElement.innerHTML = `
                    <svg class="w-4 h-4 mr-1 text-red-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-red-600 font-medium">Gagal</span>
                `;
            }
        })
        .catch(error => {
            statusElement.innerHTML = `
                <svg class="w-4 h-4 mr-1 text-red-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-600 font-medium">Error</span>
            `;
        });
    }

    function updateSavedCount() {
        const savedItems = document.querySelectorAll('.save-status:not(:empty)').length;
        document.getElementById('saved-count').textContent = savedItems;
    }

    // Initial status update for existing values
    document.querySelectorAll('.stock-fisik-input').forEach(input => {
        // Set default value jika kosong
        if (!input.value) {
            const systemStock = parseInt(input.closest('.verifikasi-item').querySelector('.from-gray-100').textContent.trim());
            input.value = systemStock;
        }
        updateStatusIndicator(input);
    });
});
</script>

<style>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Remove number input arrows on some browsers */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
}
</style>
@endsection