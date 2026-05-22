@extends('layouts.app')
@section('title', 'My Applications – PGRKAM')

@section('content')
@php
  $avatarColors = [
    ['bg-rose-100 dark:bg-rose-900/30',     'text-rose-600 dark:text-rose-400'],
    ['bg-orange-100 dark:bg-orange-900/30', 'text-orange-600 dark:text-orange-400'],
    ['bg-amber-100 dark:bg-amber-900/30',   'text-amber-600 dark:text-amber-400'],
    ['bg-emerald-100 dark:bg-emerald-900/30','text-emerald-600 dark:text-emerald-400'],
    ['bg-teal-100 dark:bg-teal-900/30',     'text-teal-600 dark:text-teal-400'],
    ['bg-cyan-100 dark:bg-cyan-900/30',     'text-cyan-600 dark:text-cyan-400'],
    ['bg-blue-100 dark:bg-blue-900/30',     'text-blue-600 dark:text-blue-400'],
    ['bg-indigo-100 dark:bg-indigo-900/30', 'text-indigo-600 dark:text-indigo-400'],
    ['bg-violet-100 dark:bg-violet-900/30', 'text-violet-600 dark:text-violet-400'],
    ['bg-pink-100 dark:bg-pink-900/30',     'text-pink-600 dark:text-pink-400'],
  ];
  $totalApps   = $applications->count();
  $cntPending  = $applications->where('status','pending')->count();
  $cntReviewed = $applications->where('status','reviewed')->count();
  $cntShortlisted = $applications->where('status','shortlisted')->count();
@endphp

<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- ── Hero Header ── --}}
  <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-blue-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-lg mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
          <p class="text-primary-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">My Applications</h1>
          <p class="text-primary-100 mt-2 text-sm">Track every step of your job application journey</p>
        </div>
        <a href="{{ route('jobs.index') }}"
           class="self-start inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white text-sm font-semibold px-5 py-2.5 rounded-xl border border-white/25 backdrop-blur transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          Browse Jobs
        </a>
      </div>
      {{-- Stats --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-white">{{ $totalApps }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">Total</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-yellow-300">{{ $cntPending }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">Pending</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-blue-200">{{ $cntReviewed }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">In Review</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-green-300">{{ $cntShortlisted }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">Shortlisted</p>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Cards (overlap hero with negative margin) ── --}}
  <div class="max-w-screen-lg mx-auto px-4 md:px-6 -mt-14 pb-16">

    @if($applications->isEmpty())
      {{-- Empty state --}}
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 text-center py-20 px-8">
        <div class="w-20 h-20 mx-auto mb-5 bg-primary-50 dark:bg-primary-900/20 rounded-full flex items-center justify-center">
          <svg class="w-10 h-10 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">No Applications Yet</h3>
        <p class="text-gray-400 text-sm mb-8 max-w-xs mx-auto">Start your career journey by applying to jobs that match your skills and interests</p>
        <a href="{{ route('jobs.index') }}"
           class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-3 rounded-xl transition shadow-lg">
          Browse Available Jobs
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>

    @else
      <div class="space-y-4">
        @foreach($applications as $app)
          @php
            $dept      = $app->department ?? 'General';
            $initial   = strtoupper(substr($dept, 0, 1));
            $colorIdx  = ord($initial) % count($avatarColors);
            [$bgColor, $textColor] = $avatarColors[$colorIdx];
            $isRejected = $app->status === 'rejected';
            $stepActive = match($app->status) {
              'reviewed'    => 1,
              'shortlisted' => 2,
              default       => 0,
            };
            $steps = ['Submitted', 'Under Review', 'Shortlisted', 'Interview', 'Decision'];
          @endphp

          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-shadow duration-300">
            <div class="p-5 md:p-6">

              {{-- ── Card top: avatar + job info + status badge ── --}}
              <div class="flex items-start gap-4">

                {{-- Department initial avatar --}}
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl {{ $bgColor }} flex items-center justify-center flex-shrink-0 shadow-sm">
                  <span class="text-xl md:text-2xl font-black {{ $textColor }}">{{ $initial }}</span>
                </div>

                {{-- Info block --}}
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-3 flex-wrap">
                    <div class="min-w-0">
                      <h3 class="font-bold text-gray-900 dark:text-gray-100 text-base leading-snug">{{ $app->job_title }}</h3>
                      <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $app->department }}</p>
                    </div>

                    {{-- Status badge --}}
                    @if($isRejected)
                      <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Not Selected
                      </span>
                    @elseif($app->status === 'shortlisted')
                      <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Shortlisted ✓
                      </span>
                    @elseif($app->status === 'reviewed')
                      <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Under Review
                      </span>
                    @else
                      <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                      </span>
                    @endif
                  </div>

                  {{-- Meta chips --}}
                  <div class="flex flex-wrap items-center gap-2 mt-2.5">
                    @if($app->location)
                      <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $app->location }}
                      </span>
                    @endif
                    @if($app->type)
                      <span class="px-2 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-semibold rounded-full border border-primary-100 dark:border-primary-800">
                        {{ $app->type }}
                      </span>
                    @endif
                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                      {{ \Carbon\Carbon::parse($app->created_at)->format('d M Y') }}
                    </span>
                    @if($app->application_ref)
                      <span class="text-xs text-gray-400 font-mono bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-lg">
                        {{ $app->application_ref }}
                      </span>
                    @endif
                    @if($app->experience)
                      <span class="text-xs text-gray-400">· {{ $app->experience }}</span>
                    @endif
                  </div>
                </div>
              </div>

              {{-- ── Progress Tracker ── --}}
              <div class="mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">
                @if($isRejected)
                  <div class="flex items-center gap-3 bg-red-50 dark:bg-red-950/40 border border-red-100 dark:border-red-900 rounded-2xl px-4 py-3">
                    <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center flex-shrink-0">
                      <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                      <p class="text-sm font-bold text-red-600 dark:text-red-400">Application Not Progressed</p>
                      <p class="text-xs text-red-400 dark:text-red-500 mt-0.5">This application was not selected. Your next opportunity awaits!</p>
                    </div>
                  </div>
                @else
                  {{-- Parcel-style step tracker --}}
                  <div class="flex items-start">
                    @foreach($steps as $idx => $label)
                      @php $done = $idx <= $stepActive; $current = $idx === $stepActive; @endphp

                      {{-- Step node --}}
                      <div class="flex flex-col items-center">
                        @if($done)
                          <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shadow-sm {{ $current ? 'ring-4 ring-primary-100 dark:ring-primary-900/60' : '' }}">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                          </div>
                        @else
                          <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center">
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500">{{ $idx + 1 }}</span>
                          </div>
                        @endif
                        <p class="text-xs text-center leading-tight mt-2 w-16
                          {{ $current ? 'font-bold text-primary-600 dark:text-primary-400' :
                             ($done    ? 'font-medium text-primary-500 dark:text-primary-500' :
                                         'text-gray-400 dark:text-gray-500') }}">
                          {{ $label }}
                        </p>
                      </div>

                      {{-- Connector line --}}
                      @if($idx < count($steps) - 1)
                        <div class="flex-1 h-0.5 mt-4 rounded-full {{ $idx < $stepActive ? 'bg-primary-500' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                      @endif
                    @endforeach
                  </div>
                @endif
              </div>

            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
