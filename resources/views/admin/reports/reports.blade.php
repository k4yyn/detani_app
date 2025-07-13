@extends('layouts.admin')

@section('title', 'Laporan Transaksi')
@section('header', 'Laporan Transaksi')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <!-- Laporan Harian -->
    <a href="{{ route('admin.reports.daily') }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-amber-500 p-5 flex items-center justify-between group">
        <div>
            <h3 class="text-lg font-semibold text-stone-800 group-hover:text-amber-600 transition-colors">Laporan Harian</h3>
            <p class="text-sm text-stone-500">Transaksi hari ini</p>
        </div>
        <div class="bg-amber-100 text-amber-600 p-3 rounded-lg shadow-inner group-hover:bg-amber-200 transition-colors">
            <i class="fas fa-calendar-day text-xl"></i>
        </div>
    </a>

    <!-- Laporan Mingguan -->
    <a href="{{ route('admin.reports.weekly') }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-green-500 p-5 flex items-center justify-between group">
        <div>
            <h3 class="text-lg font-semibold text-stone-800 group-hover:text-green-600 transition-colors">Laporan Mingguan</h3>
            <p class="text-sm text-stone-500">Transaksi 7 hari terakhir</p>
        </div>
        <div class="bg-green-100 text-green-600 p-3 rounded-lg shadow-inner group-hover:bg-green-200 transition-colors">
            <i class="fas fa-calendar-week text-xl"></i>
        </div>
    </a>

    <!-- Laporan Bulanan -->
    <a href="{{ route('admin.reports.monthly') }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-blue-500 p-5 flex items-center justify-between group">
        <div>
            <h3 class="text-lg font-semibold text-stone-800 group-hover:text-blue-600 transition-colors">Laporan Bulanan</h3>
            <p class="text-sm text-stone-500">Transaksi bulan ini</p>
        </div>
        <div class="bg-blue-100 text-blue-600 p-3 rounded-lg shadow-inner group-hover:bg-blue-200 transition-colors">
            <i class="fas fa-calendar-alt text-xl"></i>
        </div>
    </a>

    <!-- Laporan Tahunan -->
    <a href="{{ route('admin.reports.yearly') }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border-l-4 border-purple-500 p-5 flex items-center justify-between group">
        <div>
            <h3 class="text-lg font-semibold text-stone-800 group-hover:text-purple-600 transition-colors">Laporan Tahunan</h3>
            <p class="text-sm text-stone-500">Transaksi tahun ini</p>
        </div>
        <div class="bg-purple-100 text-purple-600 p-3 rounded-lg shadow-inner group-hover:bg-purple-200 transition-colors">
            <i class="fas fa-calendar text-xl"></i>
        </div>
    </a>
</div>

<div class="mt-8 bg-white rounded-xl shadow-sm p-5">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-stone-800">Filter Laporan Kustom</h3>
    </div>
    
    <form action="{{ route('admin.reports.custom') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-stone-600 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:ring-amber-500 focus:border-amber-500">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-lg transition-colors duration-300">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
        </div>
    </form>
</div>
@endsection