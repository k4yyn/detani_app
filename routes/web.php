<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\RegisterController,
    Auth\AuthenticatedSessionController,
    ProfileController,
    DataController,
    DashboardController,
    TransaksiKasirController,
    ReportController,
    UserController,
};

// Redirect user ke dashboard sesuai role saat akses root '/'
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

// ========================
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

    // Logout 
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile Routes (semua user)
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

        // Data Barang untuk USER
         Route::get('/data', [DataController::class, 'index'])->name('data.index');
    });

     // Route untuk transaksi kasir
        Route::prefix('user/transaksi')->name('user.transaksi.')->group(function () {
            Route::get('/', [TransaksiKasirController::class, 'index'])->name('index');
            Route::post('/keranjang/tambah', [TransaksiKasirController::class, 'tambahKeranjang'])->name('keranjang.tambah');
            Route::get('/keranjang', [TransaksiKasirController::class, 'keranjang'])->name('keranjang');
            Route::post('/keranjang/update/{id}', [TransaksiKasirController::class, 'updateQty'])->name('keranjang.update');
            Route::delete('/keranjang/{id}', [TransaksiKasirController::class, 'hapusItem'])->name('keranjang.hapus');
            Route::post('/keranjang/edit/{id}', [TransaksiKasirController::class, 'editHargaDiskon'])->name('keranjang.edit');
            Route::post('/checkout', [TransaksiKasirController::class, 'checkout'])->name('checkout');
            Route::get('/struk/{id}', [TransaksiKasirController::class, 'struk'])->name('struk');
        });

    // ========================
    // ADMIN Routes (role:admin)
    // ========================
    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Data Barang untuk admin
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/', [DataController::class, 'index'])->name('index');
            Route::get('/create', [DataController::class, 'create'])->name('create');
            Route::post('/', [DataController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataController::class, 'destroy'])->name('destroy');
        });

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

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
    });
});
