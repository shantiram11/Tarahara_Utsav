<section id="festival-category" class="w-full px-4 py-8 sm:px-6 lg:px-8">
  <section
  id="categories"
  class="bg-white pb-8 pt-10 sm:pt-14"
>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <h2
      class="mb-6 text-center text-3xl font-extrabold tracking-tight text-slate-900"
    >
      Festival Categories
    </h2>

    @if($festivalCategoriesData['hasCategories'])
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($festivalCategoriesData['categories'] as $category)
        <article
          class="group rounded-2xl bg-{{ $category['color_scheme'] }}-50 p-6 ring-1 ring-{{ $category['color_scheme'] }}-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="{{ $category['image'] }}"
              alt="{{ $category['title'] }}"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">{{ $category['title'] }}</h3>
          <p class="mt-2 text-sm text-slate-600">
            {{ $category['description'] }}
          </p>
          @if($category['has_content'])
          <a
            href="{{ route('festival-categories.show', $category['slug']) }}"
            class="mt-4 inline-flex items-center text-sm font-semibold text-{{ $category['color_scheme'] }}-700 hover:underline"
            >Learn More →</a
          >
          @endif
        </article>
        @endforeach
      </div>
    @else
      <!-- Fallback static content -->
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Card 1 -->
        <article
          class="group rounded-2xl bg-violet-50 p-6 ring-1 ring-violet-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=1600&auto=format&fit=crop"
              alt="Music and dance performance"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">Music & Dance</h3>
          <p class="mt-2 text-sm text-slate-600">
            Traditional and contemporary performances showcasing diverse
            cultural expressions.
          </p>
          <a
            href="#"
            class="mt-4 inline-flex items-center text-sm font-semibold text-violet-700 hover:underline"
            >Learn More →</a
          >
        </article>

        <!-- Card 2 -->
        <article
          class="group rounded-2xl bg-rose-50 p-6 ring-1 ring-rose-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=1600&auto=format&fit=crop"
              alt="Food festival"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">Food Festival</h3>
          <p class="mt-2 text-sm text-slate-600">
            Authentic cuisines from various cultures, cooking
            demonstrations, and tastings.
          </p>
          <a
            href="#"
            class="mt-4 inline-flex items-center text-sm font-semibold text-rose-700 hover:underline"
            >Learn More →</a
          >
        </article>

        <!-- Card 3 -->
        <article
          class="group rounded-2xl bg-emerald-50 p-6 ring-1 ring-emerald-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=1600&auto=format&fit=crop"
              alt="Arts and crafts"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">Arts & Crafts</h3>
          <p class="mt-2 text-sm text-slate-600">
            Handmade creations, workshops, and exhibitions by local
            artisans.
          </p>
          <a
            href="#"
            class="mt-4 inline-flex items-center text-sm font-semibold text-emerald-700 hover:underline"
            >Learn More →</a
          >
        </article>

        <!-- Card 4 -->
        <article
          class="group rounded-2xl bg-amber-50 p-6 ring-1 ring-amber-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="https://images.unsplash.com/photo-1520975661595-6453be3f7070?q=80&w=1600&auto=format&fit=crop"
              alt="Fashion and textiles"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">Fashion & Textiles</h3>
          <p class="mt-2 text-sm text-slate-600">
            Traditional clothing displays, fashion shows, and textile
            demonstrations.
          </p>
          <a
            href="#"
            class="mt-4 inline-flex items-center text-sm font-semibold text-amber-700 hover:underline"
            >Learn More →</a
          >
        </article>

        <!-- Card 5 -->
        <article
          class="group rounded-2xl bg-indigo-50 p-6 ring-1 ring-indigo-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1600&auto=format&fit=crop"
              alt="Competition trophy"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">Competitions</h3>
          <p class="mt-2 text-sm text-slate-600">
            Cultural contests, talent shows, and interactive challenges for
            all ages.
          </p>
          <a
            href="#"
            class="mt-4 inline-flex items-center text-sm font-semibold text-indigo-700 hover:underline"
            >Learn More →</a
          >
        </article>

        <!-- Card 6 -->
        <article
          class="group rounded-2xl bg-pink-50 p-6 ring-1 ring-pink-100 transition-shadow hover:shadow-soft"
        >
          <div
            class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl"
          >
            <img
              src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop"
              alt="Community events"
              class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
            />
            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            ></div>
          </div>
          <h3 class="text-lg font-semibold">Community Events</h3>
          <p class="mt-2 text-sm text-slate-600">
            Family activities, workshops, and collaborative cultural
            experiences.
          </p>
          <a
            href="#"
            class="mt-4 inline-flex items-center text-sm font-semibold text-pink-700 hover:underline"
            >Learn More →</a
          >
        </article>
      </div>
    @endif
  </div>
</section>
</section>