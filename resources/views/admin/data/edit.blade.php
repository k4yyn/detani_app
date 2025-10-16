@extends('layouts.admin')

@section('content')
<div>
    <div class="max-w-9x1 mx-auto px-4 sm:px-2 lg:px-6 py-2">
        <div class="bg-transparent rounded-2xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="bg-green-800 px-8 py-6">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-2xl font-semibold text-white flex items-center group">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Edit Data Barang
                </h1>
                <p class="text-gray-300 text-sm sm:text-base md:text-md">Lengkapi informasi barang dengan detail yang akurat</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <strong class="text-red-800 font-medium">Ada kesalahan:</strong>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.data.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6">
                    <div class="mb-6">
                        <label for="stock_gudang" class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            Jumlah Stok <span class="text-red-700">*</span>
                        </label>
                        <input
                            type="number"
                            name="stock_gudang"
                            id="stok"
                            min="1"
                            max="9999"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                            placeholder="Masukkan jumlah stok"
                            value="{{ old('stock_gudang', $data->stock_gudang) }}"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="harga_pokok" class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            Harga Pokok (Rp) <span class="text-red-700">*</span>
                        </label>
                        <input
                            type="number"
                            name="harga_pokok"
                            id="harga_pokok"
                            min="0"
                            step="100"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                            placeholder="Masukkan harga pokok"
                            value="{{ old('harga_pokok', $data->harga_pokok) }}"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="harga_jual" class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            Harga Jual (Rp) <span class="text-red-700">*</span>
                        </label>
                        <input
                            type="number"
                            name="harga_jual"
                            id="harga_jual"
                            min="0"
                            step="100"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                            placeholder="Masukkan harga jual"
                            value="{{ old('harga_jual', $data->harga_jual) }}"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="lokasi_penyimpanan" class="block text-sm font-semibold text-green-800 mb-2 flex items-center">
                            Lokasi Penyimpanan <span class="text-red-700">*</span>
                        </label>
                        <input
                            type="text"
                            name="lokasi_penyimpanan"
                            id="lokasi_penyimpanan"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-700 focus:border-green-700 transition-all duration-200 hover:border-gray-400"
                            placeholder="Masukkan lokasi penyimpanan"
                            value="{{ old('lokasi_penyimpanan', $data->lokasi_penyimpanan) }}"
                        >
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-between items-center gap-4">
                    <a
                        href="{{ route('admin.data.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group"
                    >
                        Kembali
                    </a>
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-green-800 hover:bg-green-900 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 group"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection