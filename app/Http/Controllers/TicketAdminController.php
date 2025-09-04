<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\TicketStock;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    public function index()
    {
        $stocks = TicketStock::with('sales')->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        
        // Cek apakah ada stock yang memiliki penambahan stok
        $hasAdditionalStocks = $stocks->some(function($stock) {
            return $stock->hasAdditionalStock();
        });
        
        return view('admin.tickets.index', compact('stocks', 'hasAdditionalStocks'));
    }

    public function create()
    {
        return view('admin.tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|integer',
            'initial_stock' => 'required|integer|min:1',
        ]);

        // cek apakah stok untuk bulan & tahun tsb sudah ada
        $stock = TicketStock::where('month', $request->month)
            ->where('year', $request->year)
            ->first();

        if ($stock) {
            // update stok lama (ditambah)
            $stock->increment('initial_stock', $request->initial_stock);
        } else {
            // kalau belum ada → buat baru
            TicketStock::create([
                'month' => ucfirst(strtolower($request->month)),
                'year' => $request->year,
                'initial_stock' => $request->initial_stock,
            ]);
        }

        return redirect()->back()->with('success', 'Stok tiket berhasil disimpan/ditambahkan.');
    }

  public function reportsIndex(Request $request)
    {
        // set locale agar nama bulan pakai Bahasa (jika diperlukan)
        Carbon::setLocale('id');

        // default filter (pakai nama bulan, karena blade select kamu mengirim nama bulan)
        $month = $request->input('month', Carbon::now()->translatedFormat('F'));
        $year  = $request->input('year', Carbon::now()->year);

        // list stocks (bisa dipakai nanti kalau perlu menampilkan daftar stok)
        $stocks = TicketStock::with('sales')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get();

        // ambil stock yang relevan untuk periode yang dipilih (single)
        $stock = TicketStock::with('sales')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->latest('created_at')
                    ->first();

        // Jika ada stock, ambil sales dari relasi stock -> sales
        if ($stock) {
            $salesHistory = $stock->sales()->orderBy('date', 'asc')->get();

            $totalSold = $salesHistory->sum('sold_amount');
            $remaining = $stock->initial_stock - $totalSold;

            // rekap uang (pastikan kolom-nya sesuai: gross_total, discount, net_total)
            $totalRevenue = $salesHistory->sum('gross_total') ?? 0;
            $totalDiscount = $salesHistory->sum('discount') ?? 0;
            $totalNet = $salesHistory->sum('net_total') ?? 0;
        } else {
            // tidak ada stock untuk periode → set default
            $salesHistory = collect();
            $totalSold = 0;
            $remaining = 0;
            $totalRevenue = 0;
            $totalDiscount = 0;
            $totalNet = 0;
        }

        // kirim ke view — termasuk 'stock' (singular) yang dibutuhkan blade kamu
        return view('admin.tickets.reports.index', compact(
            'stock',
            'stocks',
            'salesHistory',
            'totalSold',
            'remaining',
            'month',
            'year',
            'totalRevenue',
            'totalDiscount',
            'totalNet'
        ))->with('transaksis', $salesHistory); // alias backward-compat kalau partial lama pakai $transaksis
    }
        
    public function edit($id)
    {
        $stock = TicketStock::findOrFail($id);
        return view('admin.tickets.edit', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        $stock = TicketStock::findOrFail($id);

        $request->validate([
            'month' => 'required',
            'year' => 'required|integer',
            'additional_stock' => 'required|integer|min:1'
        ]);

        // Jika ini adalah penambahan stok pertama kali setelah pembuatan, set original_stock
        if (is_null($stock->original_stock)) {
            $stock->original_stock = $stock->initial_stock;
            $stock->save();
        }

        // Tambahkan stok tambahan ke stok yang sudah ada
        $stock->increment('initial_stock', $request->additional_stock);

        return redirect()->route('admin.tickets.index')->with('success', 
            "Berhasil menambahkan {$request->additional_stock} tiket ke stok {$stock->month} {$stock->year}. Total stok sekarang: " . number_format($stock->initial_stock)
        );
    }
}
