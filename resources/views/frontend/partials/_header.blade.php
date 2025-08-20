<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-white/20 shadow-lg">
  <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
      <div class="flex justify-between items-center h-20">
          <!-- Logo with Animation -->
          <div class="flex-shrink-0">
              <a href="{{ route('home') }}" class="flex items-center group">
                  <div class="relative overflow-hidden rounded-xl">
                      <img src="{{ asset('assets/Logo.png') }}" alt="Tarahara Utsav" class="h-14 w-auto transition-all duration-500 group-hover:scale-110 group-hover:rotate-2">

                  </div>
                  <span
            class="ml-1 rounded-full bg-amber-300/20 px-2 py-0.5 text-[10px] font-semibold text-amber-300 ring-1 ring-amber-300/40"
            >2025</span
          >
              </a>
          </div>

          <!-- Desktop Navigation Links -->
          <div class="hidden md:block">
              <div class="flex items-center space-x-2">
                  <!-- Home Link - Active -->
                  <a href="{{ route('home') }}" class="relative group px-4 py-3 text-red-600 font-semibold text-sm rounded-xl bg-red-50 transition-all duration-300 hover:bg-red-100 hover:-translate-y-0.5 overflow-hidden">
                      <span class="relative z-10">Home</span>
                      <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-red-600 to-red-500 rounded-full"></div>
                  </a>

                  <!-- Regular Nav Links -->
                  <a href="#mosaic" class="relative group px-4 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5 overflow-hidden">
                      <span class="relative z-10">Events</span>
                      <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                  </a>

                  <a href="#categories" class="relative group px-4 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5 overflow-hidden">
                      <span class="relative z-10">Category</span>
                      <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                  </a>

                  <a href="#trusted" class="relative group px-4 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5 overflow-hidden">
                      <span class="relative z-10">Highlights</span>
                      <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                  </a>

                  <a href="#sponsors" class="relative group px-4 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5 overflow-hidden">
                      <span class="relative z-10">Sponsor</span>
                      <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                  </a>

                  <a href="#footer" class="relative group px-4 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5 overflow-hidden">
                      <span class="relative z-10">Contact</span>
                      <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                  </a>

                  @auth
                      <!-- Authenticated User -->
                      <a href="" class="relative group ml-2 px-5 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl border border-gray-300 hover:border-gray-400 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md overflow-hidden">
                          <span class="relative z-10 flex items-center space-x-2">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                              </svg>
                              <span>Dashboard</span>
                          </span>
                          <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                      </a>

                      <!-- Logout Button -->
                      <form method="POST" action="{{ route('logout') }}" class="inline ml-2">
                          @csrf
                          <button type="submit" class="relative group px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold text-sm rounded-xl shadow-lg shadow-red-500/25 transition-all duration-300 hover:shadow-xl hover:shadow-red-500/35 hover:-translate-y-1 hover:from-red-700 hover:to-red-600 overflow-hidden">
                              <span class="relative z-10">Logout</span>
                              <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-600 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                          </button>
                      </form>
                  @else
                      <!-- Guest User -->
                      <a href="{{ route('login') }}" class="relative group ml-2 px-5 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl border border-gray-300 hover:border-gray-400 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md overflow-hidden">
                          <span class="relative z-10 flex items-center space-x-2">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                              </svg>
                              <span>Login</span>
                          </span>
                          <div class="absolute inset-0 bg-gray-50 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                      </a>

                      <!-- Sign Up Button -->
                      <a href="{{ route('register') }}" class="relative group ml-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold text-sm rounded-xl shadow-lg shadow-red-500/25 transition-all duration-300 hover:shadow-xl hover:shadow-red-500/35 hover:-translate-y-1 hover:from-red-700 hover:to-red-600 overflow-hidden">
                          <span class="relative z-10">Sign Up</span>
                          <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-600 scale-0 group-hover:scale-100 transition-transform duration-300 rounded-xl"></div>
                      </a>
                  @endauth
              </div>
          </div>

          <!-- Mobile menu button -->
          <div class="md:hidden">
              <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all duration-300 hover:scale-105 border border-gray-200" onclick="toggleMobileMenu()">
                  <span class="sr-only">Open main menu</span>
                  <div class="w-6 h-5 flex flex-col justify-between">
                      <span id="line1" class="block h-0.5 w-full bg-gray-700 rounded transition-all duration-300 transform origin-center"></span>
                      <span id="line2" class="block h-0.5 w-full bg-gray-700 rounded transition-all duration-300"></span>
                      <span id="line3" class="block h-0.5 w-full bg-gray-700 rounded transition-all duration-300 transform origin-center"></span>
                  </div>
              </button>
          </div>
      </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="md:hidden fixed inset-0 top-20 z-40 transform -translate-y-full opacity-0 transition-all duration-500 ease-out pointer-events-none">
      <!-- Backdrop -->
      <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

      <!-- Menu Content -->
      <div class="relative bg-white/95 backdrop-blur-xl m-4 rounded-2xl shadow-2xl transform translate-y-8 transition-transform duration-500">
          <div class="p-6 space-y-1">
              <!-- Navigation Links -->
              <a href="{{ route('home') }}" class="group flex items-center justify-between py-4 px-4 text-red-600 bg-red-50 font-semibold rounded-xl transition-all duration-300 hover:bg-red-100 hover:pl-6 border-b border-gray-100">
                  <span>Home</span>
                  <div class="w-1 h-8 bg-gradient-to-b from-red-600 to-red-500 rounded-full"></div>
              </a>

              <a href="#mosaic" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Events</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="#categories" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Category</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="#trusted" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Highlights</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="#sponsors" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Sponsor</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="#footer" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Contact</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <!-- Mobile Auth Buttons -->
              <div class="pt-4 space-y-3 border-t border-gray-200">
                  @auth
                      <!-- Authenticated User -->
                      <a href="" class="flex items-center space-x-3 py-4 px-4 text-gray-600 hover:text-gray-900 font-medium border border-gray-300 hover:border-gray-400 rounded-xl transition-all duration-300 hover:bg-gray-50">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                          </svg>
                          <span>Dashboard</span>
                      </a>

                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit" class="w-full text-center py-4 px-6 bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600">
                              Logout
                          </button>
                      </form>
                  @else
                      <!-- Guest User -->
                      <a href="{{ route('login') }}" class="flex items-center space-x-3 py-4 px-4 text-gray-600 hover:text-gray-900 font-medium border border-gray-300 hover:border-gray-400 rounded-xl transition-all duration-300 hover:bg-gray-50">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                          </svg>
                          <span>Login</span>
                      </a>

                      <a href="{{ route('register') }}" class="block text-center py-4 px-6 bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600">
                          Sign Up
                      </a>
                  @endauth
              </div>
          </div>
      </div>
  </div>
