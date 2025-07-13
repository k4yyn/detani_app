<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Transaksi;
use App\Models\TransaksiKasir;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiKasirController extends Controller
{
    public function index()
    {
        $transaksis = TransaksiDetail::with('data')
            ->whereNull('transaksi_id')
            ->latest()
            ->get();
            
        $grandTotal = $transaksis->sum(function($item) {
            return $item->qty * $item->data->harga_jual;
        });

        $products = Data::where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('user.transaksi.index', [
            'transaksis' => $transaksis,
            'grandTotal' => $grandTotal,
            'products' => $products
        ]);
    }

    // Keep other methods but ensure they use Transaksi model

    public function store(Request $request)
    {
        $request->validate([
            'data_id' => 'required|exists:data,id',
            'codetrx' => 'required',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'harga_jual' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Data::findOrFail($request->data_id);

        if ($product->stok < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $product->stok);
        }

        $existingItem = TransaksiDetail::where('data_id', $request->data_id)
                                     ->whereNull('transaksi_id')
                                     ->first();

        if ($existingItem) {
            $existingItem->qty += $request->qty;
            $existingItem->save();
        } else {
            TransaksiDetail::create([
                'data_id' => $request->data_id,
                'codetrx' => $request->codetrx,
                'qty' => $request->qty
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Item berhasil ditambahkan ke transaksi!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data berhasil dihapus!');
    }

    public function deleteAll()
    {
        TransaksiDetail::whereNull('transaksi_id')->delete();

        return redirect()->route('transaksi.index')->with('success', 'Semua item transaksi berhasil dihapus!');
    }

    public function checkout(Request $request)
{
    $request->validate([
        'codetrx' => 'required|string',
        'uang_dibayar' => 'required|numeric|min:0',
    ]);

    $transaksiDetails = TransaksiDetail::with('data')->whereNull('transaksi_id')->get();

    if ($transaksiDetails->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Tidak ada item untuk diproses.']);
    }

    $grandTotal = $transaksiDetails->sum(function ($item) {
        return $item->qty * $item->data->harga_jual;
    });

    if ($request->uang_dibayar < $grandTotal) {
        return response()->json([
            'success' => false,
            'message' => 'Uang dibayar kurang dari total belanja. Kurang: Rp ' . number_format($grandTotal - $request->uang_dibayar, 0, ',', '.')
        ]);
    }

    DB::beginTransaction();

    try {
        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'kode_transaksi' => $request->codetrx,
            'total_harga' => $grandTotal,
            'uang_dibayar' => $request->uang_dibayar,
            'kembalian' => $request->uang_dibayar - $grandTotal
        ]);

        foreach ($transaksiDetails as $item) {
            $item->transaksi_id = $transaksi->id;
            $item->save();

            $product = Data::find($item->data_id);
            if ($product->stok < $item->qty) {
                throw new \Exception("Stok {$product->nama_barang} tidak mencukupi");
            }
            $product->decrement('stok', $item->qty);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'struk_url' => route('transaksi.struk', $transaksi->id)
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Transaksi gagal: ' . $e->getMessage()]);
    }
}

    public function showStruk($id)
    {
        $transaksi = Transaksi::with(['user', 'details.data'])->findOrFail($id);
        return view('transaksi.struk', compact('transaksi'));
    }

    public function cetakStruk($id)
{
    $transaksi = Transaksi::with(['details.data', 'user'])->findOrFail($id);

    return view('user.transaksi.struk', [
        'transaksi' => $transaksi
    ]);
}

}
