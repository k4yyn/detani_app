@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-md mx-auto">
        <!-- Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">
                Update Stok Barang
            </h2>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <strong class="text-red-800 font-medium">Ada kesalahan:</strong>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.data.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Stock Input -->
                <div class="mb-6">
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Stok
                    </label>
                    <input
                        type="number"
                        name="stok"
                        id="stok"
                        min="1"
                        max="9999"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Masukkan jumlah stok"
                        value="{{ old('stok', $data->stok) }}"
                    >
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Update Stok
                    </button>

                    <a
                        href="{{ route('admin.data.index') }}"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md text-center transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    >
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
