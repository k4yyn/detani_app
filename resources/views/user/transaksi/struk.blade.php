<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - Kantin DeTani</title>
    <style>
        /* CSS Thermal Printer */
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-width: 58mm;
            margin: 0 auto;
            padding: 10px;
            background: white;
            line-height: 1.3;
        }
        
        .struk-content {
            background: white;
        }
        
        .center { text-align: center; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 8px 0;
        }
        
        th, td { 
            padding: 3px 0; 
            border-bottom: 1px dashed #ccc;
        }
        
        .total-row td { 
            font-weight: bold; 
            border-bottom: 2px solid #000;
        }
        
        .footer { 
            margin-top: 12px; 
            text-align: center; 
            font-size: 11px;
        }
        
        /* Tombol Mobile */
        .mobile-actions {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 12px;
            border-top: 2px solid #eee;
            display: flex;
            gap: 8px;
            justify-content: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        
        .btn {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            flex: 1;
            min-width: 0;
        }
        
        .btn-print {
            background: #28a745;
            color: white;
        }
        
        .btn-back {
            background: #6c757d;
            color: white;
            text-decoration: none;
            text-align: center;
        }

        /* Success message */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
        
        /* Sembunyikan tombol saat print */
        @media print {
            .mobile-actions, .no-print { 
                display: none !important; 
            }
            body { 
                margin: 0; 
                padding: 5px;
                max-width: 58mm;
            }
            .alert-success {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Pesan Success -->
    @if(session('success'))
        <div class="alert-success no-print">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="struk-content">
        <!-- KONTEN STRUK -->
        <div class="center">
            <img src="{{ asset('asset/image/logo-detani.png') }}" alt="Logo Kantin" 
                 style="max-width: 100px; height: auto; margin-bottom: 10px;">
            <h2 style="margin: 5px 0; font-size: 16px;">Kantin DeTani</h2>
            <p style="margin: 5px 0; font-size: 11px;">
                Jln. Goalpara, Kp. Cijeruk, Sukamekar<br>
                Kec. Sukaraja, Sukabumi<br>
                Telp: 0819-1188-0088
            </p>
        </div>

        <hr style="border: 1px dashed #000; margin: 10px 0;">

        <div style="margin-bottom: 15px;">
            <p style="margin: 3px 0;"><strong>Kode:</strong> {{ $transaksi->kode_transaksi }}</p>
            <p style="margin: 3px 0;"><strong>Tanggal:</strong> {{ $transaksi->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</p>
            <p style="margin: 3px 0;"><strong>Kasir:</strong> {{ optional($transaksi->user)->name ?? '-' }}</p>
            
            @if ($transaksi->nama_pelanggan)
                <p style="margin: 3px 0;"><strong>Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}</p>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th style="text-align: left;">Barang</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->details as $item)
                    <tr>
                        <td style="text-align: left;">
                            {{ $item->nama_manual ?? optional($item->data)->nama_barang ?? '-' }}
                        </td>
                        <td style="text-align: center;">{{ $item->qty }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                
                <tr class="total-row">
                    <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                    <td style="text-align: right;"><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
                
                <tr>
                    <td colspan="2" style="text-align: right;">Bayar:</td>
                    <td style="text-align: right;">Rp {{ number_format($transaksi->uang_dibayar, 0, ',', '.') }}</td>
                </tr>
                
                <tr>
                    <td colspan="2" style="text-align: right;">Kembali:</td>
                    <td style="text-align: right;">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p><strong>Terima kasih telah berbelanja!</strong></p>
            <p>~ De Tani Waterpark ~</p>
        </div>
    </div>

    <!-- Tombol Aksi Mobile -->
    <div class="mobile-actions no-print">
        <button class="btn btn-print" onclick="handlePrint()">
            🖨️ CETAK STRUK
        </button>
        <a href="{{ route('user.transaksi.index') }}" class="btn btn-back">
            🔙 KE TRANSAKSI
        </a>
    </div>

    <!-- Script Print yang Diperbaiki -->
    <script>
    function handlePrint() {
        // Sembunyikan alert success sebelum print
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.display = 'none';
        }
        
        // Tunggu sebentar untuk memastikan DOM siap
        setTimeout(() => {
            window.print();
        }, 100);
    }

    // HANYA auto-print untuk desktop, itupun dengan konfirmasi
    @if($auto_print)
    document.addEventListener('DOMContentLoaded', function() {
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        
        if (!isMobile) {
            // Desktop: Auto print setelah 1 detik
            setTimeout(() => {
                if (confirm('Cetak struk transaksi?')) {
                    handlePrint();
                }
            }, 1000);
        }
    });
    @endif

    // Handle after print event (jika browser support)
    window.addEventListener('afterprint', function() {
        console.log('Print dialog closed');
        // Tidak redirect otomatis, biarkan user yang memutuskan
    });
    </script>
</body>
</html>