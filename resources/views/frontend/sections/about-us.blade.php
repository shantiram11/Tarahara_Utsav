<section id="mosaic" class="w-full px-4 py-12 md:py-16 sm:px-6 lg:px-8">
  <div
    class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-8 md:grid-cols-2"
  >
    <div>
      <span
        class="mb-4 block text-xs md:text-sm inline-flex items-center rounded-md bg-amber-600 px-4 py-2 font-medium text-white transition-all hover:bg-amber-500 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2
"
        >About Event</span
      >

      <h3 class="text-4xl font-semibold text-slate-900 md:text-6xl">
        {{ $aboutData['title'] }}
      </h3>
      <p class="my-4 text-base text-slate-600 md:my-6 md:text-lg">
        {{ $aboutData['content'] }}
      </p>
    </div>
    <div>
      <div
        id="shuffle-grid"
        class="grid h-[450px] gap-1 overflow-hidden rounded-xl"
        data-images="{{ json_encode($aboutData['images']) }}"
        data-fallback-images="{{ json_encode($aboutData['fallbackImages']) }}"
        data-has-images="{{ $aboutData['hasImages'] ? 'true' : 'false' }}"
      >
        <!-- Tiles will be injected by app.js -->
      </div>
    </div>
  </div>
  <div class="h-10"></div>
</section>