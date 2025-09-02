<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Laporan Transaksi</h1>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Laporan Harian -->
            <a href="#" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-green-600 p-5 flex items-center justify-between group">
                <div>
                    <h3 class="text-lg font-semibold text-stone-800 group-hover:text-green-700 transition-colors">Laporan Harian</h3>
                    <p class="text-sm text-stone-500">Transaksi hari ini</p>
                </div>
                <div class="bg-green-100 text-green-700 p-3 rounded-lg shadow-inner group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
            </a>

            <!-- Laporan Mingguan -->
            <a href="#" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-red-500 p-5 flex items-center justify-between group">
                <div>
                    <h3 class="text-lg font-semibold text-stone-800 group-hover:text-red-600 transition-colors">Laporan Mingguan</h3>
                    <p class="text-sm text-stone-500">Transaksi 7 hari terakhir</p>
                </div>
                <div class="bg-red-100 text-red-600 p-3 rounded-lg shadow-inner group-hover:bg-red-200 transition-colors">
                    <i class="fas fa-calendar-week text-xl"></i>
                </div>
            </a>

            <!-- Laporan Bulanan -->
            <a href="#" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-green-600 p-5 flex items-center justify-between group">
                <div>
                    <h3 class="text-lg font-semibold text-stone-800 group-hover:text-green-700 transition-colors">Laporan Bulanan</h3>
                    <p class="text-sm text-stone-500">Transaksi bulan ini</p>
                </div>
                <div class="bg-green-100 text-green-700 p-3 rounded-lg shadow-inner group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </a>

            <!-- Laporan Tahunan -->
            <a href="#" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-red-600 p-5 flex items-center justify-between group">
                <div>
                    <h3 class="text-lg font-semibold text-stone-800 group-hover:text-red-700 transition-colors">Laporan Tahunan</h3>
                    <p class="text-sm text-stone-500">Transaksi tahun ini</p>
                </div>
                <div class="bg-red-100 text-red-700 p-3 rounded-lg shadow-inner group-hover:bg-red-200 transition-colors">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
            </a>
        </div>

        <div class="mt-8 bg-white rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-stone-800">Filter Laporan Kustom</h3>
            </div>
            
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-green-600 focus:border-green-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-600 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-green-600 focus:border-green-600">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors duration-300">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
