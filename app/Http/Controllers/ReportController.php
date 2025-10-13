<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index(Request $request)
{
    $filter = $request->input('filter', 'harian');
    $jenisTransaksi = $request->input('jenis_transaksi', 'semua');
    $metodePembayaran = $request->input('metode_pembayaran', 'semua');
                
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $dateFrom = Carbon::parse($request->start_date)->startOfDay();
        $dateTo = Carbon::parse($request->end_date)->endOfDay();
    } else {
        // Gunakan preset berdasarkan filter
        switch ($filter) {
            case 'mingguan':
                $dateFrom = Carbon::now('Asia/Jakarta')->startOfWeek();
                $dateTo = Carbon::now('Asia/Jakarta')->endOfWeek();
                break;
            case 'bulanan':
                $dateFrom = Carbon::now('Asia/Jakarta')->startOfMonth();
                $dateTo = Carbon::now('Asia/Jakarta')->endOfMonth();
                break;
            case 'tahunan':
                $dateFrom = Carbon::now('Asia/Jakarta')->startOfYear();
                $dateTo = Carbon::now('Asia/Jakarta')->endOfYear();
                break;
            default:
                $dateFrom = Carbon::now('Asia/Jakarta')->startOfDay();
                $dateTo = Carbon::now('Asia/Jakarta')->endOfDay();
        }
    }

    // QUERY UNTUK PAGINATION (hanya untuk table)
    $query = Transaksi::with(['details.data', 'user'])
        ->whereBetween('created_at', [$dateFrom, $dateTo]);

    // Filter berdasarkan jenis transaksi
    if ($jenisTransaksi !== 'semua') {
        $query->where('jenis_transaksi', $jenisTransaksi);
    }

    // Filter berdasarkan metode pembayaran
    if ($metodePembayaran !== 'semua') {
        $query->where('metode_pembayaran', $metodePembayaran);
    }

    $transaksis = $query->orderBy('created_at', 'desc')
        ->paginate(10);

    // ✅ QUERY TERPISAH UNTUK SUMMARY CARDS (total keseluruhan)
    $summaryQuery = Transaksi::whereBetween('created_at', [$dateFrom, $dateTo]);
    
    if ($jenisTransaksi !== 'semua') {
        $summaryQuery->where('jenis_transaksi', $jenisTransaksi);
    }

    if ($metodePembayaran !== 'semua') {
        $summaryQuery->where('metode_pembayaran', $metodePembayaran);
    }

    // Hitung total yang sebenarnya (semua data, bukan hanya di halaman saat ini)
    $totalTransaksi = $summaryQuery->count();
    $totalPendapatan = $summaryQuery->sum('total_harga');
    $rataTransaksi = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

    // Hitung produk terjual dengan query terpisah juga
    $produkTerjualQuery = DB::table('transaksi_details')
        ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
        ->whereBetween('transaksis.created_at', [$dateFrom, $dateTo]);

    if ($jenisTransaksi !== 'semua') {
        $produkTerjualQuery->where('transaksis.jenis_transaksi', $jenisTransaksi);
    }

    if ($metodePembayaran !== 'semua') {
        $produkTerjualQuery->where('transaksis.metode_pembayaran', $metodePembayaran);
    }

    $produkTerjual = $produkTerjualQuery->sum('transaksi_details.qty');

    // Query produk terlaris
    $produkTerlarisQuery = DB::table('transaksi_details')
        ->join('data', 'transaksi_details.data_id', '=', 'data.id')
        ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
        ->select(
            'data.nama_barang as name',
            'data.codetrx as plu',
            DB::raw('SUM(transaksi_details.qty) as sold'),
            DB::raw('SUM(transaksi_details.qty * data.harga_jual) as revenue')
        )
        ->whereBetween('transaksis.created_at', [$dateFrom, $dateTo]);

    if ($jenisTransaksi !== 'semua') {
        $produkTerlarisQuery->where('transaksis.jenis_transaksi', $jenisTransaksi);
    }

    if ($metodePembayaran !== 'semua') {
        $produkTerlarisQuery->where('transaksis.metode_pembayaran', $metodePembayaran);
    }

    $produkTerlaris = $produkTerlarisQuery->groupBy('data.codetrx', 'data.nama_barang')
        ->orderByDesc('sold')
        ->take(4)
        ->get();

    return view('admin.reports.index', [
        'transaksis' => $transaksis,
        'filter' => $filter,
        'jenisTransaksi' => $jenisTransaksi,
        'metodePembayaran' => $metodePembayaran,
        'total' => $totalPendapatan,
        'totalTransaksiHariIni' => $totalTransaksi,
        'pendapatanHariIni' => $totalPendapatan,
        'produkTerjualHariIni' => $produkTerjual, // ✅ PERBAIKAN: nama variable yang benar
        'rataTransaksiHariIni' => $rataTransaksi,
        'avgTransaksi' => $rataTransaksi,
        'kenaikan' => $this->hitungKenaikanDariKemarin($dateFrom, $dateTo, $jenisTransaksi, $metodePembayaran),
        'transaksiTerbaru' => $transaksis->take(5),
        'produkTerlaris' => $produkTerlaris,
    ]);
}

