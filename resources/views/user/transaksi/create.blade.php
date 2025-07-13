<!-- resources/views/user/transaksi/create.blade.php -->
@extends('layouts.user')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-amber-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-white font-bold text-lg">Tambah Transaksi Baru</h2>
                <a href="{{ route('transaksi.index') }}" class="text-white hover:text-amber-200">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="p-6">
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">PLU/Kode Barang</label>
                            <input type="text" name="plu" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Nama Barang</label>
                            <input type="text" name="deskripsi" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Kategori</label>
                            <select name="kategori" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Alat Tulis">Alat Tulis</option>
                                <option value="Seragam">Seragam</option>
                                <option value="Kesehatan & Kebersihan">Kesehatan & Kebersihan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Jumlah</label>
                            <input type="number" name="qty" min="1" value="1" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Harga Satuan</label>
                            <input type="number" name="harga" min="0" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Diskon (Rp)</label>
                            <input type="number" name="diskon" min="0" value="0" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('transaksi.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 rounded-lg hover:bg-stone-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                        <i class="fas fa-save mr-2"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection