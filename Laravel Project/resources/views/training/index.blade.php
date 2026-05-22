@extends('layouts.app')
@section('title', 'Training Programs – PGRKAM')

@section('content')
<div class="bg-white min-h-screen">

  {{-- ── Hero ── --}}
  <section class="relative py-16 px-6 overflow-hidden"
           style="background-image:url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    <div class="absolute -top-12 -right-12 w-72 h-72 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-52 h-52 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="relative z-10 max-w-screen-xl mx-auto">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
          <span class="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-4 tracking-wide uppercase">
            Government of Punjab — Free Skill Development
          </span>
          <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3">Skill Training Programs</h1>
          <p class="text-white/70 text-lg max-w-xl">
            Free and subsidised skill development programs by the Government of Punjab — enroll today and boost your career.
          </p>
        </div>
        <div class="flex gap-4 flex-shrink-0">
          @foreach([
            ['svg'=>'book',  'val'=> count($trainings).'+', 'lbl'=>'Programs'],
            ['svg'=>'users', 'val'=>'Free',                  'lbl'=>'For All' ],
            ['svg'=>'award', 'val'=>'Govt.',                 'lbl'=>'Certified'],
          ] as $sb)
          <div class="bg-white/10 rounded-2xl px-5 py-4 text-center">
            @if($sb['svg']=='book')
              <svg class="w-5 h-5 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            @elseif($sb['svg']=='users')
              <svg class="w-5 h-5 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            @else
              <svg class="w-5 h-5 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            @endif
            <p class="text-xl font-extrabold text-white leading-none">{{ $sb['val'] }}</p>
            <p class="text-white/60 text-xs mt-0.5">{{ $sb['lbl'] }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- ── Filters ── --}}
  <section class="max-w-screen-xl mx-auto px-6 py-6">
    <form action="{{ route('training.index') }}" method="GET"
          class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-3 items-center">
      <div class="relative flex-1 w-full">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search training programs..."
               class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent text-gray-900 placeholder-gray-400 transition" />
      </div>
      <div class="flex items-center gap-2 flex-wrap">
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        @foreach($categories as $cat)
          <a href="{{ route('training.index', array_merge(request()->except('category','page'), ['category' => $cat])) }}"
             class="px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ request('category','All') == $cat ? 'bg-primary-600 text-white shadow-md shadow-primary-200' : 'bg-gray-100 text-gray-600 hover:bg-primary-50 hover:text-primary-700' }}">
            {{ $cat }}
          </a>
        @endforeach
      </div>
    </form>
  </section>

  {{-- ── Cards ── --}}
  <section class="max-w-screen-xl mx-auto px-6 pb-16">
    <p class="text-sm text-gray-500 mb-4">
      Showing <span class="font-semibold text-gray-800">{{ count($trainings) }}</span> program{{ count($trainings) != 1 ? 's' : '' }}
    </p>

    @if($trainings->isEmpty())
      <div class="text-center py-24">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <p class="text-gray-500 font-medium">No training programs found.</p>
        <p class="text-gray-400 text-sm mt-1">Try a different category or search term.</p>
        <a href="{{ route('training.index') }}" class="text-primary-600 text-sm mt-3 inline-block hover:underline font-semibold">Clear filters</a>
      </div>

    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($trainings as $t)
      @php
        $isEnrolled = in_array($t->id, $enrolled);
        $pct        = $t->total_seats > 0 ? min(100, round(($t->enrolled_count / $t->total_seats) * 100)) : 0;
        $isFull     = $t->enrolled_count >= $t->total_seats;
        $seatsLeft  = max(0, $t->total_seats - $t->enrolled_count);

        // Category color map
        $catColors = [
          'IT'            => ['badge'=>'bg-blue-100 text-blue-700',  'bar'=>'bg-blue-600',    'icon'=>'bg-blue-100 text-blue-700'  ],
          'Electrical'    => ['badge'=>'bg-blue-100 text-blue-700',  'bar'=>'bg-blue-500',    'icon'=>'bg-blue-100 text-blue-700'  ],
          'Marketing'     => ['badge'=>'bg-blue-100 text-blue-700',  'bar'=>'bg-primary-600', 'icon'=>'bg-blue-100 text-blue-700'  ],
          'Finance'       => ['badge'=>'bg-green-100 text-green-700','bar'=>'bg-green-600',   'icon'=>'bg-green-100 text-green-700'],
          'Handcraft'     => ['badge'=>'bg-blue-100 text-blue-700',  'bar'=>'bg-primary-700', 'icon'=>'bg-blue-100 text-blue-700'  ],
          'Communication' => ['badge'=>'bg-blue-100 text-blue-700',  'bar'=>'bg-primary-800', 'icon'=>'bg-blue-100 text-blue-700'  ],
        ];
        $colors = $catColors[$t->category] ?? ['badge'=>'bg-blue-100 text-blue-700','bar'=>'bg-primary-600','icon'=>'bg-blue-100 text-blue-700'];

        // Title-keyword → Unsplash full URL (full IDs required by Unsplash CDN)
        $imgMap = [
          'Web Development'        => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=600&q=80&auto=format&fit=crop',
          'Mobile Phone'           => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&q=80&auto=format&fit=crop',
          'Python'                 => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=600&q=80&auto=format&fit=crop',
          'Cyber Security'         => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80&auto=format&fit=crop',
          'MS Office'              => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&q=80&auto=format&fit=crop',
          'Data Entry'             => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=600&q=80&auto=format&fit=crop',
          'Android'                => 'https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?w=600&q=80&auto=format&fit=crop',
          'Electrician'            => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&q=80&auto=format&fit=crop',
          'Solar Panel'            => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=600&q=80&auto=format&fit=crop',
          'Industrial Electrician' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=600&q=80&auto=format&fit=crop',
          'AC & Refrigeration'     => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=600&q=80&auto=format&fit=crop',
          'Digital Marketing'      => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=600&q=80&auto=format&fit=crop',
          'Tally'                  => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&q=80&auto=format&fit=crop',
          'Sales & Retail'         => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&q=80&auto=format&fit=crop',
          'Banking'                => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=600&q=80&auto=format&fit=crop',
          'E-Commerce'             => 'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=600&q=80&auto=format&fit=crop',
          'Tailoring'              => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=600&q=80&auto=format&fit=crop',
          'Beauty'                 => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&q=80&auto=format&fit=crop',
          'Phulkari'               => 'https://images.unsplash.com/photo-1464195244916-405fa0a82545?w=600&q=80&auto=format&fit=crop',
          'Pottery'                => 'https://images.unsplash.com/photo-1493612276216-ee3925520721?w=600&q=80&auto=format&fit=crop',
          'Furniture'              => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=600&q=80&auto=format&fit=crop',
          'Spoken English'         => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=600&q=80&auto=format&fit=crop',
          'Interview'              => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=600&q=80&auto=format&fit=crop',
          'Customer Service'       => 'https://images.unsplash.com/photo-1543269664-56d93c1b41a6?w=600&q=80&auto=format&fit=crop',
          'Public Speaking'        => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=600&q=80&auto=format&fit=crop',
          'Legal Literacy'         => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=600&q=80&auto=format&fit=crop',
        ];
        $catFallback = [
          'IT'            => 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=600&q=80&auto=format&fit=crop',
          'Electrical'    => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&q=80&auto=format&fit=crop',
          'Marketing'     => 'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=600&q=80&auto=format&fit=crop',
          'Finance'       => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=600&q=80&auto=format&fit=crop',
          'Handcraft'     => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=600&q=80&auto=format&fit=crop',
          'Communication' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=600&q=80&auto=format&fit=crop',
        ];
        $img = null;
        foreach($imgMap as $kw => $url) { if(str_contains($t->title, $kw)) { $img = $url; break; } }
        if(!$img) $img = $catFallback[$t->category] ?? 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=600&q=80&auto=format&fit=crop';
      @endphp

      <div class="bg-white rounded-2xl border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col">

        {{-- Thumbnail --}}
        <div class="relative h-36 overflow-hidden">
          <img src="{{ $img }}" alt="{{ $t->title }}"
               class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy" />
          <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/40"></div>
          <span class="absolute bottom-2 left-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $colors['badge'] }}">{{ $t->category }}</span>
        </div>

        {{-- Colored top accent --}}
        <div class="h-1 w-full {{ $colors['bar'] }}"></div>

        <div class="p-6 flex flex-col gap-4 flex-1">
          {{-- Icon --}}
          <div class="flex items-center justify-between">
            <div class="w-12 h-12 rounded-2xl {{ $colors['icon'] }} flex items-center justify-center">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
          </div>

          {{-- Title + provider --}}
          <div>
            <h3 class="font-extrabold text-gray-900 text-base leading-snug">{{ $t->title }}</h3>
            <p class="text-sm text-gray-500 mt-0.5">{{ $t->provider }}</p>
          </div>

          {{-- Meta chips --}}
          <div class="flex flex-wrap gap-3">
            @if($t->duration)
              <span class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 px-2.5 py-1.5 rounded-lg">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $t->duration }}
              </span>
            @endif
            <span class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 px-2.5 py-1.5 rounded-lg">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              {{ $t->enrolled_count }}/{{ $t->total_seats }} seats
            </span>
            @if($t->fee)
              <span class="flex items-center gap-1 text-xs font-bold bg-primary-50 text-primary-700 px-2.5 py-1.5 rounded-lg">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14.5v.5h-2v-.5a3 3 0 01-3-3h2a1 1 0 001 1v-2l-2-.67C7.64 11.32 7 10.46 7 9.5a3 3 0 013-3V6h2v.5a3 3 0 013 3h-2a1 1 0 00-1-1v2l2 .67C15.36 11.68 16 12.54 16 13.5a3 3 0 01-3 3z"/></svg>
                {{ $t->fee }}
              </span>
            @endif
          </div>

          {{-- Seat progress --}}
          <div>
            <div class="flex justify-between text-xs text-gray-400 mb-1.5">
              <span>Seats filled</span>
              <span class="{{ $pct >= 90 ? 'text-red-500 font-semibold' : '' }}">{{ $pct }}%</span>
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full rounded-full {{ $isFull ? 'bg-red-500' : ($pct >= 80 ? 'bg-orange-400' : $colors['bar']) }}"
                   style="width: {{ $pct }}%"></div>
            </div>
            @if($isFull)
              <p class="text-xs text-red-500 font-medium mt-1">All seats filled</p>
            @elseif($pct >= 80)
              <p class="text-xs text-orange-500 font-medium mt-1">Hurry! Only {{ $seatsLeft }} seats left</p>
            @endif
          </div>

          {{-- Enroll button --}}
          @if($isEnrolled)
            <span class="mt-auto w-full py-2.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 bg-primary-50 text-primary-700 cursor-default">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              Enrolled
            </span>
          @elseif($isFull)
            <span class="mt-auto w-full py-2.5 rounded-xl text-sm font-semibold text-center bg-gray-100 text-gray-400 cursor-not-allowed">No Seats Available</span>
          @elseif(!auth()->check())
            <a href="{{ route('login') }}" class="mt-auto block text-center w-full py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold transition shadow-md shadow-primary-200">Login to Enroll</a>
          @else
            <a href="{{ route('training.enroll.show', $t->id) }}"
               class="mt-auto block text-center w-full py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold transition shadow-md shadow-primary-200">
              Enroll Now →
            </a>
          @endif
        </div>


      </div>
      @endforeach
    </div>
    @endif
  </section>
</div>
@endsection
