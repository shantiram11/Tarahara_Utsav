@extends('layouts.app')

@section('content')
<section class="w-full px-4 py-8 sm:px-6 lg:px-8 pt-24">
  <div class="mx-auto max-w-6xl">
    <!-- Breadcrumb -->
    <nav class="mb-8">
      <ol class="flex items-center space-x-2 text-sm text-slate-600">
        <li><a href="{{ route('home') }}" class="hover:text-slate-900">Home</a></li>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <a href="{{ route('home') }}#festival-category" class="hover:text-slate-900">TU Honours</a>
        </li>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-slate-900">{{ $festivalCategory->title }}</span>
        </li>
      </ol>
    </nav>

    <!-- Article Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <!-- Main Article -->
      <article class="lg:col-span-8">
        <!-- Cover Image -->
        <div class="relative overflow-hidden rounded-2xl bg-slate-100">
          <img
            src="{{ Storage::url($festivalCategory->image) }}"
            alt="{{ $festivalCategory->title }}"
            class="w-full h-[280px] sm:h-[360px] lg:h-[420px] object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
          <div class="absolute bottom-6 left-6 right-6">
            <div class="flex items-center gap-3 mb-3">
              <span class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-slate-800 ring-1 ring-white">
                <span class="w-2 h-2 rounded-full bg-{{ $festivalCategory->color_scheme }}-500"></span>
                {{ ucfirst($festivalCategory->color_scheme) }}
              </span>
              <span class="text-white/90 text-xs">{{ $festivalCategory->created_at->format('M d, Y') }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white drop-shadow">{{ $festivalCategory->title }}</h1>
            <p class="mt-2 text-white/90 max-w-3xl">{{ $festivalCategory->description }}</p>
          </div>
        </div>

        <!-- Body -->
        <div class="mt-8">
          @if($festivalCategory->content)
            <div class="prose prose-slate prose-lg max-w-none bg-white rounded-2xl p-6 sm:p-8 shadow-sm ring-1 ring-slate-200">
              {!! nl2br(e($festivalCategory->content)) !!}
            </div>
          @else
            <div class="rounded-2xl p-8 ring-1 ring-{{ $festivalCategory->color_scheme }}-200 bg-{{ $festivalCategory->color_scheme }}-50">
              <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-{{ $festivalCategory->color_scheme }}-100 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-{{ $festivalCategory->color_scheme }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <h3 class="text-xl font-semibold text-{{ $festivalCategory->color_scheme }}-900 mb-2">More Details Coming Soon</h3>
                <p class="text-{{ $festivalCategory->color_scheme }}-700">We're working on adding more detailed information about {{ $festivalCategory->title }}. Check back soon for updates!</p>
              </div>
            </div>
          @endif
        </div>
      </article>

      <!-- Sidebar -->
      <aside class="lg:col-span-4">
        <div class="sticky top-28 space-y-6">
          <!-- Meta Card -->
          <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Article Info</h3>
            <dl class="text-sm text-slate-600 grid grid-cols-1 gap-2">
              <div class="flex items-center justify-between">
                <dt>Published</dt>
                <dd class="text-slate-900">{{ $festivalCategory->created_at->format('M d, Y') }}</dd>
              </div>
              <div class="flex items-center justify-between">
                <dt>Category</dt>
                <dd class="inline-flex items-center gap-2 text-slate-900">
                  <span class="w-2 h-2 rounded-full bg-{{ $festivalCategory->color_scheme }}-500"></span>
                  {{ ucfirst($festivalCategory->color_scheme) }}
                </dd>
              </div>
            </dl>
          </div>

          <!-- Advertisement Section -->
          @if(isset($advertisementsData) && !empty($advertisementsData['sidebar']))
            <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-8">
              <h3 class="text-sm font-semibold text-slate-900 mb-6">Advertisement</h3>
              <div class="space-y-6">
                @foreach($advertisementsData['sidebar'] as $advertisement)
                  <div class="advertisement-item bg-gray-50 rounded-xl p-4 border border-gray-200">
                    @if($advertisement['link_url'])
                      <a href="{{ $advertisement['link_url'] }}" target="_blank" rel="noopener" class="block hover:opacity-90 transition-opacity">
                        <img
                          src="{{ $advertisement['image'] }}"
                          alt="{{ $advertisement['title'] }}"
                          class="w-full h-auto rounded-lg shadow-md border border-gray-300"
                          style="max-height: 400px; min-height: 300px; object-fit: contain; object-position: center; width: 100%;"
                        >
                      </a>
                    @else
                      <img
                        src="{{ $advertisement['image'] }}"
                        alt="{{ $advertisement['title'] }}"
                        class="w-full h-auto rounded-lg shadow-md border border-gray-300"
                        style="max-height: 400px; min-height: 300px; object-fit: contain; object-position: center; width: 100%;"
                      >
                    @endif
                  </div>
                @endforeach
              </div>
            </div>
          @else
            <!-- Show if no sidebar ads -->
            <div class="rounded-2xl bg-gray-50 ring-1 ring-gray-200 p-6">
              <h3 class="text-sm font-semibold text-gray-900 mb-4">Advertisement</h3>
              <p class="text-sm text-gray-600">No sidebar advertisements available at the moment.</p>
            </div>
          @endif

          <!-- Share Card -->
          <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Share</h3>
            @php
              $shareUrl = urlencode(url()->current());
              $shareText = urlencode($festivalCategory->title);
            @endphp
            <div class="flex items-center gap-3">
              <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" aria-label="Share on X" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black hover:bg-black/80 transition-colors">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
              </a>
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" aria-label="Share on Facebook" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
              </a>
              <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" aria-label="Share on LinkedIn" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-700 hover:bg-blue-800 transition-colors">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
              <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" aria-label="Share on WhatsApp" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-500 hover:bg-green-600 transition-colors">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516"/>
                </svg>
              </a>
              <a href="viber://forward?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" aria-label="Share on Viber" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-600 hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M11.398.002C9.473.028 5.331.344 3.014 2.467 1.294 4.177.693 6.698.623 9.82c-.06 3.11-.13 8.95 5.5 10.541v2.42s-.038.97.602.582c.64-.388 2.885-1.771 4.084-2.777 1.43.125 3.059.197 4.67.066 3.123-.07 5.644-.67 7.355-2.39 1.72-1.709 2.032-4.23 2.032-7.64 0-3.41-.312-5.931-2.032-7.64C20.84.262 16.187-.018 11.398.002zm.067 1.697c4.185-.016 8.31.23 9.797 1.7 1.324 1.31 1.594 3.423 1.594 6.4 0 2.976-.27 5.09-1.594 6.4-1.324 1.31-3.767 1.94-6.591 2.004-1.433.114-2.913.052-4.178-.05-.553 0-1.122.26-1.741.678-.619.417-1.234.85-1.756 1.226v-1.39c0-.424-.335-.765-.748-.765-4.756-1.304-4.636-6.148-4.582-8.95.054-2.803.543-4.79 1.868-6.115C5.543 1.926 8.88 1.698 11.465 1.7zm.047 2.679c-.243.004-.44.2-.44.444 0 .245.198.444.444.444 2.842.015 5.14 2.31 5.155 5.15 0 .246.2.445.444.445s.444-.2.444-.445c-.02-3.334-2.709-6.023-6.047-6.038zm-2.184.566c-.543-.02-1.104.234-1.48.67l-.87.87c-.548.55-.85 1.348-.784 2.158.066.81.45 1.559.97 2.22.52.661 1.19 1.303 1.933 1.952.743.65 1.564 1.291 2.42 1.806.855.514 1.747.9 2.554.97.808.07 1.604-.23 2.158-.784l.87-.87c.436-.436.69-.997.67-1.54-.02-.542-.318-1.06-.784-1.364l-1.416-.93c-.466-.306-.984-.392-1.364-.227-.38.165-.708.493-1.01.826-.302.333-.58.676-.87.87-.29.194-.59.238-.87.113-.28-.125-.55-.375-.826-.67-.276-.295-.546-.635-.784-.97-.238-.335-.454-.664-.67-.97-.216-.306-.392-.58-.227-.87.165-.29.493-.58.826-.87.333-.29.661-.58.826-1.01.165-.43.08-.898-.227-1.364l-.93-1.416c-.304-.466-.822-.764-1.364-.784z"/>
                </svg>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="rounded-2xl bg-{{ $festivalCategory->color_scheme }}-50 ring-1 ring-{{ $festivalCategory->color_scheme }}-200 p-6">
            <h3 class="text-sm font-semibold text-{{ $festivalCategory->color_scheme }}-900 mb-4">Quick Links</h3>
            <ul class="space-y-2 text-sm">
              <li><a class="text-{{ $festivalCategory->color_scheme }}-700 hover:underline" href="{{ route('home') }}#festival-category">← Back to TU Honours</a></li>
            </ul>
          </div>
        </div>
      </aside>
    </div>

    <!-- Related Categories -->
    <div class="mt-16">
      <h2 class="text-2xl font-bold text-slate-900 mb-8">Related Categories</h2>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($relatedCategories as $category)
        <article class="group rounded-2xl bg-{{ $category->color_scheme }}-50 p-6 ring-1 ring-{{ $category->color_scheme }}-100 transition-shadow hover:shadow-soft">
          <div class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl">
            <img
              src="{{ Storage::url($category->image) }}"
              alt="{{ $category->title }}"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
          </div>
          <h3 class="text-lg font-semibold">{{ $category->title }}</h3>
          <p class="mt-2 text-sm text-slate-600">{{ Str::limit($category->description, 100) }}</p>
          @if($category->content)
          <a
            href="{{ route('festival-categories.show', $category->slug) }}"
            class="mt-4 inline-flex items-center text-sm font-semibold text-{{ $category->color_scheme }}-700 hover:underline"
          >Read More →</a>
          @endif
        </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection
