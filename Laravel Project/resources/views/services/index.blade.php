@extends('layouts.app')
@section('title', 'Services – PGRKAM')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-10">

  {{-- ── Hero ─────────────────────────────────────────────────── --}}
  <div class="rounded-3xl text-white px-8 py-14 text-center mb-14 relative overflow-hidden"
       style="background-image:url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-700/85 to-indigo-800/80"></div>
    <div class="absolute inset-0 opacity-5" style="background-image:radial-gradient(circle at 20% 50%, white 1px, transparent 1px),radial-gradient(circle at 80% 20%, white 1px, transparent 1px);background-size:40px 40px"></div>
    <div class="relative z-10">
      <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">Punjab Govt Employment Portal</span>
      <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 leading-tight">All Employment Services</h1>
      <p class="text-white/80 text-lg max-w-2xl mx-auto mb-8">
        PGRKAM brings government jobs, skill training, career counselling and welfare schemes — all under one roof for every citizen of Punjab.
      </p>
      <div class="flex flex-wrap justify-center gap-8">
        @foreach([['500+','Job Listings'],['15+','Training Programs'],['6','Welfare Schemes'],['Free','All Services']] as $s)
        <div class="text-center">
          <div class="text-3xl font-extrabold">{{ $s[0] }}</div>
          <div class="text-white/70 text-sm">{{ $s[1] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ── Service Cards ──────────────────────────────────────────── --}}
  <div class="mb-14">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-extrabold text-gray-900">Our Services</h2>
      <p class="text-gray-500 mt-2 max-w-xl mx-auto">Everything you need for your career — completely free for Punjab citizens.</p>
    </div>

    @php
    $services = [
      ['icon'=>'🏛️','color'=>'blue','path'=>'/jobs',
       'image'=>'photo-1529119368496-2dfda6ec2804',
       'title'=>'Government Jobs','tagline'=>'Sarkari Naukri — Punjab & Central Govt',
       'desc'=>'Access real-time government job notifications from Punjab Police, Revenue Dept., Health Dept., PSPCL, PPSC and all state departments.',
       'highlights'=>['25+ active vacancies','PPSC & PSSSB jobs','Updated daily','Direct apply'],
       'badge'=>'Most Popular','badgeCls'=>'bg-blue-100 text-blue-700',
       'borderCls'=>'bg-blue-50 border-blue-100','textCls'=>'text-blue-700','iconBg'=>'bg-blue-100'],
      ['icon'=>'🏢','color'=>'indigo','path'=>'/jobs?type=private',
       'image'=>'photo-1497366216548-37526070297c',
       'title'=>'Private Jobs','tagline'=>'Corporate & Industry Opportunities',
       'desc'=>'Explore private sector jobs from IT companies, manufacturing units, banks, hospitals and MNCs operating in Punjab.',
       'highlights'=>['IT & Software','Banking & Finance','Healthcare','Manufacturing'],
       'badge'=>'High Demand','badgeCls'=>'bg-indigo-100 text-indigo-700',
       'borderCls'=>'bg-indigo-50 border-indigo-100','textCls'=>'text-indigo-700','iconBg'=>'bg-indigo-100'],
      ['icon'=>'🎓','color'=>'green','path'=>'/training',
       'image'=>'photo-1509062522246-3755977927d7',
       'title'=>'Skill Training','tagline'=>'Free & Subsidised — Punjab Skill Mission',
       'desc'=>'Government-sponsored short-term and long-term skill development programs. Learn a trade, get certified and earn better.',
       'highlights'=>['100% free for BPL','Certificate on completion','Multiple batches','Stipend available'],
       'badge'=>'Free Programs','badgeCls'=>'bg-primary-100 text-primary-700',
       'borderCls'=>'bg-primary-50 border-primary-100','textCls'=>'text-primary-700','iconBg'=>'bg-primary-100'],
      ['icon'=>'📄','color'=>'orange','path'=>'/resume',
       'image'=>'photo-1517245386807-bb43f82c33c4',
       'title'=>'Resume Builder','tagline'=>'Professional CV in Minutes',
       'desc'=>'Create an ATS-friendly professional resume tailored for government and private job applications. Export as PDF instantly.',
       'highlights'=>['ATS-friendly format','PDF export','Multiple templates','Auto-fill from profile'],
       'badge'=>'Free Tool','badgeCls'=>'bg-orange-100 text-orange-700',
       'borderCls'=>'bg-orange-50 border-orange-100','textCls'=>'text-orange-700','iconBg'=>'bg-orange-100'],
      ['icon'=>'💬','color'=>'purple','path'=>'/counselling',
       'image'=>'photo-1521737604893-d14cc237f11d',
       'title'=>'Career Counselling','tagline'=>'One-on-One Expert Guidance',
       'desc'=>'Book personal sessions with experienced career counsellors. Get advice on career path, interview preparation, and skill gaps.',
       'highlights'=>['Free sessions','Expert counsellors','Online & offline','Interview prep'],
       'badge'=>'Book Free','badgeCls'=>'bg-purple-100 text-purple-700',
       'borderCls'=>'bg-purple-50 border-purple-100','textCls'=>'text-purple-700','iconBg'=>'bg-purple-100'],
      ['icon'=>'📋','color'=>'red','path'=>'/services',
       'image'=>'photo-1573164713988-8665fc963095',
       'title'=>'Employment Schemes','tagline'=>'Punjab & Central Govt Welfare',
       'desc'=>'Explore state and central government employment welfare schemes — financial aid, subsidies, apprenticeship stipends and more.',
       'highlights'=>['Ghar Ghar Rozgar','PM Kaushal Vikas','Startup Punjab','Apprenticeship'],
       'badge'=>'Benefits','badgeCls'=>'bg-red-100 text-red-700',
       'borderCls'=>'bg-red-50 border-red-100','textCls'=>'text-red-700','iconBg'=>'bg-red-100'],
    ];
    @endphp

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($services as $svc)
      <a href="{{ url($svc['path']) }}"
         class="group rounded-2xl border overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col {{ $svc['borderCls'] }}">
        {{-- Image --}}
        <div class="relative h-40 overflow-hidden">
          <img src="https://images.unsplash.com/{{ $svc['image'] }}?w=600&q=80&auto=format&fit=crop"
               alt="{{ $svc['title'] }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
          <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/40"></div>
          <span class="absolute top-3 right-3 text-xs font-bold px-2.5 py-1 rounded-full shadow {{ $svc['badgeCls'] }}">{{ $svc['badge'] }}</span>
          <div class="absolute bottom-3 left-3 w-10 h-10 rounded-xl {{ $svc['iconBg'] }} flex items-center justify-center text-xl shadow-lg">
            {{ $svc['icon'] }}
          </div>
        </div>
        {{-- Content --}}
        <div class="p-5 flex flex-col flex-1">
          <h3 class="text-lg font-extrabold text-gray-900 mb-0.5">{{ $svc['title'] }}</h3>
          <p class="text-xs font-semibold text-gray-400 mb-3 uppercase tracking-wide">{{ $svc['tagline'] }}</p>
          <p class="text-sm text-gray-600 leading-relaxed mb-4 flex-1">{{ $svc['desc'] }}</p>
          <ul class="space-y-1.5 mb-5">
            @foreach($svc['highlights'] as $h)
            <li class="flex items-center gap-2 text-xs text-gray-600">
              <svg class="w-3 h-3 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              {{ $h }}
            </li>
            @endforeach
          </ul>
          <div class="flex items-center gap-1 text-sm font-semibold {{ $svc['textCls'] }} group-hover:gap-2 transition-all duration-200">
            Explore
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>

  {{-- ── How It Works ──────────────────────────────────────────── --}}
  <div class="bg-gray-50 rounded-3xl px-8 py-12 mb-14">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-extrabold text-gray-900">How It Works</h2>
      <p class="text-gray-500 mt-2">Get your dream job in 4 simple steps</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @php
      $steps = [
        ['num'=>'01','title'=>'Register Free','desc'=>'Create your PGRKAM account in 2 minutes — no fees, no paperwork.','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
        ['num'=>'02','title'=>'Build Your Profile','desc'=>'Fill your qualifications, skills and build a professional resume.','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['num'=>'03','title'=>'Browse & Apply','desc'=>'Search government and private jobs filtered by location and type.','icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2'],
        ['num'=>'04','title'=>'Get Hired','desc'=>'Track your applications and get shortlisted by top employers.','icon'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
      ];
      @endphp
      @foreach($steps as $i => $step)
      <div class="relative text-center">
        @if($i < 3)
          <div class="hidden lg:block absolute top-8 left-[calc(50%+2.5rem)] w-[calc(100%-5rem)] h-0.5 bg-primary-200"></div>
        @endif
        <div class="w-16 h-16 rounded-2xl bg-primary-600 text-white flex items-center justify-center mx-auto mb-4 shadow-lg">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
        </div>
        <div class="text-xs font-bold text-primary-400 mb-1">{{ $step['num'] }}</div>
        <h3 class="font-extrabold text-gray-900 mb-2">{{ $step['title'] }}</h3>
        <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ── Employment Schemes ───────────────────────────────────── --}}
  <div class="mb-14">
    <div class="text-center mb-10">
      <span class="inline-block bg-primary-100 text-primary-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">Government Welfare</span>
      <h2 class="text-3xl font-extrabold text-gray-900">Employment Schemes</h2>
      <p class="text-gray-500 mt-2 max-w-xl mx-auto">Punjab & Central Government schemes to support your career and livelihood.</p>
    </div>

    @php
    $schemes = [
      ['icon'=>'🏠','tag'=>'State Scheme','tagCls'=>'bg-blue-100 text-blue-700',
       'image'=>'photo-1551836022-d5d88e9218df',
       'title'=>'Ghar Ghar Rozgar Yojana',
       'desc'=>'Punjab government initiative providing job placement assistance to unemployed youth across all districts. Covers job fairs, skill mapping and direct employer connect.',
       'benefits'=>['Free job fair participation','Priority placement support','Career counselling included'],
       'eligibility'=>'Punjab domicile, Age 18–35'],
      ['icon'=>'🛠️','tag'=>'Central Scheme','tagCls'=>'bg-primary-100 text-primary-700',
       'image'=>'photo-1434030216411-0b793f4b4173',
       'title'=>'PM Kaushal Vikas Yojana (PMKVY)',
       'desc'=>'Central government skill development scheme offering free short-term training in 300+ job roles with NSDC-certified trainers and placement support.',
       'benefits'=>['Free training (300+ trades)','₹8,000 cash reward on certification','Placement assistance'],
       'eligibility'=>'Indian citizen, Min. 8th pass'],
      ['icon'=>'🚀','tag'=>'Startup','tagCls'=>'bg-purple-100 text-purple-700',
       'image'=>'photo-1559136555-9303baea8ebd',
       'title'=>'Startup Punjab',
       'desc'=>'Entrepreneurship ecosystem with seed funding, co-working spaces, mentorship and regulatory support for first-generation entrepreneurs in Punjab.',
       'benefits'=>['Up to ₹20L seed funding','Mentorship from IIT/IIM alumni','Tax exemptions for 3 years'],
       'eligibility'=>'Punjab resident, Innovative idea'],
      ['icon'=>'🎓','tag'=>'Apprenticeship','tagCls'=>'bg-yellow-100 text-yellow-700',
       'image'=>'photo-1504307651254-35680f356dfd',
       'title'=>'National Apprenticeship Scheme',
       'desc'=>'Learn while you earn — structured on-the-job training at registered companies with monthly stipend. Leads to NCVT/SCVT certification.',
       'benefits'=>['₹6,000–14,000/month stipend','Industry experience','Govt-recognised certificate'],
       'eligibility'=>'ITI/10th/12th pass, Age 14–21'],
      ['icon'=>'💰','tag'=>'Financial Aid','tagCls'=>'bg-orange-100 text-orange-700',
       'image'=>'photo-1554224155-6726b3ff858f',
       'title'=>'Punjab SC/BC Employment Loan',
       'desc'=>'Subsidised loans for SC/BC/OBC youth to start self-employment ventures. Interest subvention and capital subsidy from Punjab govt.',
       'benefits'=>['Loan up to ₹5 Lakh','50% interest subvention','No collateral for small loans'],
       'eligibility'=>'SC/BC/OBC, Punjab domicile'],
      ['icon'=>'👩‍💼','tag'=>'Women Scheme','tagCls'=>'bg-pink-100 text-pink-700',
       'image'=>'photo-1573497019940-1c28c88b4f3e',
       'title'=>'Punjab Mahila Rozgar Scheme',
       'desc'=>'Special employment and self-employment scheme for women of Punjab — skill training, micro-enterprise support and priority placement.',
       'benefits'=>['Free skill training','Priority in govt jobs','₹25,000 business grant'],
       'eligibility'=>'Women, Age 18–45, Punjab'],
    ];
    @endphp

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($schemes as $scheme)
      <div class="glass-card overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
        <div class="relative h-44 overflow-hidden">
          <img src="https://images.unsplash.com/{{ $scheme['image'] }}?w=600&q=80&auto=format&fit=crop"
               alt="{{ $scheme['title'] }}"
               class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy" />
          <div class="absolute inset-0 bg-gradient-to-b from-black/10 to-black/50"></div>
          <span class="absolute top-3 right-3 text-xs font-bold px-2.5 py-1 rounded-full shadow {{ $scheme['tagCls'] }}">{{ $scheme['tag'] }}</span>
          <span class="absolute bottom-3 left-3 text-2xl">{{ $scheme['icon'] }}</span>
        </div>
        <div class="p-6 flex flex-col flex-1">
          <h3 class="font-extrabold text-gray-900 text-base mb-2">{{ $scheme['title'] }}</h3>
          <p class="text-sm text-gray-500 leading-relaxed mb-4 flex-1">{{ $scheme['desc'] }}</p>
          <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Key Benefits</p>
            <ul class="space-y-1.5">
              @foreach($scheme['benefits'] as $b)
              <li class="flex items-center gap-2 text-xs text-gray-700">
                <svg class="w-3 h-3 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $b }}
              </li>
              @endforeach
            </ul>
          </div>
          <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
            <div>
              <p class="text-xs text-gray-400">Eligibility</p>
              <p class="text-xs font-semibold text-gray-700">{{ $scheme['eligibility'] }}</p>
            </div>
            <a href="{{ route('services.index') }}" class="btn-primary text-xs px-3 py-1.5 inline-flex">Apply Now</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ── CTA Banner ──────────────────────────────────────────── --}}
  <div class="rounded-3xl bg-gradient-to-r from-primary-600 to-primary-800 text-white px-8 py-12 text-center">
    <svg class="w-10 h-10 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
    <h2 class="text-3xl font-extrabold mb-3">Ready to Start Your Career Journey?</h2>
    <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">
      Join 50,000+ Punjab youth who have found employment through PGRKAM. Register free today.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      @guest
        <a href="{{ route('register') }}" class="bg-white text-primary-700 font-bold px-8 py-3 rounded-xl hover:shadow-lg transition hover:-translate-y-0.5">Register Free</a>
      @else
        <a href="{{ route('dashboard') }}" class="bg-white text-primary-700 font-bold px-8 py-3 rounded-xl hover:shadow-lg transition hover:-translate-y-0.5">Go to Dashboard</a>
      @endguest
      <a href="{{ route('jobs.index') }}" class="bg-white/20 text-white font-bold px-8 py-3 rounded-xl border border-white/30 hover:bg-white/30 transition">Browse Jobs</a>
    </div>
  </div>

</div>
@endsection
