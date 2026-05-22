@extends('layouts.app')
@section('title', 'Notifications – PGRKAM')

@section('content')
@php
  $readCount = $totalCount - $unreadCount;
  $typeConfigs = [
    'job' => [
      'icon'   => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2',
      'bg'     => 'bg-blue-100 dark:bg-blue-900/30',
      'text'   => 'text-blue-600 dark:text-blue-400',
      'border' => 'border-l-blue-500',
      'badge'  => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700',
      'label'  => 'Job',
    ],
    'training' => [
      'icon'   => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
      'bg'     => 'bg-emerald-100 dark:bg-emerald-900/30',
      'text'   => 'text-emerald-600 dark:text-emerald-400',
      'border' => 'border-l-emerald-500',
      'badge'  => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-300 dark:border-emerald-700',
      'label'  => 'Training',
    ],
    'alert' => [
      'icon'   => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
      'bg'     => 'bg-orange-100 dark:bg-orange-900/30',
      'text'   => 'text-orange-600 dark:text-orange-400',
      'border' => 'border-l-orange-500',
      'badge'  => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/20 dark:text-orange-300 dark:border-orange-700',
      'label'  => 'Alert',
    ],
    'info' => [
      'icon'   => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
      'bg'     => 'bg-purple-100 dark:bg-purple-900/30',
      'text'   => 'text-purple-600 dark:text-purple-400',
      'border' => 'border-l-purple-500',
      'badge'  => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-700',
      'label'  => 'Info',
    ],
    'default' => [
      'icon'   => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
      'bg'     => 'bg-gray-100 dark:bg-gray-700',
      'text'   => 'text-gray-500 dark:text-gray-400',
      'border' => 'border-l-gray-400',
      'badge'  => 'bg-gray-50 text-gray-600 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
      'label'  => 'Info',
    ],
  ];

  // Pre-group notifications by read status for Alpine filtering
  $allNotifs    = $notifications;
  $unreadNotifs = $notifications->where('is_read', false);
  $readNotifs   = $notifications->where('is_read', true);
@endphp

