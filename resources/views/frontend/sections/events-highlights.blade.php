<section id="highlights" class="bg-slate-50 py-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <h2
      class="mb-8 text-center text-3xl font-extrabold tracking-tight text-slate-900"
    >
      Event Highlights
    </h2>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @php
        $highlights = isset($eventHighlightsData) && $eventHighlightsData['hasHighlights'] ? $eventHighlightsData['highlights'] : ($eventHighlightsData['fallbackHighlights'] ?? []);
      @endphp

      @foreach($highlights as $highlight)
        <article
          class="rounded-2xl bg-white p-6 ring-1 ring-slate-200 hover:shadow-soft transition-shadow"
        >
          <div
            class="mb-4 grid h-10 w-10 place-content-center rounded-full text-xl"
            style="background-color: {{ $highlight['color_scheme'] === 'amber' ? '#fef3c7' : ($highlight['color_scheme'] === 'emerald' ? '#d1fae5' : ($highlight['color_scheme'] === 'rose' ? '#fce7f3' : ($highlight['color_scheme'] === 'blue' ? '#dbeafe' : ($highlight['color_scheme'] === 'green' ? '#dcfce7' : ($highlight['color_scheme'] === 'red' ? '#fee2e2' : ($highlight['color_scheme'] === 'purple' ? '#e9d5ff' : ($highlight['color_scheme'] === 'orange' ? '#fed7aa' : '#fce7f3'))))))) }};"
          >
            {{ $highlight['icon'] }}
          </div>
          <h3 class="font-semibold">{{ $highlight['title'] }}</h3>
          <p class="mt-1 text-xs text-amber-600">{{ $highlight['date'] }}</p>
          <p class="mt-2 text-sm text-slate-600">
            {{ $highlight['description'] }}
          </p>
        </article>
      @endforeach
    </div>
  </div>
</section>