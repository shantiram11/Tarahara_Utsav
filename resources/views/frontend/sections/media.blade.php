<section
        id="trusted"
        class="relative bg-gradient-to-b from-slate-50 to-white py-12 sm:py-16"
      >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p
              class="text-xs font-semibold uppercase tracking-widest text-slate-500"
            >
              Media coverage
            </p>
            <span class="text-xs text-slate-400">Hover to pause</span>
          </div>
        </div>
        <div class="relative mt-6">
          <!-- edge fades -->
          <div
            class="pointer-events-none absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-slate-50 to-transparent"
          ></div>
          <div
            class="pointer-events-none absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-white to-transparent"
          ></div>
          <div class="overflow-hidden">
            <ul
              id="media-track"
              style="--marquee-duration: 26s"
              class="media-track flex items-center gap-16 px-12"
            >
              <!-- repeat set twice for seamless loop -->
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="BBC"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="The Guardian"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="Al Jazeera"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="CNN"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="Reuters"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="NYTimes"
                />
              </li>

              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="BBC"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="The Guardian"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="Al Jazeera"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="CNN"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="Reuters"
                />
              </li>
              <li class="shrink-0">
                <img
                  class="h-8 sm:h-12 md:h-16 lg:h-[68px] opacity-90"
                  src="{{ asset('assets/Logo.png') }}"
                  alt="NYTimes"
                />
              </li>
            </ul>
          </div>
        </div>
      </section>

      <style>
        @keyframes media-scroll {
          0% {
            transform: translateX(0);
          }
          100% {
            transform: translateX(-50%);
          }
        }
        .media-track {
          width: max-content;
          animation: media-scroll var(--marquee-duration, 28s) linear infinite;
        }
        .media-track:hover {
          animation-play-state: paused;
        }
      </style>