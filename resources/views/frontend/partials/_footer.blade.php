<footer
  id="contact"
  class="border-t border-slate-200 text-white/90 bg-[linear-gradient(110deg,_#B7C1D3_0%,_#7E889B_30%,_#3B4F70_65%,_#001233_100%)]"
>
  <div class="mx-auto max-w-7xl px-4 py-10 sm:py-12 lg:py-14 sm:px-6 lg:px-8">
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">

      <!-- Logo + Description -->
      <div>
        <div class="flex items-center gap-2">
          <img
            src="{{ asset('assets/Logo.png') }}"
            alt="Tarahara Utsav"
            class="h-14 w-auto transition-transform duration-300 hover:scale-105"
          >
          <span
            class="ml-1 rounded-full bg-amber-300/20 px-2 py-0.5 text-[10px] font-semibold text-amber-300 ring-1 ring-amber-300/40"
          >
            2025
          </span>
        </div>
        <p class="mt-4 text-sm text-white/80 leading-relaxed">
          Celebrating our rich cultural heritage through music, dance, food, and traditions.
          Join us for an unforgettable cultural experience.
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="text-sm font-semibold text-white">Quick Links</h4>
        <ul class="mt-4 space-y-2 text-sm">
          <li>
            <a href="{{ route('home') }}" class="relative inline-block text-white/80 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">Home</a>
          </li>
          <li>
            <a href="{{ request()->routeIs('home') ? '#mosaic' : route('home').'#mosaic' }}" class="relative inline-block text-white/80 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">Events</a>
          </li>
          <li>
            <a href="{{ request()->routeIs('home') ? '#sponsors' : route('home').'#sponsors' }}" class="relative inline-block text-white/80 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">Sponsors</a>
          </li>
          <li>
            <a href="{{ request()->routeIs('home') ? '#highlights' : route('home').'#highlights' }}" class="relative inline-block text-white/80 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">Highlights</a>
          </li>
          <li>
            <a href="{{ route('contact') }}" class="relative inline-block text-white/80 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">Contact</a>
          </li>
        </ul>
      </div>

      <!-- Event Date -->
      <div>
        <h4 class="text-sm font-semibold text-white">Event Date</h4>
        <dl class="mt-4 space-y-2 text-sm">
          <div class="flex items-start gap-2">
            <dt class="w-16 text-white/70">Dates:</dt>
            <dd class="text-white/85">December 15–17, 2025</dd>
          </div>
          <div class="flex items-start gap-2">
            <dt class="w-16 text-white/70">Time:</dt>
            <dd class="text-white/85">10:00 AM — 10:00 PM Daily</dd>
          </div>
          <div class="flex items-start gap-2">
            <dt class="w-16 text-white/70">Venue:</dt>
            <dd class="text-white/85">Tarahara Bazaar, Basketball Court</dd>
          </div>
        </dl>
      </div>

      <!-- Contact Info -->
      <div>
        <h4 class="text-sm font-semibold text-white">Contact Us</h4>
        <ul class="mt-4 space-y-2 text-sm">
          <li>Tarahara Bazaar Itahari-2<br />Sunsari Nepal</li>
          <li>+977 9800000977</li>
          <li><a href="mailto:info@taraharautsav.com" class="relative inline-block text-white/80 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">info@taraharautsav.com</a></li>
        </ul>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div class="mt-8 border-t border-white/10 pt-6 text-xs text-white/65">
      <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <a href="#" class="relative inline-block text-white/75 transition-colors hover:text-white after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:h-0.5 after:w-full after:scale-x-0 after:origin-left after:bg-white after:transition-transform after:duration-300 hover:after:scale-x-100">Terms & Privacy</a>
        <p>© 2025 Tarahara Utsav. All rights reserved.</p>
        <div class="flex items-center gap-4">
          <a aria-label="Facebook" href="#" class="opacity-80 hover:opacity-100 transition" title="Facebook">
            <img src="{{ asset('assets/social-facebook.svg') }}" alt="Facebook" class="h-4 w-4" />
          </a>
          <a aria-label="X" href="#" class="opacity-80 hover:opacity-100 transition" title="X">
            <img src="{{ asset('assets/social-x.svg') }}" alt="X" class="h-4 w-4" />
          </a>
          <a aria-label="LinkedIn" href="#" class="opacity-80 hover:opacity-100 transition" title="LinkedIn">
            <img src="{{ asset('assets/social-linkedin.svg') }}" alt="LinkedIn" class="h-4 w-4" />
          </a>
        </div>
      </div>
    </div>
  </div>
</footer>
