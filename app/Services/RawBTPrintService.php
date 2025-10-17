<?php

namespace App\Services;

use App\Models\Transaksi;

class RawBTPrintService
{
    public function generateESC_POS($transaksi)
    {
        $lines = [];
        
        // Initialize printer
        $lines[] = "\x1B\x40";
        
        // Header - Center alignment & Double size
        $lines[] = "\x1B\x61\x01"; // Center align
        $lines[] = "\x1B\x21\x22"; // Double height and width
        $lines[] = "Kantin DeTani\n";
        
        // Normal text
        $lines[] = "\x1B\x21\x00";
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
        
        // Items
        foreach ($transaksi->details as $item) {
            $nama = $item->nama_manual ?? optional($item->data)->nama_barang ?? '-';
            $nama = substr($nama, 0, 20);
            
            $qty = str_pad($item->qty, 3);
            $harga = "Rp " . number_format($item->harga, 0, ',', '.');
            
            $lines[] = str_pad($nama, 20) . str_pad($qty, 5) . str_pad($harga, 15) . "\n";
        }
        
        $lines[] = "========================\n";
        
        // Totals
        $lines[] = str_pad("TOTAL:", 25) . "Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n";
        $lines[] = str_pad("BAYAR:", 25) . "Rp " . number_format($transaksi->uang_dibayar, 0, ',', '.') . "\n";
        $lines[] = str_pad("KEMBALI:", 25) . "Rp " . number_format($transaksi->kembalian, 0, ',', '.') . "\n";
        
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
    
    public function getBase64ESC_POS($transaksi)
    {
        $escpos = $this->generateESC_POS($transaksi);
        return base64_encode($escpos);
    }
    
    // Simple text version untuk testing
    public function generateSimpleText($transaksi)
    {
        $text = "";
        
        // Header
        $text .= "Kantin DeTani\n";
        $text .= "Jln. Goalpara, Kp. Cijeruk, Sukamekar\n";
        $text .= "Kec. Sukaraja, Sukabumi\n";
        $text .= "Telp: 0819-1188-0088\n";
        $text .= "========================\n\n";
        
        // Transaction Info
        $text .= "Kode    : " . $transaksi->kode_transaksi . "\n";
        $text .= "Tanggal : " . $transaksi->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') . "\n";
        $text .= "Kasir   : " . ($transaksi->user->name ?? '-') . "\n";
        
        if ($transaksi->nama_pelanggan) {
            $text .= "Customer: " . $transaksi->nama_pelanggan . "\n";
        }
        
        $text .= "========================\n\n";
        
        // Items
        $text .= str_pad("ITEM", 20) . str_pad("QTY", 5) . str_pad("HARGA", 15) . "\n";
        $text .= "------------------------\n";
        
        foreach ($transaksi->details as $item) {
            $nama = $item->nama_manual ?? optional($item->data)->nama_barang ?? '-';
            $nama = substr($nama, 0, 20);
            
            $qty = str_pad($item->qty, 3);
            $harga = "Rp " . number_format($item->harga, 0, ',', '.');
            
            $text .= str_pad($nama, 20) . str_pad($qty, 5) . str_pad($harga, 15) . "\n";
        }
        
        $text .= "========================\n";
        $text .= str_pad("TOTAL:", 25) . "Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n";
        $text .= str_pad("BAYAR:", 25) . "Rp " . number_format($transaksi->uang_dibayar, 0, ',', '.') . "\n";
        $text .= str_pad("KEMBALI:", 25) . "Rp " . number_format($transaksi->kembalian, 0, ',', '.') . "\n\n";
        
        // Footer
        $text .= "Terima kasih telah berbelanja!\n";
        $text .= "~ De Tani Waterpark ~\n\n\n\n";
        
        return $text;
    }
}