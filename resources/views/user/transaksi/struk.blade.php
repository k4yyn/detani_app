@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

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
    <body>
    <div class="struk">
        <div class="center">
            <h2>Kantin DeTani</h2>
            <p>Jln. Goalpara, Kp. Cijeruk, Sukamekar, Kec. Sukaraja, Sukabumi <br>Telp: 0819-1188-0088</p>
        </div>

        <hr>

        <p>
            <strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}<br>
            <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}<br>
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
                            <br><strong>Catatan:</strong> {{ $transaksi->keterangan }}<br>
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
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih telah berbelanja!</p>
            <p>~ De Tani Waterpark ~</p>
        </div>

        <!-- Button kembali -->
    <a href="{{ route('user.transaksi.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kembali ke Transaksi</a>
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
@endsection
