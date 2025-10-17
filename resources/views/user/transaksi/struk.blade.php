<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - Kantin DeTani</title>
    <style>
        /* CSS Thermal Printer */
             * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box;
            line-height: 1.1;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px; /* Lebih kecil untuk thermal */
            font-weight: normal;
            width: 58mm; /* Standar thermal 58mm */
            max-width: 58mm;
            margin: 0 auto;
            padding: 2mm;
            background: white;
            color: black;
        }

        /* HEADER */
        .center { 
            text-align: center; 
            margin-bottom: 8px;
        }
        
        .center img {
            max-width: 60px !important; /* Logo lebih kecil */
            height: auto;
            margin-bottom: 5px;
        }
        
        .center h2 {
            font-size: 13px;
            margin: 3px 0;
            font-weight: bold;
        }
        
        .center p {
            font-size: 9px;
            margin: 1px 0;
            line-height: 1.2;
        }

        /* DIVIDER */
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        /* INFO TRANSAKSI */
        .transaction-info {
            margin-bottom: 8px;
            font-size: 10px;
        }
        
        .transaction-info p {
            margin: 2px 0;
        }

        /* TABLE STYLING */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 10px;
        }
        
        th, td {
            padding: 2px 0;
            border-bottom: 1px dashed #ccc;
        }
        
        th {
            text-align: left;
            font-weight: bold;
        }
        
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .total-row td {
            font-weight: bold;
            border-bottom: 2px solid #000;
            padding-top: 3px;
        }

        /* FOOTER */
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 9px;
        }

        /* PRINT SPECIFIC STYLES */
        @media print {
            @page {
                size: 58mm auto; /* UKURAN THERMAL 58mm */
                margin: 0;
                padding: 0;
            }
            
            body {
                width: 58mm !important;
                margin: 0 !important;
                padding: 2mm !important;
                font-size: 11px !important;
            }
            
            .mobile-actions, .no-print, .alert-success {
                display: none !important;
            }
            
            /* Force black text for printing */
            * {
                color: black !important;
                background: transparent !important;
            }
        }

        /* MOBILE ACTIONS (Hanya untuk preview) */
        .mobile-actions {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 10px;
            border-top: 2px solid #eee;
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        .btn {
            padding: 10px 14px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            flex: 1;
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

    <div class="mobile-actions no-print">
    <form action="{{ route('user.transaksi.print.thermal', $transaksi->id) }}" method="POST" style="flex: 1;">
        @csrf
        <button type="submit" class="btn btn-print">
            🖨️ CETAK THERMAL
        </button>
    </form>
    <a href="{{ route('user.transaksi.index') }}" class="btn btn-back">
        🔙 KE TRANSAKSI
    </a>
</div>

    <!-- RawBT Printing Script -->
<script>
class RawBTPrinter {
    constructor() {
        this.isRawBTAvailable = typeof RawBT !== 'undefined';
    }

    // Print dengan RawBT
    printWithRawBT(escposData) {
        if (this.isRawBTAvailable) {
            // Jika RawBT tersedia (Android app)
            RawBT.printText(escposData);
            return true;
        } else {
            // Fallback: Buka RawBT app dengan data
            this.openRawBTApp(escposData);
            return false;
        }
    }

    // Buka RawBT app dengan intent
    openRawBTApp(escposData) {
        const base64Data = btoa(escposData).replace(/\//g, '_').replace(/\+/g, '-');
        const url = `intent://rawbt/#Intent;scheme=rawbt;package=ru.a402d.rawbtprinter;S.data=${base64Data};end`;
        
        // Coba buka RawBT app
        window.location.href = url;
        
        // Fallback ke Play Store jika app tidak terinstall
        setTimeout(() => {
            if (!document.hidden) {
                window.location.href = 'https://play.google.com/store/apps/details?id=ru.a402d.rawbtprinter';
            }
        }, 500);
    }

    // Print struk transaksi
    async printStruk(transaksiId) {
        try {
            const response = await fetch(`/user/transaksi/print-thermal/${transaksiId}?rawbt=1`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();
            
            if (result.success && result.rawbt) {
                // Decode base64 ESC/POS data
                const escposText = atob(result.escpos_data);
                return this.printWithRawBT(escposText);
            } else {
                throw new Error('Format response tidak sesuai');
            }
        } catch (error) {
            console.error('Print error:', error);
            alert('Gagal mencetak: ' + error.message);
            return false;
        }
    }
}

// Initialize RawBT printer
const rawBTPrinter = new RawBTPrinter();

// Handle print button click
document.addEventListener('DOMContentLoaded', function() {
    const printForm = document.querySelector('form[action*="print-thermal"]');
    
    if (printForm) {
        printForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const transaksiId = '{{ $transaksi->id }}';
            const isAndroid = /Android/i.test(navigator.userAgent);
            
            if (isAndroid) {
                // Gunakan RawBT untuk Android
                await rawBTPrinter.printStruk(transaksiId);
            } else {
                // Desktop: submit form biasa
                this.submit();
            }
        });
    }

    // Auto print untuk RawBT jika di-set
    @if($auto_print && request()->has('rawbt_auto'))
    setTimeout(() => {
        rawBTPrinter.printStruk('{{ $transaksi->id }}');
    }, 1000);
    @endif
});
</script>
</body>
</html>