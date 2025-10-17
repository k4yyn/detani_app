<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\{
    Auth\RegisterController,
    Auth\AuthenticatedSessionController,
    ProfileController,
    DataController,
    DashboardController,
    TransaksiKasirController,
    ReportController,
    UserController,
    TicketAdminController,
    TicketKasirController,
    StockKantinController,
};

// ========================
// Default Route (Redirect)
// ========================
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->intended(
        auth()->user()->role === 'admin'
            ? route('admin.dashboard')
            : route('user.transaksi.index')
    );
});

// ======================= =
// Guest (Auth) Routes
// ========================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// ========================
// Authenticated Routes
// ========================
Route::middleware('auth')->group(function () {

    // ---------- Logout ----------
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // ---------- Profile (All Roles) ----------
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // ========================
    // USER Routes (role:user)
    // ========================
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

        // Data Barang untuk User
        Route::prefix('user/data')->name('user.data.')->group(function () {
            Route::get('/', [DataController::class, 'index'])->name('index'); // Halaman kategori
            Route::get('/all', [DataController::class, 'indexAll'])->name('all'); // Semua barang
            Route::get('/kategori/{kategori}', [DataController::class, 'byKategori'])->name('by-kategori'); // Per kategori
        });

        // Transaksi Kasir
        Route::prefix('user/transaksi')->name('user.transaksi.')->group(function () {
            Route::get('/', [TransaksiKasirController::class, 'index'])->name('index');
            Route::post('/keranjang/tambah', [TransaksiKasirController::class, 'tambahKeranjang'])->name('keranjang.tambah');
            Route::get('/keranjang', [TransaksiKasirController::class, 'keranjang'])->name('keranjang');
            Route::post('/keranjang/update/{id}', [TransaksiKasirController::class, 'updateQty'])->name('keranjang.update');
            Route::delete('/keranjang/clear', [TransaksiKasirController::class, 'clear'])
             ->name('keranjang.clear');
            Route::delete('/keranjang/{id}', [TransaksiKasirController::class, 'hapusItem'])->name('keranjang.hapus');
            Route::post('/keranjang/edit/{id}', [TransaksiKasirController::class, 'editHargaDiskon'])->name('keranjang.edit');
            Route::post('/checkout', [TransaksiKasirController::class, 'checkout'])->name('checkout');
            Route::get('/struk/{id}', [TransaksiKasirController::class, 'struk'])->name('struk');
            Route::post('/print-thermal/{id}', [TransaksiKasirController::class, 'printThermal'])
                ->name('print.thermal');
            Route::get('/test-print', [TransaksiKasirController::class, 'testPrint']);
        });

        // Tickets untuk User
        Route::prefix('user')->group(function () {
            Route::get('tickets/create', [TicketKasirController::class, 'createSale'])->name('user.tickets.create');
            Route::post('tickets', [TicketKasirController::class, 'storeSale'])->name('user.tickets.store');
        });

        // Nota
        Route::get('/user/nota/nota-harian', [App\Http\Controllers\NotaHarianController::class, 'index'])
            ->name('user.nota.notaHarian');
        Route::get('/user/nota/nota-harian/cetak', [App\Http\Controllers\NotaHarianController::class, 'cetak'])
            ->name('user.nota.notaHarian.cetak');

        Route::prefix('user/stock-kantin')->name('user.stock-kantin.')->group(function () {
        Route::get('/dashboard', [StockKantinController::class, 'dashboard'])->name('dashboard');
        Route::get('/verifikasi', [StockKantinController::class, 'verifikasiStock'])->name('verifikasi');
        Route::post('/verifikasi', [StockKantinController::class, 'simpanVerifikasi'])->name('simpan-verifikasi');
        Route::get('/transfer', [StockKantinController::class, 'transferStock'])->name('transfer');
        Route::post('/transfer', [StockKantinController::class, 'prosesTransfer'])->name('proses-transfer');
        Route::get('/laporan', [StockKantinController::class, 'laporan'])->name('laporan');
        Route::get('/auto-setup', [StockKantinController::class, 'autoSetup'])->name('auto-setup');
        });
    });

    // ========================
    // ADMIN Routes (role:admin)
    // ========================
    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Tickets Admin
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [TicketAdminController::class, 'index'])->name('index');
            Route::get('/create', [TicketAdminController::class, 'create'])->name('create');
            Route::post('/', [TicketAdminController::class, 'store'])->name('store');
            Route::get('/reports', [TicketAdminController::class, 'reportsIndex'])->name('reports.index');
            Route::get('/{ticket}/edit', [TicketAdminController::class, 'edit'])->name('edit');
            Route::put('/{ticket}', [TicketAdminController::class, 'update'])->name('update');
        });

        // Data Barang
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/', [DataController::class, 'index'])->name('index'); // Default ke halaman kategori
            Route::get('/all', [DataController::class, 'indexAll'])->name('all'); // Halaman daftar semua barang
            Route::get('/kategori/{kategori}', [DataController::class, 'byKategori'])->name('by-kategori'); // Produk per kategori
            Route::get('/create', [DataController::class, 'create'])->name('create');
            Route::post('/', [DataController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataController::class, 'destroy'])->name('destroy');
            Route::delete('/kategori/{kategori}', [DataController::class, 'destroyKategori'])->name('destroy-kategori');
        });

        // User Management - Lengkap
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/{id}/approve', [UserController::class, 'approve'])->name('approve');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
            Route::get('/weekly', [ReportController::class, 'weekly'])->name('weekly');
            Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
            Route::get('/yearly', [ReportController::class, 'yearly'])->name('yearly');
            Route::get('/custom', [ReportController::class, 'custom'])->name('custom');
            Route::post('/filter', [ReportController::class, 'filter'])->name('filter');
            Route::match(['get', 'post'], '/export', [ReportController::class, 'export'])->name('export');
        });

        // Struk admin
        Route::get('/transaksi/{id}/struk', [ReportController::class, 'struk'])->name('transaksi.struk');

        // ❌ ADMIN STOCK OPNAME - COMMENT DULU
        // Route::prefix('stock-opname')->name('stock-opname.')->group(function () {
        //     Route::get('/', [Admin\StockOpnameController::class, 'index'])->name('index');
        //     Route::get('/{id}', [Admin\StockOpnameController::class, 'show'])->name('show');
        // });
    });
});