@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Flash Message -->
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header with Search and Filter -->
    <div class="bg-white shadow-sm border-b sticky top-0 z-40">
        <div class="px-4 py-3">
            <!-- Top Bar -->
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-3">
                    <button class="p-2 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-green-700">TRANSAKSI</h1>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

                    
            <!-- Search and Filter Bar -->
            <div class="flex items-center space-x-3">
                <!-- Search Icon -->
                <button id="search-toggle" class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Search Input (hidden by default) -->
                <input type="text" id="search-input" class="hidden border p-1 rounded-md" placeholder="Cari...">

                
                <!-- Add Button -->
                <button class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
                
                
                <!-- Barcode -->
                <button class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
                
                <!-- Filter Dropdown -->
                <div class="flex-1 flex justify-end">
                    <div class="relative">
                        <button id="filterButton" onclick="toggleFilter()" class="flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <span id="filterText">Semua item</span>
                            <svg id="filterIcon" class="w-4 h-4 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="filterDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="py-2">
                                <button onclick="filterProducts('all')" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center justify-between filter-option active">
                                    <span>Semua item</span>
                                    <span class="text-xs text-gray-500" id="count-all">{{ count($data) }}</span>
                                </button>
                                @php
                                    $kategoris = $data->groupBy('kategori');
                                @endphp
                                @foreach($kategoris as $kategori => $items)
                                <button onclick="filterProducts('{{ $kategori }}')" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center justify-between filter-option">
                                    <span>{{ $kategori }}</span>
                                    <span class="text-xs text-gray-500">{{ count($items) }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products List -->
<div class="px-2 py-1">
    <div id="productList" class="space-y-1">
        @forelse ($data as $item)
            <div class="product-item bg-white rounded-md p-3 shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer text-sm" 
                 data-kategori="{{ $item->kategori }}"
                 onclick="addToCart({{ $item->id }}, '{{ $item->nama_barang }}', {{ $item->harga_jual }})">
                <div class="flex items-center space-x-2">
                    <!-- Product Icon/Image -->
                    <div class="w-9 h-9 bg-gradient-to-br from-gray-100 to-gray-200 rounded-md flex items-center justify-center flex-shrink-0">
                        <span class="text-gray-600 font-bold text-sm">{{ strtoupper(substr($item->nama_barang, 0, 2)) }}</span>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 text-sm leading-tight mb-0.5">{{ $item->nama_barang }}</h3>
                        <div class="flex items-center space-x-1 text-xs text-gray-600 mb-1">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">{{ $item->kategori }}</span>
                            <span>•</span>
                            <span>Stok: {{ $item->stok }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-base font-bold text-gray-900">Rp {{ number_format($item->harga_jual) }}</span>
                            @if($item->stok <= 0)
                                <span class="text-xs text-red-500 bg-red-50 px-1.5 py-0.5 rounded">Habis</span>
                            @else
                                <button class="text-green-600 hover:text-green-700 p-1 rounded-full hover:bg-green-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2a2 2 0 00-2 2v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3a2 2 0 00-2-2H4"></path>
                </svg>
                <p class="text-gray-500">Belum ada produk tersedia</p>
            </div>
        @endforelse
    </div>
</div>

        <!-- Empty State for Filtered Results -->
        <div id="emptyState" class="text-center py-12 hidden">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-500">Tidak ada produk ditemukan</p>
            <button onclick="filterProducts('all')" class="mt-2 text-green-600 hover:text-green-700 font-medium">Tampilkan semua produk</button>
        </div>
    </div>

    <!-- Floating Cart Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="{{ route('user.transaksi.keranjang') }}" 
           id="cartButton"
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6M9 17h6"></path>
            </svg>
            <span id="cartText">Keranjang (<span id="cartCount">{{ collect($keranjang)->sum('qty') }}</span>)</span>
        </a>
    </div>

    <!-- Success Toast -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 max-w-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span id="toastMessage" class="text-sm">Produk berhasil ditambahkan!</span>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <svg class="w-6 h-6 animate-spin text-green-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700">Menambahkan ke keranjang...</span>
        </div>
    </div>
    <!-- Modal Tambah Transaksi -->
    <div id="modalTambahTransaksi" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto p-6">
            <h2 class="text-xl font-semibold mb-4 text-center">TRANSAKSI TAMBAHAN</h2>
            <div class="space-y-3">
                <input type="text" id="namaBarangTambahan" placeholder="Barang atau jasa" class="w-full border border-gray-300 p-2 rounded" />
                <input type="text" id="kodeBarangTambahan" placeholder="Kode" class="w-full border border-gray-300 p-2 rounded" />
                <input type="number" id="hargaJualTambahan" placeholder="Harga jual" class="w-full border border-gray-300 p-2 rounded" />
                <div class="flex items-center justify-center space-x-4">
                    <button onclick="kurangiQty()" class="text-xl px-3 py-1 border rounded">-</button>
                    <span id="jumlahQty" class="text-lg font-bold">1</span>
                    <button onclick="tambahQty()" class="text-xl px-3 py-1 border rounded">+</button>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button onclick="tutupModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">BATAL</button>
               <button onclick="submitTransaksiTambahan()" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white">OK</button>
            </div>
        </div>
    </div>

</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let currentFilter = 'all';

// Toggle filter dropdown
function toggleFilter() {
    const dropdown = document.getElementById('filterDropdown');
    const icon = document.getElementById('filterIcon');
    
    dropdown.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}

// Toggle search input
document.getElementById('search-toggle').addEventListener('click', function () {
    const input = document.getElementById('search-input');
    input.classList.toggle('hidden');
    input.focus();
});

// Close filter dropdown jika klik di luar
document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('filterDropdown');
    const button = document.getElementById('filterButton');
    
    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
        dropdown.classList.add('hidden');
        document.getElementById('filterIcon').classList.remove('rotate-180');
    }
});

