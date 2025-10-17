<?php

namespace App\Services;

use App\Models\Transaksi;

class ThermalPrintService
{
    public function __construct($connectionType = 'rawbt')
    {
        // Tidak perlu inisialisasi khusus untuk RawBT
    }

    public function printReceipt($transaksi)
    {
        // Untuk compatibility dengan code lama
        $rawbtService = new RawBTPrintService();
        return $rawbtService->generateESC_POS($transaksi);
    }

    public function getRawBTData($transaksi)
    {
        $rawbtService = new RawBTPrintService();
        return $rawbtService->getBase64ESC_POS($transaksi);
    }
}