<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
    @media print {
        nav, .navbar, .footer-nav, .btn-cetak, .mt-4, .no-print {
            display: none !important;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        @page {
            size: 58mm auto;   /* ganti ke 80mm auto kalau pakai kertas 80mm */
            margin: 0;         
        }

        .struk {
            width: 100%;
            max-width: 58mm;
            margin: auto;
        }

        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 4px 0; border-bottom: 1px dashed #ccc; text-align: left; font-size: 12px; }
        .total-row td { font-weight: bold; }
        .footer { margin-top: 10px; text-align: center; font-size: 11px; }
    }
    </style>
</head>
<body>
    <div class="struk">
        <div class="center">
            <img src="{{ asset('asset/image/logo-detani.png') }}" alt="Logo Kantin" style="display:block; margin:0 auto 2px auto; max-width:120px;">
            <h2>Kantin DeTani</h2>
            <p>Jln. Goalpara, Kp. Cijeruk, Sukamekar, Kec. Sukaraja, Sukabumi <br>Telp: 0819-1188-0088</p>
        </div>

        <hr>

        <p>
            <strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}<br>
            <strong>Tanggal:</strong> {{ $transaksi->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}<br>
            <strong>Kasir:</strong> {{ optional($transaksi->user)->name ?? '-' }}<br>
            @if ($transaksi->nama_pelanggan)
                <strong>Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}<br>
            @endif
            @if ($transaksi->nomor_meja)
                <strong>Meja:</strong> {{ $transaksi->nomor_meja }}<br>
            @endif
            @if ($transaksi->keterangan_tambahan)
                <strong>Catatan:</strong> {{ $transaksi->keterangan_tambahan }}<br>
            @endif
        </p>

        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->details as $item)
                    <tr>
                        <td>
                            {{ $item->nama_manual ?? optional($item->data)->nama_barang ?? '-' }}
                            @if ($item->diskon && $item->diskon > 0)
                                <br><small>Diskon: Rp {{ number_format($item->diskon, 0, ',', '.') }}</small>
                            @endif
                            @if ($transaksi->keterangan)
                                <br><strong>Catatan:</strong> {{ $transaksi->keterangan }}
                            @endif
                        </td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3">Uang Dibayar</td>
                    <td>Rp {{ number_format($transaksi->uang_dibayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3">Kembalian</td>
                    <td>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3">Metode</td>
                    <td>{{ $transaksi->metode_pembayaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="3">Status</td>
                    <td>{{ $transaksi->status_pembayaran ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah berbelanja!</p>
            <p>~ De Tani Waterpark ~</p>
        </div>

        <!-- Tombol kembali (hanya tampil di layar, tidak ikut ke print) -->
        <a href="{{ route('user.transaksi.index') }}" 
           class="no-print mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
           Kembali ke Transaksi
        </a>
    </div>

    @if (request('print') === 'true')
    <script>
        window.onload = function () {
            window.print();
            setTimeout(function () {
                window.location.href = "{{ route('user.transaksi.index') }}";
            }, 1000);
        };
    </script>
    @endif
</body>
</html>