// Fungsi untuk memfilter produk berdasarkan kategori
function filterProducts(kategori) {
    currentFilter = kategori;
    const products = document.querySelectorAll('.product-item');
    const emptyState = document.getElementById('emptyState');
    const filterText = document.getElementById('filterText');
    const dropdown = document.getElementById('filterDropdown');

    let visibleCount = 0;
    const keyword = document.getElementById('search-input').value.toLowerCase(); // ambil keyword pencarian juga

    products.forEach(product => {
        const productKategori = product.getAttribute('data-kategori');
        const namaProduk = product.querySelector('h3').textContent.toLowerCase();

        const cocokKategori = kategori === 'all' || productKategori === kategori;
        const cocokSearch = namaProduk.includes(keyword);

        if (cocokKategori && cocokSearch) {
            product.style.display = 'block';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });

    // Update tulisan tombol filter
    filterText.textContent = kategori === 'all' ? 'Semua item' : kategori;

    // Update tampilan active di dropdown
    document.querySelectorAll('.filter-option').forEach(option => {
        option.classList.remove('active', 'bg-green-50', 'text-green-700');
    });
    event.target.classList.add('active', 'bg-green-50', 'text-green-700');

    // Tampilkan atau sembunyikan "tidak ada hasil"
    if (visibleCount === 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
    }

    // Tutup dropdown
    dropdown.classList.add('hidden');
    document.getElementById('filterIcon').classList.remove('rotate-180');
}

// Tambah ke keranjang
async function addToCart(productId, productName, price) {
    const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.classList.remove('hidden');

    try {
        const response = await fetch('{{ route("user.transaksi.keranjang.tambah") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                id: productId
            })
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('cartCount').textContent = data.keranjang_count;
            showToast(`${productName} berhasil ditambahkan!`);

            const cartButton = document.getElementById('cartButton');
            cartButton.classList.add('animate-pulse');
            setTimeout(() => cartButton.classList.remove('animate-pulse'), 600);
        } else {
            showToast('Gagal menambahkan produk', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan, silakan coba lagi', 'error');
    } finally {
        loadingOverlay.classList.add('hidden');
    }
}

// Tampilkan toast
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    const toastDiv = toast.firstElementChild;

    toastMessage.textContent = message;

    if (type === 'error') {
        toastDiv.className = toastDiv.className.replace('bg-green-500', 'bg-red-500');
    } else {
        toastDiv.className = toastDiv.className.replace('bg-red-500', 'bg-green-500');
    }

    toast.classList.remove('hidden');
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

// Pencarian berdasarkan input #search-input
document.getElementById('search-input').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    const products = document.querySelectorAll('.product-item');
    const emptyState = document.getElementById('emptyState');

    let visibleCount = 0;

    products.forEach(product => {
        const namaProduk = product.querySelector('h3').textContent.toLowerCase();
        const productKategori = product.getAttribute('data-kategori');

        const cocokKategori = currentFilter === 'all' || productKategori === currentFilter;
        const cocokSearch = namaProduk.includes(keyword);

        if (cocokKategori && cocokSearch) {
            product.style.display = 'block';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });

    if (visibleCount === 0) {
        emptyState.classList.remove('hidden');
    } else {
        emptyState.classList.add('hidden');
    }
});

