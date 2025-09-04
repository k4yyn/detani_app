<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - DETANI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 py-8 px-4">
    <div class="w-full max-w-lg mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header with Logo -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-8 text-center">
                <div class="logo mb-4">
                    <a href="/" class="inline-block">
                        <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition duration-300">
                            <div class="relative">
                                <!-- Sun -->
                                <div class="w-8 h-8 bg-yellow-400 rounded-full absolute -top-2 -right-1"></div>
                                <!-- Mountain -->
                                <div class="w-6 h-4 bg-green-500 rounded-t-full transform -rotate-12"></div>
                                <!-- House -->
                                <div class="w-4 h-3 bg-red-500 rounded-sm mt-1"></div>
                                <!-- Water splash -->
                                <div class="w-2 h-2 bg-cyan-400 rounded-full absolute -bottom-1 right-0"></div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <h1 class="text-3xl font-bold text-white mb-2">De Tani</h1>
                <p class="text-green-100 text-sm font-medium">Waterpark Management</p>
            </div>

            <!-- Form Container -->
            <div class="px-8 py-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Create Account</h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-green-500 to-yellow-400 mx-auto rounded-full mb-3"></div>
                    <p class="text-gray-600 text-sm">Join De Tani Waterpark</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <!-- Name Field -->
                    <div class="group">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Full Name
                            </span>
                        </label>
                        <input 
                            id="name" 
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-green-200 focus:border-green-500 transition-all duration-300 bg-gray-50 focus:bg-white placeholder-gray-400 text-gray-800" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            required 
                            autofocus
                            placeholder="Enter your full name"
                        />
                        @error('name')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                Email Address
                            </span>
                        </label>
                        <input 
                            id="email" 
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-300 bg-gray-50 focus:bg-white placeholder-gray-400 text-gray-800" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required
                            placeholder="Enter your email address"
                        />
                        @error('email')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Password
                            </span>
                        </label>
                        <input 
                            id="password" 
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-orange-200 focus:border-orange-500 transition-all duration-300 bg-gray-50 focus:bg-white placeholder-gray-400 text-gray-800"
                            type="password"
                            name="password"
                            required 
                            autocomplete="new-password"
                            placeholder="Create a secure password"
                        />
                        @error('password')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="group">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Confirm Password
                            </span>
                        </label>
                        <input 
                            id="password_confirmation" 
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-red-200 focus:border-red-500 transition-all duration-300 bg-gray-50 focus:bg-white placeholder-gray-400 text-gray-800"
                            type="password"
                            name="password_confirmation"
                            required
                            placeholder="Confirm your password"
                        />
                        @error('password_confirmation')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div class="group">
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                </svg>
                                Select Role
                            </span>
                        </label>
                        <select 
                            name="role" 
                            id="role"
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-4 focus:ring-cyan-200 focus:border-cyan-500 transition-all duration-300 bg-gray-50 focus:bg-white text-gray-800" 
                            required
                        >
                            <option value="" disabled selected>Choose your role</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>👤 User (Staff)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👨‍💼 Admin (Admin/SPV/Owner)</option>
                        </select>
                        @error('role')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start space-x-3 py-2">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms"
                            required
                            class="mt-1 w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2"
                        >
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-green-600 hover:text-green-700 font-medium underline">Terms and Conditions</a> and <a href="#" class="text-green-600 hover:text-green-700 font-medium underline">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button 
                            type="submit" 
                            id="submit-btn"
                            class="w-full flex justify-center items-center py-4 px-6 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 focus:ring-4 focus:ring-green-300"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create Account
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-8 pt-6 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold ml-1 hover:underline transition duration-200">
                            Sign in here →
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-gray-500 text-xs">
            <p>© 2024 DETANI Waterpark. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Enhanced form interactions
        document.querySelectorAll('input, select').forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            field.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html>