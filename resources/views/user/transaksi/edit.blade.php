<!-- resources/views/user/transaksi/edit.blade.php -->
@extends('layouts.user')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-amber-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-white font-bold text-lg">Edit Item Transaksi</h2>
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

            <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">PLU/Kode Barang</label>
                            <input type="text" name="plu" id="plu" list="produk-list" 
                                   value="{{ old('plu', $transaksi->plu) }}" 
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" 
                                   required>
                            <datalist id="produk-list">
                                @foreach($produks as $produk)
                                <option value="{{ $produk->plu }}">{{ $produk->nama_barang }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Nama Barang</label>
                            <input type="text" name="deskripsi" id="deskripsi" 
                                   value="{{ old('deskripsi', $transaksi->deskripsi) }}" 
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Kategori</label>
                            <select name="kategori" id="kategori" 
                                    class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan" {{ old('kategori', $transaksi->kategori) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="Minuman" {{ old('kategori', $transaksi->kategori) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="Alat Tulis" {{ old('kategori', $transaksi->kategori) == 'Alat Tulis' ? 'selected' : '' }}>Alat Tulis</option>
                                <option value="Seragam" {{ old('kategori', $transaksi->kategori) == 'Seragam' ? 'selected' : '' }}>Seragam</option>
                                <option value="Kesehatan & Kebersihan" {{ old('kategori', $transaksi->kategori) == 'Kesehatan & Kebersihan' ? 'selected' : '' }}>Kesehatan & Kebersihan</option>
                                <option value="Lainnya" {{ old('kategori', $transaksi->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Jumlah</label>
                            <input type="number" name="qty" min="1" 
                                   value="{{ old('qty', $transaksi->qty) }}" 
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Harga Satuan</label>
                            <input type="number" name="harga" id="harga" min="0" 
                                   value="{{ old('harga', $transaksi->harga) }}" 
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Diskon (Rp)</label>
                            <input type="number" name="diskon" min="0" 
                                   value="{{ old('diskon', $transaksi->diskon) }}" 
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('transaksi.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 rounded-lg hover:bg-stone-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Autofill data produk ketika PLU dipilih
    document.getElementById('plu').addEventListener('change', function() {
        const plu = this.value;
        const produk = {!! json_encode($produks->keyBy('plu')) !!}[plu];
        
        if (produk) {
            document.getElementById('deskripsi').value = produk.nama_barang;
            document.getElementById('harga').value = produk.harga_jual;
            document.getElementById('kategori').value = produk.kategori;
            document.getElementById('qty').focus();
        }
    });

    // Hitung total otomatis saat ada perubahan
    const hitungTotal = () => {
        const qty = parseFloat(document.querySelector('input[name="qty"]').value) || 0;
        const harga = parseFloat(document.querySelector('input[name="harga"]').value) || 0;
        const diskon = parseFloat(document.querySelector('input[name="diskon"]').value) || 0;
        
        return (harga * qty) - diskon;
    };

    // Update total saat input berubah
    ['qty', 'harga', 'diskon'].forEach(field => {
        document.querySelector(`input[name="${field}"]`).addEventListener('input', function() {
            // Di sini Anda bisa menampilkan total jika diperlukan
            console.log('Total:', hitungTotal());
        });
    });
</script>
@endpush
@endsection