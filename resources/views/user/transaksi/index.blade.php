@extends('layouts.user')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Daftar Transaksi -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-amber-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-white font-bold text-lg">Daftar Transaksi</h2>
                <div class="flex items-center space-x-2">
                    <button onclick="printReceipt()" class="px-3 py-1 bg-white text-amber-600 rounded text-sm font-medium">
                        <i class="fas fa-print mr-1"></i> Cetak
                    </button>
                    <form action="{{ route('transaksi.deleteAll') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua item transaksi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm font-medium transition-colors">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Semua
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-stone-50 text-stone-600 text-sm uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left">No</th>
                            <th class="py-3 px-4 text-left">Kode Barang</th>
                            <th class="py-3 px-4 text-left">Nama Barang</th>
                            <th class="py-3 px-4 text-left">Kategori</th>
                            <th class="py-3 px-4 text-left">Qty</th>
                            <th class="py-3 px-4 text-left">Harga</th>
                            <th class="py-3 px-4 text-left">Total</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                       @forelse($transaksis as $item)
                    <tr class="hover:bg-amber-50">
                        <td class="py-4 px-4">{{ $loop->iteration }}</td>
                        <td class="py-4 px-4">{{ $item->data->codetrx ?? '-' }}</td>
                        <td class="py-4 px-4 font-medium">{{ $item->data->nama_barang ?? '-' }}</td>
                        <td class="py-4 px-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-800">
                                {{ $item->data->kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="py-4 px-4">{{ $item->qty }}</td>
                        <td class="py-4 px-4">Rp {{ number_format($item->data->harga_jual ?? 0, 0, ',', '.') }}</td>
                        <td class="py-4 px-4 font-medium">Rp {{ number_format($item->qty * ($item->data->harga_jual ?? 0), 0, ',', '.') }}</td>
                        <td class="py-4 px-4">
                            <div class="flex space-x-2">
                                <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Hapus item ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-stone-500">
                            <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                            <p>Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Tambah Item dan Pembayaran -->
    <div class="space-y-6">
        <!-- Form Tambah Item -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-amber-600 px-6 py-4">
                <h2 class="text-white font-bold text-lg">Tambah Item</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Pilih Barang dari Daftar -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Pilih Barang</label>
                            <select id="product-select" name="data_id" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-codetrx="{{ $product->codetrx }}"
                                        data-nama="{{ $product->nama_barang }}"
                                        data-kategori="{{ $product->kategori }}"
                                        data-harga="{{ $product->harga_jual }}"
                                        data-stok="{{ $product->stok }}">
                                        {{ $product->codetrx }} - {{ $product->nama_barang }} (Stok: {{ $product->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Kode Barang -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Kode Barang</label>
                            <input type="text" name="codetrx" id="codetrx" readonly
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg bg-stone-100" required>
                        </div>

                        <!-- Input Nama Barang -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" readonly
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg bg-stone-100" required>
                        </div>

                        <!-- Input Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Kategori</label>
                            <input type="text" name="kategori" id="kategori" readonly
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg bg-stone-100" required>
                        </div>

                        <!-- Input Harga Satuan -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Harga Satuan</label>
                            <input type="number" name="harga_jual" id="harga_jual" readonly
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg bg-stone-100" required>
                        </div>

                        <!-- Input Stok Tersedia -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Stok Tersedia</label>
                            <input type="number" id="stok_tersedia" readonly
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg bg-stone-100">
                        </div>

                        <!-- Input Jumlah -->
                        <div>
                            <label class="block text-sm font-medium text-stone-600 mb-1">Jumlah</label>
                            <input type="number" name="qty" min="1" value="1" id="qty" 
                                   class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
                        </div>

                        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus-circle mr-2"></i> Tambahkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form Pembayaran -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-amber-600 px-6 py-4">
                <h2 class="text-white font-bold text-lg">Pembayaran</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-stone-600 font-medium">Total Belanja:</span>
                    <span class="text-2xl font-bold text-amber-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('transaksi.checkout') }}" method="POST">
    @csrf
    <input type="hidden" name="codetrx" value="{{ 'TRX' . strtoupper(uniqid()) }}">

    <div>
        <label class="block text-sm font-medium text-stone-600 mb-1">Jumlah Uang</label>
        <input type="number" id="uang_dibayar" name="uang_dibayar" min="0" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500" required>
    </div>
    
    <div class="mt-2">
        <label class="block text-sm font-medium text-stone-600 mb-1">Kembalian</label>
        <input type="text" id="kembalian" class="w-full px-4 py-2 border border-stone-200 rounded-lg bg-stone-100" readonly>
    </div>
    
    <button type="submit" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition-colors font-medium">
        <i class="fas fa-cash-register mr-2"></i> Proses Pembayaran
    </button>
</form>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ketika produk dipilih
        $('#product-select').change(function() {
            const selectedOption = $(this).find('option:selected');
            
            if (selectedOption.val()) {
                // Isi form otomatis
                $('#codetrx').val(selectedOption.data('codetrx'));
                $('#nama_barang').val(selectedOption.data('nama'));
                $('#kategori').val(selectedOption.data('kategori'));
                $('#harga_jual').val(selectedOption.data('harga'));
                $('#stok_tersedia').val(selectedOption.data('stok'));
                $('#qty').val(1).focus().attr('max', selectedOption.data('stok'));
            } else {
                // Kosongkan form jika tidak ada yang dipilih
                $('#codetrx').val('');
                $('#nama_barang').val('');
                $('#kategori').val('');
                $('#harga_jual').val('');
                $('#stok_tersedia').val('');
                $('#qty').val('').removeAttr('max');
            }
        });

        // Validasi jumlah tidak melebihi stok
        $("#qty").on('change', function() {
            const stok = parseInt($("#stok_tersedia").val());
            const qty = parseInt($(this).val());
            
            if (qty > stok) {
                alert('Jumlah melebihi stok tersedia!');
                $(this).val(stok);
            }
        });

        // Hitung kembalian dengan feedback visual
        $("#uang_dibayar").on('input', function() {
            const total = {{ $grandTotal }};
            const uangDibayar = parseFloat($(this).val()) || 0;
            const kembalian = uangDibayar - total;
            const kembalianField = $("#kembalian");
            
            if (kembalian >= 0) {
                kembalianField.val('Rp ' + kembalian.toLocaleString('id-ID'));
                kembalianField.removeClass('text-red-500').addClass('text-green-500');
            } else {
                kembalianField.val('Uang kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID'));
                kembalianField.removeClass('text-green-500').addClass('text-red-500');
            }
        });

        // Validasi form checkout
        $("form[action='{{ route('transaksi.checkout') }}']").on('submit', function(e) {
            const total = {{ $grandTotal }};
            const uangDibayar = parseFloat($("#uang_dibayar").val()) || 0;
            
            if (uangDibayar < total) {
                e.preventDefault();
                alert('Uang yang dibayar kurang dari total belanja. Silakan masukkan jumlah yang cukup.');
                $("#uang_dibayar").focus();
            }
        });
    });

    // Fungsi cetak struk (tetap sama)
    function printReceipt() {
        const transaksis = {!! json_encode($transaksis) !!};
        const grandTotal = {!! $grandTotal !!};
        
        if (transaksis.length === 0) {
            alert('Tidak ada transaksi untuk dicetak!');
            return;
        }

        let receiptContent = `
            <style>
                body { font-family: Arial, sans-serif; }
                .receipt { width: 80mm; margin: 0 auto; padding: 10px; }
                .header { text-align: center; margin-bottom: 10px; }
                .title { font-weight: bold; font-size: 18px; }
                .address { font-size: 12px; margin-bottom: 10px; }
                .divider { border-top: 1px dashed #000; margin: 10px 0; }
                .item { display: flex; justify-content: space-between; margin-bottom: 5px; }
                .total { font-weight: bold; margin-top: 10px; text-align: right; }
                .footer { text-align: center; margin-top: 20px; font-size: 12px; }
            </style>
            <div class="receipt">
                <div class="header">
                    <div class="title">Toko Amaliah</div>
                    <div class="address">Jl. Contoh No. 123, Kota</div>
                </div>
                <div class="divider"></div>
                <div>${new Date().toLocaleString()}</div>
                <div class="divider"></div>
        `;

        transaksis.forEach(item => {
            receiptContent += `
                <div class="item">
                    <div>${item.codetrx} - ${item.nama_barang} (${item.qty}x)</div>
                    <div>Rp ${(item.harga_jual * item.qty).toLocaleString('id-ID')}</div>
                </div>
            `;
        });

        receiptContent += `
            <div class="divider"></div>
            <div class="item">
                <div>Total:</div>
                <div>Rp ${grandTotal.toLocaleString('id-ID')}</div>
            </div>
            <div class="footer">
                Terima kasih telah berbelanja
            </div>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(receiptContent);
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endpush
@endsection