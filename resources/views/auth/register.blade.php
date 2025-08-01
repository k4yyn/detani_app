<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen py-8 px-4">
    <div class="w-full max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="logo">
                <a href="/" class="flex justify-center">
                    <div class="w-16 h-16 bg-amber-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">L</span>
                    </div>
                </a>
            </div>
            
            <h2 class="text-2xl font-bold text-amber-500 mt-4">Create Account</h2>
            <div class="w-12 h-1 bg-amber-500 mx-auto my-2 rounded-full"></div>
            <p class="text-gray-600 text-sm">Join us today</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input 
                    id="name" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200 bg-gray-50 focus:bg-white" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus
                    placeholder="Full Name"
                />
                @error('name')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input 
                    id="email" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200 bg-gray-50 focus:bg-white" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    placeholder="Email Address"
                />
                @error('email')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                    id="password" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200 bg-gray-50 focus:bg-white"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Password"
                />
                @error('password')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input 
                    id="password_confirmation" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200 bg-gray-50 focus:bg-white"
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Confirm Password"
                />
                @error('password_confirmation')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Pilih Role</label>
                <select name="role" class="form-control block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200 bg-gray-50 focus:bg-white" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    Create Account
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-500 font-medium underline decoration-transparent hover:decoration-amber-500 transition duration-200">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</body>
</html>