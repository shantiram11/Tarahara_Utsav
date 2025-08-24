<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-white/20 shadow-sm">
  <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
      <div class="flex justify-between items-center h-20">
          <!-- Logo with Animation -->
          <div class="flex-shrink-0">
              <a href="{{ route('home') }}" class="flex items-center">
                  <div class="relative">
                      <img src="{{ asset('assets/Logo.png') }}" alt="Tarahara Utsav" class="h-10 sm:h-12 w-auto">
                  </div>
                  <span
            class="ml-1 rounded-full bg-amber-300/20 px-2 py-0.5 text-[10px] font-semibold text-amber-300 ring-1 ring-amber-300/40"
            >2025</span
          >
              </a>
          </div>

          <!-- Desktop Navigation Links -->
          <div class="hidden md:block">
              <div class="desktop-nav flex items-center space-x-1">
                  <!-- Home Link -->
                  <a href="{{ route('home') }}" class="nav-link relative px-3 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('home') && !request()->has('_fragment') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-700 hover:text-gray-900' }}" id="home-link">
                      <span>Home</span>
                      <span class="active-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded bg-red-600" style="display:none"></span>
                  </a>

                  <!-- Regular Nav Links -->
                  <a href="{{ request()->routeIs('home') ? '#mosaic' : route('home').'#mosaic' }}" class="nav-link relative px-3 py-2 text-gray-700 hover:text-gray-900 text-sm rounded-md transition-colors">
                      <span>Events</span>
                      <span class="active-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded bg-red-600" style="display:none"></span>
                  </a>

                  <a href="{{ request()->routeIs('home') ? '#sponsors' : route('home').'#sponsors' }}" class="nav-link relative px-3 py-2 text-gray-700 hover:text-gray-900 text-sm rounded-md transition-colors">
                      <span>Sponsors</span>
                      <span class="active-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded bg-red-600" style="display:none"></span>
                  </a>

                  <a href="{{ request()->routeIs('home') ? '#categories' : route('home').'#categories' }}" class="nav-link relative px-3 py-2 text-gray-700 hover:text-gray-900 text-sm rounded-md transition-colors">
                      <span>Category</span>
                      <span class="active-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded bg-red-600" style="display:none"></span>
                  </a>

                  <a href="{{ request()->routeIs('home') ? '#highlights' : route('home').'#highlights' }}" class="nav-link relative px-3 py-2 text-gray-700 hover:text-gray-900 text-sm rounded-md transition-colors">
                      <span>Highlights</span>
                      <span class="active-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded bg-red-600" style="display:none"></span>
                  </a>

                  <a href="{{ route('contact') }}" class="nav-link relative px-3 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('contact') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-700 hover:text-gray-900' }}">
                      <span>Contact</span>
                      <span class="active-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded bg-red-600" style="{{ request()->routeIs('contact') ? 'display:block' : 'display:none' }}"></span>
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
              <button type="button" id="mobile-menu-button" class="relative z-50 inline-flex items-center justify-center p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all duration-300 hover:scale-105 border border-gray-200 pointer-events-auto" onclick="toggleMobileMenu()" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open main menu">
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

              <a href="{{ request()->routeIs('home') ? '#mosaic' : route('home').'#mosaic' }}" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Events</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="{{ request()->routeIs('home') ? '#categories' : route('home').'#categories' }}" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Category</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="{{ request()->routeIs('home') ? '#trusted' : route('home').'#trusted' }}" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Highlights</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="{{ request()->routeIs('home') ? '#sponsors' : route('home').'#sponsors' }}" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
                  <span>Sponsor</span>
                  <div class="w-1 h-0 group-hover:h-8 bg-gradient-to-b from-gray-400 to-gray-500 rounded-full transition-all duration-300"></div>
              </a>

              <a href="{{ route('contact') }}" class="group flex items-center justify-between py-4 px-4 text-gray-600 hover:text-gray-900 font-medium rounded-xl transition-all duration-300 hover:bg-gray-50 hover:pl-6 border-b border-gray-100">
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
// Mobile Menu Toggle Function
function toggleMobileMenu() {
    const menu = document.getElementById("mobile-menu");
    const button = document.getElementById("mobile-menu-button");
    const line1 = document.getElementById("line1");
    const line2 = document.getElementById("line2");
    const line3 = document.getElementById("line3");

    console.log("Toggle called", { menu, button });

    if (!menu || !button) {
        console.log("Menu or button not found!");
        return;
    }

    if (menu.classList.contains('opacity-0')) {
        // Open menu
        menu.classList.remove('opacity-0', '-translate-y-full', 'pointer-events-none');
        menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');

        // Animate hamburger to X
        if (line1 && line2 && line3) {
            line1.style.transform = "rotate(45deg) translate(5px, 5px)";
            line2.style.opacity = "0";
            line2.style.transform = "scale(0)";
            line3.style.transform = "rotate(-45deg) translate(5px, -5px)";
        }

        // Update button aria
        button.setAttribute("aria-expanded", "true");
    } else {
        // Close menu
        menu.classList.add('opacity-0', '-translate-y-full', 'pointer-events-none');
        menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');

        // Animate X back to hamburger
        if (line1 && line2 && line3) {
            line1.style.transform = "rotate(0) translate(0, 0)";
            line2.style.opacity = "1";
            line2.style.transform = "scale(1)";
            line3.style.transform = "rotate(0) translate(0, 0)";
        }

        // Update button aria
        button.setAttribute("aria-expanded", "false");
    }
}

// Make function globally available
window.toggleMobileMenu = toggleMobileMenu;

// Close mobile menu when a link is clicked; smooth scroll for in-page links
document.addEventListener('DOMContentLoaded', function () {
  const menu = document.getElementById('mobile-menu');
  if (!menu) return;

  const mobileLinks = Array.from(menu.querySelectorAll('a'));
  mobileLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      const href = link.getAttribute('href') || '';
      const isHash = href.startsWith('#');

      // Only close menu after a small delay to prevent immediate closing
      setTimeout(() => {
        if (menu.style.display !== 'none') {
          toggleMobileMenu();
        }
      }, 100);

      if (isHash) {
        e.preventDefault();
        const targetEl = document.querySelector(href);
        if (targetEl) {
          const offset = 80;
          const top = targetEl.getBoundingClientRect().top + window.pageYOffset - offset;
          window.scrollTo({ top, behavior: 'smooth' });
          if (window.location.hash !== href) {
            history.pushState(null, '', href);
          }
        }
      }
    });
  });

  // Close menu when clicking backdrop
  document.addEventListener('click', function(e) {
    const menu = document.getElementById('mobile-menu');
    const menuButton = document.getElementById('mobile-menu-button');

    if (!menu.classList.contains('opacity-0') && !menu.contains(e.target) && !menuButton.contains(e.target)) {
      toggleMobileMenu();
    }
  });
});
</script>