<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'PGRKAM – Punjab Employment Portal')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>(function(){if(localStorage.getItem('pgrkam_theme')==='dark')document.documentElement.classList.add('dark');})()</script>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col" x-data="{ sidebarOpen: false, mobileOpen: false }">

  {{-- Sidebar Drawer (authenticated only) --}}
  @auth
  <aside :style="{ transform: sidebarOpen ? 'translateX(0)' : 'translateX(-100%)', top: '4rem', zIndex: '40' }"
         style="transform:translateX(-100%); top:4rem; z-index:40"
         class="fixed left-0 h-[calc(100vh-4rem)] flex flex-col w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-lg transition-transform duration-300">

    {{-- User info --}}
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full {{ auth()->user()->role === 'admin' ? 'bg-gradient-to-br from-orange-500 to-red-500' : 'bg-gradient-to-br from-primary-600 to-blue-400' }} flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div class="overflow-hidden">
          <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ auth()->user()->name }}</p>
          @if(auth()->user()->role === 'admin')
            <span class="inline-block mt-0.5 px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] font-semibold rounded-full">Admin</span>
          @else
            <span class="inline-block mt-0.5 px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-semibold rounded-full">User</span>
          @endif
        </div>
      </div>
    </div>

    {{-- Nav links --}}
    <nav class="flex-1 py-4 px-2 space-y-0.5 overflow-y-auto">
      @php
        if(auth()->user()->role === 'admin') {
          $sidebarLinks = [
            ['label'=>'Dashboard',        'route'=>route('admin.dashboard'),    'icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ['label'=>'Manage Users',     'route'=>route('admin.users'),        'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label'=>'Manage Jobs',      'route'=>route('admin.jobs'),         'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2'],
            ['label'=>'Manage Trainings', 'route'=>route('admin.trainings'),    'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['label'=>'Applications',     'route'=>route('admin.applications'), 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            ['label'=>'Counselling',      'route'=>route('admin.counselling'),  'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
          ];
        } else {
          $sidebarLinks = [
            ['label'=>'Dashboard',          'route'=>route('dashboard'),      'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['label'=>'Jobs',               'route'=>route('jobs.index'),     'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2'],
            ['label'=>'My Applications',    'route'=>route('applications'),   'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            ['label'=>'Saved Jobs',         'route'=>route('saved-jobs'),     'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['label'=>'Training',           'route'=>route('training.index'), 'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['label'=>'My Enrollments',     'route'=>route('enrollments'),    'icon'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
            ['label'=>'Employment Schemes', 'route'=>route('services.index'), 'icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['label'=>'Resume',             'route'=>route('resume'),         'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label'=>'Career Counselling', 'route'=>route('counselling'),    'icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ['label'=>'Notifications',      'route'=>route('notifications'),  'icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
            ['label'=>'Profile & Settings', 'route'=>route('profile'),        'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
          ];
        }
      @endphp
      @foreach($sidebarLinks as $link)
      <a href="{{ $link['route'] }}" @click="sidebarOpen=false"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ request()->url() === $link['route']
                    ? (auth()->user()->role === 'admin' ? 'bg-orange-600 text-white shadow-md' : 'bg-primary-600 text-white shadow-md')
                    : 'text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 hover:text-primary-700 dark:hover:text-primary-300' }}">
        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
        </svg>
        <span class="truncate">{{ $link['label'] }}</span>
      </a>
      @endforeach
    </nav>

    {{-- Logout --}}
    <div class="p-3 border-t border-gray-100 dark:border-gray-700">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
          <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- Sidebar backdrop --}}
  <div x-show="sidebarOpen" @click="sidebarOpen=false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-30 bg-black/30" style="display:none"></div>
  @endauth

  {{-- Navbar --}}
  <nav class="fixed top-0 inset-x-0 z-50 bg-white/90 dark:bg-gray-900/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">

        <div class="flex items-center gap-3">
          @auth
          <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition" aria-label="Toggle sidebar">
            <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
          @endauth
          <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-9 h-9 bg-gradient-to-br from-primary-700 to-blue-500 rounded-xl flex items-center justify-center shadow">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/>
              </svg>
            </div>
            <div class="hidden sm:block">
              <p class="text-sm font-bold text-primary-800 leading-tight">PGRKAM</p>
              <p class="text-xs text-gray-500 leading-tight">Employment Portal</p>
            </div>
          </a>
        </div>

        <div class="hidden md:flex items-center gap-1">
          <a href="{{ route('home') }}"          class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('home') ? 'text-primary-700 bg-primary-50 dark:text-primary-300 dark:bg-primary-900/40' : 'text-gray-600 dark:text-gray-300 hover:text-primary-700 hover:bg-primary-50 dark:hover:text-primary-300 dark:hover:bg-primary-900/30' }}">Home</a>
          <a href="{{ route('services.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('services.*') ? 'text-primary-700 bg-primary-50 dark:text-primary-300 dark:bg-primary-900/40' : 'text-gray-600 dark:text-gray-300 hover:text-primary-700 hover:bg-primary-50 dark:hover:text-primary-300 dark:hover:bg-primary-900/30' }}">Services</a>
          <a href="{{ route('jobs.index') }}"     class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('jobs.*') ? 'text-primary-700 bg-primary-50 dark:text-primary-300 dark:bg-primary-900/40' : 'text-gray-600 dark:text-gray-300 hover:text-primary-700 hover:bg-primary-50 dark:hover:text-primary-300 dark:hover:bg-primary-900/30' }}">Jobs</a>
          <a href="{{ route('training.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('training.*') ? 'text-primary-700 bg-primary-50 dark:text-primary-300 dark:bg-primary-900/40' : 'text-gray-600 dark:text-gray-300 hover:text-primary-700 hover:bg-primary-50 dark:hover:text-primary-300 dark:hover:bg-primary-900/30' }}">Training</a>
          <a href="{{ route('about') }}"          class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('about') ? 'text-primary-700 bg-primary-50 dark:text-primary-300 dark:bg-primary-900/40' : 'text-gray-600 dark:text-gray-300 hover:text-primary-700 hover:bg-primary-50 dark:hover:text-primary-300 dark:hover:bg-primary-900/30' }}">About</a>
          <a href="{{ route('contact') }}"        class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('contact') ? 'text-primary-700 bg-primary-50 dark:text-primary-300 dark:bg-primary-900/40' : 'text-gray-600 dark:text-gray-300 hover:text-primary-700 hover:bg-primary-50 dark:hover:text-primary-300 dark:hover:bg-primary-900/30' }}">Contact</a>
        </div>

        <div class="flex items-center gap-2">
          @auth
            @php $unread = \DB::table('notifications')->where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
            <a href="{{ route('notifications') }}" class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
              @if($unread > 0)
                <span class="absolute top-1 right-1 min-w-[16px] h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-0.5">{{ $unread > 9 ? '9+' : $unread }}</span>
              @endif
            </a>

            {{-- Dark / Light toggle --}}
            <div x-data="{ dark: localStorage.getItem('pgrkam_theme')==='dark', toggle() { this.dark=!this.dark; document.documentElement.classList.toggle('dark',this.dark); localStorage.setItem('pgrkam_theme',this.dark?'dark':'light'); } }">
              <button @click="toggle()" class="p-2 rounded-lg text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition" title="Toggle dark mode">
                <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="dark" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
              </button>
            </div>

            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-200">{{ explode(' ', auth()->user()->name)[0] }}</span>
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>
              <div x-show="open" @click.away="open = false" x-transition
                   class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-lg py-2 z-50 animate-fade-in">
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                  <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('dashboard') }}" @click="open=false" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 hover:text-primary-700 dark:hover:text-primary-300">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  My Dashboard
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" @click="open=false" class="flex items-center gap-3 px-4 py-2 text-sm text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-700 font-semibold">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                  Admin Panel
                </a>
                @endif
                <a href="{{ route('profile') }}" @click="open=false" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700 hover:text-primary-700 dark:hover:text-primary-300">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                  Profile Settings
                </a>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                  </button>
                </form>
              </div>
            </div>
          @else
            <a href="{{ route('login') }}" class="btn-secondary text-sm py-2 px-4">Login</a>
            <a href="{{ route('register') }}" class="btn-primary text-sm py-2 px-4">Register</a>
          @endauth
          <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              <path x-show="mobileOpen"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-gray-100 dark:border-gray-700 py-3 space-y-1 px-4 bg-white dark:bg-gray-800 animate-fade-in">
      <a href="{{ route('home') }}"          @click="mobileOpen=false" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">Home</a>
      <a href="{{ route('services.index') }}" @click="mobileOpen=false" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">Services</a>
      <a href="{{ route('jobs.index') }}"     @click="mobileOpen=false" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">Jobs</a>
      <a href="{{ route('training.index') }}" @click="mobileOpen=false" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">Training</a>
      <a href="{{ route('about') }}"          @click="mobileOpen=false" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">About</a>
      <a href="{{ route('contact') }}"        @click="mobileOpen=false" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-700 dark:hover:text-primary-300 hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg">Contact</a>
      @auth
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST">@csrf
          <button class="block w-full text-left px-4 py-2 text-sm font-medium text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg">Logout</button>
        </form>
      @endauth
    </div>
  </nav>

  @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
         class="fixed top-20 right-4 z-50 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-2xl shadow-lg text-sm font-medium flex items-center gap-2">
      <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
         class="fixed top-20 right-4 z-50 bg-red-50 border border-red-200 text-red-800 px-5 py-3 rounded-2xl shadow-lg text-sm font-medium flex items-center gap-2">
      <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      {{ session('error') }}
    </div>
  @endif

  <main class="flex-1">
    @yield('content')
  </main>

  {{-- ═══ FLOATING SMART GUIDE WIDGET (every page) ═══ --}}
  <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">

    {{-- Chat Window --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="mb-4 w-80 bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden"
         style="display:none">

      {{-- Header --}}
      <div class="bg-gradient-to-r from-primary-700 to-blue-600 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          </div>
          <div>
            <p class="text-white font-bold text-xs">PGRKAM Guide</p>
            <p class="text-blue-200 text-[10px] flex items-center gap-1"><span class="w-1.5 h-1.5 bg-green-400 rounded-full inline-block animate-pulse"></span>Online · Free</p>
          </div>
        </div>
        <button @click="open=false" class="text-white/70 hover:text-white transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      {{-- Quick Buttons --}}
      <div class="px-3 pt-3 pb-1 flex flex-wrap gap-1.5">
        @foreach([['I need a job','government job'],['Learn a skill','skill training'],['Build resume','resume cv'],['Career advice','career counselling']] as $b)
        <button onclick="floatGuide('{{ $b[1] }}')"
          class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-primary-50 text-primary-700 border border-primary-200 hover:bg-primary-100 transition">
          {{ $b[0] }}
        </button>
        @endforeach
      </div>

      {{-- Messages --}}
      <div id="float-messages" class="px-3 py-2 space-y-2 h-48 overflow-y-auto bg-gray-50">
        <div class="flex gap-2">
          <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">🤖</div>
          <div class="bg-white rounded-xl rounded-tl-none px-3 py-2 shadow-sm border border-gray-100 text-xs text-gray-700 max-w-[200px]">
            Hi! Tell me what you need — job, training, resume, or career advice!
          </div>
        </div>
      </div>

      {{-- Input --}}
      <div class="p-3 border-t border-gray-100 bg-white">
        <div class="flex gap-2">
          <input type="text" id="float-input" placeholder="Type your query..."
            class="flex-1 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-primary-400"
            onkeydown="if(event.key==='Enter') floatGuide()" />
          <button onclick="floatGuide()" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-xl transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
          </button>
        </div>
      </div>
    </div>

    {{-- Toggle Button --}}
    <button @click="open=!open"
      class="w-14 h-14 bg-gradient-to-br from-primary-600 to-blue-500 hover:from-primary-700 hover:to-blue-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all flex items-center justify-center relative">
      <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
      </svg>
      <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
      <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></span>
    </button>
  </div>

  <script>
  function floatGuide(preset) {
    const input = document.getElementById('float-input');
    const msg   = preset || input.value.trim();
    if (!msg) return;
    const box = document.getElementById('float-messages');
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    box.innerHTML += `<div class="flex justify-end gap-2">
      <div class="bg-primary-600 text-white rounded-xl rounded-tr-none px-3 py-2 text-xs max-w-[180px]">${msg}</div>
    </div>`;
    box.innerHTML += `<div id="float-typing" class="flex gap-2">
      <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 text-xs">🤖</div>
      <div class="bg-white rounded-xl rounded-tl-none px-3 py-2 shadow-sm border border-gray-100">
        <div class="flex gap-1 items-center h-4">
          <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
          <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
          <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
        </div>
      </div>
    </div>`;
    box.scrollTop = box.scrollHeight;
    input.value = '';

    fetch('/api/chat-guide', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
      body: JSON.stringify({ message: msg })
    })
    .then(r => r.json())
    .then(data => {
      document.getElementById('float-typing')?.remove();
      let html = `<div class="flex gap-2">
        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">🤖</div>
        <div class="bg-white rounded-xl rounded-tl-none px-3 py-2 shadow-sm border border-gray-100 max-w-[200px]">
          <p class="text-xs text-gray-700 mb-1">${data.reply}</p>`;
      if (data.suggestions) {
        data.suggestions.forEach(s => {
          html += `<a href="${s.path}" class="flex items-center gap-1.5 mt-1.5 px-2 py-1.5 bg-primary-50 hover:bg-primary-100 border border-primary-200 rounded-lg transition">
            <span class="text-sm">${s.icon}</span>
            <span class="text-[11px] font-bold text-primary-700">${s.module}</span>
            <svg class="w-3 h-3 text-primary-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>`;
        });
      }
      html += `</div></div>`;
      box.innerHTML += html;
      box.scrollTop = box.scrollHeight;
    });
  }
  </script>

  <footer class="bg-navy-900 text-gray-300">
    <div class="max-w-screen-xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <div>
        <div class="flex items-center gap-2 mb-4">
          <div class="w-9 h-9 bg-gradient-to-br from-primary-600 to-blue-400 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2"/></svg>
          </div>
          <div>
            <p class="text-white font-bold text-sm">PGRKAM</p>
            <p class="text-gray-400 text-xs">Employment Portal</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 leading-relaxed mb-4">Punjab Government's official smart employment guidance system — connecting citizens with jobs, training, and career services.</p>
        <div class="flex gap-3">
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary-600 flex items-center justify-center transition-colors duration-200"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary-600 flex items-center justify-center transition-colors duration-200"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary-600 flex items-center justify-center transition-colors duration-200"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"/></svg></a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary-600 flex items-center justify-center transition-colors duration-200"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg></a>
        </div>
      </div>
      <div>
        <h3 class="text-white font-semibold mb-4">Quick Links</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('jobs.index') }}"     class="hover:text-primary-400 transition-colors">Government Jobs</a></li>
          <li><a href="{{ route('training.index') }}" class="hover:text-primary-400 transition-colors">Skill Training</a></li>
          <li><a href="{{ route('resume') }}"         class="hover:text-primary-400 transition-colors">Resume Builder</a></li>
          <li><a href="{{ route('counselling') }}"    class="hover:text-primary-400 transition-colors">Career Counselling</a></li>
          <li><a href="{{ route('services.index') }}" class="hover:text-primary-400 transition-colors">Employment Schemes</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-white font-semibold mb-4">Resources</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('about') }}"          class="hover:text-primary-400 transition-colors">About PGRKAM</a></li>
          <li><a href="{{ route('services.index') }}" class="hover:text-primary-400 transition-colors">Services</a></li>
          <li><a href="{{ route('contact') }}"        class="hover:text-primary-400 transition-colors">Contact Us</a></li>
          <li><a href="{{ route('login') }}"          class="hover:text-primary-400 transition-colors">Login</a></li>
          <li><a href="{{ route('register') }}"       class="hover:text-primary-400 transition-colors">Register</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-white font-semibold mb-4">Contact Us</h3>
        <ul class="space-y-3 text-sm">
          <li class="flex items-start gap-3">
            <svg class="w-4 h-4 text-primary-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            <span>Department of Employment,<br/>SCO 153-155, Sector 34-A,<br/>Chandigarh – 160022</span>
          </li>
          <li class="flex items-center gap-3">
            <svg class="w-4 h-4 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            <span>0172-2664000</span>
          </li>
          <li class="flex items-center gap-3">
            <svg class="w-4 h-4 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <span>helpdesk@pgrkam.gov.in</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/10 py-4 px-6">
      <div class="max-w-screen-xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-500">
        <p>© {{ date('Y') }} PGRKAM – Government of Punjab. All rights reserved.</p>
        <div class="flex gap-4">
          <a href="#" class="hover:text-gray-300 transition">Privacy Policy</a>
          <a href="#" class="hover:text-gray-300 transition">Terms of Use</a>
          <a href="#" class="hover:text-gray-300 transition">Accessibility</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
