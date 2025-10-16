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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span>Transfer Stock ke Kantin 1</span>
                        </h1>
                        <p class="text-green-50 mt-1.5 text-sm sm:text-base">Tambah stock dari gudang ke kantin</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">
            <!-- Form Transfer -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 sm:p-6">
                <div class="flex items-center mb-5 sm:mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Transfer Barang Baru</h2>
                </div>
                
                @if($barangTersedia->count() > 0)
                    <form id="transferForm">
                        @csrf
                        
                        <!-- Pilih Barang -->
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Barang</label>
                            <select name="data_id" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow bg-white" 
                                    required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangTersedia as $item)
                                    <option value="{{ $item->id }}" 
                                            data-stock="{{ $item->stock_gudang ?: $item->stok }}"
                                            data-stock-kantin="{{ $item->stock_kantin1 }}">
                                        {{ $item->nama_barang }} 
                                        (Tersedia: {{ $item->stock_gudang ?: $item->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Info Stock -->
                        <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-5">
                            <div class="text-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                                <span class="block text-xs font-medium text-gray-600 mb-1.5">Stock Gudang</span>
                                <span id="stockGudangDisplay" class="text-xl sm:text-2xl font-bold text-gray-900">-</span>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                                <span class="block text-xs font-medium text-blue-700 mb-1.5">Stock Kantin 1</span>
                                <span id="stockKantinDisplay" class="text-xl sm:text-2xl font-bold text-blue-800">-</span>
                            </div>
                        </div>

                        <!-- Jumlah Transfer -->
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Transfer</label>
                            <input type="number" 
                                   name="jumlah" 
                                   min="1" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"
                                   placeholder="Masukkan jumlah"
                                   required>
                            <p class="text-xs sm:text-sm text-gray-500 mt-2 flex items-center" id="maxStockInfo">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Maksimal: -
                            </p>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                            <textarea name="keterangan" 
                                      rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow resize-none"
                                      placeholder="Catatan transfer..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-3 px-4 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg flex items-center justify-center text-sm sm:text-base">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Transfer Stock
                        </button>
                    </form>
                @else
                    <div class="text-center py-8 sm:py-12">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Stock gudang kosong</h3>
                        <p class="text-sm text-gray-500">Tidak ada barang yang bisa ditransfer dari gudang</p>
                    </div>
                @endif
            </div>

            <!-- Riwayat Transfer Hari Ini -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-5 sm:p-6">
                <div class="flex items-center mb-5 sm:mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Riwayat Transfer Hari Ini</h2>
                </div>
                
                @if($transferHariIni->count() > 0)
                    <div class="space-y-3 max-h-[450px] overflow-y-auto pr-1">
                        @foreach($transferHariIni as $transfer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $transfer->data->nama_barang }}</h4>
                                        <div class="flex flex-wrap items-center gap-3 mt-2 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-800 rounded-lg font-semibold">
                                                <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                {{ $transfer->jumlah }} unit
                                            </span> 
                                            <span class="text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $transfer->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                            </span>
                                        </div>
                                        @if($transfer->keterangan)
                                            <p class="text-xs sm:text-sm text-gray-600 mt-2 bg-gray-50 px-2.5 py-1.5 rounded">{{ $transfer->keterangan }}</p>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 whitespace-nowrap">
                                        ✓ Selesai
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="mt-5 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 text-sm">
                            <span class="text-gray-600 font-medium">Total Transfer Hari Ini:</span>
                            <span class="font-bold text-gray-900">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $transferHariIni->count() }} barang
                                </span>
                                <span class="mx-2">•</span>
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    {{ $transferHariIni->sum('jumlah') }} unit
                                </span>
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 sm:py-12">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Belum ada transfer hari ini</h3>
                        <p class="text-sm text-gray-500">Riwayat transfer akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transferForm');
    if (!form) return;

    const barangSelect = form.querySelector('select[name="data_id"]');
    const jumlahInput = form.querySelector('input[name="jumlah"]');
    const stockGudangDisplay = document.getElementById('stockGudangDisplay');
    const stockKantinDisplay = document.getElementById('stockKantinDisplay');
    const maxStockInfo = document.getElementById('maxStockInfo');

    // Update stock info when barang is selected
    barangSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stockGudang = selectedOption.getAttribute('data-stock');
        const stockKantin = selectedOption.getAttribute('data-stock-kantin');

        if (stockGudang) {
            stockGudangDisplay.textContent = stockGudang;
            stockKantinDisplay.textContent = stockKantin;
            maxStockInfo.innerHTML = `
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Maksimal: ${stockGudang} unit
            `;
            jumlahInput.max = stockGudang;
            jumlahInput.placeholder = `1 - ${stockGudang}`;
        } else {
            stockGudangDisplay.textContent = '-';
            stockKantinDisplay.textContent = '-';
            maxStockInfo.innerHTML = `
                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Maksimal: -
            `;
            jumlahInput.removeAttribute('max');
        }
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        // Show loading state
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
        submitButton.disabled = true;

        fetch('{{ route("user.stock-kantin.proses-transfer") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);
                
                // Reset form
                form.reset();
                stockGudangDisplay.textContent = '-';
                stockKantinDisplay.textContent = '-';
                maxStockInfo.innerHTML = `
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Maksimal: -
                `;
                
                // Reload page after 1 second to update history
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan saat transfer');
        })
        .finally(() => {
            // Restore button state
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        });
    });

    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.transfer-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        // Create alert element
        const alert = document.createElement('div');
        alert.className = `transfer-alert fixed top-4 right-4 z-50 p-4 rounded-lg shadow-xl max-w-sm animate-slide-in ${
            type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
        }`;
        alert.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                            type === 'success' ? 'M5 13l4 4L19 7' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                        }"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 flex-shrink-0 text-white hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(alert);

        // Remove alert after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>

<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}

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
</style>
@endsection