@extends('layouts.app')
@section('title', 'PGRKAM – Punjab Employment Portal')
@section('content')

{{-- Hero --}}
<section class="relative min-h-[88vh] flex items-center overflow-hidden"
  style="background-image:url('https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
  <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
  <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
  <div class="relative z-10 max-w-screen-xl mx-auto px-6 py-24 text-center w-full">
    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white/90 text-sm font-medium mb-6 backdrop-blur-sm">
      <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
      Punjab Government Employment Portal
    </span>
    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
      Find Your Path to <br/><span class="text-blue-300">Employment Success</span>
    </h1>
    <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed">
      PGRKAM connects Punjab's workforce with government jobs, skill training, career counselling, and resume building.
    </p>
    <form action="{{ route('jobs.index') }}" method="GET" class="max-w-2xl mx-auto mb-8">
      <div class="flex gap-2 p-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl">
        <svg class="w-5 h-5 text-white/60 self-center ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" placeholder="Search jobs, training programs, services..." class="flex-1 px-3 py-2.5 bg-transparent text-white placeholder-white/60 focus:outline-none text-sm" />
        <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow">Search</button>
      </div>
    </form>
    <div class="flex flex-wrap justify-center gap-3">
      @auth
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow-lg">Go to Dashboard <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
      @else
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition shadow-lg">Get Started <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
      @endauth
      <a href="#guide" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 border border-white/20 text-white rounded-xl font-semibold text-sm hover:bg-white/20 transition">
        🤖 Smart Guide
      </a>
    </div>
  </div>
</section>

{{-- Stats --}}
<section class="bg-primary-800 py-10">
  <div class="max-w-screen-xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
    <div><div class="text-3xl font-extrabold text-white">{{ number_format($stats['jobs']) }}+</div><div class="text-primary-300 text-sm mt-1">Active Jobs</div></div>
    <div><div class="text-3xl font-extrabold text-white">{{ number_format($stats['trainings']) }}+</div><div class="text-primary-300 text-sm mt-1">Training Programs</div></div>
    <div><div class="text-3xl font-extrabold text-white">{{ number_format($stats['users']) }}+</div><div class="text-primary-300 text-sm mt-1">Registered Users</div></div>
    <div><div class="text-3xl font-extrabold text-white">22</div><div class="text-primary-300 text-sm mt-1">Districts Covered</div></div>
  </div>
</section>

{{-- Services --}}
<section class="py-20 bg-gray-50">
  <div class="max-w-screen-xl mx-auto px-6">
    <div class="text-center mb-12">
      <span class="inline-block px-3 py-1 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold mb-3">Our Services</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Everything You Need, In One Place</h2>
      <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm">Comprehensive employment services designed to help Punjab's workforce succeed.</p>
    </div>
    @php
    $svcs = [
      ['icon'=>'🏛️','title'=>'Government Jobs','desc'=>'Access thousands of state and central government job listings.','img'=>'photo-1529119368496-2dfda6ec2804','link'=>'/jobs'],
      ['icon'=>'🏢','title'=>'Private Jobs','desc'=>'Explore private sector opportunities across IT, manufacturing and more.','img'=>'photo-1497366216548-37526070297c','link'=>'/jobs?type=private'],
      ['icon'=>'🎓','title'=>'Skill Training','desc'=>'Government-sponsored training programs to upskill Punjab\'s workforce.','img'=>'photo-1509062522246-3755977927d7','link'=>'/training'],
      ['icon'=>'📄','title'=>'Resume Builder','desc'=>'Create a professional, ATS-friendly resume in minutes.','img'=>'photo-1517245386807-bb43f82c33c4','link'=>'/resume'],
      ['icon'=>'💬','title'=>'Career Counselling','desc'=>'One-on-one sessions with certified career advisors.','img'=>'photo-1521737604893-d14cc237f11d','link'=>'/counselling'],
      ['icon'=>'📋','title'=>'Employment Schemes','desc'=>'Discover state-run employment schemes and support programs.','img'=>'photo-1573164713988-8665fc963095','link'=>'/services'],
    ];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($svcs as $svc)
      <a href="{{ url($svc['link']) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group block">
        <div class="relative h-44 overflow-hidden">
          <img src="https://images.unsplash.com/{{ $svc['img'] }}?w=600&q=80&auto=format&fit=crop" alt="{{ $svc['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
          <span class="absolute top-3 left-3 text-2xl">{{ $svc['icon'] }}</span>
        </div>
        <div class="p-5">
          <h3 class="font-bold text-gray-900 mb-1 group-hover:text-primary-700 transition">{{ $svc['title'] }}</h3>
          <p class="text-sm text-gray-500 leading-relaxed">{{ $svc['desc'] }}</p>
          <span class="inline-flex items-center gap-1 text-primary-600 text-xs font-semibold mt-3">Learn more <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="bg-gradient-primary py-16">
  <div class="max-w-screen-xl mx-auto px-6 text-center">
    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Ready to Find Your Opportunity?</h2>
    <p class="text-white/80 mb-8 text-lg">Join thousands of Punjab citizens already using PGRKAM.</p>
    <div class="flex flex-wrap justify-center gap-4">
      @guest
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-primary-700 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">Register Free <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
      @else
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-primary-700 rounded-xl font-bold hover:bg-blue-50 transition shadow-lg">Go to Dashboard <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
      @endguest
      <a href="#guide" class="inline-flex items-center gap-2 px-8 py-3 bg-white/10 border border-white/30 text-white rounded-xl font-bold hover:bg-white/20 transition">🤖 Try Smart Guide</a>
    </div>
  </div>
