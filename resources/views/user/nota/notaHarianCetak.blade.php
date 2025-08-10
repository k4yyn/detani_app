@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50">

    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .struk { max-width: 400px; margin: auto; padding: 20px; }
        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px 0; border-bottom: 1px dashed #ccc; text-align: left; }
        .total-row td { font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 13px; }
        
        /* Enhanced button styling */
        .action-buttons {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
            min-width: 140px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .btn-print {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
        }
        
        .btn-print:hover {
            background: linear-gradient(135deg, #059669, #047857);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
        }
        
        .btn-back:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }
        
        .btn svg {
            margin-right: 6px;
            width: 16px;
            height: 16px;
        }
        
        /* Responsive design for buttons */
        @media (min-width: 480px) {
            .action-buttons {
                flex-direction: row;
                justify-content: center;
                gap: 16px;
            }
        }
        
        @media print {
            .action-buttons { display: none; }
            body { background: white; }
        }
    </style>

    <div class="struk">
        <div class="center">
            <h2>Kantin DeTani</h2>
            <p>Jln. Goalpara, Kp. Cijeruk, Sukamekar, Kec. Sukaraja, Sukabumi <br>Telp: 0819-1188-0088</p>
        </div>

        <hr>

        <p>
            <strong>Tanggal:</strong> {{ now()->format('d/m/Y') }}<br>
            <strong>Kasir:</strong> {{ auth()->user()->name ?? '-' }}<br>
        </p>

        @php
            $groupedItems = [];
            $grandTotal = 0;

            foreach ($transaksi as $t) {
                foreach ($t->details as $item) {
                    $namaBarang = $item->nama_manual ?? optional($item->data)->nama_barang ?? '-';

                    if (!isset($groupedItems[$namaBarang])) {
                        $groupedItems[$namaBarang] = [
                            'qty' => 0,
                            'harga' => $item->harga,
                            'subtotal' => 0
                        ];
                    }

                    $groupedItems[$namaBarang]['qty'] += $item->qty;
                    $groupedItems[$namaBarang]['subtotal'] += $item->subtotal;
                    $grandTotal += $item->subtotal;
                }
            }
        @endphp

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedItems as $nama => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $nama }}</td>
                        <td>{{ $data['qty'] }}</td>
                        <td>Rp {{ number_format($data['harga'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4">Total Harian</td>
                    <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Terima kasih!</p>
            <p>~ De Tani Waterpark ~</p>
        </div>

        <div class="action-buttons">
            <a href="?print=true" class="btn btn-print">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Nota
            </a>
            <a href="{{ route('user.nota.notaHarian') }}" class="btn btn-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if (request('print') === 'true')
    <script>
        window.onload = function () {
            window.print();
            setTimeout(function () {
                window.location.href = "{{ route('user.nota.notaHarian') }}";
            }, 1000);
        };
    </script>
    @endif
</div>
@endsection