<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsBluetoothPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

class ThermalPrintService
{
    private $printer;

    public function __construct($connectionType = 'bluetooth', $deviceMac = null)
    {
        $this->connect($connectionType, $connectionString);
    }

    private function connect($connectionType, $connectionString)
    {
        try {
            if ($connectionType === 'bluetooth') {
                // Untuk Bluetooth printer (via IP)
                $macAddress = $deviceMac ?? env('THERMAL_PRINTER_MAC', '02:2E:35:1D:06:BE');
                $connector = new FilePrintConnector("bluetooth://$macAddress");
            } else {
                // Untuk USB printer
                 $connector = new FilePrintConnector(env('THERMAL_PRINTER_USB', '/dev/usb/lp0'));
            }
            
            $this->printer = new Printer($connector);
            
        } catch (\Exception $e) {
            throw new \Exception("Cannot connect to printer: " . $e->getMessage());
        }
    }

    public function printReceipt($transaksi)
    {
        try {
            // Config printer untuk thermal 58mm
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            
            // Header - Logo dan Nama Toko (ambil dari struk.blade.php kamu)
            $this->printer->setTextSize(2, 2);
            $this->printer->text("Kantin DeTani\n");
            $this->printer->setTextSize(1, 1);
            $this->printer->text("Jln. Goalpara, Kp. Cijeruk, Sukamekar\n");
            $this->printer->text("Kec. Sukaraja, Sukabumi\n");
            $this->printer->text("Telp: 0819-1188-0088\n");
            $this->printer->feed();
            
            // Garis pemisah
            $this->printer->text("========================\n");
            
            // Info Transaksi
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text("Kode    : " . $transaksi->kode_transaksi . "\n");
            $this->printer->text("Tanggal : " . $transaksi->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') . "\n");
            $this->printer->text("Kasir   : " . ($transaksi->user->name ?? '-') . "\n");
            
            if ($transaksi->nama_pelanggan) {
                $this->printer->text("Customer: " . $transaksi->nama_pelanggan . "\n");
            }
            
            $this->printer->text("========================\n");
            
            // Header Table Items
            $this->printer->text(str_pad("ITEM", 20) . str_pad("QTY", 5) . str_pad("HARGA", 10) . "\n");
            $this->printer->text("------------------------\n");
            
            // Items
            foreach ($transaksi->details as $item) {
                $nama = $item->nama_manual ?? optional($item->data)->nama_barang ?? '-';
                $nama = substr($nama, 0, 20); // Potong panjang nama
                
                $qty = str_pad($item->qty, 3);
                $harga = str_pad(number_format($item->harga, 0, ',', '.'), 8);
                
                $this->printer->text(str_pad($nama, 20) . str_pad($qty, 5) . str_pad($harga, 10) . "\n");
            }
            
            $this->printer->text("========================\n");
            
            // Total dan Pembayaran
            $this->printer->text(str_pad("TOTAL:", 25) . str_pad(number_format($transaksi->total_harga, 0, ',', '.'), 10) . "\n");
            $this->printer->text(str_pad("BAYAR:", 25) . str_pad(number_format($transaksi->uang_dibayar, 0, ',', '.'), 10) . "\n");
            $this->printer->text(str_pad("KEMBALI:", 25) . str_pad(number_format($transaksi->kembalian, 0, ',', '.'), 10) . "\n");
            
            $this->printer->feed();
            
            // Footer
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text("Terima kasih telah berbelanja!\n");
            $this->printer->text("~ De Tani Waterpark ~\n");
            $this->printer->feed(3);
            
            // Cut paper
            $this->printer->cut();
            
            $this->printer->close();
            
            return true;
            
        } catch (\Exception $e) {
            throw new \Exception("Print failed: " . $e->getMessage());
        }
    }
}

