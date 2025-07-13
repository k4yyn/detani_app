<!-- resources/views/layouts/user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Amaliah - {{ $title ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8f5f2;
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        }

        .transition-colors {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .hover\:shadow-md:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .border-l-4 {
            border-left-width: 4px;
        }

        .text-stone-800 {
            color: #292524;
        }

        .text-stone-700 {
            color: #44403c;
        }

        .text-stone-600 {
            color: #57534e;
        }

        .text-stone-500 {
            color: #78716c;
        }

        .text-stone-400 {
            color: #a8a29e;
        }

        .bg-stone-100 {
            background-color: #f5f5f4;
        }

        .bg-stone-200 {
            background-color: #e7e5e4;
        }

        .bg-amber-50 {
            background-color: #fffbeb;
        }

        .bg-amber-100 {
            background-color: #fef3c7;
        }

        .bg-amber-200 {
            background-color: #fde68a;
        }

        .bg-amber-600 {
            background-color: #d97706;
        }

        .bg-amber-700 {
            background-color: #b45309;
        }

        .border-stone-100 {
            border-color: #f5f5f4;
        }

        .border-amber-200 {
            border-color: #fde68a;
        }

        .divide-stone-100 {
            border-color: #f5f5f4;
        }

        .text-amber-600 {
            color: #d97706;
        }

        .text-amber-700 {
            color: #b45309;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-stone-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-amber-700 text-white shadow-md">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-store text-2xl"></i>
                    <h1 class="text-xl font-bold">Kasir Amaliah</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="date-display flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-50 to-amber-100 text-stone-700 shadow-md border border-amber-200">
                        <i class="far fa-calendar-alt text-amber-600"></i>
                        <span class="font-medium tracking-wide">{{ now()->format('d M Y') }}</span>
                    </div>
                    <span class="text-sm"><i class="far fa-user mr-1"></i> {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm hover:text-amber-200 transition">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>