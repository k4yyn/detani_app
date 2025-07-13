<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .struk { max-width: 400px; margin: auto; border: 1px solid #ccc; padding: 20px; }
        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px 0; border-bottom: 1px dashed #ccc; text-align: left; }
        .total-row td { font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 13px; }
        .btn-cetak { margin-top: 20px; text-align: center; }
        .btn-cetak button { padding: 8px 16px; font-size: 14px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="struk">
        <div class="center">
            <h2>Toko Kita</h2>
            <p>Jl. Contoh No.1, Bandung<br>Telp: 0812-3456-7890</p>
        </div>

        <hr>

        <p>
            <strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}<br>
            <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}<br>
            <strong>Kasir:</strong> {{ $transaksi->user->name }}
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
                        <td>{{ $item->data->nama_barang }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->data->harga_jual, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->qty * $item->data->harga_jual, 0, ',', '.') }}</td>
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
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah berbelanja!</p>
            <p>~ Toko Kita ~</p>
        </div>

        <div class="btn-cetak">
            <button onclick="window.print()">🖨️ Cetak Struk</button>
        </div>
    </div>
</body>
</html>
