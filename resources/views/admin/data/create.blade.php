@extends('layouts.admin')

@section('content')
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Data Barang
                </h1>
                <p class="text-amber-100 mt-2">Lengkapi informasi barang dengan detail yang akurat</p>
            </div>
        </div>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 rounded-lg shadow-sm mb-6">
                <div class="flex items-start p-4">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 mb-2">Terdapat kesalahan dalam pengisian form:</h3>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <span class="w-1 h-1 bg-red-400 rounded-full mr-2"></span>
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
            $prefix = 'am-' . $today . '-';
            $countToday = Data::whereRaw('DATE(created_at) = ?', [now()->toDateString()])->count() + 1;
            $order = str_pad($countToday, 2, '0', STR_PAD_LEFT);
            $generatedCodetrx = $prefix . $order . 'id';
        @endphp

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-amber-100 overflow-hidden">
            <form action="{{ route('admin.data.store') }}" method="POST" class="p-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kode Transaksi -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            Kode Transaksi (otomatis)
                        </label>
                        <div class="relative">
                            <input type="text"
                                   class="w-full px-4 py-3 bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-xl text-amber-800 font-mono font-bold text-center tracking-wider focus:outline-none cursor-not-allowed"
                                   value="{{ $generatedCodetrx }}"
                                   readonly>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Barang -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="nama_barang"
                               class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300"
                               value="{{ old('nama_barang') }}"
                               placeholder="Masukkan nama barang..."
                               required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori"
                                class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300 bg-white"
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>🍔 Makanan</option>
                            <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>🥤 Minuman</option>
                            <option value="Alat Tulis" {{ old('kategori') == 'Alat Tulis' ? 'selected' : '' }}>✏️ Alat Tulis</option>
                            <option value="Seragam" {{ old('kategori') == 'Seragam' ? 'selected' : '' }}>👕 Seragam</option>
                            <option value="Kesehatan & Kebersihan" {{ old('kategori') == 'Kesehatan & Kebersihan' ? 'selected' : '' }}>🧼 Kesehatan & Kebersihan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                        </select>
                    </div>

                    <!-- Lokasi Penyimpanan -->
                    <div>
                        <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi Penyimpanan <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="lokasi_penyimpanan"
                               class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300"
                               value="{{ old('lokasi_penyimpanan') }}"
                               placeholder="Contoh: Rak A-1, Gudang B..."
                               required>
                    </div>

                    <!-- Row untuk Stok, Harga Pokok, Harga Jual -->
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="stok"
                                   class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300"
                                   value="{{ old('stok') }}"
                                   min="1"
                                   placeholder="0"
                                   required>
                        </div>

                        <!-- Harga Pokok -->
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Harga Pokok <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-amber-600 font-semibold">Rp</span>
                                <input type="number"
                                       name="harga_pokok"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300"
                                       value="{{ old('harga_pokok') }}"
                                       min="0"
                                       placeholder="0"
                                       required>
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Harga Jual <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-amber-600 font-semibold">Rp</span>
                                <input type="number"
                                       name="harga_jual"
                                       class="w-full pl-12 pr-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-amber-300"
                                       value="{{ old('harga_jual') }}"
                                       min="0"
                                       placeholder="0"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-amber-100">
                    <a href="{{ route('admin.data.index') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-amber-800 font-semibold mb-1">Tips Pengisian</h4>
                    <p class="text-amber-700 text-sm">
                        • Pastikan semua field yang bertanda <span class="text-red-500 font-semibold">*</span> telah diisi<br>
                        • Harga jual sebaiknya lebih tinggi dari harga pokok untuk mendapatkan keuntungan<br>
                        • Gunakan deskripsi yang jelas untuk memudahkan identifikasi barang
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
