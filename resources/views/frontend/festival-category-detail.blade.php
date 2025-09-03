@extends('layouts.app')

@section('content')
<section class="w-full px-4 py-8 sm:px-6 lg:px-8 pt-24">
  <div class="mx-auto max-w-4xl">
    <!-- Breadcrumb -->
    <nav class="mb-8">
      <ol class="flex items-center space-x-2 text-sm text-slate-600">
        <li><a href="{{ route('home') }}" class="hover:text-slate-900">Home</a></li>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <a href="{{ route('home') }}#festival-category" class="hover:text-slate-900">Festival Categories</a>
        </li>
        <li class="flex items-center">
          <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="text-slate-900">{{ $festivalCategory->title }}</span>
        </li>
      </ol>
    </nav>

    <!-- Hero Section -->
    <div class="mb-12">
      <div class="relative aspect-[16/9] overflow-hidden rounded-2xl mb-8">
        <img
          src="{{ Storage::url($festivalCategory->image) }}"
          alt="{{ $festivalCategory->title }}"
          class="h-full w-full object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        <div class="absolute bottom-6 left-6 right-6">
          <h1 class="text-4xl font-bold text-white mb-2">{{ $festivalCategory->title }}</h1>
          <p class="text-lg text-white/90">{{ $festivalCategory->description }}</p>
        </div>
      </div>
    </div>

    <!-- Content Section -->
    <div class="prose prose-lg max-w-none">
      @if($festivalCategory->content)
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-200">
          <div class="text-slate-700 leading-relaxed">
            {!! nl2br(e($festivalCategory->content)) !!}
          </div>
        </div>
      @else
        <div class="bg-{{ $festivalCategory->color_scheme }}-50 rounded-2xl p-8 border border-{{ $festivalCategory->color_scheme }}-200">
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-{{ $festivalCategory->color_scheme }}-100 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-{{ $festivalCategory->color_scheme }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-{{ $festivalCategory->color_scheme }}-900 mb-2">More Details Coming Soon</h3>
            <p class="text-{{ $festivalCategory->color_scheme }}-700">
              We're working on adding more detailed information about {{ $festivalCategory->title }}.
              Check back soon for updates!
            </p>
          </div>
        </div>
      @endif
    </div>

    <!-- Related Categories -->
    <div class="mt-16">
      <h2 class="text-2xl font-bold text-slate-900 mb-8">Other Festival Categories</h2>
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @php
          $relatedCategories = \App\Models\FestivalCategory::active()
            ->where('id', '!=', $festivalCategory->id)
            ->ordered()
            ->limit(3)
            ->get();
        @endphp

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
          >Learn More →</a>
          @endif
        </article>
        @endforeach
      </div>
    </div>

    <!-- Back to Categories -->
    <div class="mt-12 text-center">
      <a
        href="{{ route('home') }}#festival-category"
        class="inline-flex items-center px-6 py-3 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors"
      >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Festival Categories
      </a>
    </div>
  </div>
</section>
@endsection
