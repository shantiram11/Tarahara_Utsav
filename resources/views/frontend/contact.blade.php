@extends('layouts.app')

@section('content')
  <section id="contact" class="py-12 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Contact Us</h1>
        <p class="mt-2 text-sm text-slate-600">We’d love to hear from you. Send us a message and we’ll respond soon.</p>
      </div>

      <div class="mx-auto grid max-w-5xl grid-cols-1 items-start gap-6 sm:gap-8 lg:gap-8 lg:grid-cols-3">
        <div class="rounded-2xl ring-1 ring-slate-200 bg-white p-6 sm:p-8 shadow-sm lg:col-span-2">
          <h2 class="text-lg sm:text-xl font-semibold text-slate-900">Send a message</h2>
          <form class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2" method="post" action="#">
            <div class="sm:col-span-1">
              <label class="block text-xs font-medium text-slate-600">First Name</label>
              <input type="text" name="first_name" required class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none ring-0 transition focus:ring-2 focus:ring-amber-400 focus:border-transparent" />
            </div>
            <div class="sm:col-span-1">
              <label class="block text-xs font-medium text-slate-600">Last Name</label>
              <input type="text" name="last_name" required class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none ring-0 transition focus:ring-2 focus:ring-amber-400 focus:border-transparent" />
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-medium text-slate-600">Email</label>
              <input type="email" name="email" required class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none ring-0 transition focus:ring-2 focus:ring-amber-400 focus:border-transparent" />
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-medium text-slate-600">Subject</label>
              <input type="text" name="subject" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none ring-0 transition focus:ring-2 focus:ring-amber-400 focus:border-transparent" />
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-medium text-slate-600">Message</label>
              <textarea rows="6" name="message" required class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none ring-0 transition focus:ring-2 focus:ring-amber-400 focus:border-transparent"></textarea>
            </div>
            <div class="sm:col-span-2">
              <button type="submit" class="w-full rounded-xl bg-amber-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-amber-500">
                Submit
              </button>
            </div>
          </form>
        </div>

        <aside class="rounded-2xl ring-1 ring-slate-200 bg-white p-6 sm:p-8 shadow-sm lg:sticky lg:top-24">
          <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Reach us</h3>
          <ul class="mt-4 space-y-3 text-sm text-slate-700">
            <li><span class="font-semibold">Email:</span> info@taraharautsav.com</li>
            <li><span class="font-semibold">Phone:</span> +977 9800000977</li>
            <li><span class="font-semibold">Address:</span> Tarahara Bazaar Itahari-2, Sunsari Nepal</li>
          </ul>
          <div class="mt-6 h-48 w-full overflow-hidden rounded-xl">
            <iframe title="map" width="100%" height="100%" style="border: 0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2201.0000000000005!2d87.277!3d26.663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sTarahara%20Bazaar!5e0!3m2!1sen!2snp!4v1710000000000"></iframe>
          </div>
          <div class="mt-6 flex items-center gap-2 text-slate-600">
            <a href="#" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium hover:bg-slate-200">Facebook</a>
            <a href="#" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium hover:bg-slate-200">Twitter</a>
            <a href="#" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium hover:bg-slate-200">LinkedIn</a>
          </div>
        </aside>
      </div>
    </div>
  </section>
@endsection
