<?php
// app/Http/Controllers/StockKantinController.php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\StockOpname;
use App\Models\StockTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockKantinController extends Controller
{
    /**
     * Dashboard Stock Kantin 1
     */
    public function dashboard()
    {
        // Hanya untuk kasir kantin 1
        if (auth()->user()->role !== 'user') {
            abort(403, 'Hanya kasir yang dapat mengakses halaman ini');
        }

        $barangKantin1 = Data::where('stock_kantin1', '>', 0)
            ->orWhere(function($query) {
                $query->where('stock_kantin1', '<=', DB::raw('min_stock_kantin1'))
                      ->where('stock_kantin1', '>', 0);
            })
            ->orderBy('nama_barang')
            ->get();

        $stokRendah = Data::where('stock_kantin1', '<=', DB::raw('min_stock_kantin1'))
            ->where('stock_kantin1', '>', 0)
            ->count();

        $stokHabis = Data::where('stock_kantin1', 0)->count();

        return view('user.stock-kantin.dashboard', compact(
            'barangKantin1', 'stokRendah', 'stokHabis'
        ));
    }

    public function verifikasiStock(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            abort(403);
        }

        $tanggal = $request->tanggal ?? now()->format('Y-m-d');

        $barangKantin1 = Data::where('stock_kantin1', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        $existingVerifikasi = StockOpname::whereDate('tanggal', $tanggal)
            ->where('kantin_id', '1')
            ->where('user_id', auth()->id())
            ->get()
            ->keyBy('data_id');

        // Untuk barang yang belum diverifikasi hari ini, default ke stock sistem
        foreach ($barangKantin1 as $item) {
            if (!isset($existingVerifikasi[$item->id])) {
                // Buat record temporary untuk default value
                $existingVerifikasi[$item->id] = (object)[
                    'stock_fisik' => $item->stock_kantin1, // Default ke sistem terbaru
                    'keterangan' => '',
                    'status' => 'match'
                ];
            }
        }

        return view('user.stock-kantin.verifikasi', compact(
            'barangKantin1', 'existingVerifikasi', 'tanggal'
        ));
    }

    public function simpanVerifikasi(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'data_id' => 'required|exists:data,id',
            'tanggal' => 'required|date',
            'stock_fisik' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $barang = Data::findOrFail($request->data_id);
                
                // Auto verifikasi - sistem yang handle
                StockOpname::updateOrCreate(
                    [
                        'data_id' => $request->data_id,
                        'tanggal' => $request->tanggal,
                        'kantin_id' => '1',
                        'user_id' => auth()->id()
                    ],
                    [
                        'stock_sistem' => $barang->stock_kantin1,
                        'stock_fisik' => $request->stock_fisik,
                        'keterangan' => $request->keterangan
                        // selisih & status auto calculated by model
                    ]
                );
            });

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi stock berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan verifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Transfer Stock dari Gudang - SIMPLE
     */
    public function transferStock(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            abort(403);
        }

        $barangTersedia = Data::where('stock_gudang', '>', 0)
        ->orderBy('nama_barang')
        ->get();

        $transferHariIni = StockTransfer::whereDate('created_at', today())
            ->where('ke_lokasi', 'kantin1')
            ->where('user_id', auth()->id())
            ->with('data')
            ->get();

        return view('user.stock-kantin.transfer', compact(
            'barangTersedia', 'transferHariIni'
        ));
    }

    
    public function prosesTransfer(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'data_id' => 'required|exists:data,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $barang = Data::findOrFail($request->data_id);

                // Cek stock gudang cukup
                if ($barang->stock_gudang < $request->jumlah) {
                    throw new \Exception('Stock gudang tidak cukup. Tersedia: ' . $barang->stock_gudang);
                }

                // Kurangi gudang, tambah kantin1
                $barang->decrement('stock_gudang', $request->jumlah);
                $barang->increment('stock_kantin1', $request->jumlah);
                
                // ✅ FIX: UPDATE DATA.STOK UNTUK SINKRONISASI DENGAN GUDANG
                $barang->stok = $barang->stock_gudang; // Stok data = stock gudang
                $barang->save();

                // Record transfer
                StockTransfer::create([
                    'data_id' => $request->data_id,
                    'jumlah' => $request->jumlah,
                    'dari_lokasi' => 'gudang',
                    'ke_lokasi' => 'kantin1',
                    'status' => 'completed',
                    'user_id' => auth()->id(),
                    'keterangan' => $request->keterangan
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Transfer stock berhasil'
            ]);

        } catch (\Exception $e) {
          return response()->json([
                'success' => false,
                'message' => 'Gagal transfer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function laporan(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            abort(403);
        }

        $tanggal = $request->tanggal ?? now()->format('Y-m-d');

        // Data verifikasi (stock pagi)
        $verifikasi = StockOpname::with('data')
            ->whereDate('tanggal', $tanggal)
            ->where('kantin_id', '1')
            ->where('user_id', auth()->id())
            ->get();

        // Data transfer
        $transfer = StockTransfer::with('data')
            ->whereDate('created_at', $tanggal)
            ->where('ke_lokasi', 'kantin1')
            ->where('user_id', auth()->id())
            ->get();

        // NEW: Hitung penjualan dan stock malam
        $stockMalam = [];
        $totalPenjualanHariIni = 0;

        foreach ($verifikasi as $v) {
            // Hitung total penjualan untuk barang ini di tanggal tersebut
            $totalPenjualan = \App\Models\TransaksiDetail::where('data_id', $v->data_id)
                ->whereHas('transaksi', function($query) use ($tanggal) {
                    $query->whereDate('created_at', $tanggal);
                })
                ->sum('qty');

            $stockAkhir = $v->stock_fisik - $totalPenjualan;

            $stockMalam[] = [
                'barang' => $v->data,
                'stock_pagi' => $v->stock_fisik,
                'terjual' => $totalPenjualan,
                'stock_akhir' => $stockAkhir,
                'verifikasi' => $v
            ];

            $totalPenjualanHariIni += $totalPenjualan;
        }

        // Summary
        $summary = [
            'total_verifikasi' => $verifikasi->count(),
            'total_match' => $verifikasi->where('status', 'match')->count(),
            'total_selisih' => $verifikasi->where('status', 'selisih')->count(),
            'total_transfer' => $transfer->count(),
            'total_barang_transfer' => $transfer->sum('jumlah'),
            'total_penjualan' => $totalPenjualanHariIni, // NEW
            'total_barang_stock_malam' => count($stockMalam) // NEW
        ];

        return view('user.stock-kantin.laporan', compact(
            'verifikasi', 'transfer', 'summary', 'tanggal', 'stockMalam' // NEW
        ));
    }

    public function autoSetup()
    {
        if (auth()->user()->role !== 'user') {
            abort(403);
        }

        try {
            DB::transaction(function () {
                // 1. Reset dulu
                DB::table('data')->update([
                    'stock_kantin1' => 0,
                    'stock_gudang' => DB::raw('stok')
                ]);
                
                // 2. Hapus history
                DB::table('stock_transfers')->truncate();
                DB::table('stock_opnames_kantin')->truncate();
                
                // 3. Setup baru - pindah SEMUA stock ke kantin1
                $barangWithStock = Data::where('stok', '>', 0)->get();
                
                foreach ($barangWithStock as $barang) {
                    if ($barang->stok > 0) {
                        $barang->stock_kantin1 = $barang->stok;
                        $barang->stock_gudang = 0;
                        $barang->save();

                        StockTransfer::create([
                            'data_id' => $barang->id,
                            'jumlah' => $barang->stok,
                            'dari_lokasi' => 'gudang',
                            'ke_lokasi' => 'kantin1',
                            'status' => 'completed', 
                            'user_id' => auth()->id(),
                            'keterangan' => 'Auto-setup: Semua stock dipindah ke kantin 1'
                        ]);
                    }
                }
            });

            return redirect()->route('user.stock-kantin.dashboard')
                ->with('success', '✅ Stock berhasil direset & disetup ulang! Sistem siap digunakan.');

        } catch (\Exception $e) {
            return redirect()->route('user.stock-kantin.dashboard')
                ->with('error', '❌ Gagal setup: ' . $e->getMessage());
        }
    }
}