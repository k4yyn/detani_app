@extends('layouts.admin')

@section('content')
<div>
    <div class="max-w-9x1 mx-auto px-4 sm:px-2 lg:px-6 py-2">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="bg-green-800 px-8 py-6">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-2xl font-semibold text-white flex items-center group">
                    <svg class="w-6 h-6 sm:w-8 md:w-10 h-8 md:h-10 mr-2 sm:mr-3 md:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Data Barang
                </h1>
                <p class="text-gray-300 text-sm sm:text-base md:text-md">Lengkapi informasi barang dengan detail yang akurat</p>
            </div>
        </div>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-700 rounded-lg shadow-sm mb-6">
                <div class="flex items-start p-4">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 mb-2">Terdapat kesalahan dalam pengisian form:</h3>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <span class="w-1 h-1 bg-red-600 rounded-full mr-2"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @php
            use Carbon\Carbon;
            use App\Models\Data;

            $today = Carbon::now()->format('dmY');
            $prefix = 'DT-' . $today . '-';
            $countToday = Data::whereRaw('DATE(created_at) = ?', [now()->toDateString()])->count() + 1;
            $order = str_pad($countToday, 2, '0', STR_PAD_LEFT);
            $generatedCodetrx = $prefix . $order . 'ID';
        @endphp

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.data.store') }}" method="POST" class="p-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kode Transaksi -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            Kode Transaksi (otomatis)
                        </label>
                        <div class="relative">
                            <input type="text"
                                   class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-300 rounded-xl text-green-800 font-mono font-bold text-center tracking-wider focus:outline-none cursor-not-allowed"
                                   value="{{ $generatedCodetrx }}"
                                   readonly>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Barang -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Nama Barang <span class="text-red-700">*</span>
                        </label>
                        <input type="text"
                               name="nama_barang"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                               value="{{ old('nama_barang') }}"
                               placeholder="Masukkan nama barang..."
                               required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Kategori <span class="text-red-700">*</span>
                        </label>
                        <select id="kategoriSelect" name="kategori"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400 bg-white"
                            required>
                            <option value="">Pilih Kategori</option>
                            <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>🍔 Makanan</option>
                            <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="Kesehatan & Kebersihan" {{ old('kategori') == 'Kesehatan & Kebersihan' ? 'selected' : '' }}>🧼 Kesehatan & Kebersihan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                        </select>

                        <input type="text" id="kategoriLainnya" name="kategori_lainnya"
                            class="w-full px-4 py-3 mt-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400 bg-white hidden"
                            placeholder="Tulis kategori lainnya..."
                            value="{{ old('kategori_lainnya') }}">
                    </div>

                    <!-- Lokasi Penyimpanan -->
                    <div>
                        <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi Penyimpanan <span class="text-red-700">*</span>
                        </label>
                        <input type="text"
                               name="lokasi_penyimpanan"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                               value="{{ old('lokasi_penyimpanan') }}"
                               placeholder="Contoh: Rak A-1, Gudang B..."
                               required>
                    </div>

                    <!-- Stok, Harga Pokok, Harga Jual -->
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                                Stok <span class="text-red-700">*</span>
                            </label>
                            <input type="number"
                                   name="stok"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                                   value="{{ old('stok') }}"
                                   min="1"
                                   placeholder="0"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                                Harga Pokok <span class="text-red-700">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-700 font-semibold">Rp</span>
                                <input type="number"
                                       name="harga_pokok"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                                       value="{{ old('harga_pokok') }}"
                                       min="0"
                                       placeholder="0"
                                       required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                                Harga Jual <span class="text-red-700">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-700 font-semibold">Rp</span>
                                <input type="number"
                                       name="harga_jual"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                                       value="{{ old('harga_jual') }}"
                                       min="0"
                                       placeholder="0"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-300">
                    <a href="{{ route('admin.data.index') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                        Kembali
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-green-800 hover:bg-green-900 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 group">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
            <h4 class="text-green-800 font-semibold mb-2">Tips Pengisian</h4>
            <p class="text-green-700 text-sm">
                • Pastikan semua field yang bertanda <span class="text-red-700 font-semibold">*</span> telah diisi<br>
                • Harga jual sebaiknya lebih tinggi dari harga pokok untuk mendapatkan keuntungan<br>
                • Gunakan deskripsi yang jelas untuk memudahkan identifikasi barang
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('kategoriSelect').addEventListener('change', function () {
    const lainnyaInput = document.getElementById('kategoriLainnya');
    if (this.value === 'Lainnya') {
        lainnyaInput.classList.remove('hidden');
        lainnyaInput.setAttribute('required', 'required');
    } else {
        lainnyaInput.classList.add('hidden');
        lainnyaInput.removeAttribute('required');
    }
});
</script>
@endpush
@endsection