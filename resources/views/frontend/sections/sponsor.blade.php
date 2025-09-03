<section id="sponsors" class="bg-gradient-to-b from-white to-slate-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">
              Our Sponsors
            </h2>
            <p class="mt-3 text-sm text-slate-600">
              We're grateful for the support of our partners who help bring
              Tarahara Utsav to life.
            </p>
          </div>

          @if(isset($sponsorData) && $sponsorData['hasSponsors'])
            <!-- Tier 1 Sponsors -->
            <div class="mt-12 rounded-3xl border border-slate-200 bg-white/60 p-6 backdrop-blur">
              <p class="mb-6 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                Tier 1
              </p>
              <div class="grid grid-cols-2 items-stretch gap-3 sm:grid-cols-4">
                @foreach($sponsorData['tier1'] as $sponsor)
                  <a href="{{ $sponsor['website_url'] ?? '#' }}"
                     class="group flex items-center justify-center rounded-2xl bg-white p-5 ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft"
                     @if($sponsor['website_url']) target="_blank" @endif>
                    <img class="h-12 opacity-80 transition-all group-hover:opacity-100 object-contain"
                         src="{{ $sponsor['image'] }}"
                         alt="{{ $sponsor['title'] }}" />
                  </a>
                @endforeach
              </div>
            </div>

            <!-- Tier 2 Sponsors -->
            <div class="mt-10 rounded-3xl border border-slate-200 bg-white/60 p-6 backdrop-blur">
              <p class="mb-6 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                Tier 2
              </p>
              <div class="grid grid-cols-2 items-stretch gap-2 sm:grid-cols-6">
                @foreach($sponsorData['tier2'] as $sponsor)
                  <a href="{{ $sponsor['website_url'] ?? '#' }}"
                     class="group flex items-center justify-center rounded-2xl bg-white p-4 ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft"
                     @if($sponsor['website_url']) target="_blank" @endif>
                    <img class="h-10 opacity-70 transition-all group-hover:opacity-100 object-contain"
                         src="{{ $sponsor['image'] }}"
                         alt="{{ $sponsor['title'] }}" />
                  </a>
                @endforeach
              </div>
            </div>
          @else
            <!-- Fallback Sponsors -->
            <div class="mt-12 rounded-3xl border border-slate-200 bg-white/60 p-6 backdrop-blur">
              <p class="mb-6 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                Tier 1
              </p>
              <div class="grid grid-cols-2 items-stretch gap-3 sm:grid-cols-4">
                @foreach(['Stripe', 'GitHub', 'Vercel', 'Cloudflare'] as $sponsor)
                  <a href="#" class="group flex items-center justify-center rounded-2xl bg-white p-5 ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft">
                    <img class="h-12 opacity-80 transition-all group-hover:opacity-100"
                         src="{{ asset('assets/Logo.png') }}"
                         alt="{{ $sponsor }}" />
                  </a>
                @endforeach
              </div>
            </div>

            <div class="mt-10 rounded-3xl border border-slate-200 bg-white/60 p-6 backdrop-blur">
              <p class="mb-6 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                Tier 2
              </p>
              <div class="grid grid-cols-2 items-stretch gap-2 sm:grid-cols-6">
                @foreach(['Figma', 'Slack', 'Atlassian', 'DigitalOcean', 'Netlify', 'Twilio'] as $sponsor)
                  <a href="#" class="group flex items-center justify-center rounded-2xl bg-white p-4 ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft">
                    <img class="h-10 opacity-70 transition-all group-hover:opacity-100"
                         src="{{ asset('assets/Logo.png') }}"
                         alt="{{ $sponsor }}" />
                  </a>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </section>