protected function hitungKenaikanDariKemarin($currentStart, $currentEnd, $jenisTransaksi = 'semua', $metodePembayaran = 'semua')
{
    $previousStart = Carbon::parse($currentStart)->subDay()->startOfDay();
    $previousEnd = Carbon::parse($currentEnd)->subDay()->endOfDay();

    // Query untuk periode sekarang
    $currentQuery = Transaksi::whereBetween('created_at', [$currentStart, $currentEnd]);
    $previousQuery = Transaksi::whereBetween('created_at', [$previousStart, $previousEnd]);

    // Filter berdasarkan jenis transaksi jika dipilih
    if ($jenisTransaksi !== 'semua') {
        $currentQuery->where('jenis_transaksi', $jenisTransaksi);
        $previousQuery->where('jenis_transaksi', $jenisTransaksi);
    }

    // Filter berdasarkan metode pembayaran jika dipilih
    if ($metodePembayaran !== 'semua') {
        $currentQuery->where('metode_pembayaran', $metodePembayaran);
        $previousQuery->where('metode_pembayaran', $metodePembayaran);
    }

    $currentPendapatan = $currentQuery->sum('total_harga');
    $currentTransaksi = $currentQuery->count();

    $previousPendapatan = $previousQuery->sum('total_harga');
    $previousTransaksi = $previousQuery->count();

    $kenaikanTransaksi = $previousTransaksi > 0
        ? (($currentTransaksi - $previousTransaksi) / $previousTransaksi) * 100
        : ($currentTransaksi > 0 ? 100 : 0);

    $kenaikanPendapatan = $previousPendapatan > 0
        ? (($currentPendapatan - $previousPendapatan) / $previousPendapatan) * 100
        : ($currentPendapatan > 0 ? 100 : 0);

    return [
        'transaksi' => round($kenaikanTransaksi, 2),
        'pendapatan' => round($kenaikanPendapatan, 2)
    ];
}

public function daily()
{
    $dateFrom = Carbon::today()->startOfDay();
    $dateTo = Carbon::today()->endOfDay();

    $transaksis = Transaksi::with(['details.data', 'user'])
        ->whereBetween('created_at', [$dateFrom, $dateTo])
        ->orderBy('jenis_transaksi')
        ->orderBy('created_at', 'desc')
        ->get();

         $groupedTransaksis = [
        'owner' => $transaksis->where('jenis_transaksi', 'owner'),
        'karyawan' => $transaksis->where('jenis_transaksi', 'karyawan'), 
        'lainnya' => $transaksis->where('jenis_transaksi', 'lainnya'),
        'pelanggan' => $transaksis->where('jenis_transaksi', 'pelanggan')
    ];

    $totalTransaksi = $transaksis->count();
    $totalPendapatan = $transaksis->sum('total_harga');
    $rataTransaksi = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

    // ✅ GUNAKAN VARIABLE $total UNTUK KOMPATIBILITAS
    $total = $totalPendapatan;

    return view('admin.reports.daily', compact(
        'transaksis', 
        'total', // ✅ untuk view yang butuh $total
        'totalTransaksi',
        'rataTransaksi',
        'groupedTransaksis'
    ));
}

public function weekly()
{
    $dateFrom = Carbon::now()->startOfWeek();
    $dateTo = Carbon::now()->endOfWeek();

    $transaksis = Transaksi::with(['details.data', 'user'])
        ->whereBetween('created_at', [$dateFrom, $dateTo])
        ->orderBy('jenis_transaksi')
        ->orderBy('created_at', 'desc')
        ->get();

         $groupedTransaksis = [
        'owner' => $transaksis->where('jenis_transaksi', 'owner'),
        'karyawan' => $transaksis->where('jenis_transaksi', 'karyawan'), 
        'lainnya' => $transaksis->where('jenis_transaksi', 'lainnya'),
        'pelanggan' => $transaksis->where('jenis_transaksi', 'pelanggan')
         ];

    $totalTransaksi = $transaksis->count();
    $totalPendapatan = $transaksis->sum('total_harga');
    $rataTransaksi = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

    // ✅ GUNAKAN VARIABLE $total UNTUK KOMPATIBILITAS
    $total = $totalPendapatan;

    return view('admin.reports.weekly', compact(
        'transaksis', 
        'total', // ✅ untuk view yang butuh $total
        'totalTransaksi',
        'rataTransaksi',
        'groupedTransaksis'
    ));
}

