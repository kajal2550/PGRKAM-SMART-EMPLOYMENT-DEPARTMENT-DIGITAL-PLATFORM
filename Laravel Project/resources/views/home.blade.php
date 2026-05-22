@extends('layouts.app')
@section('title', 'PGRKAM – Punjab Employment Portal')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-[88vh] flex items-center overflow-hidden"
         style="background-image:url('https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
  <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
  <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
  <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-primary-400/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

  <div class="relative z-10 max-w-screen-xl mx-auto px-6 py-24 text-center w-full">
    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white/90 text-sm font-medium mb-6 backdrop-blur-sm">
      <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
      Punjab Government Employment Portal
    </span>

    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
      Find Your Path to <br/>
      <span class="text-blue-300">Employment Success</span>
    </h1>
    <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
      PGRKAM connects Punjab's workforce with government jobs, skill training, career counselling, and resume building.
    </p>

    <form action="{{ route('jobs.index') }}" method="GET" class="max-w-2xl mx-auto mb-8">
      <div class="flex gap-2 p-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl">
        <svg class="w-5 h-5 text-white/60 self-center ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" placeholder="Search jobs, training programs, services..."
               class="flex-1 px-3 py-2.5 bg-transparent text-white placeholder-white/60 focus:outline-none text-sm" />
        <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow">
          Search
        </button>
      </div>
    </form>

    <div class="flex flex-wrap justify-center gap-3">
      @auth
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow-lg active:scale-95">
          Go to Dashboard
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      @else
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow-lg active:scale-95">
          Get Started
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      @endauth
      <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow-lg active:scale-95">
        Browse Services
      </a>
    </div>
  </div>
</section>

{{-- Stats Strip --}}
<section class="bg-primary-800 py-10">
  <div class="max-w-screen-xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
    <div>
      <div class="text-3xl font-extrabold text-white">{{ number_format($stats['jobs']) }}+</div>
      <div class="text-primary-300 text-sm mt-1">Active Jobs</div>
    </div>
    <div>
      <div class="text-3xl font-extrabold text-white">{{ number_format($stats['trainings']) }}+</div>
      <div class="text-primary-300 text-sm mt-1">Training Programs</div>
    </div>
    <div>
      <div class="text-3xl font-extrabold text-white">{{ number_format($stats['users']) }}+</div>
      <div class="text-primary-300 text-sm mt-1">Registered Users</div>
    </div>
    <div>
      <div class="text-3xl font-extrabold text-white">22</div>
      <div class="text-primary-300 text-sm mt-1">Districts Covered</div>
    </div>
  </div>
</section>

{{-- Visual Showcase --}}
<section class="py-20 bg-white">
  <div class="max-w-screen-xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    <div class="relative">
      <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=700&q=80&auto=format&fit=crop"
           alt="Employment" class="rounded-2xl shadow-xl w-full object-cover aspect-[4/3]" />
      <span class="absolute bottom-4 left-4 inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm text-green-700 font-semibold text-xs px-3 py-1.5 rounded-full shadow">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Govt. of Punjab Verified
      </span>
    </div>
    <div>
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold mb-4">
        Why PGRKAM?
      </span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
        Punjab's Most Trusted<br/>
        <span class="text-gradient">Employment Platform</span>
      </h2>
      <p class="text-gray-500 mb-6 leading-relaxed text-sm">From finding your first job to advancing your career — PGRKAM is your complete employment companion backed by the Government of Punjab.</p>
      <ul class="space-y-3 mb-8">
        @foreach(['Direct access to government and private job listings', 'Govt-sponsored skill training and certification programs', 'AI-powered career counselling and guidance', 'Free professional resume builder with templates'] as $feat)
        <li class="flex items-start gap-3 text-gray-600 text-sm">
          <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ $feat }}
        </li>
        @endforeach
      </ul>
      <a href="{{ route('services.index') }}" class="btn-primary">
        Explore All Services
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>
  </div>
</section>

