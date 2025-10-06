@extends('layouts.admin')

@section('content')


        
    <div class="max-w-9x1 mx-auto px-4 sm:px-2 lg:px-6 py-2">
        <!-- Header -->
        <div class="bg-green-800 rounded-xl shadow-sm border border-green-200 p-6 mb-6">
            <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-2xl font-semibold text-white flex items-center group">
                <svg class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-9 2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2v-3a2 2 0 012-2h3zM10 11a4 4 0 100-8 4 4 0 000 8z" />
                </svg>Permintaan Persetujuan User
            </h2>
            <p class="text-gray-300 text-sm sm:text-base md:text-md">Kelola permintaan persetujuan user yang baru mendaftar</p>
        </div>

        <!-- User Cards -->
        <div class="space-y-4">
            @forelse ($pendingUsers as $user)
                <div class="bg-white rounded-xl shadow-sm border border-green-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- User Info -->
                            <div class="flex-1">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 uppercase tracking-wide">Nama</label>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 uppercase tracking-wide">Email</label>
                                        <p class="mt-1 text-gray-900 font-medium">{{ $user->email }}</p>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 uppercase tracking-wide">Role</label>
                                        <p class="mt-1.5 font-medium bg-blue-200 bg:hover text-blue-700 px-1 py-0.5 rounded-full w-fit">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 lg:ml-6">
                                <form action="{{ route('admin.approval.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.approval.reject', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm border border-green-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-green-900 mb-2">Tidak ada permintaan pending</h3>
                    <p class="text-gray-600">Saat ini tidak ada user yang menunggu persetujuan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection