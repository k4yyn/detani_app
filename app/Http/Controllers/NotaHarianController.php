<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class NotaHarianController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        return view('user.nota.nota_harian', compact('transaksi'));
    }

    public function cetak()
    {
        $transaksi = Transaksi::with(['details.data', 'user'])
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('user.nota.notaHarianCetak', compact('transaksi'));
    }

}
