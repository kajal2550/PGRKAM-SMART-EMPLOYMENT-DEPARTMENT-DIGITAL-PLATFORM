@extends('layouts.app')
@section('title', 'My Enrollments – PGRKAM')

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
  $total     = $enrollments->count();
  $active    = $enrollments->where('status','enrolled')->count();
  $completed = $enrollments->where('status','completed')->count();
@endphp

<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- ── Hero (Blue) ── --}}
  <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-blue-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-lg mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
          <p class="text-primary-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">My Enrollments</h1>
          <p class="text-primary-100 mt-2 text-sm">Track your training journey step by step</p>
        </div>
        <a href="{{ route('training.index') }}"
           class="self-start inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white text-sm font-semibold px-5 py-2.5 rounded-xl border border-white/25 backdrop-blur transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C14.754 5.477 16.34 5 18.09 5c1.747 0 3.332.477 4.5 1.253v13"/></svg>
          Explore Training
        </a>
      </div>
      {{-- Stats --}}
      <div class="grid grid-cols-3 gap-3 max-w-sm">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-white">{{ $total }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">Total</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-yellow-300">{{ $active }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">Active</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
          <p class="text-3xl font-black text-green-300">{{ $completed }}</p>
          <p class="text-primary-100 text-xs mt-1 font-semibold uppercase tracking-wide">Done</p>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Cards ── --}}
  <div class="max-w-screen-lg mx-auto px-4 md:px-6 -mt-14 pb-16">

    @if($enrollments->isEmpty())
      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 text-center py-20 px-8">
        <div class="w-20 h-20 mx-auto mb-5 bg-primary-50 dark:bg-primary-900/20 rounded-full flex items-center justify-center">
          <svg class="w-10 h-10 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C14.754 5.477 16.34 5 18.09 5c1.747 0 3.332.477 4.5 1.253v13"/></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-200 mb-2">No Enrollments Yet</h3>
        <p class="text-gray-400 text-sm mb-8 max-w-xs mx-auto">Enroll in skill development programs to boost your career prospects</p>
        <a href="{{ route('training.index') }}"
           class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-3 rounded-xl transition shadow-lg">
          Browse Training Programs
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>

    @else
      <div class="space-y-4">
        @foreach($enrollments as $e)
          @php
            $cat      = $e->category ?? 'General';
            $initial  = strtoupper(substr($cat, 0, 1));
            $colorIdx = ord($initial) % count($avatarColors);
            [$bgColor, $textColor] = $avatarColors[$colorIdx];

            $isCancelled = ($e->status === 'cancelled');
            $isCompleted = ($e->status === 'completed');
            $hasStarted  = $e->start_date && \Carbon\Carbon::parse($e->start_date)->isPast();

            $stepActive = $isCompleted ? 3
                        : ($hasStarted  ? 2
                        : 0);

            $steps = ['Enrolled', 'Batch Assigned', 'In Training', 'Certificate'];

            $statusColor = $isCompleted  ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                        : ($isCancelled  ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
                        :                  'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400');
          @endphp

          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-shadow duration-300">
            <div class="p-5 md:p-6">

              {{-- ── Top row: avatar + info + status ── --}}
              <div class="flex items-start gap-4">

                {{-- Category avatar --}}
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl {{ $bgColor }} flex items-center justify-center flex-shrink-0 shadow-sm">
                  <span class="text-xl md:text-2xl font-black {{ $textColor }}">{{ $initial }}</span>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-3 flex-wrap">
                    <div class="min-w-0">
                      @if($e->category)
                        <span class="inline-block mb-1 px-2 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-semibold rounded-full border border-primary-100 dark:border-primary-800">
                          {{ $e->category }}
                        </span>
                      @endif
                      <h3 class="font-bold text-gray-900 dark:text-gray-100 text-base leading-snug">{{ $e->training_title }}</h3>
                      @if($e->provider)
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-0.5">{{ $e->provider }}</p>
                      @endif
                    </div>
                    {{-- Status badge --}}
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                      @if($isCompleted)
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Completed ✓
                      @elseif($isCancelled)
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Cancelled
                      @else
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500 inline-block animate-pulse"></span> Active
                      @endif
                    </span>
                  </div>

                  {{-- Meta chips --}}
                  <div class="flex flex-wrap items-center gap-2 mt-2.5">
                    @if($e->duration)
                      <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $e->duration }}
                      </span>
                    @endif
                    @if($e->preferred_timing)
                      <span class="px-2 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-semibold rounded-full border border-primary-100 dark:border-primary-800">
                        {{ $e->preferred_timing }}
                      </span>
                    @endif
                    @if($e->start_date)
                      <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Starts {{ \Carbon\Carbon::parse($e->start_date)->format('d M Y') }}
                      </span>
                    @endif
                    @if($e->certificate_type)
                      <span class="inline-flex items-center gap-1 text-xs text-yellow-600 dark:text-yellow-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $e->certificate_type }}
                      </span>
                    @endif
                    <span class="text-xs text-gray-400">· Enrolled {{ \Carbon\Carbon::parse($e->enrolled_at)->format('d M Y') }}</span>
                  </div>
                </div>
              </div>

              {{-- ── Progress Tracker ── --}}
              <div class="mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">
                @if($isCancelled)
                  <div class="flex items-center gap-3 bg-red-50 dark:bg-red-950/40 border border-red-100 dark:border-red-900 rounded-2xl px-4 py-3">
                    <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center flex-shrink-0">
                      <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                      <p class="text-sm font-bold text-red-600 dark:text-red-400">Enrollment Cancelled</p>
                      <p class="text-xs text-red-400 dark:text-red-500 mt-0.5">This enrollment was cancelled. Browse other programs!</p>
                    </div>
                  </div>
                @else
                  <div class="flex items-start">
                    @foreach($steps as $idx => $label)
                      @php $done = $idx <= $stepActive; $current = $idx === $stepActive; @endphp

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
