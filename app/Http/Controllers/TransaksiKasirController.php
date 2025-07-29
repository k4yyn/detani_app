<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransaksiKasirController extends Controller
{
    public function index()
    {
        $data = Data::all();
        $keranjang = Session::get('keranjang', []);
        $total = collect($keranjang)->sum('subtotal');

        return view('user.transaksi.index', compact('data', 'keranjang', 'total'));
    }

    public function tambahKeranjang(Request $request)
{
    //transaksi manual
    if ($request->manual) {
        $keranjang = Session::get('keranjang', []);
        $index = collect($keranjang)->search(fn($item) => $item['id'] == $request->id);

        if ($index !== false) {
            $keranjang[$index]['qty'] += $request->qty;
            $keranjang[$index]['subtotal'] = $keranjang[$index]['qty'] * $keranjang[$index]['harga'];
        } else {
            $keranjang[] = [
                'id' => $request->id,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'qty' => $request->qty,
                'diskon' => 0,
                'subtotal' => $request->harga * $request->qty,
            ];
        }

        Session::put('keranjang', $keranjang);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi tambahan berhasil ditambahkan ke keranjang',
            'keranjang_count' => collect($keranjang)->sum('qty'),
            'total' => collect($keranjang)->sum('subtotal'),
            'keranjang' => $keranjang
        ]);
    }

    // Proses transaksi dari produk asli (bukan tambahan)
    $produk = Data::findOrFail($request->id);
    $keranjang = Session::get('keranjang', []);
    $index = collect($keranjang)->search(fn($item) => $item['id'] == $produk->id);

    if ($index !== false) {
        $keranjang[$index]['qty'] += 1;
        $keranjang[$index]['subtotal'] = $keranjang[$index]['qty'] * $keranjang[$index]['harga'];
    } else {
        $keranjang[] = [
            'id' => $produk->id,
            'nama' => $produk->nama_barang,
            'harga' => $produk->harga_jual,
            'qty' => 1,
            'diskon' => 0,
            'subtotal' => $produk->harga_jual,
        ];
    }

    Session::put('keranjang', $keranjang);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'keranjang_count' => collect($keranjang)->sum('qty'),
            'total' => collect($keranjang)->sum('subtotal'),
            'keranjang' => $keranjang
        ]);
    }

    return redirect()->route('user.transaksi.index');
}


    public function keranjang()
    {
        $keranjang = Session::get('keranjang', []);
        $total = collect($keranjang)->sum('subtotal');

        return view('user.transaksi.keranjang', compact('keranjang', 'total'));
    }

    public function hapusItem($id)
    {
        $keranjang = Session::get('keranjang', []);
        $keranjang = collect($keranjang)->reject(fn($item) => $item['id'] == $id)->values()->all();
        Session::put('keranjang', $keranjang);

        if (request()->ajax()) {
            $total = collect($keranjang)->sum('subtotal');
            $totalItems = collect($keranjang)->sum('qty');
            
            return response()->json([
                'success' => true,
                'keranjang_count' => $totalItems,
                'total' => $total,
                'keranjang' => $keranjang
            ]);
        }

        return back();
    }

    public function updateQty(Request $request, $id)
    {
        $keranjang = Session::get('keranjang', []);
        $index = collect($keranjang)->search(fn($item) => $item['id'] == $id);

        if ($index !== false) {
            $qty = max(1, (int)$request->qty);
            $keranjang[$index]['qty'] = $qty;
            $hargaSetelahDiskon = $keranjang[$index]['harga'] - ($keranjang[$index]['diskon'] ?? 0);
            $keranjang[$index]['subtotal'] = $hargaSetelahDiskon * $qty;
            Session::put('keranjang', $keranjang);
        }

        if ($request->ajax()) {
            $total = collect($keranjang)->sum('subtotal');
            $totalItems = collect($keranjang)->sum('qty');
            
            return response()->json([
                'success' => true,
                'keranjang_count' => $totalItems,
                'total' => $total,
                'keranjang' => $keranjang
            ]);
        }

        return back();
    }

    public function editHargaDiskon(Request $request, $id)
{
    $keranjang = session()->get('keranjang', []);
    
    // Cari item berdasarkan ID produk, bukan index
    $index = collect($keranjang)->search(fn($item) => $item['id'] == $id);

    if ($index === false) {
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan']);
    }

    $keranjang[$index]['harga'] = $request->harga;
    $keranjang[$index]['diskon'] = $request->diskon ?? 0;
    $keranjang[$index]['subtotal'] = ($request->harga - $request->diskon) * $keranjang[$index]['qty'];

    session()->put('keranjang', $keranjang);

    return response()->json(['success' => true]);
}


    public function checkout(Request $request)
{
    $keranjang = Session::get('keranjang', []);
    if (empty($keranjang)) {
        return back()->with('error', 'Keranjang kosong');
    }

    $total = collect($keranjang)->sum('subtotal');
    $bayar = (float)$request->bayar;

    if ($bayar < $total) {
        return back()->with('error', 'Uang bayar tidak mencukupi');
    }

    $kembalian = $bayar - $total;

    // Simpan transaksi
    $transaksi = Transaksi::create([
        'user_id' => auth()->id(),
        'kode_transaksi' => $request->no_transaksi ?? 'TRX-' . strtoupper(\Str::random(8)),
        'nama_pelanggan' => $request->nama_pelanggan,
        'nomor_meja' => $request->nomor_meja,
        'keterangan_tambahan' => $request->keterangan_tambahan,
        'keterangan' => $request->keterangan,
        'total_harga' => $total,
        'uang_dibayar' => $bayar,
        'kembalian' => $kembalian,
    ]);

    // Simpan detail
    foreach ($keranjang as $item) {
        TransaksiDetail::create([
            'transaksi_id' => $transaksi->id,
            'data_id' => is_numeric($item['id']) ? $item['id'] : null,
            'nama_manual' => !is_numeric($item['id']) ? $item['nama'] : null,
            'harga' => $item['harga'],
            'qty' => $item['qty'],
            'subtotal' => $item['subtotal'],
            'diskon' => $item['diskon'] ?? 0
        ]);

        if (is_numeric($item['id'])) {
            $produk = Data::find($item['id']);
            if ($produk) {
                $produk->decrement('stok', $item['qty']);
            }
        }
    }

    Session::forget('keranjang');

    // Cek apakah user ingin mencetak struk
    $cetak = $request->has('cetak_struk') ? 'true' : 'false';

    if ($request->has('cetak_struk')) {
        return redirect()->route('user.transaksi.struk', [
            'id' => $transaksi->id,
            'print' => 'true'
        ])->with('success', 'Transaksi berhasil. Struk akan dicetak.');
    } else {
        return redirect()->route('user.transaksi.index')
            ->with('success', 'Transaksi berhasil.');
    }
}

    public function struk($id)
{
        $transaksi = Transaksi::with(['user', 'details.data'])->findOrFail($id);
        return view('user.transaksi.struk', compact('transaksi'));
}

}