<div class="pt-16 min-h-screen bg-gray-50 dark:bg-gray-900">

  {{-- ═══════════════════════════════ HERO ═══════════════════════════════ --}}
  <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-blue-600 pt-10 pb-24 px-6">
    <div class="max-w-screen-xl mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        {{-- Title --}}
        <div>
          <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">Punjab Govt. Rozgar Kendra</p>
          <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            Notifications
            @if($unreadCount > 0)
              <span class="text-sm bg-red-500 text-white px-3 py-1 rounded-full font-bold shadow-lg animate-pulse">
                {{ $unreadCount }} new
              </span>
            @endif
          </h1>
          <p class="text-blue-100 mt-2 text-sm">Your alerts, updates and activity from PGRKAM</p>
        </div>

        {{-- Hero stat cards --}}
        <div class="flex gap-3 flex-wrap">
          <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-5 py-3 text-center min-w-[76px]">
            <p class="text-2xl font-black text-white leading-none">{{ $totalCount }}</p>
            <p class="text-blue-100 text-xs mt-0.5 font-semibold">Total</p>
          </div>
          <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl px-5 py-3 text-center min-w-[76px]">
            <p class="text-2xl font-black text-white leading-none">{{ $unreadCount }}</p>
            <p class="text-blue-100 text-xs mt-0.5 font-semibold">Unread</p>
          </div>
          <div class="bg-emerald-400/30 backdrop-blur-sm border border-emerald-300/40 rounded-2xl px-5 py-3 text-center min-w-[76px]">
            <p class="text-2xl font-black text-white leading-none">{{ $readCount }}</p>
            <p class="text-emerald-100 text-xs mt-0.5 font-semibold">Read</p>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- ═══════════════════════════════ MAIN ═══════════════════════════════ --}}
  <div class="max-w-screen-xl mx-auto px-4 md:px-6 -mt-14 pb-16" x-data="{ filter: 'all' }">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

      {{-- ─────────────── LEFT: Filter Tabs + List ─────────────── --}}
      <div class="lg:col-span-3 space-y-4">

        {{-- Filter Tabs --}}
        <div class="grid grid-cols-3 gap-3">

          {{-- All --}}
          <button @click="filter='all'"
            :class="filter==='all'
              ? 'ring-2 ring-primary-400 shadow-lg bg-white dark:bg-gray-800 scale-[1.02]'
              : 'bg-white/80 dark:bg-gray-800/70 hover:shadow-md'"
            class="rounded-2xl border border-gray-100 dark:border-gray-700 p-4 text-center transition-all duration-200 cursor-pointer">
            <p class="text-2xl font-black text-gray-800 dark:text-white">{{ $totalCount }}</p>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-0.5">All</p>
          </button>

          {{-- Unread --}}
          <button @click="filter='unread'"
            :class="filter==='unread'
              ? 'ring-2 ring-primary-400 shadow-lg scale-[1.02]'
              : 'hover:shadow-md'"
            class="rounded-2xl border border-gray-100 dark:border-gray-700 p-4 text-center transition-all duration-200 cursor-pointer bg-white dark:bg-gray-800">
            <p class="text-2xl font-black text-primary-700 dark:text-primary-400">{{ $unreadCount }}</p>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-0.5">Unread</p>
          </button>

          {{-- Read --}}
          <button @click="filter='read'"
            :class="filter==='read'
              ? 'ring-2 ring-primary-400 shadow-lg scale-[1.02]'
              : 'hover:shadow-md'"
            class="rounded-2xl border border-gray-100 dark:border-gray-700 p-4 text-center transition-all duration-200 cursor-pointer bg-white dark:bg-gray-800">
            <p class="text-2xl font-black text-emerald-700 dark:text-emerald-400">{{ $readCount }}</p>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-0.5">Read</p>
          </button>

        </div>

        {{-- ── Notification List ── --}}
        @if($notifications->isEmpty())

          {{-- Empty state --}}
          <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-16 text-center">
            <div class="w-20 h-20 rounded-full bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center mx-auto mb-5">
              <svg class="w-10 h-10 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-1">No notifications yet</h3>
            <p class="text-gray-400 text-sm max-w-xs mx-auto">Apply for jobs or enroll in training — you'll see updates here.</p>
          </div>

        @else

          {{-- All notifications --}}
          <div x-show="filter==='all'" class="space-y-3">
            @foreach($notifications as $n)
              @php
                $type = $n->type ?? 'default';
                $cfg  = $typeConfigs[$type] ?? $typeConfigs['default'];
              @endphp
              <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 flex overflow-hidden
                {{ !$n->is_read
                    ? 'border-l-4 '.$cfg['border'].' border border-gray-100 dark:border-gray-700 hover:-translate-y-0.5'
                    : 'border border-gray-100 dark:border-gray-700 hover:-translate-y-0.5' }}">
                @include('_partials.notification-item', ['n' => $n, 'cfg' => $cfg])
              </div>
            @endforeach
          </div>

          {{-- Unread only --}}
          <div x-show="filter==='unread'" class="space-y-3">
            @php $unreadItems = $notifications->where('is_read', false); @endphp
            @forelse($unreadItems as $n)
              @php
                $type = $n->type ?? 'default';
                $cfg  = $typeConfigs[$type] ?? $typeConfigs['default'];
              @endphp
              <div class="group relative bg-white dark:bg-gray-800 rounded-2xl border-l-4 {{ $cfg['border'] }} border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex overflow-hidden">
                @include('_partials.notification-item', ['n' => $n, 'cfg' => $cfg])
              </div>
            @empty
              <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-12 text-center">
                <div class="w-14 h-14 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mx-auto mb-3">
                  <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <p class="text-sm font-bold text-gray-600 dark:text-gray-300">All caught up!</p>
                <p class="text-xs text-gray-400 mt-1">No unread notifications.</p>
              </div>
            @endforelse
          </div>

          {{-- Read only --}}
          <div x-show="filter==='read'" class="space-y-3">
            @php $readItems = $notifications->where('is_read', true); @endphp
            @forelse($readItems as $n)
              @php
                $type = $n->type ?? 'default';
                $cfg  = $typeConfigs[$type] ?? $typeConfigs['default'];
              @endphp
              <div class="group relative bg-gray-50 dark:bg-gray-800/60 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex overflow-hidden">
                @include('_partials.notification-item', ['n' => $n, 'cfg' => $cfg])
              </div>
            @empty
              <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-12 text-center">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No read notifications yet.</p>
              </div>
            @endforelse
          </div>

          <div class="mt-4">{{ $notifications->links() }}</div>

        @endif
      </div>

      {{-- ─────────────── RIGHT: Summary Panel ─────────────── --}}
      <div class="lg:col-span-2">
        <div class="sticky top-24 space-y-4">

          {{-- Summary Card --}}
          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-primary-700 px-5 py-3.5 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="text-white text-sm font-bold">Notification Summary</span>
              </div>
              <span class="bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $totalCount }}</span>
            </div>
            <div class="p-5 space-y-1">
              @foreach([
                ['label' => 'Total',  'value' => $totalCount,   'color' => 'text-gray-800 dark:text-white',         'dot' => 'bg-gray-400',     'bg' => ''],
                ['label' => 'Unread', 'value' => $unreadCount,  'color' => 'text-primary-700 dark:text-primary-400', 'dot' => 'bg-primary-500',  'bg' => 'bg-primary-50/50 dark:bg-primary-900/10'],
                ['label' => 'Read',   'value' => $readCount,    'color' => 'text-emerald-700 dark:text-emerald-400', 'dot' => 'bg-emerald-500',  'bg' => 'bg-emerald-50/50 dark:bg-emerald-900/10'],
              ] as $stat)
              <div class="flex items-center justify-between px-3 py-2.5 rounded-xl {{ $stat['bg'] }}">
                <div class="flex items-center gap-2.5">
                  <span class="w-2.5 h-2.5 rounded-full {{ $stat['dot'] }} flex-shrink-0"></span>
                  <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $stat['label'] }}</span>
                </div>
                <span class="font-black text-xl {{ $stat['color'] }}">{{ $stat['value'] }}</span>
              </div>
              @endforeach
            </div>
          </div>

          {{-- Notification Types --}}
          <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 bg-primary-50/50 dark:bg-primary-900/10 flex items-center gap-2">
              <div class="w-8 h-8 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
              </div>
              <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Notification Types</h2>
                <p class="text-xs text-gray-400">What each colour means</p>
              </div>
            </div>
            <div class="p-5 space-y-3">
              @foreach([
                ['color' => 'bg-blue-500',    'label' => 'Job',      'desc' => 'Job listings & applications'],
                ['color' => 'bg-emerald-500',  'label' => 'Training', 'desc' => 'Training & enrollment updates'],
                ['color' => 'bg-orange-500',   'label' => 'Alert',    'desc' => 'Important alerts & reminders'],
                ['color' => 'bg-purple-500',   'label' => 'Info',     'desc' => 'General information & updates'],
              ] as $t)
              <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                <span class="w-3 h-3 rounded-full {{ $t['color'] }} flex-shrink-0 shadow-sm"></span>
                <div>
                  <p class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $t['label'] }}</p>
                  <p class="text-[11px] text-gray-400 dark:text-gray-500">{{ $t['desc'] }}</p>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          {{-- Info notice --}}
          <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl p-4 flex items-start gap-3">
            <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
              Notifications are sent automatically when you
              <strong class="text-emerald-700 dark:text-emerald-400">apply for jobs</strong>,
              enroll in training, or receive updates from PGRKAM advisors.
            </p>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
