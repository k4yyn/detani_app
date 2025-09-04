@extends('layouts.user')

@section('content')
<div class="w-full px-4 py-6 max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <span class="text-blue-600">💰</span> Input Penjualan Tiket
        </h1>
        <p class="text-gray-600">Catat penjualan tiket harian Anda</p>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 relative">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-green-800 mb-1">Berhasil!</h3>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" class="absolute top-2 right-2 p-1 text-green-600 hover:text-green-800" 
                    onclick="this.parentElement.style.display='none'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 relative">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-red-800 mb-1">Error!</h3>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
            <button type="button" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800" 
                    onclick="this.parentElement.style.display='none'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Stock Information Section -->
    <div class="bg-white shadow-lg rounded-lg mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Informasi Stok Bulan Ini
            </h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stok Awal -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 mb-1">Stok Awal</p>
                            <p class="text-2xl font-bold text-blue-800">{{ number_format($stock->initial_stock) }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Terjual -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-600 mb-1">Total Terjual</p>
                            <p class="text-2xl font-bold text-yellow-800">{{ number_format($stock->totalSold()) }}</p>
                            <p class="text-xs text-yellow-600">
                                {{ $stock->initial_stock > 0 ? round(($stock->totalSold() / $stock->initial_stock) * 100, 1) : 0 }}% terjual
                            </p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sisa Stok -->
                <div class="bg-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-50 border border-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-600 mb-1">
                                Sisa Stok
                            </p>
                            <p class="text-2xl font-bold text-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-800">
                                {{ number_format($stock->remainingStock()) }}
                            </p>
                            <p class="text-xs text-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-600">
                                @if($stock->remainingStock() <= 10)
                                    ⚠️ Stok hampir habis!
                                @else
                                    ✅ Stok tersedia
                                @endif
                            </p>
                        </div>
                        <div class="p-3 bg-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-100 rounded-full">
                            <svg class="w-6 h-6 text-{{ $stock->remainingStock() > 10 ? 'green' : 'red' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progress Penjualan</span>
                    <span>{{ $stock->initial_stock > 0 ? round(($stock->totalSold() / $stock->initial_stock) * 100, 1) : 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $stock->initial_stock > 0 ? ($stock->totalSold() / $stock->initial_stock) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Form Section -->
<div class="bg-white shadow-lg rounded-lg">
    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Form Input Penjualan
        </h2>
    </div>
    
    <form action="{{ route('user.tickets.store') }}" method="POST" class="p-6 space-y-6">
        @csrf
        <input type="hidden" name="ticket_stock_id" value="{{ $stock->id }}">
        
        <!-- Tanggal Penjualan -->
        <div class="space-y-2">
            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Penjualan <span class="text-red-500">*</span></label>
            <input type="date" name="date" id="date"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500"
                value="{{ now()->toDateString() }}" 
                min="{{ now()->startOfMonth()->toDateString() }}" 
                max="{{ now()->endOfMonth()->toDateString() }}" 
                required>
        </div>

        <!-- Jumlah Tiket Terjual -->
        <div class="space-y-2">
            <label for="sold_amount" class="block text-sm font-medium text-gray-700">Jumlah Tiket Terjual <span class="text-red-500">*</span></label>
            <input type="number" name="sold_amount" id="sold_amount"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500"
                placeholder="Masukkan jumlah..." min="1" max="{{ $stock->remainingStock() }}" required>
        </div>

        <!-- Harga per Tiket -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Harga per Tiket</label>
            <input type="text" id="price_per_ticket" name="price_per_ticket" readonly
                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Total Kotor -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Total Kotor</label>
            <input type="text" id="gross_total" name="gross_total" readonly
                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Diskon -->
        <div class="space-y-2">
            <label for="discount" class="block text-sm font-medium text-gray-700">Diskon</label>
            <input type="number" name="discount" id="discount" value="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Total Bersih -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Total Bersih</label>
            <input type="text" id="net_total" name="net_total" readonly
                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Catatan -->
        <div class="space-y-2">
            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
            <textarea name="notes" id="notes" rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500"
                placeholder="Tambahkan catatan jika ada..."></textarea>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 border-t border-gray-200">
            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg shadow-md flex items-center justify-center">
                Simpan Penjualan
            </button>
        </div>
    </form>
</div>


    <!-- Tips Section -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-medium mb-2">💡 Tips:</p>
                <ul class="space-y-1">
                    <li>• Input penjualan setiap hari untuk data yang akurat</li>
                    <li>• Pastikan jumlah tiket sesuai dengan yang benar-benar terjual</li>
                    <li>• Jika ada kesalahan, segera hubungi admin untuk koreksi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Script Auto Hitung -->
<script>
    const dateInput = document.getElementById('date');
    const soldInput = document.getElementById('sold_amount');
    const priceInput = document.getElementById('price_per_ticket');
    const grossInput = document.getElementById('gross_total');
    const discountInput = document.getElementById('discount');
    const netInput = document.getElementById('net_total');

    function updateTotals() {
        const date = new Date(dateInput.value);
        const day = date.getDay(); // 0 = Minggu, 6 = Sabtu
        const price = (day === 0 || day === 6) ? 25000 : 20000;

        const sold = parseInt(soldInput.value) || 0;
        const discount = parseInt(discountInput.value) || 0;

        const gross = sold * price;
        const net = Math.max(gross - discount, 0);

        priceInput.value = price.toLocaleString('id-ID');
        grossInput.value = gross.toLocaleString('id-ID');
        netInput.value = net.toLocaleString('id-ID');
    }

    dateInput.addEventListener('change', updateTotals);
    soldInput.addEventListener('input', updateTotals);
    discountInput.addEventListener('input', updateTotals);

    // initial load
    updateTotals();
</script>
@endsection