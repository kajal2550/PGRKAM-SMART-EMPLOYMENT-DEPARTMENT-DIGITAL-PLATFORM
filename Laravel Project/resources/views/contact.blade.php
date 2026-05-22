@extends('layouts.app')
@section('title', 'Contact Us – PGRKAM')

@section('content')
<div class="bg-white">

  {{-- ── Hero ─────────────────────────────────────────────────────────── --}}
  <section class="relative py-20 px-6 overflow-hidden text-center"
    style="background-image:url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/92 via-primary-800/88 to-primary-700/82"></div>
    <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="absolute bottom-0 -left-10 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="relative z-10 max-w-2xl mx-auto">
      <span class="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-5 tracking-wide uppercase">
        We're here to help
      </span>
      <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Contact Us</h1>
      <p class="text-white/70 text-lg">
        Have a question, concern or feedback? Reach out to the PGRKAM helpdesk — our team responds within 2 business days.
      </p>
    </div>
  </section>

  {{-- ── Support Cards ─────────────────────────────────────────────────── --}}
  <section class="max-w-screen-xl mx-auto px-6 -mt-8 relative z-10">
    <div class="grid sm:grid-cols-3 gap-4">
      @foreach([
        ['color'=>'bg-green-500',  'icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title'=>'Call Us',        'sub'=>'0172-2664000',           'note'=>'Toll Free: 18001800000'],
        ['color'=>'bg-blue-500',   'icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',                       'title'=>'Email Support', 'sub'=>'helpdesk@pgrkam.gov.in', 'note'=>'Reply within 48 hours'],
        ['color'=>'bg-purple-500', 'icon'=>'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'title'=>'Live Chat',      'sub'=>'Chat with our bot',      'note'=>'Available 24 × 7'],
      ] as $card)
      <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-5 flex items-center gap-4">
        <div class="w-12 h-12 {{ $card['color'] }} rounded-xl flex items-center justify-center flex-shrink-0">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/></svg>
        </div>
        <div>
          <p class="font-bold text-gray-900 text-sm">{{ $card['title'] }}</p>
          <p class="text-gray-700 text-sm">{{ $card['sub'] }}</p>
          <p class="text-gray-400 text-xs">{{ $card['note'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  {{-- ── Main Content ──────────────────────────────────────────────────── --}}
  <section class="max-w-screen-xl mx-auto px-6 py-16 grid lg:grid-cols-3 gap-8">

    {{-- Left – Info + Hours --}}
    <div class="space-y-5">

      {{-- Address --}}
      <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-start gap-4">
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
          <p class="font-semibold text-gray-900 text-sm mb-0.5">Headquarters</p>
          <p class="text-gray-500 text-sm leading-relaxed">SCO 153-155, Sector 34-A,<br>Chandigarh – 160022</p>
        </div>
      </div>

      {{-- Phone --}}
      <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-start gap-4">
        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
        <div>
          <p class="font-semibold text-gray-900 text-sm mb-0.5">Phone</p>
          <p class="text-gray-500 text-sm">0172-2664000</p>
          <p class="text-green-600 text-xs font-medium mt-0.5">18001800000 (Toll Free)</p>
        </div>
      </div>

      {{-- Email --}}
      <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-start gap-4">
        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <div>
          <p class="font-semibold text-gray-900 text-sm mb-0.5">Email</p>
          <p class="text-gray-500 text-sm">helpdesk@pgrkam.gov.in</p>
          <p class="text-gray-500 text-sm">support@pgrkam.gov.in</p>
        </div>
      </div>

      {{-- Office Hours --}}
      <div class="bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-2xl p-5">
        <div class="flex items-center gap-2 mb-3">
          <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <p class="font-semibold text-primary-900 text-sm">Office Hours</p>
        </div>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-600">Mon – Fri</span>
            <span class="font-medium text-gray-900">9:00 AM – 5:00 PM</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Saturday</span>
            <span class="font-medium text-gray-900">9:00 AM – 1:00 PM</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Sunday</span>
            <span class="font-medium text-red-500">Closed</span>
          </div>
        </div>
      </div>

      {{-- Quick tip --}}
      <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 flex gap-3">
        <svg class="w-4 h-4 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p class="text-xs text-yellow-800 leading-relaxed">For urgent issues, call the toll-free number during office hours for the fastest response.</p>
      </div>

    </div>

    {{-- Right – Form (Alpine.js for success state) --}}
    <div class="lg:col-span-2" x-data="{ submitted: false, email: '' }">

      <div x-show="!submitted" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
          </div>
          <div>
            <h2 class="font-extrabold text-gray-900">Send us a Message</h2>
            <p class="text-xs text-gray-400">We'll get back to you within 2 business days</p>
          </div>
        </div>

        <form x-on:submit.prevent="submitted = true" class="space-y-4">
          @csrf
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium text-gray-700 mb-1.5 block">Full Name <span class="text-red-500">*</span></label>
              <input type="text" name="name" placeholder="Your full name"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-700 mb-1.5 block">Email <span class="text-red-500">*</span></label>
              <input type="email" name="email" x-model="email" placeholder="you@example.com"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition" />
            </div>
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium text-gray-700 mb-1.5 block">Phone</label>
              <input type="tel" name="phone" placeholder="+91 98765 43210"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition" />
            </div>
            <div>
              <label class="text-sm font-medium text-gray-700 mb-1.5 block">Subject</label>
              <select name="subject"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                <option value="">Select a subject…</option>
                <option>Job Query</option>
                <option>Training Enrollment</option>
                <option>Technical Issue</option>
                <option>Account / Login</option>
                <option>Government Scheme</option>
                <option>Other</option>
              </select>
            </div>
          </div>
          <div>
            <label class="text-sm font-medium text-gray-700 mb-1.5 block">Message <span class="text-red-500">*</span></label>
            <textarea name="message" rows="5" placeholder="Describe your query in detail…"
              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 resize-none transition"></textarea>
          </div>
          <button type="submit"
            class="flex items-center gap-2 bg-primary-700 hover:bg-primary-800 text-white font-semibold px-7 py-3 rounded-xl transition-colors shadow-lg shadow-primary-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            Send Message
          </button>
        </form>
      </div>

      <div x-show="submitted" x-cloak class="bg-white rounded-2xl border border-gray-100 shadow-sm p-14 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
          <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Message Sent!</h2>
        <p class="text-gray-500 text-sm mb-1">We've received your message.</p>
        <p class="text-gray-500 text-sm">Our team will reply to <span class="font-semibold text-gray-700" x-text="email || 'your email'"></span> within 2 business days.</p>
        <button @click="submitted = false; email = ''"
          class="mt-7 border border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
          Send Another Message
        </button>
      </div>

    </div>
  </section>

  {{-- ── FAQ ───────────────────────────────────────────────────────────── --}}
  <section class="bg-gray-50 py-16 px-6">
    <div class="max-w-screen-xl mx-auto">
      <div class="text-center mb-10">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Frequently Asked Questions</h2>
        <p class="text-gray-500 text-sm">Quick answers to common queries</p>
      </div>
      <div class="grid md:grid-cols-2 gap-5 max-w-4xl mx-auto">
        @foreach([
          ['q'=>'How do I register on PGRKAM?', 'a'=>'Click the Register button, fill in your details and verify your email to activate your free account.'],
          ['q'=>'Is this portal free to use?',   'a'=>'Yes, PGRKAM is 100% free for all Punjab residents — job seekers and employers alike.'],
          ['q'=>'How can I apply for a job?',    'a'=>'Browse the Jobs section, click on a listing and hit "Apply Now". Track your applications under My Applications.'],
          ['q'=>'What documents are needed?',    'a'=>'Aadhaar card, educational certificates, and a recent passport-size photograph are commonly required.'],
        ] as $faq)
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
          <p class="font-semibold text-gray-900 text-sm mb-2 flex items-start gap-2">
            <span class="w-5 h-5 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">Q</span>
            {{ $faq['q'] }}
          </p>
          <p class="text-gray-500 text-sm leading-relaxed pl-7">{{ $faq['a'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ── CTA Banner ────────────────────────────────────────────────────── --}}
  <section class="bg-gradient-to-r from-primary-700 to-primary-900 py-14 px-6 text-center">
    <h2 class="text-2xl font-extrabold text-white mb-2">Still need help?</h2>
    <p class="text-white/70 mb-6 text-sm">Visit your nearest District Employment Office or call our toll-free number.</p>
    <a href="tel:18001800000"
      class="inline-flex items-center gap-2 bg-white text-primary-800 font-bold px-7 py-3 rounded-xl hover:bg-gray-100 transition-colors shadow-lg text-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
      Call 18001800000 (Free)
    </a>
  </section>

</div>
@endsection
