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
            'sold_amount'     => 'required|integer|min:1',
            'date'            => 'required|date|after_or_equal:' . now()->startOfMonth()->toDateString() .
                                '|before_or_equal:' . now()->endOfMonth()->toDateString(),
            'discount'        => 'nullable|integer|min:0',
            'notes'           => 'nullable|string',
        ]);

        // Cek stok cukup
        if ($stock->remainingStock() < $request->sold_amount) {
            return redirect()->back()->with('error', 'Stok tiket tidak mencukupi.');
        }

        // Tentukan harga weekday / weekend
        $isWeekend = Carbon::parse($request->date)->isWeekend();
        $pricePerTicket = $isWeekend ? 25000 : 20000;

        // Hitung total
        $grossTotal = $pricePerTicket * $request->sold_amount;
        $discount   = $request->discount ?? 0;
        $netTotal   = $grossTotal - $discount;

        // Simpan penjualan
        TicketSale::create([
            'ticket_stock_id'  => $stock->id,
            'date'             => $request->date,
            'sold_amount'      => $request->sold_amount,
            'user_id'          => Auth::id(),
            'price_per_ticket' => $pricePerTicket,
            'gross_total'      => $grossTotal,
            'discount'         => $discount,
            'net_total'        => $netTotal,
            'notes'            => $request->notes,
        ]);

        return redirect()->route('user.tickets.create')->with('success', 'Penjualan tiket berhasil dicatat.');
    }
}