{{-- Services Section --}}
<section class="py-20 bg-gray-50">
  <div class="max-w-screen-xl mx-auto px-6">
    <div class="text-center mb-12">
      <span class="inline-block px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold mb-3">Our Services</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Everything You Need,<br/>In One Place</h2>
      <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm">Comprehensive employment services designed to help Punjab's workforce succeed.</p>
    </div>

    @php
    $svcs = [
      ['icon'=>'🏛️','title'=>'Government Jobs','desc'=>'Access thousands of state and central government job listings with direct application links.','img'=>'photo-1529119368496-2dfda6ec2804','link'=>'/jobs'],
      ['icon'=>'🏢','title'=>'Private Jobs','desc'=>'Explore private sector opportunities across IT, manufacturing, healthcare and more.','img'=>'photo-1497366216548-37526070297c','link'=>'/jobs?type=private'],
      ['icon'=>'🎓','title'=>'Skill Training','desc'=>'Government-sponsored training programs to upskill Punjab\'s workforce for modern careers.','img'=>'photo-1509062522246-3755977927d7','link'=>'/training'],
      ['icon'=>'📄','title'=>'Resume Builder','desc'=>'Create a professional, ATS-friendly resume in minutes using our smart builder.','img'=>'photo-1517245386807-bb43f82c33c4','link'=>'/resume'],
      ['icon'=>'💬','title'=>'Career Counselling','desc'=>'One-on-one sessions with certified career advisors to guide your professional journey.','img'=>'photo-1521737604893-d14cc237f11d','link'=>'/counselling'],
      ['icon'=>'📋','title'=>'Employment Schemes','desc'=>'Discover state-run employment schemes, subsidies, and support programs for job seekers.','img'=>'photo-1573164713988-8665fc963095','link'=>'/services'],
    ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($svcs as $svc)
      <a href="{{ url($svc['link']) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group block">
        <div class="relative h-44 overflow-hidden">
          <img src="https://images.unsplash.com/{{ $svc['img'] }}?w=600&q=80&auto=format&fit=crop"
               alt="{{ $svc['title'] }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
          <span class="absolute top-3 left-3 text-2xl">{{ $svc['icon'] }}</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-1 group-hover:text-primary-700 transition">{{ $svc['title'] }}</h3>
          <p class="text-sm text-gray-500 leading-relaxed">{{ $svc['desc'] }}</p>
          <span class="inline-flex items-center gap-1 text-primary-600 text-xs font-semibold mt-3">
            Learn more
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </span>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- AI Guidance Section --}}
<section class="py-20 bg-gradient-to-br from-primary-50 to-blue-50">
  <div class="max-w-screen-xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    <div>
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold mb-4">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
        AI Guidance
      </span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
        Smart Guidance at<br/>Your Fingertips
      </h2>
      <p class="text-gray-500 mb-6 leading-relaxed text-sm">Get personalized career advice — no appointment needed.</p>
      <ul class="space-y-3">
        @foreach(['Instant answers to your employment questions','Personalized job recommendations based on your profile','Resume tips and interview preparation guidance','Career path planning for long-term success'] as $tip)
        <li class="flex items-start gap-3 text-gray-600 text-sm">
          <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ $tip }}
        </li>
        @endforeach
      </ul>
      <a href="{{ route('counselling') }}" class="btn-primary mt-8 inline-flex">
        Try Career Counselling
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>

    <div>
      <div class="glass-card p-6 max-w-sm mx-auto">
        <div class="flex items-center gap-3 pb-4 border-b border-gray-100 mb-4">
          <div class="w-9 h-9 bg-gradient-to-br from-primary-600 to-blue-400 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-800">PGRKAM Assistant</p>
            <span class="text-xs text-green-500 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>Online</span>
          </div>
        </div>
        <div class="space-y-3">
          <div class="flex justify-start">
            <div class="chat-bubble-bot">
              <p class="text-sm">Hello! I'm your PGRKAM assistant. How can I help you today?</p>
            </div>
          </div>
          <div class="flex justify-end">
            <div class="chat-bubble-user">
              <p class="text-sm">I need a government job in Chandigarh</p>
            </div>
          </div>
          <div class="flex justify-start">
            <div class="chat-bubble-bot">
              <p class="text-sm">Great! There are <strong>47 active government vacancies</strong> in Chandigarh right now. Shall I show you the top matches?</p>
            </div>
          </div>
        </div>
        <div class="mt-4 flex gap-2">
          <input type="text" placeholder="Type your question..." class="flex-1 text-sm px-3 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white" readonly />
          <a href="{{ route('counselling') }}" class="px-3 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition flex items-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CTA Banner --}}
<section class="bg-gradient-primary py-16">
  <div class="max-w-screen-xl mx-auto px-6 text-center">
    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Ready to Find Your Opportunity?</h2>
    <p class="text-white/80 mb-8 text-lg">Join thousands of Punjab citizens already using PGRKAM.</p>
    <div class="flex flex-wrap justify-center gap-4">
      @guest
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-primary-700 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
          Register Free
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      @else
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-primary-700 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">
          Go to Dashboard
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      @endguest
      <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white/10 border border-white/30 text-white rounded-xl font-bold hover:bg-white/20 transition">
        Browse Jobs
      </a>
    </div>
  </div>
</section>

@endsection
