@extends('layouts.user')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">

    <!-- Notifikasi sukses + tombol cetak struk  -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if(session('kembalian'))
                <br>Kembalian: Rp {{ number_format(session('kembalian')) }}
            @endif
            @if(session('last_transaksi_id'))
                <br><a href="{{ route('user.transaksi.struk', session('last_transaksi_id')) }}" target="_blank" class="btn btn-sm btn-primary mt-2">Cetak Struk</a>
            @endif
        </div>
    @endif

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <a href="{{ route('user.transaksi.index') }}" class="p-2 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h2>
            </div>
            @if(count($keranjang) > 0)
                <button onclick="clearCart()" class="text-red-500 hover:text-red-700 text-sm font-medium">
                    Kosongkan Keranjang
                </button>
            @endif
        </div>

        @if (count($keranjang) == 0)
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6M9 17h6"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-500 mb-6">Belum ada produk di keranjang Anda</p>
                <a href="{{ route('user.transaksi.index') }}" 
                   class="inline-flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Mulai Belanja</span>
                </a>
            </div>
        @else

           <!-- Cart Items -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700">Produk</th>
                    <th class="text-center py-4 px-4 font-semibold text-gray-700">Harga</th>
                    <th class="text-center py-4 px-4 font-semibold text-gray-700">Qty</th>
                    <th class="text-right py-4 px-4 font-semibold text-gray-700">Subtotal</th>
                    <th class="text-center py-4 px-4 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                @foreach ($keranjang as $index => $item)
                    <tr class="border-b hover:bg-gray-50 cart-item" data-id="{{ $item['id'] }}">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $item['nama'] }}</h4>
                                    <p class="text-sm text-gray-500">ID: {{ $item['id'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center text-gray-700">
                            Rp {{ number_format($item['harga']) }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center justify-center space-x-2">
                                <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['qty'] - 1 }})" 
                                        class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors {{ $item['qty'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       value="{{ $item['qty'] }}" 
                                       min="1" 
                                       class="w-16 text-center border border-gray-300 rounded-lg py-1 quantity-input"
                                       data-id="{{ $item['id'] }}"
                                       onchange="updateQuantity({{ $item['id'] }}, this.value)">
                                <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['qty'] + 1 }})" 
                                        class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-right font-semibold text-gray-800 subtotal">
                            Rp {{ number_format($item['subtotal']) }}
                        </td>
                        <td class="py-4 px-4 text-center space-x-1">
                            <button onclick="openEditModal({{ $item['id'] }}, {{ $item['harga'] }}, {{ $item['diskon'] ?? 0 }})" 
                                    class="text-blue-500 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                            <button onclick="removeItem({{ $item['id'] }})" 
                                    class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-700">Total Belanja:</span>
                    <span class="text-2xl font-bold text-orange-600" id="total-amount">Rp {{ number_format($total) }}</span>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pembayaran</h3>
                <form action="{{ route('user.transaksi.checkout') }}" method="POST" id="checkout-form">
                    @csrf
                    <!-- Tambahan Informasi Transaksi -->
                    <div class="mb-4">
                        <button type="button" onclick="toggleTransaksiInfo()" class="text-sm text-orange-600 hover:underline">
                            + Tambahkan Info Transaksi (Opsional)
                        </button>
                        <div id="transaksi-info" class="mt-4 space-y-4 hidden">
                            <input type="hidden" name="no_transaksi" id="no_transaksi">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Meja</label>
                                <input type="text" name="nomor_meja" class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                                <input type="text" name="keterangan_tambahan" class="w-full border rounded-lg px-4 py-2">
                            </div>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Bayar *</label>
                            <input type="number" 
                                   name="bayar" 
                                   id="bayar-input"
                                   placeholder="Masukkan jumlah bayar" 
                                   required 
                                   min="{{ $total }}"
                                   step="1000"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   oninput="calculateChange()">
                            <div class="mt-2 space-x-2">
                                <button type="button" onclick="setExactAmount()" class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">Pas</button>
                                <button type="button" onclick="setBayar({{ $total + 5000 }})" class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">+5K</button>
                                <button type="button" onclick="setBayar({{ $total + 10000 }})" class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">+10K</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kembalian</label>
                            <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700 font-semibold" id="kembalian-display">
                                Rp 0
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (opsional)</label>
                        <textarea name="keterangan" 
                                  rows="3"
                                  placeholder="Catatan untuk transaksi ini..." 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"></textarea>
                         <label class="inline-flex items-center mt-2">
                            <input type="checkbox" name="cetak_struk" class="form-checkbox text-indigo-600">
                            <span class="ml-2 text-sm text-gray-700">Cetak Struk setelah checkout</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <option value="Cash">Cash</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('user.transaksi.index') }}" 
                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center px-6 py-3 rounded-lg font-medium transition-colors">
                            Tambah Produk
                        </a>
                        <button type="submit" 
                                id="checkout-btn"
                                class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="checkout-text">Proses Pembayaran</span>
                            <span class="checkout-loading hidden">
                                <svg class="w-5 h-5 animate-spin inline mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="w-6 h-6 animate-spin text-orange-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">Memproses transaksi...</span>
        </div>
    </div>
    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
            <h3 class="text-lg font-semibold mb-4">Edit Harga & Diskon</h3>
            <form id="editForm">
                <input type="hidden" id="editItemId">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                    <input type="number" id="editHarga" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Diskon (Rp)</label>
                    <input type="number" id="editDiskon" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">Simpan</button>
                </div>
            </form>
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">✕</button>
        </div>
    </div>
     @if(session('success_checkout'))
        <div class="mb-6">
            <a href="{{ route('user.transaksi.struk', session('success_checkout')) }}" 
            target="_blank"
            class="inline-flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6m1-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z"></path>
                </svg>
                <span>Cetak Struk</span>
            </a>
        </div>
    @endif
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let currentTotal = {{ $total }};

    // --- Update quantity ---
    async function updateQuantity(productId, newQty) {
        if (newQty < 1) return;

        try {
            const response = await fetch(`/user/transaksi/keranjang/update/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ qty: newQty })
            });

            const data = await response.json();
            if (data.success) location.reload();
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal mengupdate quantity');
        }
    }

    // --- Remove item ---
    async function removeItem(productId) {
        if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;

        showLoading(true);
        try {
            const url = `{{ url('user/transaksi/keranjang/hapus') }}/${productId}`;
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            if (data.success) location.reload();
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menghapus item');
        } finally {
            showLoading(false);
        }
    }

    // --- Clear cart ---
    function clearCart() {
        if (!confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) return;
        alert('Fitur kosongkan keranjang akan diimplementasikan');
    }

    // --- Hitung kembalian ---
    function calculateChange() {
        const bayarInput = document.getElementById('bayar-input');
        const kembalianDisplay = document.getElementById('kembalian-display');
        const checkoutBtn = document.getElementById('checkout-btn');

        const bayar = parseFloat(bayarInput.value) || 0;
        const kembalian = bayar - currentTotal;

        if (kembalian >= 0) {
            kembalianDisplay.textContent = `Rp ${formatNumber(kembalian)}`;
            kembalianDisplay.classList.remove('text-red-600');
            kembalianDisplay.classList.add('text-gray-700');
            checkoutBtn.disabled = false;
        } else {
            kembalianDisplay.textContent = `Kurang Rp ${formatNumber(Math.abs(kembalian))}`;
            kembalianDisplay.classList.add('text-red-600');
            checkoutBtn.disabled = true;
        }
    }

    // --- Bayar otomatis dan preset ---
    function setExactAmount() {
        document.getElementById('bayar-input').value = currentTotal;
        calculateChange();
    }

    function setBayar(amount) {
        document.getElementById('bayar-input').value = amount;
        calculateChange();
    }

    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function showLoading(show) {
        const overlay = document.getElementById('loading-overlay');
        overlay.classList.toggle('hidden', !show);
    }

    // --- Checkout submit handler ---
    document.getElementById('checkout-form').addEventListener('submit', function (e) {
        const checkoutBtn = document.getElementById('checkout-btn');
        const checkoutText = checkoutBtn.querySelector('.checkout-text');
        const checkoutLoading = checkoutBtn.querySelector('.checkout-loading');

        checkoutText.classList.add('hidden');
        checkoutLoading.classList.remove('hidden');
        checkoutBtn.disabled = true;
});

    // --- Modal edit harga/diskon ---
    function openEditModal(id, harga, diskon) {
        document.getElementById('editItemId').value = id;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editDiskon').value = diskon || 0;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }

    document.getElementById('editForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const id = document.getElementById('editItemId').value;
        const harga = parseInt(document.getElementById('editHarga').value);
        const diskon = parseInt(document.getElementById('editDiskon').value) || 0;

        try {
            const url = `{{ url('user/transaksi/keranjang/edit') }}/${id}`;
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ harga, diskon })
            });

            const result = await response.json();

            if (result.success) {
                closeEditModal();
                location.reload();
            } else {
                alert('Gagal menyimpan perubahan: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        }
    });

    function toggleTransaksiInfo() {
        document.getElementById('transaksi-info').classList.toggle('hidden');
    }

    // --- Generate nomor transaksi otomatis saat halaman dimuat ---
    document.addEventListener('DOMContentLoaded', function () {
        calculateChange();

        const now = new Date();
        const kode = `TRX${now.getFullYear()}${(now.getMonth()+1).toString().padStart(2,'0')}${now.getDate().toString().padStart(2,'0')}${now.getHours().toString().padStart(2,'0')}${now.getMinutes().toString().padStart(2,'0')}${now.getSeconds().toString().padStart(2,'0')}`;
        const noTransaksiInput = document.getElementById('no_transaksi');
        if (noTransaksiInput) {
            noTransaksiInput.value = kode;
        }
    });
</script>

<style>
@media (max-width: 768px) {
    .overflow-x-auto table {
        font-size: 0.875rem;
    }
    
    .overflow-x-auto th,
    .overflow-x-auto td {
        padding: 0.75rem 0.5rem;
    }
}
</style>
@endsection