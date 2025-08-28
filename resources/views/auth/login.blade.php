<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Decorative leaf background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-20 h-20 opacity-10">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-green-300 transform rotate-45">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>
        </div>
        <div class="absolute top-32 right-16 w-16 h-16 opacity-10">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-green-400 transform -rotate-12">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>
        </div>
        <div class="absolute bottom-20 left-20 w-24 h-24 opacity-10">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-emerald-300 transform rotate-90">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>
        </div>
        <div class="absolute bottom-32 right-8 w-18 h-18 opacity-10">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-green-500 transform -rotate-45">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>
        </div>
    </div>

    <!-- Header -->
    <div class="mb-8 text-center relative z-10">
        <div class="flex items-center justify-center mb-4">
            <svg class="w-12 h-12 text-green-400 mr-3" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
            </svg>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-300 via-emerald-300 to-green-400 bg-clip-text text-transparent mb-3">Sign In</h1>
        </div>
        <p class="text-green-200">Welcome back! Please sign in to your account</p>
    </div>
    
    <form method="POST" action="{{ route('login') }}" class="space-y-5 relative z-10">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="text-green-200 text-sm font-medium mb-2 block flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                </svg>
                Email Address
            </label>
            <div class="relative">
                <input
                    id="email"
                    class="w-full px-4 py-3 pl-12 bg-green-900/20 border border-green-600/30 rounded-xl text-green-100 placeholder:text-green-400/60 focus:ring-2 focus:ring-green-500 focus:border-green-400 transition-all duration-200 backdrop-blur-sm"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your email address"
                />
                <div class="absolute top-3.5 left-4">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-300 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="text-green-200 text-sm font-medium mb-2 block flex items-center">
                <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
                Password
            </label>
            <div class="relative">
                <input
                    id="password"
                    class="w-full px-4 py-3 pl-12 pr-12 bg-green-900/20 border border-green-600/30 rounded-xl text-green-100 placeholder:text-green-400/60 focus:ring-2 focus:ring-green-500 focus:border-green-400 transition-all duration-200 backdrop-blur-sm"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />
                <div class="absolute top-3.5 left-4">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <button
                    type="button"
                    onclick="togglePasswordVisibility()"
                    class="absolute top-3.5 right-4 text-green-400 hover:text-green-300 transition-colors duration-200"
                >
                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-300 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    name="remember" 
                    type="checkbox" 
                    class="h-4 w-4 text-green-600 bg-green-800/50 border-green-600 rounded focus:ring-green-500 focus:ring-2"
                >
                <label for="remember_me" class="ml-2 text-sm text-green-200">Remember me</label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-green-400 hover:text-green-300 transition-colors duration-200 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button 
            type="submit" 
            class="w-full py-3 px-4 bg-gradient-to-r from-green-600 via-emerald-600 to-green-600 hover:from-green-500 hover:via-emerald-500 hover:to-green-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:shadow-green-500/25 transform hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-transparent relative overflow-hidden group"
        >
            <span class="relative z-10 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                </svg>
                Sign In
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-green-700/50 via-emerald-700/50 to-green-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </button>

       <!-- Register Link -->
        <div class="text-center text-sm text-green-300 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 hover:underline transition-all duration-200 font-medium">
                Daftar di sini
            </a>
        </div>
    </form>

    <!-- Additional decorative elements -->
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-600 via-emerald-500 to-green-600 opacity-30"></div>

    <!-- Password Toggle Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414l-1.414-1.414M9.878 9.878l4.242 4.242m0 0L15.535 15.535m-1.415-1.414l1.414 1.414"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</x-guest-layout>