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
              @php
                $tier1Packages = [
                  ['label' => 'RS. 2,00,000/-', 'sub' => 'TITLE SPONSOR'],
                  ['label' => 'RS. 1,00,000/-', 'sub' => 'SPONSORS'],
                  ['label' => 'RS. 50,000/-', 'sub' => 'CO-SPONSORS'],
                  ['label' => 'RS. 25,000/-', 'sub' => 'CELEB. PARTNERS'],
                ];
              @endphp
              <div class="grid grid-cols-2 items-stretch gap-3 sm:grid-cols-4">
                 @foreach($sponsorData['tier1'] as $index => $sponsor)
                  <a href="{{ $sponsor['website_url'] ?? '#' }}"
                     class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white p-5 text-center ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft"
                     @if($sponsor['website_url']) target="_blank" @endif>
                    <img class="h-12 opacity-80 transition-all group-hover:opacity-100 object-contain"
                         src="{{ $sponsor['image'] }}"
                         alt="{{ $sponsor['title'] }}" />
                    @php $pkg = $tier1Packages[$index] ?? null; @endphp
                    @if($pkg)
                      <div class="leading-tight">
                        <p class="text-xs font-bold tracking-wide text-slate-900">{{ $pkg['label'] }}</p>
                        <p class="text-[11px] font-semibold tracking-wider text-slate-600">{{ $pkg['sub'] }}</p>
                      </div>
                    @endif
                  </a>
                @endforeach
              </div>
            </div>

            <!-- Tier 2 Sponsors -->
            <div class="mt-10 rounded-3xl border border-slate-200 bg-white/60 p-6 backdrop-blur">
              <p class="mb-6 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                Tier 2
              </p>
              @php
                $tier2Packages = [
                  ['label' => 'RS. 20K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'RS. 15K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'RS. 10K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'RS. 5K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'IN-KIND', 'sub' => 'SPONSORS'],
                  ['label' => 'COMMUNITY', 'sub' => 'SUPPORTERS'],
                ];
              @endphp
              <div class="grid grid-cols-2 items-stretch gap-2 sm:grid-cols-6">
                 @foreach($sponsorData['tier2'] as $index => $sponsor)
                  <a href="{{ $sponsor['website_url'] ?? '#' }}"
                     class="group flex flex-col items-center justify-center gap-1 rounded-2xl bg-white p-4 text-center ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft"
                     @if($sponsor['website_url']) target="_blank" @endif>
                    <img class="h-10 opacity-70 transition-all group-hover:opacity-100 object-contain"
                         src="{{ $sponsor['image'] }}"
                         alt="{{ $sponsor['title'] }}" />
                    @php $pkg = $tier2Packages[$index] ?? null; @endphp
                    @if($pkg)
                      <div class="leading-tight">
                        <p class="text-[11px] font-bold tracking-wide text-slate-900">{{ $pkg['label'] }}</p>
                        <p class="text-[10px] font-semibold tracking-wider text-slate-600">{{ $pkg['sub'] }}</p>
                      </div>
                    @endif
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
              @php
                $fallbackTier1Packages = [
                  ['label' => 'RS. 2,00,000/-', 'sub' => 'TITLE SPONSOR'],
                  ['label' => 'RS. 1,00,000/-', 'sub' => 'SPONSORS'],
                  ['label' => 'RS. 50,000/-', 'sub' => 'CO-SPONSORS'],
                  ['label' => 'RS. 25,000/-', 'sub' => 'CELEB. PARTNERS'],
                ];
              @endphp
              <div class="grid grid-cols-2 items-stretch gap-3 sm:grid-cols-4">
                @foreach(['Stripe', 'GitHub', 'Vercel', 'Cloudflare'] as $i => $sponsor)
                  <a href="#" class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white p-5 text-center ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft">
                    <img class="h-12 opacity-80 transition-all group-hover:opacity-100"
                         src="{{ asset('assets/Logo.png') }}"
                         alt="{{ $sponsor }}" />
                    @php $pkg = $fallbackTier1Packages[$i] ?? null; @endphp
                    @if($pkg)
                      <div class="leading-tight">
                        <p class="text-xs font-bold tracking-wide text-slate-900">{{ $pkg['label'] }}</p>
                        <p class="text-[11px] font-semibold tracking-wider text-slate-600">{{ $pkg['sub'] }}</p>
                      </div>
                    @endif
                  </a>
                @endforeach
              </div>
            </div>

            <div class="mt-10 rounded-3xl border border-slate-200 bg-white/60 p-6 backdrop-blur">
              <p class="mb-6 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                Tier 2
              </p>
              @php
                $fallbackTier2Packages = [
                  ['label' => 'RS. 20K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'RS. 15K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'RS. 10K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'RS. 5K', 'sub' => 'SUPPORTERS'],
                  ['label' => 'IN-KIND', 'sub' => 'SPONSORS'],
                  ['label' => 'COMMUNITY', 'sub' => 'SUPPORTERS'],
                ];
              @endphp
              <div class="grid grid-cols-2 items-stretch gap-2 sm:grid-cols-6">
                @foreach(['Figma', 'Slack', 'Atlassian', 'DigitalOcean', 'Netlify', 'Twilio'] as $i => $sponsor)
                  <a href="#" class="group flex flex-col items-center justify-center gap-1 rounded-2xl bg-white p-4 text-center ring-1 ring-slate-200 transition-all hover:-translate-y-1 hover:ring-amber-300 hover:shadow-soft">
                    <img class="h-10 opacity-70 transition-all group-hover:opacity-100"
                         src="{{ asset('assets/Logo.png') }}"
                         alt="{{ $sponsor }}" />
                    @php $pkg = $fallbackTier2Packages[$i] ?? null; @endphp
                    @if($pkg)
                      <div class="leading-tight">
                        <p class="text-[11px] font-bold tracking-wide text-slate-900">{{ $pkg['label'] }}</p>
                        <p class="text-[10px] font-semibold tracking-wider text-slate-600">{{ $pkg['sub'] }}</p>
                      </div>
                    @endif
                  </a>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </section>
