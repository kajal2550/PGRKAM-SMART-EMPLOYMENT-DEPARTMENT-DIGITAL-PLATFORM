@extends('layouts.app')
@section('title', 'Job Listings – PGRKAM')

@section('content')
<div class="bg-white min-h-screen">

  {{-- ── Hero ── --}}
  <section class="relative py-16 px-6 overflow-hidden"
           style="background-image:url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1400&q=80&auto=format&fit=crop');background-size:cover;background-position:center">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    <div class="absolute -top-12 -right-12 w-72 h-72 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-52 h-52 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="relative z-10 max-w-screen-xl mx-auto">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
          <span class="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-4 tracking-wide uppercase">
            Punjab Government &amp; Private Sector
          </span>
          <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3">Job Listings</h1>
          <p class="text-white/70 text-lg max-w-xl">
            Discover government and private sector opportunities across all 23 districts of Punjab.
          </p>
        </div>
        <div class="flex gap-4 flex-shrink-0">
          @php $statBoxes = [['icon'=>'briefcase','val'=>count($jobs).'+','lbl'=>'Open Positions'],['icon'=>'free','val'=>'Free','lbl'=>'To Apply'],['icon'=>'map','val'=>'23','lbl'=>'Districts']]; @endphp
          @foreach($statBoxes as $sb)
          <div class="bg-white/10 rounded-2xl px-5 py-4 text-center">
            @if($sb['icon']=='briefcase')
              <svg class="w-5 h-5 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
            @elseif($sb['icon']=='free')
              <svg class="w-5 h-5 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            @else
              <svg class="w-5 h-5 text-white mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
    <form action="{{ route('jobs.index') }}" method="GET"
          class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-3 items-center">
      {{-- Search --}}
      <div class="relative flex-1 w-full">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search job title or department…"
               class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent text-gray-900 placeholder-gray-400 transition" />
      </div>
      {{-- Type filter --}}
      <div class="flex items-center gap-2 flex-wrap">
        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        @foreach($types as $t)
          <a href="{{ route('jobs.index', array_merge(request()->except('type','page'), ['type' => $t])) }}"
             class="px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ request('type','All') == $t ? 'bg-primary-600 text-white shadow-md shadow-primary-200' : 'bg-gray-100 text-gray-600 hover:bg-primary-50 hover:text-primary-700' }}">
            {{ $t }}
          </a>
        @endforeach
      </div>
      {{-- Location --}}
      <select name="location" onchange="this.form.submit()"
              class="border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-400 transition w-full sm:w-40">
        @foreach(['All','Chandigarh','Mohali','Ludhiana','Amritsar','Patiala','Jalandhar','Bathinda'] as $l)
          <option value="{{ $l }}" {{ request('location','All') == $l ? 'selected' : '' }}>{{ $l }}</option>
        @endforeach
      </select>
    </form>
  </section>

  {{-- ── Results ── --}}
  <section class="max-w-screen-xl mx-auto px-6 pb-16">

    {{-- Count --}}
    <p class="text-sm text-gray-500 mb-4">
      Showing <span class="font-semibold text-gray-800">{{ count($jobs) }}</span> job{{ count($jobs) != 1 ? 's' : '' }}
      @if(request('type') && request('type') != 'All') · <span>{{ request('type') }}</span> @endif
      @if(request('location') && request('location') != 'All') · <span>{{ request('location') }}</span> @endif
    </p>

    {{-- Empty state --}}
    @if($jobs->isEmpty())
      <div class="text-center py-24">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
        </div>
        <p class="text-gray-500 font-medium">No jobs match your filters.</p>
        <p class="text-gray-400 text-sm mt-1">Try a different location or job type.</p>
        <a href="{{ route('jobs.index') }}" class="text-primary-600 text-sm mt-3 inline-block hover:underline font-semibold">Clear filters</a>
      </div>

    @else
    {{-- Job Cards (list layout) --}}
    <div class="space-y-4">
      @foreach($jobs as $job)
      @php
        $isApplied = in_array($job->id, $applied);
        $isSaved   = in_array($job->id, $saved);
        $isGovt    = strtolower($job->type ?? '') === 'government';
      @endphp
      <div class="bg-white rounded-2xl border border-gray-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">

        {{-- Colored top accent bar --}}
        <div class="h-1 w-full {{ $isGovt ? 'bg-primary-600' : 'bg-blue-400' }}"></div>

        <div class="p-5">
          {{-- Top row --}}
          <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            {{-- Icon --}}
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $isGovt ? 'bg-primary-100' : 'bg-blue-50' }}">
              <svg class="w-5 h-5 {{ $isGovt ? 'text-primary-700' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between gap-2 flex-wrap">
                <h3 class="font-extrabold text-gray-900 text-lg leading-snug">{{ $job->title }}</h3>
                <span class="text-xs font-semibold px-3 py-1 rounded-full flex-shrink-0 {{ $isGovt ? 'bg-primary-100 text-primary-700' : 'bg-blue-50 text-blue-600' }}">
                  {{ $isGovt ? '🏛 Government' : '🏢 Private' }}
                </span>
              </div>
              <p class="text-gray-500 text-sm mt-0.5 font-medium">{{ $job->department }}</p>

              {{-- Meta chips --}}
              <div class="flex flex-wrap gap-2 mt-3">
                @if($job->location)
                  <span class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 px-2.5 py-1.5 rounded-lg">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $job->location }}
                  </span>
                @endif
                @if($job->salary_range)
                  <span class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 px-2.5 py-1.5 rounded-lg">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $job->salary_range }}
                  </span>
                @endif
                @if($job->application_deadline)
                  <span class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 px-2.5 py-1.5 rounded-lg">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}
                  </span>
                @endif
                @if($job->vacancies)
                  <span class="flex items-center gap-1.5 text-xs font-semibold bg-primary-50 text-primary-700 px-2.5 py-1.5 rounded-lg">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $job->vacancies }} Vacancies
                  </span>
                @endif
              </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex gap-2 flex-shrink-0 items-center">
              {{-- Save --}}
              <form action="{{ route('jobs.save', $job->id) }}" method="POST">
                @csrf
                <button type="submit" title="Save Job"
                        class="p-2.5 rounded-xl border-2 transition-all {{ $isSaved ? 'bg-primary-50 border-primary-300 text-primary-600' : 'border-gray-200 text-gray-400 hover:border-primary-300 hover:text-primary-600' }}">
                  <svg class="w-4 h-4" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                </button>
              </form>
              {{-- Apply --}}
              @if($isApplied)
                <span class="flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-sm font-semibold bg-primary-50 text-primary-700 cursor-default">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  Applied
                </span>
              @elseif(!auth()->check())
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-primary-600 hover:bg-primary-700 text-white shadow-md shadow-primary-200 transition">Login to Apply</a>
              @else
                <a href="{{ route('jobs.apply.show', $job->id) }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-primary-600 hover:bg-primary-700 text-white shadow-md shadow-primary-200 transition">Apply Now →</a>
              @endif
            </div>
          </div>

          {{-- Details row --}}
          <div class="mt-4 pt-4 border-t border-gray-100">
            @if($job->posted_on || $job->vacancies)
            <div class="grid sm:grid-cols-2 gap-3 mb-3 text-sm text-gray-600">
              @if($job->posted_on)
              <p class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2">
                <svg class="w-3.5 h-3.5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Posted: <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($job->posted_on)->format('d M Y') }}</span>
              </p>
              @endif
              @if($job->vacancies)
              <p class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2">
                <svg class="w-3.5 h-3.5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Vacancies: <span class="font-medium text-gray-800">{{ $job->vacancies }}</span>
              </p>
              @endif
            </div>
            @endif
            <p class="text-sm text-gray-600 leading-relaxed">
              {{ $job->description ?: "This is a {$job->type} sector position with the {$job->department}. Candidates meeting eligibility criteria may apply before " . ($job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') : 'the deadline') . "." }}
            </p>
            @if($job->qualifications)
            <div class="mt-3">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Qualifications Required</p>
              <div class="flex flex-wrap gap-2">
                @php($quals = is_array($job->qualifications) ? $job->qualifications : (is_string($job->qualifications) ? json_decode($job->qualifications, true) : []))
                @foreach(($quals ?: []) as $q)
                  <span class="text-xs bg-primary-50 text-primary-700 px-2.5 py-1 rounded-lg">{{ $q }}</span>
                @endforeach
              </div>
            </div>
            @endif
          </div>
        </div>

      </div>
      @endforeach
    </div>
    @endif

  </section>
</div>
@endsection
