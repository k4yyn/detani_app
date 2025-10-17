<?php

namespace App\Services;

use App\Models\Transaksi;

class RawBTPrintService
{
    public function generateESC_POS($transaksi)
    {
        $lines = [];
        
        // Config printer
        $lines[] = "\x1B\x40"; // Initialize printer
        $lines[] = "\x1B\x21\x00"; // Reset text size
        
        // Header - Center alignment
        $lines[] = "\x1B\x61\x01"; // Center align
        $lines[] = "\x1B\x21\x22"; // Double height and width
        $lines[] = "Kantin DeTani\n";
        $lines[] = "\x1B\x21\x00"; // Normal text
        $lines[] = "Jln. Goalpara, Kp. Cijeruk, Sukamekar\n";
        $lines[] = "Kec. Sukaraja, Sukabumi\n";
        $lines[] = "Telp: 0819-1188-0088\n";
        $lines[] = "========================\n";
        
        // Transaction Info - Left align
        $lines[] = "\x1B\x61\x00"; // Left align
        $lines[] = "Kode    : " . $transaksi->kode_transaksi . "\n";
        $lines[] = "Tanggal : " . $transaksi->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') . "\n";
        $lines[] = "Kasir   : " . ($transaksi->user->name ?? '-') . "\n";
        
        if ($transaksi->nama_pelanggan) {
            $lines[] = "Customer: " . $transaksi->nama_pelanggan . "\n";
        }
        
        $lines[] = "========================\n";
        
        // Items header
        $lines[] = $this->formatLine("ITEM", "QTY", "HARGA");
        $lines[] = "------------------------\n";
        
        // Items
        foreach ($transaksi->details as $item) {
            $nama = $item->nama_manual ?? optional($item->data)->nama_barang ?? '-';
            $nama = substr($nama, 0, 20);
            
            $qty = str_pad($item->qty, 3);
            $harga = str_pad(number_format($item->harga, 0, ',', '.'), 8);
            
            $lines[] = $this->formatLine($nama, $qty, $harga);
        }
        
        $lines[] = "========================\n";
        
        // Totals
        $lines[] = $this->formatLine("TOTAL:", "", number_format($transaksi->total_harga, 0, ',', '.'));
        $lines[] = $this->formatLine("BAYAR:", "", number_format($transaksi->uang_dibayar, 0, ',', '.'));
        $lines[] = $this->formatLine("KEMBALI:", "", number_format($transaksi->kembalian, 0, ',', '.'));
        
        $lines[] = "\n";
        
        // Footer
        $lines[] = "\x1B\x61\x01"; // Center align
        $lines[] = "Terima kasih telah berbelanja!\n";
        $lines[] = "~ De Tani Waterpark ~\n";
        $lines[] = "\n\n\n";
        
        // Cut paper
        $lines[] = "\x1D\x56\x00"; // Full cut
        
        return implode('', $lines);
    }
    
    private function formatLine($item, $qty, $harga)
    {
        $item = str_pad($item, 20);
        $qty = str_pad($qty, 5);
        $harga = str_pad($harga, 10);
        
        return $item . $qty . $harga . "\n";
    }
    
    public function getBase64ESC_POS($transaksi)
    {
        $escpos = $this->generateESC_POS($transaksi);
        return base64_encode($escpos);
    }
}