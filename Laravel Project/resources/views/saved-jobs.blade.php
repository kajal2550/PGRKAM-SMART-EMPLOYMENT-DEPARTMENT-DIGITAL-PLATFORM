@extends('layouts.app')
@section('title', 'Saved Jobs – PGRKAM')

@section('content')
@php
  $avatarColors = [
    ['bg-rose-100 dark:bg-rose-900/30',      'text-rose-600 dark:text-rose-400'],
    ['bg-orange-100 dark:bg-orange-900/30',  'text-orange-600 dark:text-orange-400'],
    ['bg-amber-100 dark:bg-amber-900/30',    'text-amber-600 dark:text-amber-400'],
    ['bg-emerald-100 dark:bg-emerald-900/30','text-emerald-600 dark:text-emerald-400'],
    ['bg-teal-100 dark:bg-teal-900/30',      'text-teal-600 dark:text-teal-400'],
    ['bg-cyan-100 dark:bg-cyan-900/30',      'text-cyan-600 dark:text-cyan-400'],
    ['bg-blue-100 dark:bg-blue-900/30',      'text-blue-600 dark:text-blue-400'],
    ['bg-indigo-100 dark:bg-indigo-900/30',  'text-indigo-600 dark:text-indigo-400'],
    ['bg-violet-100 dark:bg-violet-900/30',  'text-violet-600 dark:text-violet-400'],
    ['bg-pink-100 dark:bg-pink-900/30',      'text-pink-600 dark:text-pink-400'],
  ];
  $total = $savedJobs->count();
@endphp

<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- ── Hero ── --}}
  <div class="bg-gradient-to-br from-indigo-800 via-indigo-700 to-primary-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-lg mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
          <p class="text-indigo-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">Saved Jobs</h1>
          <p class="text-indigo-100 mt-2 text-sm">Jobs you've bookmarked for later</p>
        </div>
        <a href="{{ route('jobs.index') }}"
           class="self-start inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white text-sm font-semibold px-5 py-2.5 rounded-xl border border-white/25 backdrop-blur transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          Browse Jobs
        </a>
      </div>
      {{-- Stat --}}
      <div class="inline-flex items-center gap-4">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/20 flex items-center gap-3">
          <svg class="w-7 h-7 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
          <div>
            <p class="text-3xl font-black text-white leading-none">{{ $total }}</p>
            <p class="text-indigo-100 text-xs mt-0.5 font-semibold uppercase tracking-wide">Saved Jobs</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Cards ── --}}
  <div class="max-w-screen-lg mx-auto px-4 md:px-6 -mt-14 pb-16">

    @if($savedJobs->isEmpty())
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 text-center py-20 px-8">
        <div class="w-20 h-20 mx-auto mb-5 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center">
          <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">No Saved Jobs Yet</h3>
        <p class="text-gray-400 text-sm mb-8 max-w-xs mx-auto">Bookmark jobs that interest you and come back to apply when you're ready</p>
        <a href="{{ route('jobs.index') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl transition shadow-lg">
          Browse Available Jobs
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>

    @else
      <div class="space-y-4">
        @foreach($savedJobs as $job)
          @php
            $dept     = $job->department ?? 'General';
            $initial  = strtoupper(substr($dept, 0, 1));
            $colorIdx = ord($initial) % count($avatarColors);
            [$bgColor, $textColor] = $avatarColors[$colorIdx];

            $isExpiringSoon = $job->application_deadline &&
              \Carbon\Carbon::parse($job->application_deadline)->diffInDays(now()) <= 7 &&
              \Carbon\Carbon::parse($job->application_deadline)->isFuture();
            $isExpired = $job->application_deadline &&
              \Carbon\Carbon::parse($job->application_deadline)->isPast();
          @endphp

          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-shadow duration-300">
            <div class="p-5 md:p-6 flex items-start gap-4">

              {{-- Department avatar --}}
              <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl {{ $bgColor }} flex items-center justify-center flex-shrink-0 shadow-sm">
                <span class="text-xl md:text-2xl font-black {{ $textColor }}">{{ $initial }}</span>
              </div>

              {{-- Info --}}
              <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3 flex-wrap">
                  <div class="min-w-0">
                    @if($job->type)
                      <span class="inline-block px-2 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-semibold rounded-full border border-primary-100 dark:border-primary-800 mb-1">
                        {{ $job->type }}
                      </span>
                    @endif
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-base leading-snug">{{ $job->title }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-0.5">{{ $job->department }}</p>
                  </div>

                  {{-- Deadline badge --}}
                  @if($isExpired)
                    <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                      Expired
                    </span>
                  @elseif($isExpiringSoon)
                    <span class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400">
                      <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                      Closing Soon
                    </span>
                  @endif
                </div>

                {{-- Meta chips --}}
                <div class="flex flex-wrap items-center gap-2 mt-2.5">
                  @if($job->location)
                    <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                      {{ $job->location }}
                    </span>
                  @endif
                  @if($job->salary_range)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                      ₹ {{ $job->salary_range }}
                    </span>
                  @endif
                  @if($job->application_deadline && !$isExpired)
                    <span class="inline-flex items-center gap-1 text-xs {{ $isExpiringSoon ? 'text-orange-500 font-semibold' : 'text-gray-400' }}">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                      Due {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}
                    </span>
                  @endif
                  @if($job->saved_at)
                    <span class="text-xs text-gray-400">
                      · Saved {{ \Carbon\Carbon::parse($job->saved_at)->diffForHumans() }}
                    </span>
                  @endif
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center gap-2 mt-4">
                  <form action="{{ route('jobs.save', $job->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-500 dark:hover:text-red-400 text-gray-500 dark:text-gray-400 text-xs font-semibold transition-colors">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                      Remove
                    </button>
                  </form>
                  @if(!$isExpired)
                    <a href="{{ route('jobs.apply.show', $job->id) }}"
                       class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold transition-colors shadow-sm shadow-primary-200 dark:shadow-none">
                      Apply Now
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
