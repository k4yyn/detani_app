<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Collection; // Tambahkan di atas

class DataController extends Controller
{

public function index(Request $request)
{
    $query = Data::query();

    if ($search = $request->search) {
        $query->where('nama_barang', 'like', "%$search%")
              ->orWhere('codetrx', 'like', "%$search%")
              ->orWhere('lokasi_penyimpanan', 'like', "%$search%");
    }

    $data = $query->latest()->get(); // Ambil semua data, tanpa paginate

    // Group data by kategori
    $groupedData = $data->groupBy('kategori');

    if (auth()->user()->role === 'admin') {
        return view('admin.data.index', compact('groupedData'));
    } else {
        return view('user.data.index', compact('groupedData'));
    }
}


    public function create()
    {
        return view('admin.data.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:1',
            'harga_pokok' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'required|string',
        ]);

        $todayFormatted = now()->format('dmY');
        $countToday = Data::whereDate('created_at', now())->count() + 1;
        $order = str_pad($countToday, 2, '0', STR_PAD_LEFT);
        $codetrx = "am-{$order}-{$todayFormatted}-id";

        Data::create([
            'codetrx' => $codetrx,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'harga_pokok' => $request->harga_pokok,
            'harga_jual' => $request->harga_jual,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
        ]);

        return redirect()->route('admin.data.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = Data::findOrFail($id);
        return view('admin.data.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:1|max:9999',
        ]);

        $data = Data::findOrFail($id);
        $data->update([
            'stok' => $request->stok,
        ]);

        return redirect()->route('admin.data.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = Data::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.data.index')->with('success', 'Data berhasil dihapus!');
    }
}