</nav>

<script>
function toggleMobileMenu() {
  const menu = document.getElementById('mobile-menu');
  const button = document.getElementById('mobile-menu-button');
  const line1 = document.getElementById('line1');
  const line2 = document.getElementById('line2');
  const line3 = document.getElementById('line3');

  if (menu.classList.contains('opacity-0')) {
      // Open menu
      menu.classList.remove('opacity-0', '-translate-y-full', 'pointer-events-none');
      menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');

      // Animate hamburger to X
      line1.style.transform = 'rotate(45deg) translate(5px, 5px)';
      line2.style.opacity = '0';
      line2.style.transform = 'scale(0)';
      line3.style.transform = 'rotate(-45deg) translate(5px, -5px)';
  } else {
      // Close menu
      menu.classList.add('opacity-0', '-translate-y-full', 'pointer-events-none');
      menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');

      // Animate X back to hamburger
      line1.style.transform = 'rotate(0) translate(0, 0)';
      line2.style.opacity = '1';
      line2.style.transform = 'scale(1)';
      line3.style.transform = 'rotate(0) translate(0, 0)';
  }
}

// Close menu when clicking backdrop
document.addEventListener('click', function(e) {
  const menu = document.getElementById('mobile-menu');
  const button = document.getElementById('mobile-menu-button');

  if (!menu.classList.contains('opacity-0') && !menu.contains(e.target) && !button.contains(e.target)) {
      toggleMobileMenu();
  }
});
</script>