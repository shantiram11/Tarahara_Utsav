@extends('layouts.auth')

@section('content')
<style>
@keyframes glow {
    0% {
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), inset 0 0 0 1px rgba(239, 68, 68, 0.2);
    }
    100% {
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.5), 0 0 60px rgba(239, 68, 68, 0.3), inset 0 0 0 1px rgba(239, 68, 68, 0.4);
    }
}

/* Hide default browser password reveal button */
input[type="password"]::-ms-reveal,
input[type="password"]::-ms-clear {
    display: none;
}

input[type="password"]::-webkit-credentials-auto-fill-button {
    display: none !important;
}
</style>
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50 flex items-center justify-center p-3 sm:p-4 relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Decorative circles -->
        <div class="absolute top-10 left-5 w-24 h-24 bg-red-200/20 rounded-full blur-xl"></div>
        <div class="absolute top-20 right-10 w-16 h-16 bg-yellow-200/30 rounded-full blur-lg"></div>
        <div class="absolute bottom-20 left-1/4 w-32 h-32 bg-orange-200/15 rounded-full blur-2xl"></div>
        <div class="absolute bottom-10 right-5 w-20 h-20 bg-red-300/20 rounded-full blur-xl"></div>

        <!-- Geometric shapes -->
        <div class="absolute top-24 left-1/3 w-12 h-12 bg-gradient-to-br from-red-400 to-red-500 rotate-45 opacity-8 rounded-lg"></div>
        <div class="absolute bottom-32 right-1/3 w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-400 rotate-12 opacity-12 rounded-full"></div>

        <!-- Festival pattern -->
        <div class="absolute top-1/4 right-1/4 w-6 h-6 bg-red-400/15 rounded-full"></div>
        <div class="absolute top-1/3 right-1/5 w-3 h-3 bg-yellow-400/25 rounded-full"></div>
        <div class="absolute bottom-1/3 left-1/5 w-4 h-4 bg-orange-400/20 rounded-full"></div>
    </div>

    <!-- Home button positioned on the left side -->
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8 z-20">
        <a href="{{ route('home') }}" class="group flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-110">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 group-hover:text-red-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Logo positioned on the right side -->
    <div class="absolute top-4 right-4 sm:top-8 sm:right-8 z-20">
        <div class="py-0">
            <img src="{{ asset('assets/Logo.png') }}" alt="Tarahara Utsav" class="h-10 sm:h-12 lg:h-16 w-auto">
        </div>
    </div>

    <!-- Signup Container -->
    <div class="relative z-10 w-full max-w-sm sm:max-w-lg mx-auto px-4 sm:px-0">
        <!-- Form Header -->
        <div class="text-center mb-4 sm:mb-6 mt-16 sm:mt-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Join the Festival!</h1>
            <p class="text-sm sm:text-base text-gray-600">Create your Tarahara Utsav account</p>
        </div>

        <!-- Signup Form Card -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-2xl shadow-red-500/10 p-4 sm:p-6 lg:p-8 border border-red-200/50 shadow-lg" style="animation: glow 2s ease-in-out infinite alternate; box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), inset 0 0 0 1px rgba(239, 68, 68, 0.2);">
            <form id="signup-form" method="POST" action="{{ route('register') }}" class="space-y-3 sm:space-y-4">
                @csrf
                <!-- Fortify expects a 'name' field; compose it from first/last name -->
                <input type="hidden" name="name" id="full_name" value="{{ old('name') }}">
                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                    <div class="space-y-1">
                        <label for="first_name" class="block text-xs font-semibold text-gray-700">First Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="first_name" name="first_name" type="text" required
                                   value="{{ old('first_name') }}"
                                   class="w-full pl-8 sm:pl-10 pr-2 sm:pr-3 py-2 sm:py-2.5 bg-gray-50/80 border {{ $errors->has('first_name') ? 'border-red-500' : 'border-gray-200' }} rounded-lg sm:rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm"
                                   placeholder="First name">
                        </div>
                        @error('first_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="last_name" class="block text-xs font-semibold text-gray-700">Last Name</label>
                        <input id="last_name" name="last_name" type="text" required
                               value="{{ old('last_name') }}"
                               class="w-full pl-2 sm:pl-3 pr-2 sm:pr-3 py-2 sm:py-2.5 bg-gray-50/80 border {{ $errors->has('last_name') ? 'border-red-500' : 'border-gray-200' }} rounded-lg sm:rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm"
                               placeholder="Last name">
                        @error('last_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email Input -->
                <div class="space-y-1">
                    <label for="email" class="block text-xs font-semibold text-gray-700">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                            <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required
                               value="{{ old('email') }}"
                               class="w-full pl-8 sm:pl-10 pr-2 sm:pr-3 py-2 sm:py-2.5 bg-gray-50/80 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-lg sm:rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm"
                               placeholder="Enter your email">
                    </div>
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Input -->
                <div class="space-y-1">
                    <label for="phone" class="block text-xs font-semibold text-gray-700">Phone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                            <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input id="phone" name="phone" type="tel"
                               value="{{ old('phone') }}"
                               class="w-full pl-8 sm:pl-10 pr-2 sm:pr-3 py-2 sm:py-2.5 bg-gray-50/80 border {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-200' }} rounded-lg sm:rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm"
                               placeholder="Enter your phone number">
                    </div>
                    @error('phone')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 gap-2 sm:gap-3">
                    <div class="space-y-1">
                        <label for="password" class="block text-xs font-semibold text-gray-700">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                                                    <input id="password" name="password" type="password" required
                               class="w-full pl-8 sm:pl-10 pr-8 sm:pr-10 py-2 sm:py-2.5 bg-gray-50/80 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-lg sm:rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm"
                               placeholder="Create a password">
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-2 sm:pr-3 flex items-center touch-manipulation">
                            <svg id="eye-password" class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eye-off-password" class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400 hover:text-gray-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L16.5 16.5"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-xs font-semibold text-gray-700">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                                <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                   class="w-full pl-8 sm:pl-10 pr-8 sm:pr-10 py-2 sm:py-2.5 bg-gray-50/80 border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-200' }} rounded-lg sm:rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm"
                                   placeholder="Confirm your password">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-2 sm:pr-3 flex items-center touch-manipulation">
                                <svg id="eye-password_confirmation" class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-off-password_confirmation" class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400 hover:text-gray-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L16.5 16.5"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Terms and Newsletter -->
                <div class="space-y-2">
                    <div class="flex items-start">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-0.5 touch-manipulation">
                        <label for="terms" class="ml-2 block text-xs text-gray-700 leading-relaxed">
                            I agree to the
                            <a href="#" class="text-red-600 hover:text-red-500 font-medium">Terms & Conditions</a>
                            and
                            <a href="#" class="text-red-600 hover:text-red-500 font-medium">Privacy Policy</a>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input id="newsletter" name="newsletter" type="checkbox"
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-0.5 touch-manipulation">
                        <label for="newsletter" class="ml-2 block text-xs text-gray-700 leading-relaxed">
                            Send me festival updates and event notifications
                        </label>
                    </div>
                </div>

                <!-- Sign Up Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold py-2.5 sm:py-3 px-6 rounded-xl sm:rounded-2xl shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/35 transition-all duration-300 hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600 transform text-sm touch-manipulation">
                    Create Account
                </button>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 sm:px-3 bg-white text-gray-500">Or sign up with</span>
                    </div>
                </div>

                <!-- Social Signup Buttons -->
                <div class="grid grid-cols-3 gap-1.5 sm:gap-2">
                    <button type="button"
                            class="flex justify-center items-center py-2 sm:py-2.5 px-2 sm:px-3 bg-white border border-gray-200 rounded-lg sm:rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group touch-manipulation">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                            <path fill="#4285f4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34a853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#fbbc05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#ea4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                    </button>

                    <button type="button"
                            class="flex justify-center items-center py-2 sm:py-2.5 px-2 sm:px-3 bg-white border border-gray-200 rounded-lg sm:rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group touch-manipulation">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="#000">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.719-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.89 2.749.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.763-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-12C24.007 5.367 18.641.001.017 0z"/>
                        </svg>
                    </button>

                    <button type="button"
                            class="flex justify-center items-center py-2 sm:py-2.5 px-2 sm:px-3 bg-white border border-gray-200 rounded-lg sm:rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group touch-manipulation">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="#1877f2">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                </div>

                <!-- Sign In Link -->
                <div class="text-center">
                    <p class="text-xs text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-500 font-semibold transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Festival Note -->
        <div class="text-center mt-3 sm:mt-4">
            <p class="text-xs text-gray-500 leading-relaxed">
                Join us for Tarahara Utsav 2024<br class="sm:hidden"> • December 15-17 • Central City Park
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('signup-form');
  if (!form) return;
  form.addEventListener('submit', function () {
    const first = (document.getElementById('first_name')?.value || '').trim();
    const last = (document.getElementById('last_name')?.value || '').trim();
    const full = [first, last].filter(Boolean).join(' ').trim();
    const hidden = document.getElementById('full_name');
    if (hidden) hidden.value = full || first || last;
  });
});
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.getElementById('eye-' + fieldId);
    const eyeOffIcon = document.getElementById('eye-off-' + fieldId);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
    }
}
</script>
@endsection