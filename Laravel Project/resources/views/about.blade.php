@extends('layouts.app')
@section('title', 'About Us – PGRKAM')

@section('content')
<div class="bg-white">

  {{-- ── Hero ──────────────────────────────────────────────────────────── --}}
  <section class="relative py-24 px-6 overflow-hidden"
    style="background-image:url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/92 via-primary-800/88 to-primary-700/82"></div>
    <div class="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-56 h-56 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center">
      <span class="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6 tracking-wide uppercase">
        Government of Punjab Initiative
      </span>
      <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-5">
        About <span class="text-yellow-300">PGRKAM</span>
      </h1>
      <p class="text-white/75 text-lg max-w-2xl mx-auto leading-relaxed">
        Punjab Government Rozgar Kendra Ate Mukhya Mantri Rozgar Yojana (PGRKAM) is the
        state's official digital employment platform — connecting youth with jobs, training
        and government schemes since 2018.
      </p>
    </div>
  </section>

  {{-- ── Live Stats ────────────────────────────────────────────────────── --}}
  <section class="max-w-screen-xl mx-auto px-6 -mt-10 relative z-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @php
        $liveStats = [
          ['v' => ($stats['users'] ?? 0).'+',        'l' => 'Registered Users',   'color' => 'bg-blue-500',   'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
          ['v' => ($stats['jobs'] ?? 0).'+',         'l' => 'Jobs Listed',        'color' => 'bg-green-500',  'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
          ['v' => ($stats['trainings'] ?? 0).'+',    'l' => 'Training Programs',  'color' => 'bg-purple-500', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
          ['v' => ($stats['applications'] ?? 0).'+', 'l' => 'Applications Filed', 'color' => 'bg-orange-500', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
        ];
      @endphp
      @foreach($liveStats as $s)
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 {{ $s['color'] }} rounded-xl flex items-center justify-center flex-shrink-0">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
        </div>
        <div>
          <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $s['v'] }}</p>
          <p class="text-xs text-gray-500 mt-0.5">{{ $s['l'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  {{-- ── Mission & Vision ──────────────────────────────────────────────── --}}
  <section class="max-w-screen-xl mx-auto px-6 py-20">
    <div class="relative rounded-3xl overflow-hidden mb-12 h-64">
      <img src="https://images.unsplash.com/photo-1577495508326-19a1b3cf65b7?w=1400&q=80&auto=format&fit=crop"
           alt="Team collaboration" class="w-full h-full object-cover" loading="lazy" />
      <div class="absolute inset-0 bg-gradient-to-r from-primary-900/80 via-primary-800/60 to-transparent"></div>
      <div class="absolute inset-0 flex flex-col justify-center px-10">
        <h2 class="text-3xl font-extrabold text-white mb-3">Empowering Punjab's Youth</h2>
        <p class="text-white/80 text-base max-w-lg">Connecting 12 lakh+ job seekers with opportunities, training and government schemes since 2018.</p>
      </div>
    </div>
    <div class="grid md:grid-cols-2 gap-8">
      {{-- Mission --}}
      <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-8">
        <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-200">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-3">Our Mission</h2>
        <p class="text-gray-600 leading-relaxed mb-5">
          To bridge the gap between job seekers and employment opportunities in Punjab through
          a technology-driven, transparent and accessible digital platform that reaches every
          corner of the state.
        </p>
        <ul class="space-y-2">
          @foreach(['Reduce youth unemployment in Punjab','Transparent job matching process','Free access for all citizens'] as $item)
          <li class="flex items-center gap-2 text-sm text-blue-800">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $item }}
          </li>
          @endforeach
        </ul>
      </div>
      {{-- Vision --}}
      <div class="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-8">
        <div class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-200">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-3">Our Vision</h2>
        <p class="text-gray-600 leading-relaxed mb-5">
          A fully employed Punjab where every youth has access to quality livelihood
          opportunities, skill training and career guidance — regardless of their
          background or location.
        </p>
        <ul class="space-y-2">
          @foreach(['Employment for every educated youth','Skill Punjab — 1 lakh trained annually','Every district with employment kiosk'] as $item)
          <li class="flex items-center gap-2 text-sm text-green-800">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $item }}
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>

  {{-- ── What We Offer ─────────────────────────────────────────────────── --}}
  <section class="bg-gray-50 py-20 px-6">
    <div class="max-w-screen-xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-3">What We Offer</h2>
        <p class="text-gray-500 max-w-xl mx-auto">PGRKAM brings all employment-related services under one roof — completely free for all Punjab residents.</p>
      </div>
      @php
        $features = [
          ['color'=>'bg-blue-100 text-blue-700',   'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title'=>'Job Portal',        'desc'=>'Access thousands of government & private sector jobs across Punjab with one-click applications.'],
          ['color'=>'bg-purple-100 text-purple-700','icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title'=>'Skill Training',     'desc'=>'Enroll in free & subsidized skill development programs aligned with industry demands.'],
          ['color'=>'bg-yellow-100 text-yellow-700','icon'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'title'=>'Govt. Schemes',      'desc'=>'Explore Punjab government employment schemes, subsidies and self-employment loans.'],
          ['color'=>'bg-green-100 text-green-700',  'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title'=>'Career Counselling', 'desc'=>'Book 1-on-1 career guidance sessions with certified employment counsellors.'],
          ['color'=>'bg-red-100 text-red-700',      'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title'=>'Resume Builder',     'desc'=>'Build a professional resume in minutes with our guided resume creation tool.'],
          ['color'=>'bg-pink-100 text-pink-700',    'icon'=>'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'title'=>'Job Alerts',         'desc'=>'Get instant alerts for jobs matching your profile, skills and preferred district.'],
        ];
      @endphp
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($features as $f)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg transition-shadow">
          <div class="w-12 h-12 {{ $f['color'] }} rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/></svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $f['title'] }}</h3>
          <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ── Journey / Timeline ────────────────────────────────────────────── --}}
  <section class="max-w-screen-xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Our Journey</h2>
      <p class="text-gray-500">Milestones that shaped Punjab's employment landscape</p>
    </div>
    @php
      $timeline = [
        ['year'=>'2018','title'=>'Portal Launched',       'desc'=>'PGRKAM portal established by Punjab Government to digitize employment services.'],
        ['year'=>'2019','title'=>'1 Lakh Registrations',  'desc'=>'Crossed 1 lakh registered job seekers within the first year of operations.'],
        ['year'=>'2021','title'=>'Mobile-First Redesign',  'desc'=>'Complete redesign for mobile users; training enrollment feature launched.'],
        ['year'=>'2023','title'=>'AI-Powered Matching',    'desc'=>'Smart job matching algorithm introduced to connect seekers with relevant openings.'],
        ['year'=>'2025','title'=>'Pan-Punjab Expansion',   'desc'=>'Services expanded to all 23 districts with dedicated district employment kiosks.'],
      ];
    @endphp
    <div class="relative">
      <div class="absolute left-1/2 -translate-x-0.5 top-0 bottom-0 w-0.5 bg-primary-200 hidden md:block"></div>
      <div class="space-y-8">
        @foreach($timeline as $i => $step)
        <div class="flex flex-col md:flex-row gap-6 items-center {{ $i % 2 !== 0 ? 'md:flex-row-reverse' : '' }}">
          <div class="md:w-5/12 {{ $i % 2 === 0 ? 'md:text-right' : 'md:text-left' }}">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow">
              <p class="text-sm font-semibold text-primary-600 mb-1">{{ $step['year'] }}</p>
              <p class="font-bold text-gray-900 mb-1">{{ $step['title'] }}</p>
              <p class="text-sm text-gray-500">{{ $step['desc'] }}</p>
            </div>
          </div>
          <div class="relative z-10 w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center shadow-lg shadow-primary-200 flex-shrink-0 hidden md:flex">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="md:w-5/12"></div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ── Leadership ────────────────────────────────────────────────────── --}}
  <section class="bg-gray-50 py-20 px-6">
    <div class="max-w-screen-xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Our Leadership</h2>
        <p class="text-gray-500">The team driving Punjab's employment transformation</p>
      </div>
      <div class="grid sm:grid-cols-3 gap-6">
        @foreach([
          ['name'=>'Sh. Amritpal Singh IAS','role'=>'Secretary, Employment Dept.','dept'=>'Govt. of Punjab','photo'=>'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80&auto=format&fit=crop&crop=face'],
          ['name'=>'Ms. Simranjit Kaur IAS','role'=>'Director, Employment',       'dept'=>'PGRKAM Portal', 'photo'=>'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80&auto=format&fit=crop&crop=face'],
          ['name'=>'Mr. Kulwinder Singh',   'role'=>'IT Head, PGRKAM Portal',     'dept'=>'Technology Wing','photo'=>'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=200&q=80&auto=format&fit=crop&crop=face'],
        ] as $leader)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-lg transition-shadow">
          <div class="w-20 h-20 rounded-full mx-auto mb-4 shadow-lg overflow-hidden ring-4 ring-primary-100">
            <img src="{{ $leader['photo'] }}" alt="{{ $leader['name'] }}" class="w-full h-full object-cover" loading="lazy" />
          </div>
          <p class="font-extrabold text-gray-900">{{ $leader['name'] }}</p>
          <p class="text-sm text-primary-600 font-medium mt-1">{{ $leader['role'] }}</p>
          <p class="text-xs text-gray-400 mt-0.5">{{ $leader['dept'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ── District Offices ──────────────────────────────────────────────── --}}
  <section class="max-w-screen-xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-extrabold text-gray-900 mb-3">District Offices</h2>
      <p class="text-gray-500">Visit your nearest PGRKAM employment office for in-person assistance</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
      @foreach([
        ['city'=>'Chandigarh (HQ)','addr'=>'SCO 189-191, Sector 34-A, Chandigarh',        'phone'=>'0172-2704933'],
        ['city'=>'Ludhiana',       'addr'=>'Employment Office, Ferozepur Road',            'phone'=>'0161-2440422'],
        ['city'=>'Amritsar',       'addr'=>'Employment Bhawan, Lawrence Road',             'phone'=>'0183-2501234'],
        ['city'=>'Jalandhar',      'addr'=>'District Employment Office, Nakodar Rd',       'phone'=>'0181-2235678'],
      ] as $office)
      <div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center mb-4">
          <svg class="w-4 h-4 text-primary-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="font-bold text-gray-900 text-sm mb-1">{{ $office['city'] }}</p>
        <p class="text-xs text-gray-500 mb-3 leading-relaxed">{{ $office['addr'] }}</p>
        <p class="flex items-center gap-1.5 text-xs text-primary-700 font-medium">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          {{ $office['phone'] }}
        </p>
      </div>
      @endforeach
    </div>
  </section>

  {{-- ── Contact CTA ───────────────────────────────────────────────────── --}}
  <section class="bg-gradient-to-r from-primary-700 to-primary-900 py-16 px-6">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-2xl font-extrabold text-white mb-3">Get In Touch</h2>
      <p class="text-white/70 mb-8">Have questions about our services? Our team is ready to help you 6 days a week.</p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="mailto:pgrkam@punjab.gov.in"
           class="flex items-center justify-center gap-2 bg-white text-primary-800 font-semibold px-6 py-3 rounded-xl hover:bg-gray-100 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          pgrkam@punjab.gov.in
        </a>
        <div class="flex items-center justify-center gap-2 bg-white/10 text-white font-semibold px-6 py-3 rounded-xl">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Mon–Sat, 9 AM – 5 PM
        </div>
      </div>
    </div>
  </section>

</div>
@endsection
