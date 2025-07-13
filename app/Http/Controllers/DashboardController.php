<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    if (auth()->user()->role === 'admin') {
        $hariIni = Carbon::now('Asia/Jakarta')->toDateString();
        $startOfDay = Carbon::now('Asia/Jakarta')->startOfDay();
        $endOfDay = Carbon::now('Asia/Jakarta')->endOfDay();

        // Get today's transactions with details
        $transaksisHariIni = Transaksi::with(['details.data', 'user'])
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderByDesc('created_at')
            ->get();

        // Calculate metrics
        $totalTransaksiHariIni = $transaksisHariIni->count();
        $pendapatanHariIni = $transaksisHariIni->sum('total_harga');
        $produkTerjualHariIni = $transaksisHariIni->sum(function($transaksi) {
            return $transaksi->details->sum('qty');
        });
        
        $rataTransaksiHariIni = $totalTransaksiHariIni > 0 
            ? round($pendapatanHariIni / $totalTransaksiHariIni)
            : 0;

        // Get popular products today
        $produkTerlaris = DB::table('transaksi_details')
            ->join('data', 'transaksi_details.data_id', '=', 'data.id')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->select(
                'data.nama_barang as name',
                'data.codetrx as plu',
                DB::raw('SUM(transaksi_details.qty) as sold'),
                DB::raw('SUM(transaksi_details.qty * data.harga_jual) as revenue')
            )
            ->whereBetween('transaksis.created_at', [$startOfDay, $endOfDay])
            ->groupBy('data.codetrx', 'data.nama_barang')
            ->orderByDesc('sold')
            ->take(4)
            ->get();

        return view('admin.dashboard', [
            'totalTransaksiHariIni' => $totalTransaksiHariIni,
            'pendapatanHariIni' => $pendapatanHariIni,
            'produkTerjualHariIni' => $produkTerjualHariIni,
            'rataTransaksiHariIni' => $rataTransaksiHariIni,
            'kenaikan' => $this->hitungKenaikanDariKemarin(),
            'transaksiTerbaru' => $transaksisHariIni->take(5),
            'produkTerlaris' => $produkTerlaris
        ]);
    }

    return view('user.dashboard');
}
    protected function hitungKenaikanDariKemarin()
    {
        $hariIni = Carbon::now('Asia/Jakarta')->toDateString();
        $kemarin = Carbon::yesterday('Asia/Jakarta')->toDateString();

        // Total pendapatan hari ini dari details
        $pendapatanHariIni = DB::table('transaksi_details')
            ->join('data', 'transaksi_details.data_id', '=', 'data.id')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->whereDate('transaksis.created_at', $hariIni)
            ->sum(DB::raw('transaksi_details.qty * data.harga_jual'));

        // Total pendapatan kemarin dari details
        $pendapatanKemarin = DB::table('transaksi_details')
            ->join('data', 'transaksi_details.data_id', '=', 'data.id')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->whereDate('transaksis.created_at', $kemarin)
            ->sum(DB::raw('transaksi_details.qty * data.harga_jual'));

        // Jumlah transaksi
        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)->count();
        $transaksiKemarin = Transaksi::whereDate('created_at', $kemarin)->count();

        // Hitung persentase kenaikan
        $kenaikanTransaksi = $transaksiKemarin > 0
            ? (($transaksiHariIni - $transaksiKemarin) / $transaksiKemarin) * 100
            : 0;

        $kenaikanPendapatan = $pendapatanKemarin > 0
            ? (($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100
            : 0;

        return [
            'transaksi' => $kenaikanTransaksi,
            'pendapatan' => $kenaikanPendapatan
        ];
    }
}
