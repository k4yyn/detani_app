<?php

namespace App\Http\Controllers;

use App\Models\TicketStock;
use App\Models\TicketSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TicketKasirController extends Controller
{
    public function createSale()
    {
        // Ambil stok bulan berjalan
        $month = Carbon::now()->locale('id')->isoFormat('MMMM');
        $year = Carbon::now()->year;
        $stock = TicketStock::where('month', $month)->where('year', $year)->first();

        if (!$stock) {
            return redirect()->back()->with('error', 'Stok tiket bulan ini belum diatur oleh admin.');
        }

        return view('user.tickets.create', compact('stock'));
    }

    public function storeSale(Request $request)
    {
        $stock = TicketStock::findOrFail($request->ticket_stock_id);

        // Validasi input
        $request->validate([
            'ticket_stock_id' => 'required|exists:ticket_stocks,id',
            'sold_amount' => 'required|integer|min:1',
            'date' => 'required|date|after_or_equal:' . now()->startOfMonth()->toDateString() .
                      '|before_or_equal:' . now()->endOfMonth()->toDateString(),
        ]);

        // Cek stok cukup
        if ($stock->remainingStock() < $request->sold_amount) {
            return redirect()->back()->with('error', 'Stok tiket tidak mencukupi.');
        }

        // Simpan penjualan
        TicketSale::create([
            'ticket_stock_id' => $stock->id,
            'date' => $request->date,
            'sold_amount' => $request->sold_amount,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('user.tickets.create')->with('success', 'Penjualan tiket berhasil dicatat.');
    }
}