// Efek hover animasi produk
document.addEventListener('DOMContentLoaded', function () {
    const productItems = document.querySelectorAll('.product-item');
    productItems.forEach(item => {
        item.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-1px)';
        });

        item.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Tampilkan modal saat tombol Add diklik
document.querySelectorAll('button svg').forEach(svg => {
    if (svg.outerHTML.includes('M12 6v6m0 0v6m0-6h6m-6 0H6')) {
        svg.closest('button').addEventListener('click', function () {
            document.getElementById('modalTambahTransaksi').classList.remove('hidden');
            document.getElementById('modalTambahTransaksi').classList.add('flex');
        });
    }
});

function tutupModal() {
    const modal = document.getElementById('modalTambahTransaksi');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

let qty = 1;

function tambahQty() {
    qty++;
    document.getElementById('jumlahQty').textContent = qty;
}

function kurangiQty() {
    if (qty > 1) qty--;
    document.getElementById('jumlahQty').textContent = qty;
}

function submitTransaksiTambahan() {
    const nama = document.getElementById('namaBarangTambahan').value.trim();
    const harga = parseInt(document.getElementById('hargaJualTambahan').value);
    const qty = parseInt(document.getElementById('jumlahQty').textContent);

    if (!nama || isNaN(harga)) {
        showToast('Nama dan harga jual wajib diisi', 'error');
        return;
    }

    // Simulasikan ID produk unik untuk transaksi tambahan
    const produkTambahanId = `tambahan-${Date.now()}`;

    // Simpan ke session sebagai produk dummy
    addToCartManual(produkTambahanId, nama, harga, qty);

    tutupModal();
}

async function addToCartManual(productId, productName, price, qty = 1) {
    const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.classList.remove('hidden');

    try {
        const response = await fetch('{{ route("user.transaksi.keranjang.tambah") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                id: productId,
                manual: true,
                nama: productName,
                harga: price,
                qty: qty
            })
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('cartCount').textContent = data.keranjang_count;
            showToast(`${productName} berhasil ditambahkan!`);

            const cartButton = document.getElementById('cartButton');
            cartButton.classList.add('animate-pulse');
            setTimeout(() => cartButton.classList.remove('animate-pulse'), 600);
        } else {
            showToast('Gagal menambahkan produk', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan, silakan coba lagi', 'error');
    } finally {
        loadingOverlay.classList.add('hidden');
    }
}

</script>

<style>
.rotate-180 {
    transform: rotate(180deg);
}

.filter-option.active {
    background-color: #f0fdf4;
    color: #15803d;
}

.product-item {
    transition: all 0.2s ease;
}

.product-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

@media (max-width: 640px) {
    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endsection