</section>

{{-- ═══════════ SMART GUIDANCE SYSTEM — HEART OF THE PROJECT ═══════════ --}}
<section id="guide" style="background:linear-gradient(135deg,#1e40af 0%,#1d4ed8 50%,#1e3a8a 100%);position:relative;overflow:hidden;">
  <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);border-radius:50%;pointer-events:none;"></div>
  <div style="position:absolute;bottom:-80px;left:-80px;width:350px;height:350px;background:radial-gradient(circle,rgba(255,255,255,0.08) 0%,transparent 70%);border-radius:50%;pointer-events:none;"></div>

  <div class="max-w-screen-xl mx-auto px-6 py-24 relative" style="z-index:1;">

    {{-- Header --}}
    <div class="text-center mb-16">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border mb-6" style="background:rgba(255,255,255,0.25);border-color:rgba(255,255,255,0.5);">
        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
        <span class="text-white text-xs font-bold uppercase tracking-widest">Core Feature · Smart Guidance System</span>
      </div>
      <h2 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight mb-4">
        Your Personal<br/>
        <span style="background:linear-gradient(90deg,#1e3a5f,#0f172a,#1e3a5f);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Employment Navigator</span>
      </h2>

      <div class="flex flex-wrap justify-center gap-3 mt-10">
        @foreach(['Instant Module Detection','Keyword-Based Routing','Zero Learning Curve','Available 24/7'] as $f)
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold" style="background:#ffffff;color:#1d4ed8;border:1px solid rgba(255,255,255,0.8);">
          <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
          {{ $f }}
        </span>
        @endforeach
      </div>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start mt-10">

      {{-- LEFT: Quick Buttons --}}
      <div class="lg:col-span-2 space-y-3">
        <p class="text-white text-xs font-bold uppercase tracking-widest mb-4 flex items-center gap-2 opacity-80">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          Quick Start — Click to Navigate
        </p>
        @foreach([
          ['label'=>'I need a Government Job',  'sub'=>'Browse state & central vacancies', 'q'=>'government job',    'icon'=>'🏛️', 'grad'=>'from-blue-600 to-blue-700'],
          ['label'=>'I need a Private Job',     'sub'=>'Explore corporate opportunities',  'q'=>'private company',   'icon'=>'🏢', 'grad'=>'from-indigo-600 to-indigo-700'],
          ['label'=>'I want to Learn a Skill',  'sub'=>'Govt-sponsored training programs', 'q'=>'skill training',    'icon'=>'🎓', 'grad'=>'from-emerald-600 to-emerald-700'],
          ['label'=>'I want to Build Resume',   'sub'=>'Create professional CV instantly', 'q'=>'resume cv',         'icon'=>'📄', 'grad'=>'from-orange-500 to-orange-600'],
          ['label'=>'I need Career Advice',     'sub'=>'Free certified counselling',       'q'=>'career counselling','icon'=>'💬', 'grad'=>'from-purple-600 to-purple-700'],
          ['label'=>'Show me Govt Schemes',     'sub'=>'Employment subsidies & support',   'q'=>'employment scheme', 'icon'=>'📋', 'grad'=>'from-pink-600 to-pink-700'],
        ] as $btn)
        <button onclick="sendGuideQuery('{{ $btn['q'] }}')"
          class="w-full group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-200 hover:-translate-y-0.5 text-left"
          style="background:#ffffff;border:1px solid rgba(255,255,255,0.3);box-shadow:0 2px 8px rgba(0,0,0,0.1);"
          onmouseover="this.style.background='#f0f9ff';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)'"
          onmouseout="this.style.background='#ffffff';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
          <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $btn['grad'] }} flex items-center justify-center text-xl flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform">{{ $btn['icon'] }}</div>
          <div class="flex-1 min-w-0">
            <p class="text-gray-900 font-semibold text-sm leading-tight">{{ $btn['label'] }}</p>
            <p class="text-gray-500 text-xs mt-0.5">{{ $btn['sub'] }}</p>
          </div>
          <svg class="w-4 h-4 text-gray-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
        @endforeach
      </div>

      {{-- RIGHT: Live Chat --}}
      <div class="lg:col-span-3">
        <p class="text-white text-xs font-bold uppercase tracking-widest mb-4 flex items-center gap-2 opacity-80">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          Or Type Your Query Below
        </p>
        <div class="rounded-3xl overflow-hidden shadow-2xl" style="border:1px solid rgba(255,255,255,0.1);">
          <div style="background:linear-gradient(135deg,#4f46e5,#2563eb);" class="px-5 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="relative">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background:rgba(255,255,255,0.2);">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-400 rounded-full border-2 border-indigo-600 animate-pulse"></span>
              </div>
              <div>
                <p class="text-white font-bold text-sm">PGRKAM Smart Guide</p>
                <p class="text-indigo-200 text-xs">Keyword intelligence · Always free</p>
              </div>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="w-2.5 h-2.5 rounded-full bg-red-400 opacity-70"></span>
              <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-70"></span>
              <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
            </div>
          </div>
          <div id="guide-messages" class="p-5 space-y-4 overflow-y-auto" style="min-height:280px;max-height:380px;background:#ffffff;">
            <div class="flex gap-3">
              <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-base" style="background:#e0f2fe;border:1px solid #bae6fd;">🤖</div>
              <div class="rounded-2xl rounded-tl-none px-4 py-3 max-w-sm" style="background:#f0f9ff;border:1px solid #bae6fd;">
                <p class="text-gray-800 text-sm">👋 <strong class="text-gray-900">Hello!</strong> I'm your PGRKAM Smart Guide.</p>
                <p class="text-gray-600 text-sm mt-1">Tell me what you need — a <span class="text-blue-600 font-medium">job</span>, <span class="text-green-600 font-medium">training</span>, <span class="text-orange-500 font-medium">resume</span>, or <span class="text-purple-600 font-medium">career advice</span>!</p>
              </div>
            </div>
            <div class="flex gap-3">
              <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-base" style="background:#e0f2fe;border:1px solid #bae6fd;">🤖</div>
              <div class="rounded-2xl rounded-tl-none px-4 py-3 max-w-sm" style="background:#f0f9ff;border:1px solid #bae6fd;">
                <p class="text-gray-500 text-xs mb-2 font-semibold uppercase tracking-wide">Try asking:</p>
                <div class="space-y-1.5">
                  @foreach(['"I need a sarkari naukri"','"Resume banana hai"','"IT training chahiye"','"Career guidance leni hai"'] as $ex)
                  <button onclick="sendGuideQuery({{ json_encode(trim($ex, '"')) }})"
                    class="block w-full text-left px-3 py-1.5 rounded-xl text-xs font-medium transition"
                    style="background:#dbeafe;color:#1d4ed8;border:1px solid #bfdbfe;"
                    onmouseover="this.style.background='#bfdbfe'"
                    onmouseout="this.style.background='#dbeafe'">{{ $ex }}</button>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 py-4" style="background:#f8fafc;border-top:1px solid #e2e8f0;">
            <div class="flex gap-2">
              <input type="text" id="guide-input" placeholder="e.g. mujhe government job chahiye Ludhiana mein..."
                class="flex-1 rounded-xl px-4 py-3 text-sm focus:outline-none transition text-gray-800 placeholder-gray-400"
                style="background:#ffffff;border:1px solid #cbd5e1;"
                onkeydown="if(event.key==='Enter') sendGuideQuery()"
                onfocus="this.style.borderColor='#0ea5e9'"
                onblur="this.style.borderColor='#cbd5e1'" />
              <button onclick="sendGuideQuery()" class="px-5 py-3 rounded-xl font-bold text-sm text-white flex items-center gap-2 flex-shrink-0 hover:opacity-90 transition" style="background:linear-gradient(135deg,#0ea5e9,#2563eb);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Send
              </button>
            </div>
            <p class="text-gray-400 text-[11px] mt-2 text-center">Works in English, Hindi & Punjabi keywords</p>
          </div>
        </div>
        <div class="mt-5 grid grid-cols-3 gap-3">
          @foreach([['✍️','Type your need','In any language'],['🔍','Guide detects','Smart keyword match'],['🚀','Go directly','One click to module']] as $s)
          <div class="text-center p-3 rounded-2xl" style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.35);">
            <div class="text-2xl mb-1">{{ $s[0] }}</div>
            <p class="text-white text-xs font-bold">{{ $s[1] }}</p>
            <p class="text-sky-100 text-[11px] mt-0.5">{{ $s[2] }}</p>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function sendGuideQuery(preset) {
  const input = document.getElementById('guide-input');
  const msg   = preset || input.value.trim();
  if (!msg) return;
  const box = document.getElementById('guide-messages');
  box.innerHTML += `<div class="flex justify-end gap-3"><div class="rounded-2xl rounded-tr-none px-4 py-3 max-w-xs shadow-sm" style="background:linear-gradient(135deg,#4f46e5,#2563eb);"><p class="text-white text-sm">${msg}</p></div><div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-sm font-bold" style="background:rgba(99,102,241,0.3);color:#a5b4fc;">U</div></div>`;
  box.innerHTML += `<div id="typing" class="flex gap-3"><div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-base" style="background:rgba(99,102,241,0.2);border:1px solid rgba(99,102,241,0.3);">🤖</div><div class="rounded-2xl rounded-tl-none px-4 py-3" style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);"><div class="flex gap-1.5 items-center h-5"><span class="w-2 h-2 rounded-full animate-bounce" style="background:#818cf8;animation-delay:0ms"></span><span class="w-2 h-2 rounded-full animate-bounce" style="background:#818cf8;animation-delay:150ms"></span><span class="w-2 h-2 rounded-full animate-bounce" style="background:#818cf8;animation-delay:300ms"></span></div></div></div>`;
  box.scrollTop = box.scrollHeight;
  input.value = '';
  fetch('/api/chat-guide', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
    body: JSON.stringify({ message: msg })
  })
  .then(r => r.json())
  .then(data => {
    document.getElementById('typing')?.remove();
    let html = `<div class="flex gap-3"><div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-base" style="background:#e0f2fe;border:1px solid #bae6fd;">🤖</div><div class="rounded-2xl rounded-tl-none px-4 py-3 max-w-sm" style="background:#f0f9ff;border:1px solid #bae6fd;"><p class="text-gray-700 text-sm mb-3">${data.reply}</p>`;
    if (data.suggestions && data.suggestions.length > 0) {
      data.suggestions.forEach(s => {
        html += `<a href="${s.path}" class="flex items-center gap-3 mt-2 px-3 py-2.5 rounded-xl transition group" style="background:#dbeafe;border:1px solid #bfdbfe;" onmouseover="this.style.background='#bfdbfe'" onmouseout="this.style.background='#dbeafe'"><span class="text-xl">${s.icon}</span><div class="flex-1"><p class="text-blue-700 font-bold text-xs">${s.module}</p><p class="text-gray-500 text-[11px] mt-0.5">${s.description}</p></div><svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>`;
      });
    }
    html += `</div></div>`;
    box.innerHTML += html;
    box.scrollTop = box.scrollHeight;
  })
  .catch(() => {
    document.getElementById('typing')?.remove();
    box.innerHTML += `<div class="flex gap-3"><div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background:rgba(239,68,68,0.2);">⚠️</div><div class="rounded-2xl rounded-tl-none px-4 py-3" style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);"><p class="text-red-400 text-sm">Something went wrong. Please try again.</p></div></div>`;
    box.scrollTop = box.scrollHeight;
  });
}
</script>

@endsection