public function monthly(Request $request)
{
    $selectedMonth = $request->input('month', now()->format('Y-m'));

    $dateFrom = Carbon::parse($selectedMonth)->startOfMonth();
    $dateTo = Carbon::parse($selectedMonth)->endOfMonth();

    $transaksis = Transaksi::with(['details.data', 'user'])
        ->whereBetween('created_at', [$dateFrom, $dateTo])
        ->orderBy('jenis_transaksi')
        ->orderBy('created_at', 'desc')
        ->get();

          $groupedTransaksis = [
        'owner' => $transaksis->where('jenis_transaksi', 'owner'),
        'karyawan' => $transaksis->where('jenis_transaksi', 'karyawan'), 
        'lainnya' => $transaksis->where('jenis_transaksi', 'lainnya'),
        'pelanggan' => $transaksis->where('jenis_transaksi', 'pelanggan')
         ];

    $totalTransaksi = $transaksis->count();
    $totalPendapatan = $transaksis->sum('total_harga');
    $rataTransaksi = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

    // ✅ GUNAKAN VARIABLE $total UNTUK KOMPATIBILITAS
    $total = $totalPendapatan;

    return view('admin.reports.monthly', compact(
        'transaksis', 
        'total', // ✅ untuk view yang butuh $total
        'totalTransaksi',
        'rataTransaksi', 
        'selectedMonth',
        'groupedTransaksis'
    ));
}

public function yearly(Request $request)
{
    $tahun = $request->input('tahun', date('Y'));

    $dateFrom = Carbon::createFromDate($tahun)->startOfYear();
    $dateTo = Carbon::createFromDate($tahun)->endOfYear();

    $transaksis = Transaksi::with(['details.data', 'user'])
        ->whereBetween('created_at', [$dateFrom, $dateTo])
        ->orderBy('jenis_transaksi')
        ->orderBy('created_at', 'desc')
        ->get();

          $groupedTransaksis = [
        'owner' => $transaksis->where('jenis_transaksi', 'owner'),
        'karyawan' => $transaksis->where('jenis_transaksi', 'karyawan'), 
        'lainnya' => $transaksis->where('jenis_transaksi', 'lainnya'),
        'pelanggan' => $transaksis->where('jenis_transaksi', 'pelanggan')
         ];

    $totalTransaksi = $transaksis->count();
    $totalPendapatan = $transaksis->sum('total_harga');
    $rataTransaksi = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

    // ✅ GUNAKAN VARIABLE $total UNTUK KOMPATIBILITAS
    $total = $totalPendapatan;

    $monthlyTotals = Transaksi::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(total_harga) as total')
    )
    ->whereYear('created_at', $tahun)
    ->groupBy(DB::raw('MONTH(created_at)'))
    ->pluck('total', 'month')
    ->toArray();

    $monthlyChart = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlyChart[] = $monthlyTotals[$i] ?? 0;
    }

    return view('admin.reports.yearly', compact(
        'transaksis', 
        'total', // ✅ untuk view yang butuh $total
        'totalTransaksi',
        'rataTransaksi', 
        'tahun', 
        'monthlyChart',
        'groupedTransaksis'
    ));
}

public function custom(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $dateFrom = Carbon::parse($request->start_date)->startOfDay();
    $dateTo = Carbon::parse($request->end_date)->endOfDay();

    $transaksis = Transaksi::with(['details.data', 'user'])
        ->whereBetween('created_at', [$dateFrom, $dateTo])
        ->orderBy('jenis_transaksi')
        ->orderBy('created_at', 'desc')
        ->get();

        $groupedTransaksis = [
        'owner' => $transaksis->where('jenis_transaksi', 'owner'),
        'karyawan' => $transaksis->where('jenis_transaksi', 'karyawan'), 
        'lainnya' => $transaksis->where('jenis_transaksi', 'lainnya'),
        'pelanggan' => $transaksis->where('jenis_transaksi', 'pelanggan')
         ];

    $totalTransaksi = $transaksis->count();
    $totalPendapatan = $transaksis->sum('total_harga');
    $rataTransaksi = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

    // ✅ GUNAKAN VARIABLE $total UNTUK KOMPATIBILITAS
    $total = $totalPendapatan;

    return view('admin.reports.custom', compact(
        'transaksis', 
        'total', // ✅ untuk view yang butuh $total
        'totalTransaksi',
        'rataTransaksi', 
        'dateFrom', 
        'dateTo',
        'groupedTransaksis'
    ));
}

    public function struk($id)
    {
        $transaksi = Transaksi::with(['user', 'details.data'])->findOrFail($id);
        return view('admin.transaksi.struk', compact('transaksi'));
    }
}