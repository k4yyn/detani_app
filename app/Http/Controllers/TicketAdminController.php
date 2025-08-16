<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TicketStock;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    public function index()
    {
        $stocks = TicketStock::with('sales')->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        return view('admin.tickets.index', compact('stocks'));
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
        $month = $request->input('month', now()->translatedFormat('F')); // default bulan sekarang (string)
        $year = $request->input('year', now()->year);

        $stock = TicketStock::with('sales')
            ->where('month', $month)
            ->where('year', $year)
            ->latest('created_at')
            ->first();

        $salesHistory = collect();
        $totalSold = 0;
        $remaining = 0;

        if ($stock) {
            $salesHistory = $stock->sales()->orderBy('date', 'asc')->get();
            $totalSold = $salesHistory->sum('sold_amount');
            $remaining = $stock->initial_stock - $totalSold;
        }

        return view('admin.tickets.reports.index', compact(
            'stock',
            'salesHistory',
            'totalSold',
            'remaining',
            'month',
            'year'
        ));
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
            'initial_stock' => 'required|integer|min:0'
        ]);

        $stock->update($request->all());

        return redirect()->route('admin.tickets.index')->with('success', 'Stok tiket berhasil diperbarui.');
    }
}
