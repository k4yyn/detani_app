<x-guest-layout>
    <div class="w-full bg-white rounded-lg p-6">
        <div class="text-center mb-6">
            <x-slot name="logo">
                <a href="/" class="flex justify-center">
                    <x-application-logo class="w-16 h-16 fill-current text-amber-500" />
                </a>
            </x-slot>
            
            <h2 class="text-2xl font-bold text-amber-500 mt-4">Create Account</h2>
            <div class="w-12 h-1 bg-amber-500 mx-auto my-2 rounded-full"></div>
            <p class="text-gray-600 text-sm">Join us today</p>
        </div>

       

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <x-text-input 
                    id="name" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus
                    placeholder="Full Name"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required
                    placeholder="Email Address"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200"
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Confirm Password"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600" />
            </div>

           
            <!-- Add spacing between password confirmation and button -->
            <div class="pt-4">
                <x-primary-button class="w-full flex justify-center py-3 px-4 rounded-full bg-amber-500 hover:bg-amber-600 text-white font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                    {{ __('Create Account') }}
                </x-primary-button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-500 font-medium">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>